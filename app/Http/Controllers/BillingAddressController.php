<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\User;


class BillingAddressController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'address_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);


        // Retrieve authenticated user
        $user = auth()->user();


        // Ensure authenticated user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }


        // Create a new billing address for the authenticated user
        $billingAddress = new BillingAddress();
        $billingAddress->customer_id = $user->id; // Set user_id from authenticated user
        $billingAddress->address_name = $validatedData['address_name'];
        $billingAddress->address = $validatedData['address'];
        $billingAddress->contact_number = $validatedData['contact_number'];
        $billingAddress->save();


        return redirect()->route('customer.profile')->with('success', 'Billing address added successfully');
    }


 
    }


    // Other methods like index() and destroy() can remain as previously discussed
