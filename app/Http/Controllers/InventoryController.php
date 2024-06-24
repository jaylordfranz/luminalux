<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('admin.inventory.index', compact('inventories'));
    }

    public function create()
    {
        // Assuming you pass a list of products to choose from
        $products = \App\Models\Product::all();
        return view('admin.inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'last_updated' => now(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory added successfully.');
    }

    public function edit(Inventory $inventory)
    {
        $products = \App\Models\Product::all();
        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $inventory->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'last_updated' => now(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.inventory.show', compact('inventory'));
    }
}
