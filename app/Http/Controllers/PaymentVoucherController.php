<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentVoucher;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentVoucherController extends Controller
{
    public function index(Request $request)
    {
        // $query = PaymentVoucher::with('items')->latest();
        $query = PaymentVoucher::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('pv_no', 'like', '%' . $request->search . '%');
        }

        return view('payment_voucher.pv', [
            // 'vouchers' => $query->get(),
            'vouchers' => $query->with('items')->latest()->get(),
            'voucher' => new PaymentVoucher()
        ]);
    }

    public function store(Request $request)
    {
        $date = $request->date('pv_date');

        $items = $request->items ?? [];

        $total = collect($items)->sum(function ($item) {
            return $item['amount'] ?? 0;
        });

        $voucher = PaymentVoucher::create([
            'no' => $request->no,
            'pv_date' => $date->format('Y-m-d'),
            'pv_no' => 'PV' . $date->format('Ym') . '-' . $request->no,
            'pay_by' => $request->pay_by,
            'account_no' => $request->account_no,
            'ledger' => $request->ledger,
            'pay_to' => $request->pay_to,
            'ref_no' => $request->ref_no,
            'total_amount' => $total,
            'total_amount_word' => $request->total_amount_word,
            'bank_cheque_no' => $request->bank_cheque_no,
            'cheque_date' => $request->cheque_date,
            'prepared_by' => $request->prepared_by,
            'approved_by' => $request->approved_by,
            'received_by' => $request->received_by,
        ]);

        foreach ($items as $item) {
            if (!empty($item['payment_details']) || !empty($item['amount'])) {
                $voucher->items()->create([
                    'detail_no' => $item['detail_no'] ?? null,
                    'payment_details' => $item['payment_details'],
                    'amount' => $item['amount'] ?? 0,
                ]);
            }
        }

        return redirect('/payment-voucher')->with('success', 'Payment Voucher created');
    }

    public function update(Request $request, $id)
    {
        $voucher = PaymentVoucher::with('items')->findOrFail($id);

        $date = $request->date('pv_date');

        $items = $request->items ?? [];
        $total = collect($items)->sum(fn($i) => $i['amount'] ?? 0);

        $voucher->update([
            'no' => $request->no,
            'pv_date' => $date->format('Y-m-d'),
            'pay_by' => $request->pay_by,
            'account_no' => $request->account_no,
            'ledger' => $request->ledger,
            'pay_to' => $request->pay_to,
            'ref_no' => $request->ref_no,
            'total_amount' => $total,
            'total_amount_word' => $request->total_amount_word,
            'bank_cheque_no' => $request->bank_cheque_no,
            'cheque_date' => $request->cheque_date,
            'prepared_by' => $request->prepared_by,
            'approved_by' => $request->approved_by,
            'received_by' => $request->received_by,
        ]);

        $voucher->items()->delete();

        foreach ($items as $item) {
            if (!empty($item['payment_details']) || !empty($item['amount'])) {
                $voucher->items()->create([
                    'detail_no' => $item['detail_no'] ?? null,
                    'payment_details' => $item['payment_details'],
                    'amount' => $item['amount'] ?? 0,
                ]);
            }
        }

        return redirect('/payment-voucher')->with('success', 'Payment Voucher updated');
    }

    public function print($id)
    {
        $voucher = PaymentVoucher::with('items')->findOrFail($id);

        $pdf = PDF::loadView('payment_voucher.pv-print', compact('voucher'));

        return $pdf->stream($voucher->pv_no . '.pdf');
    }

    public function destroy($id)
    {
        // PaymentVoucher::destroy($id);
        $voucher = PaymentVoucher::findOrFail($id);
        $voucher->items()->delete();
        $voucher->delete();
        return redirect('/payment-voucher')->with('success', 'Payment Voucher deleted');
    }
}

