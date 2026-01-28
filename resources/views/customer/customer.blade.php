@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Customer Information</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#customerModal">
            <i class="bi bi-plus-lg"></i> Add Customer
        </button>
    </div>

    <div class="mb-4">
        <form class="d-flex" style="max-width: 300px;" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0" 
                       placeholder="Search" value="{{ request('search') }}">
                <button type="submit" class="btn btn-add">Search</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->address }}</td>
                    <td class="text-end">
                        <a href="javascript:void(0)" class="action-link link-edit mx-2" 
                           data-bs-toggle="modal" 
                           data-bs-target="#customerModal" 
                           data-customer='@json($c)'>
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form method="POST" action="/customer/{{ $c->id }}" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="action-link link-trash border-0 bg-transparent" 
                                    onclick="return confirm('Delete this customer?')" 
                                    title="Delete Customer">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('customer.customer-form')
@endsection