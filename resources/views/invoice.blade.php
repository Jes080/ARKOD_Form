@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Invoices</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#invoiceModal">
            <i class="bi bi-plus-lg"></i> Add Invoice
        </button>
    </div>

    <div class="mb-4">
        <form class="d-flex" style="max-width: 300px;" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search Invoice No" value="{{ request('search') }}">
                <button class="btn btn-add">Search</button>
            </div>
        </form>
    </div>
{{-- <div class="d-flex justify-content-between mb-3">
    <form class="d-flex" method="GET">
        <input type="text" name="search" class="form-control me-2" placeholder="Search Invoice No">
        <button class="btn btn-primary">Search</button>
    </form>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
        <i class="bi bi-plus-circle"></i> Create
    </button>
</div> --}}

<div class="table-responsive">
<table class="table table-custom">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $i => $invoice)
        <tr>
            <td><div> {{ $i+1 }} </div></td>
            <td> <div> {{ $invoice->invoice_no }} </div></td>
            <td class="text-end">
            <div>
                    <a class="action-link link-preview mx-1" 
                    href="/invoice/{{ $invoice->id }}/print" 
                    title="Print Invoice" target="_blank">
                        <i class="bi bi-printer"></i>Print
                    </a>

                    <a class="action-link link-edit mx-2" 
                    data-bs-toggle="modal"
                        data-bs-target="#invoiceModal"
                        data-invoice='@json($invoice)'>
                        <i class="bi bi-pencil-square"></i>Edit
                    </a>

                    <form method="POST" action="/invoice/{{ $invoice->id }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-link link-trash border-0 bg-transparent" 
                                onclick="return confirm('Delete this invoice?')" 
                                title="Delete Invoice">
                            <i class="bi bi-trash"></i>Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

</div>

@include('invoice-form')
@endsection
