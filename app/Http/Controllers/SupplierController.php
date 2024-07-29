<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    // Backend API endpoints

    public function apiIndex(): JsonResponse
    {
        $suppliers = Supplier::paginate(10);
        return response()->json($suppliers);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'address' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'images' => $images
        ]);

        return response()->json([
            'message' => 'Supplier created successfully.',
            'supplier' => $supplier,
        ], 201);
    }

    public function apiShow(Supplier $supplier): JsonResponse
    {
        return response()->json($supplier);
    }

    public function apiUpdate(Request $request, Supplier $supplier): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'address' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = $supplier->images;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                if (Storage::disk('public')->exists($imageToDelete)) {
                    Storage::disk('public')->delete($imageToDelete);
                }
            }
        }

        $supplier->update([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'images' => $images
        ]);

        return response()->json([
            'message' => 'Supplier updated successfully.',
            'supplier' => $supplier,
        ]);
    }

    public function apiDestroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();
        return response()->json([
            'message' => 'Supplier deleted successfully.',
        ]);
    }

    // Frontend views
    public function index(Request $request)
    {
        $suppliers = Supplier::latest()->paginate(10);
        if ($request->ajax()) {
            return DataTables::of($suppliers)
                ->addColumn('action', function ($supplier) {
                    $actionBtn = '<a href="#" class="btn btn-info btn-sm">View</a> ' .
                        '<a href="#" class="btn btn-warning btn-sm">Edit</a> ' .
                        '<form action="#" method="POST" style="display: inline;">' .
                        '@csrf @method("DELETE")' .
                        '<button type="submit" class="btn btn-danger btn-sm">Delete</button>' .
                        '</form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'address' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        Supplier::create([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'images' => $images
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'address' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $images = $supplier->images;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                if (Storage::disk('public')->exists($imageToDelete)) {
                    Storage::disk('public')->delete($imageToDelete);
                }
            }
        }

        $supplier->update([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'images' => $images
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
