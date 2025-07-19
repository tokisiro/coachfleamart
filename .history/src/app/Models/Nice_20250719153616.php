<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id'];

    public $timestamps = false; // nice_timeだけ管理したい場合はtimestamps不要

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
