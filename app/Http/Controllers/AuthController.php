<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Use bcrypt for hashing password
        ]);

        Auth::guard('customer')->login($customer);

        return response()->json([
            'message' => 'User registered successfully.',
            'redirect' => route('customer.dashboard')
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid login credentials.'], 422);
        }

        // Attempt to authenticate the user
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Retrieve the authenticated customer
            $customer = Auth::guard('customer')->user();

            // Check if the customer account is active
            if ($customer->isActive()) {
                return response()->json([
                    'message' => 'Login successful.',
                    'redirect' => route('customer.dashboard')
                ]);
            } else {
                // Logout the user if account is inactive
                Auth::guard('customer')->logout();
                return response()->json(['message' => 'Your account is disabled. Please contact support.'], 403);
            }
        } else {
            return response()->json(['message' => 'Invalid login credentials.'], 401);
        }
    }
}