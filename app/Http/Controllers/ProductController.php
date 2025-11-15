<?php
// namespace App\Http\Controllers;

// use App\Models\Product;
// use App\Models\Category;
// use App\Models\Supplier;
// use Illuminate\Http\Request;

// class ProductController extends Controller
// {
//     public function index()
//     {
//         $products = Product::with(['category', 'supplier'])->latest()->paginate(10);
//         return view('products.index', compact('products'));
//     }

//     public function create()
//     {
//         $categories = Category::all();
//         $suppliers = Supplier::all();
//         return view('products.create', compact('categories', 'suppliers'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'category_id' => 'required|exists:categories,id',
//             'supplier_id' => 'required|exists:suppliers,id',
//             'price' => 'required|numeric|min:0',
//             'current_stock' => 'required|integer|min:0',
//             'reorder_level' => 'required|integer|min:0',
//         ]);

//         Product::create($validated);
//         return redirect()->route('products.index')->with('success', 'Product created successfully.');
//     }

//     public function edit(Product $product)
//     {
//         $categories = Category::all();
//         $suppliers = Supplier::all();
//         return view('products.edit', compact('product', 'categories', 'suppliers'));
//     }

//     public function update(Request $request, Product $product)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'category_id' => 'required|exists:categories,id',
//             'supplier_id' => 'required|exists:suppliers,id',
//             'price' => 'required|numeric|min:0',
//             'current_stock' => 'required|integer|min:0',
//             'reorder_level' => 'required|integer|min:0',
//         ]);

//         $product->update($validated);
//         return redirect()->route('products.index')->with('success', 'Product updated successfully.');
//     }

//     public function destroy(Product $product)
//     {
//         $product->delete();
//         return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
//     }
// }


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        //   public function index() { $products = Product::with('supplier')->get(); return view('products.index', compact('products')); }
        // Show products visible to the logged-in user
        $products = Product::with(['category', 'supplier'])
            ->visibleTo(Auth::user())
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
        // $products = Product::with('supplier')->get();
        //  return view('products.index', compact('products'));
    }


    public function create()
{
    // Auth::user();
    $categories = Category::all();
    $suppliers = Supplier::all();
    $purchases = Purchase::with('supplier')->get();

    return view('products.create', compact('categories', 'suppliers','purchases'));
}


// public function store(Request $request)

// {
//     $validated = $request->validate([
//         'name' => 'required|string|max:255',
//         'category_id' => 'required|exists:categories,id',
//         'supplier_id' => 'required|exists:suppliers,id',
//         'quantity' => 'required|numeric|min:0',
//         'purchase_price' => 'required|numeric|min:0',
//         'selling_price' => 'required|numeric|min:0',
//     ]);

    
//     $validated['user_id'] = Auth::id();

//     Product::create($validated);

//     return redirect()->route('products.index')->with('success', 'Product created successfully.');
// }
    
 // AJAX to fetch purchase data
    public function getPurchaseInfo($purchaseId)
    {
        $purchase = Purchase::with('supplier')->findOrFail($purchaseId);

        return response()->json([
            'name'    => $purchase->name ?? '',
            'purchase_price'  => $purchase->purchase_price,
            'quantity'        => $purchase->quantity,
            'supplier_id'     => $purchase->supplier_id
        ]);
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'purchase_id'   => 'required|exists:purchases,id',
    //         'category_id'   => 'required|exists:categories,id',
    //         'selling_price' => 'required|numeric',
    //     ]);

    //     $purchase = Purchase::with('product')->find($request->purchase_id);

    //     Product::create([
    //         'name'           => $purchase->product->name,
    //         'category_id'    => $request->category_id,
    //         'supplier_id'    => $purchase->supplier_id,
    //         'purchase_price' => $purchase->purchase_price,
    //         'selling_price'  => $request->selling_price,
    //         'quantity'       => $purchase->quantity,
    //         'user_id'        => Auth::id(),
    //         'is_global'      => $request->boolean('is_global'),
    //     ]);

    //     return redirect()->route('products.index')
    //         ->with('success', 'Product created from purchase successfully!');
    // }
    

   public function store(Request $request)
{
    $request->validate([
        'purchase_id'   => 'required|exists:purchases,id',
        'category_id'   => 'required|exists:categories,id',
        'selling_price' => 'required|numeric',
    ]);

    $purchase = Purchase::with('product')->find($request->purchase_id);

    $productName = $purchase->name;

    // Ensure purchase has enough stock
    if ($purchase->quantity <= 0) {
        return back()->with('error', 'Purchase stock is empty. Cannot create product.');
    }

    $addedQty = $purchase->quantity; // quantity to move to product

    // Decrease purchase table quantity
    $purchase->quantity -= $addedQty;
    $purchase->save();

    // Check if product already exists
    $existingProduct = Product::where('name', $productName)->first();

    if ($existingProduct) {

        $oldStock = $existingProduct->quantity;
        $newTotal = $oldStock + $addedQty;

        // Update product stock and other details
        $existingProduct->update([
            'quantity'       => $newTotal,
            'selling_price'  => $request->selling_price,
            'category_id'    => $request->category_id,
            'supplier_id'    => $purchase->supplier_id,
            'purchase_price' => $purchase->purchase_price,
            'is_global'      => $request->boolean('is_global'),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', "Stock updated! Added: $addedQty units. Total Product Stock: $newTotal. Remaining Purchase Stock: $purchase->quantity");
    }

    // Create new product
    Product::create([
        'name'           => $productName,
        'category_id'    => $request->category_id,
        'supplier_id'    => $purchase->supplier_id,
        'purchase_price' => $purchase->purchase_price,
        'selling_price'  => $request->selling_price,
        'quantity'       => $addedQty,
        'user_id'        => Auth::id(),
        'is_global'      => $request->boolean('is_global'),
    ]);

    return redirect()
        ->route('products.index')
        ->with('success', "New product created and purchase stock updated! Added: $addedQty. Remaining Purchase Stock: $purchase->quantity");
}


    public function edit(Product $product)
    {
        // $this->authorize('update', $product); // Optional: use policy to restrict editing

        $categories = Category::all();
        $suppliers = Supplier::all();
        $purchases = Purchase::with('supplier')->get();
        return view('products.edit', compact('product', 'categories', 'suppliers', 'purchases'));
    }

    public function update(Request $request, Product $product)
    {
        // $this->authorize('update', $product); // Optional: use policy

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        // Only admins can change global status
        // if (!Auth::user()->is_admin) {
        //     unset($validated['is_global']);
        // }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
            
    }

    // public function destroy(Product $product)
    // {
    //     // $this->authorize('delete', $product); // Optional: use policy

    //     $product->delete();

    //     return redirect()->route('products.index')
    //         ->with('success', 'Product deleted successfully.');
    // }
    public function destroy(Product $product)
{
    // 🔒 If the product is global and the current user is not an admin, block deletion
    if ($product->is_global && !auth()->user()->hasRole('admin')) {
        return redirect()->route('products.index')
            ->with('error', 'You are not allowed to delete global products.');
    }

    // ✅ Otherwise, allow deletion
    $product->delete();

    return redirect()->route('products.index')
        ->with('success', 'Product deleted successfully.');
}

}
