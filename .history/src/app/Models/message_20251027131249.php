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

    // read_at カラムを Carbon インスタンス(日付時刻の実体)として扱う
    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

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
