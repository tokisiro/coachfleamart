<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','image','brand_name','situation','product_name','explanation','price','status'];

    // 出品者（ユーザー）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 商品カテゴリ
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }

    // いいね
    public function nices()
    {
        return $this->hasMany(Nice::class);
    }

    // 購入履歴
    public function userProducts()
    {
        return $this->hasMany(UserProduct::class);
    }
}
