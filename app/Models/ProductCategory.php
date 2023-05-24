<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'media_id',
        'displays_on_pos',
        'total_items',
        'author_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
