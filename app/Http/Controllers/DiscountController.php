<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::paginate(10); // Assuming you have a pagination requirement
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts',
            'description' => 'nullable',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
        ]);

        Discount::create($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount code created successfully.');
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts,code,' . $discount->id,
            'description' => 'nullable',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
        ]);

        $discount->update($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount code updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Discount code deleted successfully.');
    }

    public function show(Discount $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }
}
