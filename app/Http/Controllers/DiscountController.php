<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\DiscountsImport;
use Maatwebsite\Excel\Facades\Excel;

class DiscountController extends Controller
{
    // Backend API endpoints
    public function apiIndex(): JsonResponse
    {
        $discounts = Discount::paginate(10);
        return response()->json($discounts);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|max:255|unique:discounts',
            'description' => 'required',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);

        $discount = Discount::create($validated);

        return response()->json([
            'message' => 'Discount created successfully.',
            'discount' => $discount,
        ], 201);
    }

    public function apiShow(Discount $discount): JsonResponse
    {
        return response()->json($discount);
    }

    public function apiUpdate(Request $request, Discount $discount): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|max:255|unique:discounts,code,' . $discount->id,
            'description' => 'required',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);

        $discount->update($validated);

        return response()->json([
            'message' => 'Discount updated successfully.',
            'discount' => $discount,
        ]);
    }

    public function apiDestroy(Discount $discount): JsonResponse
    {
        $discount->delete();

        return response()->json([
            'message' => 'Discount deleted successfully.',
        ]);
    }

    // Excel Import
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new DiscountsImport, $request->file('file'));
            return redirect()->route('discounts.index')->with('success', 'Discounts imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('discounts.index')->with('error', 'Error importing discounts: ' . $e->getMessage());
        }
    }

    // Frontend views and DataTables integration
    public function index(Request $request)
    {
        $discounts = Discount::latest()->paginate(10);
        if ($request->ajax()) {
            return DataTables::of($discounts)
                ->addColumn('action', function ($discount) {
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
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|max:255|unique:discounts',
            'description' => 'required',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);
        Discount::create($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function show(Discount $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|max:255|unique:discounts,code,' . $discount->id,
            'description' => 'required',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);
        $discount->update($validated);
        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
