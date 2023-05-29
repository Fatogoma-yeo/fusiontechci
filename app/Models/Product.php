<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'media',
        'category_id',
        'status',
        'stock_management',
        'parent_id',
        'author_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function procurement()
    {
        return $this->hasMany(ProcurementsProduct::class);
    }

    public function flux()
    {
        return $this->hasMany(Flux::class);
    }

    public function producthistory()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
