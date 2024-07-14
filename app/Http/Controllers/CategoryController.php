<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoryImport;

class CategoryController extends Controller
{
    // Backend API endpoints
    public function apiIndex(Request $request): JsonResponse
{
    $categories = Category::paginate($request->get('length', 10), ['*'], 'page', $request->get('start', 1) / $request->get('length', 10) + 1);
    return response()->json([
        'draw' => $request->get('draw'),
        'recordsTotal' => $categories->total(),
        'recordsFiltered' => $categories->total(),
        'data' => $categories->items(),
    ]);
}



    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'required',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category,
        ], 201);
    }

    public function apiShow(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function apiUpdate(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'required',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => $category,
        ]);
    }

    public function apiDestroy(Category $category): JsonResponse
{
    $category->delete();

    return response()->json([
        'message' => 'Category deleted successfully.',
    ]);
}


    public function apiProductCounts(): JsonResponse
    {
        $categories = Category::withCount('products')->get(['id', 'name', 'description', 'products_count']);

        return response()->json($categories);
    }

    // Excel Import
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new CategoryImport, $request->file('file'));
            return redirect()->route('categories.index')->with('success', 'Categories imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Error importing categories: ' . $e->getMessage());
        }
    }

    // Frontend views and DataTables integration
    public function index(Request $request)
{
    if ($request->ajax()) {
        $categories = Category::latest()->get();
        return DataTables::of($categories)
            ->addColumn('action', function ($category) {
                $actionBtn = '<a href="' . route('categories.show', $category->id) . '" class="btn btn-info btn-sm">View</a> ' .
                    '<a href="' . route('categories.edit', $category->id) . '" class="btn btn-warning btn-sm">Edit</a> ' .
                    '<form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display: inline;">' .
                    '@csrf @method("DELETE")' .
                    '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' .
                    '</form>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.categories.index');
}


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories',
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
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'required',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): JsonResponse
{
    $category->delete();

    return response()->json([
        'success' => true,
        'message' => 'Category deleted successfully.',
    ]);
}
}
