<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer'); // Ensure only authenticated customers can access this controller
    }

    public function addToCart(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::guard('customer')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $customerId = Auth::guard('customer')->id();

        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Add to cart or update if already exists
        $cart = Cart::updateOrCreate(
            [
                'customer_id' => $customerId,
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
    }

    public function showCart()
    {
        // Fetch cart items for the logged-in customer
        $customerId = Auth::guard('customer')->id();
        $cartItems = Cart::where('customer_id', $customerId)->with('product')->get();

        return view('customer.cart', ['cartItems' => $cartItems]);
    }

    public function removeFromCart($id)
{
    $customerId = Auth::guard('customer')->id();
    Cart::where('id', $id)->where('customer_id', $customerId)->delete();
    
    return redirect()->route('customer.cart')->with('success', 'Item removed from cart.');
}

public function showUpdateForm($id)
    {
        $customerId = Auth::guard('customer')->id();
        $cartItem = Cart::where('id', $id)->where('customer_id', $customerId)->firstOrFail();

        return view('customer.update-cart', ['cartItem' => $cartItem]);
    }

    // Method to handle the update request
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $customerId = Auth::guard('customer')->id();
        $cartItem = Cart::where('id', $id)->where('customer_id', $customerId)->firstOrFail();

        // Update the cart item quantity
        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return redirect()->route('customer.cart')->with('success', 'Cart item updated successfully.');
    }
}
