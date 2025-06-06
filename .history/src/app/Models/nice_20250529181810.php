<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id',];

    // ユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 商品
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
