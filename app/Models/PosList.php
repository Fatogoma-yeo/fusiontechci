<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PosList extends Model
{
    use HasFactory;

    public static function countposlist($product_id) {
        $countposlist = PosList::where(['product_id' => $product_id,
         'author_id' => Auth::id()])->where('is_gross', 0)->count();

        return $countposlist;
    }
}
