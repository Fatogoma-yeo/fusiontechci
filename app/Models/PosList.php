<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosList extends Model
{
    use HasFactory;

    public function countposlist($product_id) {
        $countposlist = PosList::where(['product_id' => $product_id,
         'user_id' => Auth::user()->id])->count();

        return $countposlist;
    }
}
