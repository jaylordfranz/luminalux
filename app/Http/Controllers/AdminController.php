<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        // Logic to store user
    }

    public function updateUser(Request $request, $id)
    {
        // Logic to update user
    }

    public function deleteUser($id)
    {
        // Logic to delete user
    }

    public function showProducts()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        // Logic to store product
    }

    public function updateProduct(Request $request, $id)
    {
        // Logic to update product
    }

    public function deleteProduct($id)
    {
        // Logic to delete product
    }

    public function showPayments()
    {
        $payments = Payment::all();
        return view('admin.payments', compact('payments'));
    }

    public function verifyPayment($id)
    {
        // Logic to verify payment
    }

    public function rejectPayment($id)
    {
        // Logic to reject payment
    }

    public function showOrders()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrder(Request $request, $id)
    {
        // Logic to update order
    }

    public function cancelOrder($id)
    {
        // Logic to cancel order
    }

    public function showReviews()
    {
        $reviews = Review::all();
        return view('admin.reviews', compact('reviews'));
    }

    public function deleteReview($id)
    {
        // Logic to delete review
    }
}
