<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'first_name',
        'phone',
        'adress',
        'author_id',
        'amount_du',
        'amount_paid',
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }
}
