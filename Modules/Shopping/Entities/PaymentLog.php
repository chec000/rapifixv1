<?php

namespace Modules\Shopping\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model {

    protected $table = 'shop_payment_logs';
    protected $fillable = [
        'order_id',
        'bank_id',
        'request',
        'response',
        'status'
    ];
}
