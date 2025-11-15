<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // === Top Metrics ===
        $totalProducts   = Product::where('user_id', $user->id)->count();
        $totalSales      = Sale::sum('total_amount');
        $totalPurchases  = Purchase::sum(DB::raw('quantity * purchase_price'));
        $totalCustomers  = Customer::count();
        $totalProfit     = $totalSales - $totalPurchases;
        $todaySales      = Sale::whereDate('sale_date', today())->sum('total_amount');

        // === Low Stock Alerts ===
        $lowStockAlerts = Product::with(['category', 'supplier'])
            ->where('quantity', '<=', 10)
            ->orderBy('quantity', 'asc')
            ->get()
            ->map(function ($product) {
                $product->suggested_reorder = max(10, 20 - $product->quantity); 
                return $product;
            });

        // === Recent Activity ===
        $recentSales     = Sale::latest()->take(5)->with('customer')->get();
        $recentPurchases = Purchase::latest()->take(5)->with('supplier')->get();

        // === Charts ===
        $salesChart       = $this->getSalesChartData();
        $purchaseChart    = $this->getPurchaseChartData();
        $profitChart      = $this->getProfitChartData();
        $stockMovement    = $this->getStockMovementData();

        // === Top Entities ===
        $topProducts  = $this->getTopProducts();
        $topCustomers = $this->getTopCustomers();
        $topSuppliers = $this->getTopSuppliers();

        // === Forecast from FastAPI ===
        $forecast = $this->getForecastData();

        return view('dashboard', compact(
            'totalProducts','totalSales','totalPurchases','totalProfit','totalCustomers','todaySales',
            'lowStockAlerts','recentSales','recentPurchases','salesChart','purchaseChart','profitChart','stockMovement',
            'topProducts','topCustomers','topSuppliers','forecast'
        ));
    }

    // ===================== Charts Methods =====================
    private function getSalesChartData()
    {
        $data = Sale::select(DB::raw('DATE(sale_date) as date'), DB::raw('SUM(total_amount) as total'))
            ->where('sale_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date'),
            'totals' => $data->pluck('total'),
        ];
    }

    private function getPurchaseChartData()
    {
        $data = Purchase::select(DB::raw('DATE(purchase_date) as date'), DB::raw('SUM(quantity*purchase_price) as total'))
            ->where('purchase_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date'),
            'totals' => $data->pluck('total'),
        ];
    }

    private function getProfitChartData()
    {
        $sales = Sale::select(DB::raw('DATE(sale_date) as date'), DB::raw('SUM(total_amount) as total_sales'))
            ->where('sale_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $purchases = Purchase::select(DB::raw('DATE(purchase_date) as date'), DB::raw('SUM(quantity*purchase_price) as total_cost'))
            ->where('purchase_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $profitData = $sales->map(function ($s) use ($purchases) {
            $cost = $purchases[$s->date]->total_cost ?? 0;
            return $s->total_sales - $cost;
        });

        return [
            'labels' => $sales->pluck('date'),
            'profits' => $profitData,
        ];
    }

    private function getStockMovementData()
    {
        return StockMovement::select('type', DB::raw('SUM(quantity) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');
    }

    private function getTopProducts()
    {
        return DB::table('sale_items')
            ->join('products','sale_items.product_id','=','products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.total) as total_revenue'))
            ->groupBy('products.id','products.name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();
    }

    private function getTopCustomers()
    {
        return DB::table('sales')
            ->join('customers','sales.customer_id','=','customers.id')
            ->select('customers.name', DB::raw('COUNT(sales.id) as total_orders'), DB::raw('SUM(sales.total_amount) as total_spent'))
            ->groupBy('customers.id','customers.name')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();
    }

    private function getTopSuppliers()
    {
        return DB::table('purchases')
            ->join('suppliers','purchases.supplier_id','=','suppliers.id')
            ->select('suppliers.name', DB::raw('COUNT(purchases.id) as total_purchases'), DB::raw('SUM(purchases.purchase_price * purchases.quantity) as total_spent'))
            ->groupBy('suppliers.id','suppliers.name')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();
    }

      public function forecastProduct(int $productId)
    {
        $productId=$productId;
        $FORECASTER_URL = env('FORECAST_SERVICE_URL', 'http://localhost:8002'); // adjust in .env
        $N = 28;
        $PROJ = 7;

        $end = Carbon::today();
        $start = $end->copy()->subDays($N - 1);

        // aggregate per day for the product (weighted avg price)
        $rows = SaleItem::select(
                'sale_date',
                DB::raw('SUM(quantity) AS quantity'),
                DB::raw('CASE WHEN SUM(quantity)=0 THEN 0 ELSE SUM(quantity * selling_price) / SUM(quantity) END AS price')
            )
            ->where('product_id', $productId)
            ->whereBetween('sale_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        if ($rows->isEmpty()) {
            return [
                'message' => 'No sale items found for this product in the requested window.',
                'forecast' => null
            ];
        }

        // build payload matching forecasting-service expected shape
        $payload = [
            'sales' => $rows->map(function ($r) {
                return [
                    'date' => Carbon::parse($r->sale_date)->format('Y-m-d'),
                    'quantity' => (float) $r->quantity,
                    'price' => (float) $r->price
                ];
            })->values()->all()
        ];

        // call forecasting endpoints
        $salesResponse = Http::post($FORECASTER_URL . '/forecast/sales', $payload);
        $revenueResponse = Http::post($FORECASTER_URL . '/forecast/revenue', $payload);

        return [
            'product_id' => $productId,
            'product_name' => Product::find($productId)->name,
            'sales_forecast' => $salesResponse->successful() ? $salesResponse->json() : $salesResponse->body(),
            'revenue_forecast' => $revenueResponse->successful() ? $revenueResponse->json() : $revenueResponse->body(),
        ];
    }
    public function forcastAllProdcuts()
    {
        $products = Product::all();
        $forecasts = [];
        foreach ($products as $product) {
            $forecasts[$product->id] = $this->forecastProduct($product->id);
        }
        return response()->json($forecasts);
    }







}
