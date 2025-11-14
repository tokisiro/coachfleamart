<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reviewer_id',
        'reviewed_user_id',
        'rating',
        'comment',
        'role_as_reviewed',
    ];

    protected $casts = [
        'rating' => 'integer', // rating カラムを整数として扱う
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //評価を行った User を定義
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    //評価を受けた User を定義
    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    //特定のユーザーが「受けた」評価を取得
    public function scopeReceivedBy($query, int $userId)
    {
        return $query->where('reviewed_user_id', $userId);
    }

    public function scopeGivenBy($query, int $userId)
    {
        return $query->where('reviewer_id', $userId);
    }

    public function scopeRoleAsReviewed($query, string $role)
    {
        return $query->where('role_as_reviewed', $role);
    }
}
