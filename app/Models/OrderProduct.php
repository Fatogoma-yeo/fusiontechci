<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'orders_id',
        'product_name',
        'product_category_id',
        'procurement_product_id',
        'status',
        'quantity',
        'discount',
        'discount_percentage',
        'unit_price',
        'total_price',
        'purchase_price',
        'created_at',
    ];

    public function order()
    {
      return $this->belongsTo(Orders::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
