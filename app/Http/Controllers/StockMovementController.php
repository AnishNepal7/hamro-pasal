<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->paginate(10);

        return view('stock_movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock_movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:IN,OUT',
            'quantity' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = Auth::id();

        // Automatically update product quantity
        StockMovement::record(
            $validated['product_id'],
            $validated['type'],
            $validated['quantity'],
            $validated['description']
        );

        return redirect()->route('stock_movements.index')
            ->with('success', 'Stock movement recorded successfully.');
    }

    public function destroy(StockMovement $stockMovement)
    {
        $stockMovement->delete();
        return redirect()->route('stock_movements.index')
            ->with('success', 'Stock movement deleted successfully.');
    }
    public function downloadReport(Request $request)
    {
        $from = $request->input('from', now()->subMonth()->format('Y-m-d'));
        $to   = $request->input('to', now()->format('Y-m-d'));

        $movements = StockMovement::with('product')
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('stock_movements.report', [
            'movements' => $movements,
            'from' => $from,
            'to' => $to,
        ]);

        return $pdf->download("stock_movement_report_{$from}_to_{$to}.pdf");
    }
}
