<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
{
    $carts = Cart::with('customer', 'product')->latest()->paginate(10);

    if ($request->ajax()) {
        return DataTables::of($carts)
            ->addColumn('customer_name', function ($cart) {
                return $cart->customer->name;
            })
            ->addColumn('product_name', function ($cart) {
                return $cart->product->name;
            })
            ->addColumn('action', function ($cart) {
                $actionBtn = '<a href="#" class="btn btn-info btn-sm">View</a> ' .
                    '<a href="#" class="btn btn-warning btn-sm">Edit</a> ' .
                    '<form action="' . route('carts.destroy', $cart->id) . '" method="POST" style="display: inline;">' .
                    '@csrf @method("DELETE")' .
                    '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' .
                    '</form>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.carts.index', compact('carts'));
}

    public function apiIndex(): JsonResponse
    {
        $carts = Cart::with('customer', 'product')->paginate(10);
        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Fetch logged-in customer ID
        $customerId = Auth::id();

        // Create new cart entry
        $cart = Cart::create([
            'customer_id' => $customerId,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity']
        ]);

        return redirect()->route('carts.index')->with('success', 'Item added to cart successfully.');
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Fetch logged-in customer ID
        $customerId = Auth::id();

        // Create new cart entry
        $cart = Cart::create([
            'customer_id' => $customerId,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity']
        ]);

        return response()->json([
            'message' => 'Item added to cart successfully.',
            'cart' => $cart,
        ], 201);
    }

    public function apiShow(Cart $cart): JsonResponse
    {
        return response()->json($cart->load('customer', 'product'));
    }

    public function apiUpdate(Request $request, Cart $cart): JsonResponse
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $cart->update($validated);

    return response()->json([
        'message' => 'Cart updated successfully.',
        'cart' => $cart,
    ]);
}

public function apiDestroy(Cart $cart): JsonResponse
{
    $cart->delete();

    return response()->json([
        'message' => 'Item removed from cart successfully.',
    ]);
}
}
