<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class CustomerController extends Controller
{

   
    public function skincare() {
        return view('customer.skincare');
    }
   
    public function makeup() {
        return view('customer.makeup');
    }
   
    public function haircare() {
        return view('customer.haircare');
    }
   
    public function bodycare() {
        return view('customer.bodycare');
    }

    public function search(Request $request)
    {
        // Implement the search logic here
        $query = $request->input('query');
        
        // Example: Assuming you have a Product model to search from
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json(['data' => $products]);
    }
   
}