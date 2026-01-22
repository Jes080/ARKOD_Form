<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentVoucherController;
use App\Http\Controllers\WaybillController;
use App\Models\Invoice;
use App\Models\Waybill;
use App\Models\Customer;


Route::get('/', [DashboardController::class, 'index']);

// Customer Routes
Route::get('/customer', [CustomerController::class, 'index']);
// Route::get('/customers/search', [CustomerController::class, 'search']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
Route::put('/customer/{id}/update', [CustomerController::class, 'update']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
Route::get('/customers/search', function (Request $request) {
    return Customer::where('name', 'LIKE', '%' . $request->q . '%')
        ->get(['id','name','address','postcode','phone','email']);
});


// Invoice Routes
Route::get('/invoice', [InvoiceController::class, 'index']);
Route::post('/invoice/store', [InvoiceController::class, 'store']);
Route::get('/invoice/{id}/print', [InvoiceController::class, 'print']);
Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit']);
Route::put('/invoice/{id}/update', [InvoiceController::class, 'update']);
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy']);

// Waybill Routes
Route::get('/waybill', [WaybillController::class, 'index']);
Route::post('/waybill', [WaybillController::class, 'store']);
Route::post('/waybill/store', [WaybillController::class, 'store']);
Route::get('/waybill/{id}/print', [WaybillController::class, 'print']);
Route::get('/waybill/{id}/edit', [WaybillController::class, 'edit']);
Route::put('/waybill/{id}/update', [WaybillController::class, 'update']);
Route::delete('/waybill/{id}', [WaybillController::class, 'destroy']);

// Payment Voucher Routes
Route::get('/payment-voucher', [PaymentVoucherController::class, 'index']);
Route::post('/payment-voucher/store', [PaymentVoucherController::class, 'store']);
Route::get('/payment-voucher/{id}/print', [PaymentVoucherController::class, 'print']);
Route::get('/payment-voucher/{id}/edit', [PaymentVoucherController::class, 'edit']);
Route::put('/payment-voucher/{id}/update', [PaymentVoucherController::class, 'update']);
Route::delete('/payment-voucher/{id}', [PaymentVoucherController::class, 'destroy']);

/* placeholders */
Route::view('/vehicle-shipping', 'vehicle.index');
