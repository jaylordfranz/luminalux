<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerChartController extends Controller
{
    public function getUserActivityData()
    {
        $activeUsers = Customer::where('status', 'active')->get(['name']);
        $inactiveUsers = Customer::where('status', 'inactive')->get(['name']);
        return response()->json([
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
        ]);
    }
}