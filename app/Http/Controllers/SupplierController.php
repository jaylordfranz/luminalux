<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;


use App\Models\Supplier;
use Illuminate\Http\Request;






class SupplierController extends Controller
{
    // public function index()
    // {
    //     $suppliers = Supplier::all();
    //     return view('suppliers.index', compact('suppliers'));
    // }


    public function index()
    {
        $suppliers = Supplier::paginate(20); // Paginate with 10 items per page, adjust as needed
        return view('admin.suppliers.index', compact('suppliers'));
    }


    public function create()
    {
        return view('admin.suppliers.create');
    }
   


    public function store(Request $request)
    {
        $request->validate([
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
        $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'address' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
   
        $images = [];
   
        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }
   
        // Handle deletion of old images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                // Delete the image file from storage if it exists
                if (Storage::disk('public')->exists($imageToDelete)) {
                    Storage::disk('public')->delete($imageToDelete);
                }
            }
        }
   
        // Update supplier details
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
