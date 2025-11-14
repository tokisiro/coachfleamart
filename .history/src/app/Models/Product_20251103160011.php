<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','consider_id','image','brand_name','situation','product_name','explanation','price','status','transaction_status'];

    // 出品者（ユーザー）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //購入検討中ユーザー
    public function considerUser()
    {
        return $this->belongsTo(User::class, 'consider_id');
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

    // その商品を購入した購入者
    public function buyerUserProduct()
    {
        return $this->hasOne(UserProduct::class);
    }

    public function getBuyerAttribute()
    {
        return $this->buyerUserProduct ? $this->buyerUserProduct->user : null;
    }

    // その商品に対する評価
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }


    //この商品に関するチャット内容を取得
    public function Messages()
    {
        return $this->hasMany(Message::class);
    }

}
