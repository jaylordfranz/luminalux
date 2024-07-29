<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutChartController extends Controller
{
    public function getCheckoutData()
    {
        $checkouts = Checkout::select('id as order_id', 'total_amount')
            ->get();

        return response()->json($checkouts);
    }
}