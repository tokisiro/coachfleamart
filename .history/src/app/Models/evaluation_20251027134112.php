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
}
