<?php


namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function Index()
    {
        $categories = Category::paginate(10); // Using pagination
        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);


        Category::create($validated);


        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }




    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);


        $category->update($validated);


        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        $category->delete();


        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }


    public function productCounts()
    {
        $categories = Category::withCount('products')->get(['id', 'name', 'description', 'products_count']);


        return response()->json($categories);
    }

}
