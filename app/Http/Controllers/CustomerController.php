<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
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
    
}
