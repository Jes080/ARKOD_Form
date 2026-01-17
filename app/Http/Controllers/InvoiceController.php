<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('invoice_no', 'like', '%' . $request->search . '%');
        }

        return view('invoice', [
            'invoices' => $query->with('items')->latest()->get(),
            'invoice' => new Invoice()
        ]);
    }

    public function store(Request $request)
    {
        $date = $request->date('invoice_date');
        if (!$date) {
            return back()->withErrors(['invoice_date' => 'The date field is required.']);
        }

        $dueDate = $request->date('due_date');

        // Ensure items always exist as array
        $items = $request->items ?? [];

        // Calculate subtotal
        $subtotal = collect($items)->sum(function ($item) {
            return ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
        });

        $sstPercentage = $request->sst_percentage ?? 0;
        $sst = $subtotal * ($sstPercentage / 100);

        $invoice = Invoice::create([
            // 'invoice_date'   => $request->date('invoice_date')->format('d-m-y'),
            'invoice_date'   => $date->format('Y-m-d'),
            'no'             => $request->no,
            // 'invoice_no'     => 'ARKOD' . $request->date('invoice_date')->format('ymd') . $request->customer_id . '-INV' . $request->no,
            'invoice_no'     => 'ARKOD' . $date->format('ymd')  . $request->customer_id . '-INV' . $request->no,
            'customer_id'    => $request->customer_id,
            'sst_percentage' => $sstPercentage,
            'payment_method' => $request->payment_method,

            'company_name'   => $request->company_name,
            'attention'      => $request->attention,
            'address'        => $request->address,
            'phone'          => $request->phone,

            'payment_terms'  => $request->payment_terms, // nullable
            'due_date'       => $dueDate ? $dueDate->format('Y-m-d') : null,     // nullable

            'subtotal'       => $subtotal,
            'sst_amount'     => $sst,
            'final_price'    => $subtotal + $sst,
        ]);

        // Save items
        foreach ($items as $item) {
            if (
                isset($item['quantity'], $item['description'], $item['unit_price'])
            ) {
                $invoice->items()->create([
                    'quantity'    => $item['quantity'],
                    'description' => $item['description'],
                    'unit_price'  => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }
        }

        return redirect('/invoice');
    }

    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        return view('invoice-form', [
            'invoice' => $invoice,
            'items'   => $invoice->items,
            'isEdit'  => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        $date = $request->date('invoice_date');
        $dueDate = $request->date('due_date');

        $items = $request->items ?? [];

        $subtotal = collect($items)->sum(function ($item) {
            return ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
        });

        $sstPercentage = $request->sst_percentage ?? 0;
        $sst = $subtotal * ($sstPercentage / 100);

        $invoice->update([
            // 'invoice_date'   => $request->date('invoice_date')->format('d-m-y'),
            'invoice_date'   => $date->format('Y-m-d'),
            'customer_id'    => $request->customer_id,
            'invoice_no'     => 'ARKOD' . $request->date('invoice_date')->format('ymd') . $request->customer_id . '-INV' . $request->no,
            'sst_percentage' => $sstPercentage,
            'payment_method' => $request->payment_method,

            'company_name'   => $request->company_name,
            'attention'      => $request->attention,
            'address'        => $request->address,
            'phone'          => $request->phone,

            'payment_terms'  => $request->payment_terms, // nullable
            'due_date'       => $dueDate ? $dueDate->format('Y-m-d') : null,      // nullable

            'subtotal'       => $subtotal,
            'sst_amount'     => $sst,
            'final_price'    => $subtotal + $sst,
        ]);

        // Remove old items
        $invoice->items()->delete();

        // Insert updated items
        foreach ($items as $item) {
            // if (isset($item['quantity'], $item['description'], $item['unit_price'])) {
            if (!empty($item['description']) || (!empty($item['quantity']) && $item['quantity'] != 0) || (!empty($item['unit_price']) && $item['unit_price'] != 0)) {
                $qty = ($item['quantity'] != 0 && !empty($item['quantity'])) ? $item['quantity'] : null;
                $unitPrice = ($item['unit_price'] != 0 && !empty($item['unit_price'])) ? $item['unit_price'] : null;

                $invoice->items()->create([
                    'quantity'    => $qty,
                    'description' => $item['description'] ?? '', 
                    'unit_price'  => $unitPrice,
                    // We still calculate total_price as 0 so your math doesn't break
                    'total_price' => ($qty && $unitPrice) ? ($qty * $unitPrice) : 0,
                ]);
            }
        }

        return redirect('/invoice')->with('success', 'Invoice updated successfully');
    }



    public function print($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        $data = [
            'no'             => $invoice->no,
            'invoice_no'     => $invoice->invoice_no,
            // 'date'           => $invoice->invoice_date,
            'date'           => Carbon::parse($invoice->invoice_date)->format('d-m-Y'),
            'customer_id'    => $invoice->customer_id,
            'payment_method' => $invoice->payment_method,

            'name'           => $invoice->company_name,
            'attention'      => $invoice->attention,
            'address'        => $invoice->address,
            'tel'            => $invoice->phone,

            'payment_terms'  => $invoice->payment_terms,
            // 'due_date'       => $invoice->due_date,
            'due_date'       => $invoice->due_date ? Carbon::parse($invoice->due_date)->format('d-m-Y') : null,

            'items'          => $invoice->items,
            'subtotal'       => $invoice->subtotal,
            'sstPercentage'  => $invoice->sst_percentage,
            'sst'            => $invoice->sst_amount,
            'final_price'    => $invoice->final_price,
        ];

        $pdf = PDF::loadView('invoice-print', $data);

        $filename = $invoice->invoice_no . '.pdf';
        return new Response(
            $pdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]
        );
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();
        
        return redirect('/invoice')->with('success', 'Invoice deleted successfully');
    }
}
