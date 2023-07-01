<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'number',
        'amount',
        'date',
        'author_id',
    ];
}
