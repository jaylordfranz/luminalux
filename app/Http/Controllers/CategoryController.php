<?php

namespace App\Http\Controllers;

use App\Imports\CategoryImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    // API Endpoints

    public function apiIndex(): JsonResponse
    {
        $categories = Category::paginate(10);
        return response()->json($categories);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
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
            'name' => 'required|max:255',
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

    // Frontend Views and DataTables Integration

    public function index(Request $request)
    {
        $categories = Category::latest()->paginate(10);
        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    $actionBtn = '<a href="#" class="btn btn-info btn-sm">View</a> ' .
                        '<a href="#" class="btn btn-warning btn-sm">Edit</a> ' .
                        '<form action="#" method="POST" style="display: inline;">' .
                        '@csrf @method("DELETE")' .
                        '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' .
                        '</form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
}
