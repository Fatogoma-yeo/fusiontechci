<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    // protected $table = 'expense_categories';

    protected $fillable = [
        'name',
        'operation',
        'account',
        'author_id',
    ];

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }

    public function cashflow()
    {
      return $this->hasMany(CashFlow::class);
    }

}
