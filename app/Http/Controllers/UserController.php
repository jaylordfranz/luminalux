<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Backend API endpoints
    public function apiIndex(): JsonResponse
    {
        $customers = Customer::paginate(10);
        return response()->json($customers);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8',
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully.',
            'customer' => $customer,
        ], 201);
    }

    public function apiShow(Customer $customer): JsonResponse
    {
        return response()->json($customer);
    }

    public function apiUpdate(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'password' => 'nullable|min:8',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return response()->json([
            'message' => 'User updated successfully.',
            'customer' => $customer,
        ]);
    }

    public function apiDestroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }

    // Frontend views and DataTables integration
    public function index(Request $request)
    {
        $customers = Customer::latest()->paginate(10);

        if ($request->ajax()) {
            return DataTables::of($customers)
                ->addColumn('action', function ($customer) {
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

        return view('admin.users.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8',
        ]);

        Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('admin.users.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.users.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'password' => 'nullable|min:8',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
