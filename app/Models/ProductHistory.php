<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_id',
        'order_id',
        'operation',
        'before_quantity',
        'quantity',
        'after_quantity',
        'unit_price',
        'purchase_price',
        'total_price',
        'procurement_id',
        'procurement_name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function procurement()
    {
      return $this->belongsTo(Procurement::class);
    }
}
