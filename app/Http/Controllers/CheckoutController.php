<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\BillingAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $cartItems = Cart::where('customer_id', $customerId)->with('product')->get();
        $totalAmount = $cartItems->sum(function($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        $billingAddresses = BillingAddress::where('customer_id', $customerId)->get();

        return view('customer.checkout', [
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
            'billingAddresses' => $billingAddresses,
        ]);
    }

    public function processCheckout(Request $request)
    {
        $customerId = Auth::guard('customer')->id();

        $request->validate([
            'billing_address' => 'required|exists:billing_addresses,id',
        ]);

        $cartItems = Cart::where('customer_id', $customerId)->with('product')->get();
        $totalAmount = $cartItems->sum(function($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        $checkout = new Checkout();
        $checkout->customer_id = $customerId;
        $checkout->checkout_date = Carbon::now();
        $checkout->total_amount = $totalAmount;
        $checkout->checkout_status = 'Pending';
        $checkout->payment_status = 'Pending';
        $checkout->billing_address = $request->billing_address;
        $checkout->save();

        // Clear the cart after checkout
        Cart::where('customer_id', $customerId)->delete();

        return redirect()->route('customer.profile')->with('success', 'Checkout completed successfully!');
    }
}
