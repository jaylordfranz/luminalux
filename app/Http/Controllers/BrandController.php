<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::select('id', 'brand_name')->get(); // Adjust columns as per your table structure
        return response()->json($brands);
    }
}