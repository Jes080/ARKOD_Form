<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_date',
        'no',
        'invoice_no',
        'customer_id',
        'sst_percentage',
        'payment_method',
        'company_name',
        'attention',
        'address',
        'phone',
        'payment_terms',
        'due_date',
        'subtotal',
        'sst_amount',
        'final_price',
    ];

    protected $casts = [
        'invoice_date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
