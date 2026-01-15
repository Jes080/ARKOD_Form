@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Payment Vouchers</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#pvModal">
            <i class="bi bi-plus-lg"></i> Add Payment Voucher
        </button>
    </div>

    <div class="mb-4">
        <form class="d-flex" style="max-width: 300px;" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search Payment Voucher No" value="{{ request('search') }}">
                <button class="btn btn-add">Search</button>
            </div>
        </form>
    </div>

<div class="table-responsive">
<table class="table table-custom">
    <thead>
        <tr>
            <th>No</th>
            <th>Payment Voucher</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vouchers as $i => $voucher)
        <tr>
            <td><div> {{ $i+1 }} </div></td>
            <td> <div> {{ $voucher->pv_no }} </div></td>
            <td class="text-end">
            <div>
                    <a class="action-link link-preview mx-1" 
                    href="/payment-voucher/{{ $voucher->id }}/print" 
                    title="Print Payment Voucher" target="_blank">
                        <i class="bi bi-printer"></i>Print
                    </a>

                    <a class="action-link link-edit mx-2" 
                    data-bs-toggle="modal"
                        data-bs-target="#pvModal"
                        data-voucher='@json($voucher)'>
                        <i class="bi bi-pencil-square"></i>Edit
                    </a>

                    <form method="POST" action="/payment-voucher/{{ $voucher->id }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-link link-trash border-0 bg-transparent" 
                                onclick="return confirm('Delete this payment voucher?')" 
                                title="Delete Payment Voucher">
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

@include('payment_voucher.pv-form')
@endsection
