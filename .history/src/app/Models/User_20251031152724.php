<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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


    //このユーザーが送信したメッセージを取得
    public function sentMessages()
    {
        return $this->hasMany(TradeMessage::class, 'sender_id');
    }

    //このユーザーが受信したメッセージを取得
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    //このユーザーが行った評価を取得
    public function givenEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'reviewer_id');
    }

    //このユーザーが受けた評価を取得
    public function receivedEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'reviewed_user_id');
    }

    //平均評価を取得するアクセサ
    public function getAverageRatingAttribute()
    {
        return $this->receivedEvaluations()->avg('rating');
    }

    //総評価数を取得するアクセサ
    public function getTotalEvaluationsAttribute()
    {
        return $this->receivedEvaluations()->count();
    }
}
