<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'waybill_no',
        'customer_id',
        'service_type',
        'waybill_date',

        'shipper_name',
        'shipper_attention',
        'shipper_address',
        'shipper_postcode',
        'shipper_phone',
        'shipper_email',

        'receiver_name',
        'receiver_attention',
        'receiver_address',
        'receiver_postcode',
        'receiver_phone',
        'receiver_email',

        'content',
        'category',
        'size',
        'total_weight',
    ];
    protected $casts = [
        'waybill_date' => 'date:Y-m-d',
    ];
}

