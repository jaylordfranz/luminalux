<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {   
        {
            $query = $request->input('query');
        
            // Example logic: Fetch products based on the query
            $products = Product::where('name', 'like', '%'.$query.'%')->get();
        
            return response()->json($products);
        }
        

 
    }
}

