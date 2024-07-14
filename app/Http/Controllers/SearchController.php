<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Perform search query using Spatie
        $searchResults = (new Search())
            ->registerModel(Product::class, 'name')
            ->search($query);

        // Format results for your frontend
        $products = $searchResults->map(function ($result) {
            return [
                'id' => $result->searchable->id,
                'name' => $result->searchable->name,
                'price' => $result->searchable->price,
                'image_url' => $result->searchable->image_url,
            ];
        });

        return response()->json($products);
    }
}
