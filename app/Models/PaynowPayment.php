<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaynowPayment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'reference',
        'payment_status',
    ];
}
