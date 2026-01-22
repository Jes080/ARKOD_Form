@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Customer Information</h4>

    <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#customerModal">
        + Add Customer
    </button>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->phone }}</td>
                <td>{{ $c->email }}</td>
                <td>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#customerModal"
                        data-customer='@json($c)'>Edit</button>

                    <form action="/customer/{{ $c->id }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete?')">×</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- {{ $customers->links() }} --}}
</div>

@include('customer.customer-form')

@endsection
