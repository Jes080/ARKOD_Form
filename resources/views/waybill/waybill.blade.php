@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Waybills</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#waybillModal">
            <i class="bi bi-plus-lg"></i> Add Waybill
        </button>
    </div>

    <div class="mb-4">
        <form class="d-flex" style="max-width: 300px;" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search Waybill No">
                <button class="btn btn-add">Search</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waybill</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- loop waybills later --}}
                @foreach($waybills as $i => $waybill)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $waybill->waybill_no }}</td>
                    <td class="text-end">
                        <a class="action-link link-preview mx-1" 
                            href="/waybill/{{ $waybill->id }}/print" 
                            title="Print Waybill" target="_blank">
                            <i class="bi bi-printer"></i>Print
                        </a>
                        <a class="action-link link-edit mx-2" 
                            data-bs-toggle="modal"
                            data-bs-target="#waybillModal"
                            data-waybill='@json($waybill)'>
                            <i class="bi bi-pencil-square"></i>Edit
                        </a>
                        <form method="POST" action="/waybill/{{ $waybill->id }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-link link-trash border-0 bg-transparent" 
                                    onclick="return confirm('Delete this waybill?')" 
                                    title="Delete Waybill">
                                <i class="bi bi-trash"></i>Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@include('waybill.waybill-form')
@endsection
