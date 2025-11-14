<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable{
    use HasFactory;

    protected $fillable =['name','icon','post_code','address','building','email','password','email_verified',];

    protected $casts = [
        'email_verified' => 'boolean',
    ];

    // 購入履歴とのリレーション
    public function userProducts()
    {
        return $this->hasMany(UserProduct::class);
    }

    // コメント
    public function productComments()
    {
        return $this->hasMany(ProductComment::class);
    }

    // いいね
    public function nices()
    {
        return $this->hasMany(Nice::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
