<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // public function __construct()
    // {
    //     // Apply the auth middleware to ensure only authenticated users can access the index method
    //     $this->middleware('auth');
    // }
    // public function index()
    // {
    //     // Check if the user is authenticated
    //     if (Auth::check()) {
    //         // Get the authenticated user's ID
    //         $userId = Auth::id();

    //         // Fetch orders of the authenticated user
    //         $orders = Checkout::where('customer_id', $userId)->get();

    //         // Return the orders view with the fetched orders
    //         return view('customer.orders.index', compact('orders'));
    //     } else {
    //         // Redirect to login if the user is not authenticated
    //     }
    // }
    public function __construct()
    {
        $this->middleware('auth:customer'); // Ensure only authenticated customers can access this controller
    }

    public function index()
    {
        // Fetch orders for the logged-in customer
        $customerId = Auth::guard('customer')->id();
        $orders = Checkout::where('customer_id', $customerId)->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function getOrderReceipt($orderId)
{
    $order = Checkout::findOrFail($orderId);
    return response()->json($order);
}

public function getOrderReceiptView($orderId)
{
    $order = Checkout::findOrFail($orderId);
    return view('customer.orders.receipt', compact('order'));
}
}
