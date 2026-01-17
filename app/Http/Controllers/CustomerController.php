<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // For the "Auto-complete" search
    public function search(Request $request)
    {
        $search = $request->get('q');
        return Customer::where('name', 'LIKE', "%$search%")
            ->get(['name', 'address', 'postcode', 'phone', 'email']);
    }

    // Standard store for a Customer Management page
    public function store(Request $request) {
        Customer::create($request->all());
        return back()->with('success', 'Customer added');
    }
}