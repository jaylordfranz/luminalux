<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Cart;

class ApiCartController extends Controller
{
  
    public function index(): JsonResponse
    {
        // Fetch all cart items with their associated products
        $cartItems = Cart::with('product')->get();

        return response()->json($cartItems);
    }

    public function show($id): JsonResponse
    {
        // Fetch the cart item with its associated product
        $cartItem = Cart::with('product')->findOrFail($id);

        return response()->json($cartItem);
    }

    

    public function store(Request $request): JsonResponse
    {
        // Directly retrieve data from the request
        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Create a new cart item
        $cart = new Cart();
        $cart->customer_id = $customerId;
        $cart->product_id = $productId;
        $cart->quantity = $quantity;
        $cart->save();

        return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
    }
}
