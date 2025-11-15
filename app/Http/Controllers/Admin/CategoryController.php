<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth; // ✅ important

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function index() {

    //     $categories = Category::latest()->paginate(10)
    //         ->visibleTo(Auth::user())
    //     ;
    //     return view('admin.categories.index', compact('categories'));
    // }

    public function index() {
    $categories = Category::latest()
        ->visibleTo(Auth::user())
        ->paginate(10);

    return view('admin.categories.index', compact('categories'));
}

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:categories']);
          $validated['user_id'] = auth()->id();
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$category->id]);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}