<?php


namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    // Backend API endpoints
    public function apiIndex(): JsonResponse
    {
        $products = Product::with('category')->paginate(10);
        return response()->json($products);
    }


    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product = Product::create($validated);


        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }


    public function apiShow(Product $product): JsonResponse
    {
        return response()->json($product);
    }


    public function apiUpdate(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product->update($validated);


        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product,
        ]);
    }


    public function apiDestroy(Product $product): JsonResponse
    {
        $product->delete();


        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }


    // Frontend views and DataTables integration
    public function index(Request $request)
{
    $products = Product::with('category')->latest()->paginate(10);
    $categories = Category::all(); // Fetch all categories


    if ($request->ajax()) {
        return DataTables::of($products)
            ->addColumn('category_name', function ($product) {
                return $product->category->name;
            })
            ->addColumn('action', function ($product) {
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


    return view('admin.products.index', compact('products', 'categories'));
}


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);


        Product::create($validated);


        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        return view('customer.product-details', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product->update($validated);


        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
