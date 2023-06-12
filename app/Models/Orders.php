<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_payment_date',
        'support_instalments',
        'discount',
        'discount_percentage',
        'subtotal',
        'total',
        'payment_status',
        'process_status',
        'delivery_status',
        'customer_id',
        'author',
        'total_instalments',
        'discount_type',
    ];

    public function orderProduct()
    {
      return $this->hasMany(OrderProduct::class);
    }

    public function customer()
    {
      return $this->belongsTo(Client::class);
    }
}
