<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Checkout::select('id', 'customer_id', 'checkout_date', 'total_amount', 'payment_status')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function edit($id)
    {
        $payment = Checkout::find($id);
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|string|max:255',
        ]);

        $payment = Checkout::find($id);
        $payment->payment_status = $request->payment_status;
        $payment->save();

        return redirect()->route('admin.payments.index')->with('success', 'Payment status updated successfully.');
    }
}