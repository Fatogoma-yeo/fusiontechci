<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'first_name',
        'phone',
        'gender',
        'author_id',
        'birth_date',
        'purchase_amount',
        'owed_amount',
        'credit_limit_amount',
        'account_amount',
    ];
}
