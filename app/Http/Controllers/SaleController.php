<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockMovement;
// use Illuminate\Container\Facade\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade\Pdf;
 // add at the top

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.selling_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'sale_date' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            // Find or create customer
            $customer = null;
            if (!empty($validated['customer_name'])) {
                $customer = Customer::firstOrCreate(
                    ['name' => $validated['customer_name']]
                );
            }

            // Calculate total amount
            $totalAmount = collect($validated['products'])->sum(fn($p) => $p['selling_price'] * $p['quantity']);

            // Create sale
            $sale = Sale::create([
                'customer_id' => $customer->id ?? null,
                'total_amount' => $totalAmount,
                'discount' => $validated['discount'] ?? 0,
                'tax' => $validated['tax'] ?? 0,
                'payment_method' => $validated['payment_method'] ?? 'Cash',
                'sale_date' => $validated['sale_date'],
            ]);

            // Process products
            foreach ($validated['products'] as $productData) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'selling_price' => $productData['selling_price'],
                    'total' => $productData['quantity'] * $productData['selling_price'],
                    'sale_date' => $validated['sale_date'],
                ]);

                $product = Product::find($productData['product_id']);
                if ($product->quantity < $productData['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }
                $product->decrement('quantity', $productData['quantity']);

                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'OUT',
                    'quantity' => $productData['quantity'],
                    'description' => "Sold via Sale ID {$sale->id}",
                    'created_by' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }

    /**
     * Download sales report as PDF
     */
    public function downloadReport(Request $request)
{
    // Allowed types
    $allowedTypes = ['all','daily','monthly','yearly','custom','customer','product'];

    $request->validate([
        'type' => 'nullable|string|in:' . implode(',', $allowedTypes),
        'from_date' => 'nullable|date',
        'to_date'   => 'nullable|date|after_or_equal:from_date',
        'customer_name' => 'nullable|string|max:255',
        'product_name'  => 'nullable|string|max:255',
    ]);

    $query = Sale::with('customer', 'saleItems.product');

    // Filter by type
    switch ($request->type) {
        case 'daily':
            $query->whereDate('sale_date', today());
            break;
        case 'monthly':
            $query->whereMonth('sale_date', now()->month)
                  ->whereYear('sale_date', now()->year);
            break;
        case 'yearly':
            $query->whereYear('sale_date', now()->year);
            break;
        case 'custom':
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('sale_date', [$request->from_date, $request->to_date]);
            }
            break;
        case 'customer':
            if ($request->customer_name) {
                $query->whereHas('customer', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->customer_name . '%');
                });

                // Optional date filter for customer
                if ($request->from_date && $request->to_date) {
                    $query->whereBetween('sale_date', [$request->from_date, $request->to_date]);
                }
            }
            break;
        case 'product':
            if ($request->product_name) {
                $query->whereHas('saleItems.product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->product_name . '%');
                });

                // Optional date filter for product
                if ($request->from_date && $request->to_date) {
                    $query->whereBetween('sale_date', [$request->from_date, $request->to_date]);
                }
            }
            break;
        default:
            // 'all' - optional date filter
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('sale_date', [$request->from_date, $request->to_date]);
            }
            break;
    }

    $sales = $query->orderBy('sale_date', 'desc')->get();

    $pdf = PDF::loadView('sales.report', compact('sales'))
              ->setPaper('a4', 'landscape');

    $filename = 'sales_report_' . now()->format('Y_m_d_H_i') . '.pdf';

    return $pdf->download($filename);
}

     public function salesReport(Request $request)
    {
        $query = Sale::with('customer');

        // Optional Date Range
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('sale_date', [$request->from_date, $request->to_date]);
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();

        $pdf = Pdf::loadView('sales.report', compact('sales'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sales_report_' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * INVOICE BILL PDF
     */
    public function invoiceBill($saleId)
    {
        $sale = Sale::with(['items.product', 'customer'])->findOrFail($saleId);

        $pdf = Pdf::loadView('sales.bill', compact('sale'))
            ->setPaper('a4');

        return $pdf->download('invoice_' . $sale->id . '.pdf');
    }

    /**
     * SINGLE CUSTOMER REPORT
     */
    public function customerReport($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $sales = Sale::where('customer_id', $customerId)
            ->with('items.product')
            ->orderBy('sale_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('customers.customer_report', compact('customer', 'sales'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('customer_report_' . $customer->id . '.pdf');
    }

    /**
     * ALL CUSTOMERS REPORT
     */
    public function allCustomersReport()
    {
        $customers = Customer::withCount('sales')->get();

        $pdf = Pdf::loadView('customers.all_customers_report', compact('customers'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('customers_report_' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * PRODUCT REPORT
     */
    public function productReport()
    {
        $products = Product::with('category')->get();

        $pdf = Pdf::loadView('products.product_report', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('product_report_' . now()->format('YmdHis') . '.pdf');
    }
}
