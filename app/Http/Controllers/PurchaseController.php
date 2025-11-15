<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockMovement;
use App\Models\Supplier;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use PDF; // ← Add at the top

class PurchaseController extends Controller

    
    {
    /**
     * Display a listing of all purchases
     */
    public function index()
{
    $purchases = Purchase::with(['product', 'supplier'])
        ->where('user_id', Auth::id())
        ->latest()
        ->paginate(5);

    return view('purchase.index', compact('purchases'));
}

    /**
     * Show form for creating a new purchase
     */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchase.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created purchase
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'           => 'required|string|min:2',
        'supplier_id'    => 'required|exists:suppliers,id',
        'quantity'       => 'required|numeric|min:1',
        'purchase_price' => 'required|numeric|min:0',
        'purchase_date'  => 'required|date',
    ]);

    // -------------------------------------------
    // 1️⃣ Find existing product OR create new one
    // -------------------------------------------
    $product = Product::where('name', $validated['name'])->first();

    if (!$product) {
        // create new product if not exists
        $product = Product::create([
            'name'           => $validated['name'],
            'category_id'    => $validated['category_id'] ?? 1,
            'supplier_id'    => $validated['supplier_id'],
            'purchase_price' => $validated['purchase_price'],
            'selling_price'  => $validated['purchase_price'], // you can customize later
            'quantity'       => 0,
            'user_id'        => Auth::id(),
        ]);
    }

    // -------------------------------------------
    // 2️⃣ Create Purchase
    // -------------------------------------------
    $purchase = Purchase::create([
        'product_id'     => $product->id,
        'name'           => $validated['name'],
        'supplier_id'    => $validated['supplier_id'],
        'quantity'       => $validated['quantity'],
        'purchase_price' => $validated['purchase_price'],
        'purchase_date'  => $validated['purchase_date'],
        'user_id'        => Auth::id(),
    ]);

    // -------------------------------------------
    // 3️⃣ Update product stock
    // -------------------------------------------
    $product->quantity += $validated['quantity'];
    $product->save();

    // -------------------------------------------
    // 4️⃣ Stock Movement (IN)
    // -------------------------------------------
    StockMovement::create([
        'product_id'  => $product->id,       // ✅ correct
        'type'        => 'IN',
        'quantity'    => $validated['quantity'],
        'description' => "Purchased (Purchase ID: {$purchase->id})",
        'created_by'  => Auth::id(),
    ]);

    return redirect()
        ->route('purchase.index')
        ->with('success', 'Purchase added and stock updated successfully!');
}


    /**
     * Show form for editing an existing purchase
     */
    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchase.edit', compact('purchase', 'products', 'suppliers'));
    }

    /**
     * Update an existing purchase
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity'    => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date'  => 'required|date',
        ]);

        // Reverse the old stock quantity
        $oldProduct = Product::findOrFail($purchase->product_id);
        $oldProduct->quantity -= $purchase->quantity;
        $oldProduct->save();

        // Update purchase
        $purchase->update($validated);

        // Update new product quantity
        $newProduct = Product::findOrFail($validated['product_id']);
        $newProduct->quantity += $validated['quantity'];
        $newProduct->save();

        return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully!');
    }

    /**
     * Delete a purchase
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $product = Product::findOrFail($purchase->product_id);

        // Reduce stock
        $product->quantity -= $purchase->quantity;
        $product->save();

        $purchase->delete();

        return redirect()->route('purchase.index')->with('success', 'Purchase deleted and stock adjusted successfully!');
    }

    /**
     * Show purchase details for a specific supplier (optional)
     */
    public function supplierHistory($supplier_id)
    {
        $supplier = Supplier::with('purchases.product')->findOrFail($supplier_id);
        return view('purchases.history', compact('supplier'));
    }

    public function downloadReport()
{
    $purchases = Purchase::with(['product', 'supplier'])
        ->where('user_id', Auth::id())
        ->orderBy('purchase_date', 'desc')
        ->get();

    $total = $purchases->sum(function ($purchase) {
        return $purchase->quantity * $purchase->purchase_price;
    });

    $pdf = PDF::loadView('purchase.report', compact('purchases', 'total'));

    return $pdf->download('purchase_report_' . now()->format('Y_m_d') . '.pdf');
}
}

   
