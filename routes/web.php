<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentVoucherController;
use App\Http\Controllers\WaybillController;
use App\Models\Invoice;
use App\Models\Waybill;

Route::get('/', [DashboardController::class, 'index']);

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
Route::delete('/payment-voucher/{id}', [PaymentVoucherController::class, 'destroy']);

/* placeholders */
Route::view('/vehicle-shipping', 'vehicle.index');
