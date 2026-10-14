<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'credit_limit' => $request->credit_limit ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer created successfully!');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $customer = Customer::find($id);
        if (!$customer){
            return redirect()->route('admin.customers')->with('error', 'Customer not found');
        }
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'credit_limit' => $request->credit_limit ?? 0,
            'is_active' => $request->has('is_active'),
        ]);
    }
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer){
            return redirect()->route('admin.customers')->with('error', 'Customer not found');
        }
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully!');
    }
}
