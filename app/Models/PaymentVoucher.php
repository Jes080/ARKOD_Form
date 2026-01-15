<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    protected $fillable = [
        'no','pv_date','pv_no','pay_by','account_no',
        'ledger','pay_to','ref_no',
        'total_amount','total_amount_word',
        'bank_cheque_no','cheque_date',
        'prepared_by','approved_by','received_by'
    ];

    // protected $dates = ['pv_date', 'cheque_date'];
    protected $casts = [
        'pv_date' => 'date:Y-m-d',
        'cheque_date' => 'date:Y-m-d',
    ];

    public function items()
    {
        return $this->hasMany(PaymentVoucherItem::class);
    }
}

