<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    // Fetch orders of the logged-in user
    $userId = Auth::id();
    dd($userId); // Check if the user ID is being fetched correctly
    $orders = Checkout::where('customer_id', $userId)->get();
    return view('orders.index', compact('orders'));
}
}