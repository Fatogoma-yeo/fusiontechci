<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    // protected $table = 'cash_flows';

    protected $fillable = [
        'expense_id',
        'expense_category_id',
        'procurement_id',
        'order_id',
        'name',
        'operation',
        'customer_account_id',
        'status',
        'value',
        'author_id',
    ];

    public function category()
    {
      return $this->belongsTo(ExpenseCategory::class);
    }
}
