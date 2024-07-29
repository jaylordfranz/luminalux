<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    // Backend API endpoints
    public function apiIndex(): JsonResponse
    {
        $inventories = Inventory::with('product')->paginate(10);
        return response()->json($inventories);
    }

    public function apiStore(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0'
        ]);
    
        $inventory = new Inventory();
        $inventory->product_id = $validatedData['product_id'];
        $inventory->quantity = $validatedData['quantity'];
        $inventory->save();
    
        return response()->json(['success' => true, 'data' => $inventory]);
    }
    

    public function apiShow(Inventory $inventory): JsonResponse
    {
        $inventory->load('product');
        return response()->json($inventory);
    }

    public function apiUpdate(Request $request, Inventory $inventory): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        return response()->json([
            'message' => 'Inventory updated successfully.',
            'inventory' => $inventory,
        ]);
    }

    public function apiDestroy(Inventory $inventory): JsonResponse
    {
        $inventory->delete();

        return response()->json([
            'message' => 'Inventory deleted successfully.',
        ]);
    }

    // Frontend views and DataTables integration
    public function index(Request $request)
    {
        $inventories = Inventory::with('product')->latest()->paginate(10);
        $products = Product::all(); // Fetch all products

        if ($request->ajax()) {
            return DataTables::of($inventories)
                ->addColumn('product_name', function ($inventory) {
                    return $inventory->product->name;
                })
                ->addColumn('action', function ($inventory) {
                    $actionBtn = '<a href="' . route('inventory.show', $inventory->id) . '" class="btn btn-info btn-sm">View</a> ' .
                        '<a href="' . route('inventory.edit', $inventory->id) . '" class="btn btn-warning btn-sm">Edit</a> ' .
                        '<form action="' . route('inventory.destroy', $inventory->id) . '" method="POST" style="display: inline;">' .
                        '@csrf @method("DELETE")' .
                        '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' .
                        '</form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.inventory.index', compact('inventories', 'products'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory created successfully.');
   
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('product');
        return view('admin.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    // Excel Import
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new InventoryImport, $request->file('file'));
            return redirect()->route('inventories.index')->with('success', 'Inventories imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('inventories.index')->with('error', 'Error importing inventories: ' . $e->getMessage());
        }
    }
}