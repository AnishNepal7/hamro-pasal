<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // === Existing Statistics ===
        $totalProducts = Product::count();
        $totalSales = $this->getTotalSalesRevenue();
        $todaySales = $this->getTodaySalesRevenue();
        $lowStockProducts = Product::where('current_stock', '<=', DB::raw('reorder_level'))->count();

        // === Chart Data ===
        $monthlySalesData = $this->getMonthlySalesData();
        $dailySalesData = $this->getDailySalesData();

        // === Recent Sales ===
        $recentSales = Sale::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'product_name' => $sale->product->name,
                    'quantity' => $sale->quantity,
                    'unit_price' => $sale->product->price,
                    'total_amount' => $sale->quantity * $sale->product->price,
                    'user_name' => $sale->user->name,
                    'created_at' => $sale->created_at->format('M d, Y H:i'),
                ];
            });

        // === Top Products ===
        $topProducts = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.quantity * products.price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        // === Low Stock Alerts ===
        $lowStockAlerts = Product::with(['category', 'supplier'])
            ->where('current_stock', '<=', DB::raw('reorder_level'))
            ->orderBy('current_stock', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'current_stock' => $product->current_stock,
                    'reorder_level' => $product->reorder_level,
                    'category' => $product->category->name ?? 'N/A',
                    'supplier' => $product->supplier->name ?? 'N/A',
                ];
            });

        // === 🔮 Forecast API Integration ===
        $forecastValue = $this->getForecastValue();

        // === Return Data to View ===
        return view('dashboard', compact(
            'totalProducts',
            'totalSales',
            'todaySales',
            'lowStockProducts',
            'monthlySalesData',
            'dailySalesData',
            'recentSales',
            'topProducts',
            'lowStockAlerts',
            'forecastValue'
        ));
    }

    /**
     * 🔮 Send sales data to FastAPI to get forecasted sales
     */
    private function getForecastValue()
    {
        try {
            // Get last 30 days of sales data
            $salesData = Sale::where('created_at', '>=', now()->subDays(30))
                ->select('created_at as date', 'quantity')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($sale) {
                    return [
                        // 'date' => $sale->date->format('Y-m-d'),
                        'date' => Carbon::parse($sale->date)->format('Y-m-d'),

                        'quantity' => $sale->quantity,
                    ];
                });

            // Send data to FastAPI
            $response = Http::post('http://127.0.0.1:8001/forecast', [
                'sales' => $salesData,
            ]);

            // Parse response
            
            $data = $response->json();
            return $data['Forecast'] ?? 0;
        } catch (\Exception $e) {
            // Log error (optional)
            \Log::error('Forecast API error: ' . $e->getMessage());
            return 0;
        }
    }

    private function getTotalSalesRevenue()
    {
        return DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->sum(DB::raw('sales.quantity * products.price'));
    }

    private function getTodaySalesRevenue()
    {
        return DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->whereDate('sales.created_at', Carbon::today())
            ->sum(DB::raw('sales.quantity * products.price'));
    }

    private function getMonthlySalesData()
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $salesData = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                DB::raw('DATE_FORMAT(sales.created_at, "%Y-%m") as month'),
                DB::raw('SUM(sales.quantity * products.price) as total_revenue'),
                DB::raw('SUM(sales.quantity) as total_quantity')
            )
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $months = [];
        $revenues = [];
        $quantities = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $monthKey = $current->format('Y-m');
            $months[] = $current->format('M Y');
            $revenues[] = $salesData->get($monthKey)->total_revenue ?? 0;
            $quantities[] = $salesData->get($monthKey)->total_quantity ?? 0;
            $current->addMonth();
        }

        return [
            'labels' => $months,
            'revenues' => $revenues,
            'quantities' => $quantities,
        ];
    }

    private function getDailySalesData()
    {
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $salesData = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                DB::raw('DATE(sales.created_at) as date'),
                DB::raw('SUM(sales.quantity * products.price) as total_revenue'),
                DB::raw('SUM(sales.quantity) as total_quantity')
            )
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $dates = [];
        $revenues = [];
        $quantities = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dateKey = $current->format('Y-m-d');
            $dates[] = $current->format('M j');
            $revenues[] = $salesData->get($dateKey)->total_revenue ?? 0;
            $quantities[] = $salesData->get($dateKey)->total_quantity ?? 0;
            $current->addDay();
        }

        return [
            'labels' => $dates,
            'revenues' => $revenues,
            'quantities' => $quantities,
        ];
    }
}
