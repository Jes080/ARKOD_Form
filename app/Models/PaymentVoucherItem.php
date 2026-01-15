<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherItem extends Model
{
    protected $fillable = [
        'detail_no','payment_details','amount'
    ];

    public function voucher()
    {
        return $this->belongsTo(PaymentVoucher::class);
    }
}

