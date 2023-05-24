<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementsProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'gross_purchase_price',
        'net_purchase_price',
        'purchase_price',
        'product_id',
        'procurement_id',
        'quantity',
        'total_purchase_price',
        'author_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function provider()
    {
        return $this->hasMany(Provider::class);
    }
}
