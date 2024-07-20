<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout; // Ensure this is the correct model for orders

class AdminOrderController extends Controller
{
    // Display a listing of all orders
    public function index()
    {
        // Load related data
        $orders = Checkout::with('customer', 'cart') // Adjust based on actual relationships
            ->get(); // You might want to use pagination for large datasets

        return view('admin.orders.index', compact('orders'));
    }

    // Show the details of a specific order
    public function show($id)
    {
        $order = Checkout::with('customer', 'cart') // Adjust based on actual relationships
            ->findOrFail($id); // Fetch the order by ID or fail

        return view('admin.orders.show', compact('order'));
    }

    // Show the form for editing a specific order
    public function edit($id)
    {
        $order = Checkout::findOrFail($id); // Fetch the order by ID or fail
        $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']; // Possible statuses for checkout
        $paymentStatuses = ['Unpaid', 'Paid']; // Possible statuses for payment

        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    // Update the specified order in storage
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'checkout_status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $order = Checkout::findOrFail($id); // Fetch the order by ID or fail

        $order->checkout_status = $validatedData['checkout_status'];
        $order->payment_status = $validatedData['payment_status'];
        $order->save(); // Save the updated order

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully!');
    }
}
