<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Checkout;
use App\Models\Cart;

class ApiCheckoutController extends Controller
{
    public function __construct()
    {
        // Removed auth middleware to allow unauthenticated access
        // $this->middleware('auth:customer');
    }

    public function index(Request $request): JsonResponse
    {
        $customerId = $request->input('customer_id');

        if (!$customerId) {
            return response()->json(['error' => 'customer_id is required'], 400);
        }

        // Fetch checkout items for the specified customer
        $checkouts = Checkout::where('customer_id', $customerId)->with(['cart', 'customer'])->get();

        return response()->json($checkouts);
    }

    public function show($id): JsonResponse
    {
        // Fetch the checkout item
        $checkout = Checkout::with(['cart', 'customer'])->findOrFail($id);

        return response()->json($checkout);
    }

    public function store(Request $request): JsonResponse
    {
        // Directly retrieve data from the request

        $checkoutDate = $request->input('checkout_date');
        $totalAmount = $request->input('total_amount');
        $checkoutStatus = $request->input('checkout_status');
        $paymentStatus = $request->input('payment_status');
        $billingAddress = $request->input('billing_address');
        $customerId = $request->input('customer_id');
    
 
    
        // Create a new checkout item
        $checkout = new Checkout();
        $checkout->checkout_date = $checkoutDate;
        $checkout->total_amount = $totalAmount;
        $checkout->checkout_status = $checkoutStatus;
        $checkout->payment_status = $paymentStatus;
        $checkout->billing_address = $billingAddress;
        $checkout->customer_id = $customerId;
        $checkout->save();
    
        return response()->json(['success' => true, 'message' => 'Checkout completed successfully!'], 201);
    }
    
}
