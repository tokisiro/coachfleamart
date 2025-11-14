<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sender_id',
        'receiver_id',
        'message',
        'read_at',
    ];


    //TIMESTAMP 型をCarbon オブジェクトとして扱うためdatetime にキャストする
    //日付操作が簡単に
    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //メッセージの送信者を定義
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    //
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeUnreadForUser($query, int $userId)
    {
        return $query->where('receiver_id', $userId)
                    ->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }
}
