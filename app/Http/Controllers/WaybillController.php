<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Waybill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class WaybillController extends Controller
{
    public function index(Request $request)
    {
        $query = Waybill::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('waybill_no', 'like', '%' . $request->search . '%');
        }

        return view('waybill.waybill', [
            'waybills' => $query->get(),
            'waybill'  => new Waybill()
        ]);
    }

    public function store(Request $request)
    {
        $date = $request->date('waybill_date');

        if (!$date) {
            return back()->withErrors(['waybill_date' => 'The date field is required.']);
        }

        Waybill::create([
            'no' => $request->no,
            'waybill_date' => $date->format('Y-m-d'),
            'waybill_no' => 'ARKOD' . $date->format('ymd') . '-WB' . $request->no,
            'customer_id' => $request->customer_id,

            // ✅ MULTIPLE SERVICE TYPE (ARRAY → JSON AUTO VIA CAST)
            'service_type' => $request->service_type ?? [],

            'shipper_name' => $request->shipper['name'],
            'shipper_attention' => $request->shipper['attention'] ?? null,
            'shipper_address' => $request->shipper['address'],
            'shipper_postcode' => $request->shipper['postcode'],
            'shipper_phone' => $request->shipper['tel'],
            'shipper_email' => $request->shipper['email'] ?? null,

            'receiver_name' => $request->receiver['name'],
            'receiver_attention' => $request->receiver['attention'] ?? null,
            'receiver_address' => $request->receiver['address'],
            'receiver_postcode' => $request->receiver['postcode'],
            'receiver_phone' => $request->receiver['tel'],
            'receiver_email' => $request->receiver['email'] ?? null,

            'content' => $request->order['content'] ?? null,
            'category' => $request->order['category'] ?? null,
            'size' => $request->order['size'] ?? null,
            'total_weight' => $request->order['total_weight'] ?? null,
        ]);

        return redirect('/waybill')->with('success', 'Waybill created successfully');
    }

    public function print($id)
    {
        $waybill = Waybill::findOrFail($id);

        $data = [
            'customer_id'  => $waybill->customer_id,
            'waybill_no'   => $waybill->waybill_no,
            'waybill_date' => $waybill->waybill_date->format('d-m-Y'),

            // ✅ ARRAY
            'service_type' => $waybill->service_type,

            'shipper' => [
                'name'     => $waybill->shipper_name,
                'address'  => $waybill->shipper_address,
                'postcode' => $waybill->shipper_postcode,
                'attention'=> $waybill->shipper_attention,
                'tel'      => $waybill->shipper_phone,
                'email'    => $waybill->shipper_email,
            ],
            'receiver' => [
                'name'     => $waybill->receiver_name,
                'address'  => $waybill->receiver_address,
                'postcode' => $waybill->receiver_postcode,
                'attention'=> $waybill->receiver_attention,
                'tel'      => $waybill->receiver_phone,
                'email'    => $waybill->receiver_email,
            ],
            'order' => [
                'content'  => $waybill->content,
                'category' => $waybill->category,
                'size'     => $waybill->size,
                'total_weight' => $waybill->total_weight,
            ],
        ];

        $pdf = PDF::loadView('waybill.waybill-print', $data);
        return $pdf->stream($waybill->waybill_no . '.pdf');
    }

    public function edit($id)
    {
        return response()->json(Waybill::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $waybill = Waybill::findOrFail($id);

        $waybill->update([
            'waybill_date' => $request->date('waybill_date')->format('Y-m-d'),
            'customer_id'  => $request->customer_id,
            'waybill_no'   => 'ARKOD' . Carbon::parse($request->date('waybill_date'))->format('ymd') . '-WB' . $request->no,

            // ✅ MULTIPLE SERVICE TYPE
            'service_type' => $request->service_type ?? [],

            'shipper_name' => $request->shipper['name'],
            'shipper_attention' => $request->shipper['attention'] ?? null,
            'shipper_address' => $request->shipper['address'],
            'shipper_postcode' => $request->shipper['postcode'],
            'shipper_phone' => $request->shipper['tel'],
            'shipper_email' => $request->shipper['email'] ?? null,

            'receiver_name' => $request->receiver['name'],
            'receiver_attention' => $request->receiver['attention'] ?? null,
            'receiver_address' => $request->receiver['address'],
            'receiver_postcode' => $request->receiver['postcode'],
            'receiver_phone' => $request->receiver['tel'],
            'receiver_email' => $request->receiver['email'] ?? null,

            'content' => $request->order['content'] ?? null,
            'category' => $request->order['category'] ?? null,
            'size' => $request->order['size'] ?? null,
            'total_weight' => $request->order['total_weight'] ?? null,
        ]);

        return redirect('/waybill')->with('success', 'Waybill updated successfully');
    }

    public function destroy($id)
    {
        Waybill::destroy($id);
        return redirect('/waybill')->with('success', 'Waybill deleted successfully');
    }
}
