<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryChartController extends Controller
{
    public function getData()
    {
        $inventoryData = Inventory::with('product')
            ->selectRaw('products.name as product_name, sum(quantity) as total_quantity')
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->groupBy('product_name')
            ->get();

        return response()->json($inventoryData);
    }
}
