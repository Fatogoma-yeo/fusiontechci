<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInstalment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_paid',
        'amount_unpaid',
        'order_id',
        'payment_id',
    ];
}
