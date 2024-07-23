<?php
    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BillingAddress;

class CustomerProfileController extends Controller
{
    /**
     * Display the customer profile information.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return redirect()->route('login')->withErrors('You need to be logged in to view this page.');
        }

        $billingAddresses = BillingAddress::where('customer_id', $user->id)->get();

        return view('customer.editProfile', compact('user', 'billingAddresses'));
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return redirect()->route('login')->withErrors('You need to be logged in to view this page.');
        }

        $billingAddresses = BillingAddress::where('customer_id', $user->id)->get();

        return view('customer.editProfile', compact('user', 'billingAddresses'));
    }

    /**
     * Update the profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return redirect()->route('login')->withErrors('You need to be logged in to update your profile.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $user->id,
            'default_address' => 'nullable|exists:billing_addresses,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'default_billing_address_id' => $request->default_address,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }
}
