<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','shipping_address'];

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
