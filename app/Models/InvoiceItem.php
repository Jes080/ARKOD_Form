<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public $fillable = [
        'invoice_id',
        'description',
        'quantity',  // <--- Add this here
        'total_price',
        'unit_price',
        'subtotal_price',
        'final_price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
