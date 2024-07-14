<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart; // Make sure to import Cart model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Illuminate\Support\Facades\Log;

class CustomerProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['data' => $products]);
    }

    public function show($id)
    {
        Log::info('Fetching product with id: ' . $id);

        $product = Product::find($id);

        if (!$product) {
            Log::warning('Product not found for id: ' . $id);
            return redirect()->route('customer.dashboard')->with('error', 'Product not found.');
        }

        return view('customer.product-details', compact('product'));
    }

    public function dashboard()
    {
        // Example: Return a view for the customer dashboard
        return view('customer.dashboard');
    }

    public function addToCart(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        
        // Retrieve the authenticated user
        $user = Auth::user();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the product by ID
            $product = Product::findOrFail($id);

            // Check if requested quantity is available
            if ($quantity > $product->stock_quantity) {
                return response()->json(['error' => 'Requested quantity exceeds available stock.'], 422);
            }

            // Deduct the stock quantity
            $product->stock_quantity -= $quantity;
            $product->save();

            // Create a new cart entry
            $cart = new Cart();
            $cart->customer_id = $user->id; // Assuming customer_id is the user's ID
            $cart->product_id = $product->id;
            $cart->quantity = $quantity;
            $cart->save();

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Product added to cart successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction on exception
            DB::rollback();
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add product to cart.'], 500);
        }
    }
}
