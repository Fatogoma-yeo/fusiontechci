<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'cost',
        'invoice_number',
        'invoice_date',
        'payment_status',
        'provider_id',
        'author_id',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function procurementProduct()
    {
        return $this->hasMany(ProcurementsProduct::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function producthistory()
    {
      return $this->hasMany(ProductHistory::class);
    }
}
