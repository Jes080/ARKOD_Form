<?php
    namespace App\Http\Controllers;

    use App\Models\Customer;
    use Illuminate\Http\Request;

    class CustomerController extends Controller
    {
        public function index()
        {
            $customers = Customer::orderBy('created_at', 'desc')->get();
            return view('customer.customer', compact('customers'));
        }

        public function search(Request $request)
        {
            $q = $request->get('q');

            return Customer::where('name', 'LIKE', "%{$q}%")
                ->orderBy('name')
                ->limit(10)
                ->get([
                    'id',
                    'name',
                    'address',
                    'postcode',
                    'phone',
                    'email'
                ]);
        }


        public function store(Request $request)
        {
            // Match these keys exactly to the 'name' attributes in your HTML
            $validatedData = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'nullable|email',
                'address'  => 'nullable|string',
                'postcode' => 'nullable|string',
                'phone'    => 'nullable|string' // Changed from 'tel' to 'phone'
            ]);

            Customer::create($validatedData);

            return redirect('/customer')->with('success', 'Customer created successfully');
        }

        public function update(Request $request, $id)
        {
            $customer = Customer::findOrFail($id);

            $validatedData = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'nullable|email',
                'address'  => 'nullable|string',
                'postcode' => 'nullable|string',
                'phone'    => 'nullable|string' // Changed from 'tel' to 'phone'
            ]);

            $customer->update($validatedData);

            return redirect('/customer')->with('success', 'Customer updated successfully');
        }

        public function destroy($id)
        {
            Customer::destroy($id);
            return redirect('/customer')->with('success', 'Customer deleted successfully');
        }
    }
?>