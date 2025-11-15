<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    
    /**
     * Display a listing of the purchase items.
     */
    public function index()
    {
        $purchase_items = PurchaseItem::with(['purchase', 'product'])->latest()->get();
        return view('purchase_items.index', compact('purchase_items'));
    }

    /**
     * Show the form for creating a new purchase item.
     */
    public function create()
    {
        $purchases = Purchase::latest()->get();
        $products = Product::latest()->get();
        return view('purchase_items.create', compact('purchases', 'products'));
    }

    /**
     * Store a newly created purchase item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        PurchaseItem::create($validated);

        return redirect()->route('purchase_items.index')
            ->with('success', 'Purchase item added successfully!');
    }

    /**
     * Show the form for editing the specified purchase item.
     */
    public function edit(PurchaseItem $purchase_item)
    {
        $purchases = Purchase::latest()->get();
        $products = Product::latest()->get();

        return view('purchase_items.edit', compact('purchase_item', 'purchases', 'products'));
    }

    /**
     * Update the specified purchase item in storage.
     */
    public function update(Request $request, PurchaseItem $purchase_item)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        $purchase_item->update($validated);

        return redirect()->route('purchase_items.index')
            ->with('success', 'Purchase item updated successfully!');
    }

    /**
     * Remove the specified purchase item from storage.
     */
    public function destroy(PurchaseItem $purchase_item)
    {
        $purchase_item->delete();

        return redirect()->route('purchase_items.index')
            ->with('success', 'Purchase item deleted successfully!');
    }
}

