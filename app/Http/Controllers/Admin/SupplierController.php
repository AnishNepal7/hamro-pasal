<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller

{
     
    public function index()
    {
        //authenticated user's suppliers
        
        // Auth::user();
        // $suppliers = Supplier::latest()->paginate(10);
        // return view('admin.suppliers.index', compact('suppliers'));

        // Get suppliers of the authenticated user, latest first, 10 per page
    $suppliers = Supplier::where('user_id', Auth::id())
                         ->latest()
                         ->paginate(10);

    return view('admin.suppliers.index', compact('suppliers'));
        // $suppliers = Supplier::all(); 
        // return view('admin.suppliers.index', compact('suppliers'));
        //  $suppliers = Supplier::where('user_id', Auth::id())->get();
        // return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|unique:suppliers,name',
            'company' => 'nullable|string',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);
         Supplier::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'company' => $request->company,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ]);
                return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created.');

        
        // Supplier::create($validated);
        // return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created.');
    }

    public function edit(Supplier $supplier)
    {
         // Ensure the authenticated user owns this supplier
        if ($supplier->user_id !== Auth::id()) {
            abort(403);
        }
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        if ($supplier->user_id !== Auth::id()) {
            abort(403);
        }
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255|unique:suppliers,name,'.$supplier->id
        // ]);
         $request->validate([
            'name' => 'required|unique:suppliers,name,' . $supplier->id,
            'company' => 'nullable|string',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);
        
        // $supplier->update($validate);
         $supplier->update([
            'name' => $request->name,
            'company' => $request->company,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        // $supplier->delete();
        // return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted.');
         // Ensure the authenticated user owns this supplier
    if ($supplier->user_id !== Auth::id()) {
        abort(403);
    }

    $supplier->delete();

    return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}