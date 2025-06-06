<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    use HasFactory;

    いいねテーブル（nice）
	いいねしたユーザーのID（外部キー）(user_id)
	商品のID（外部キー）(product_id)
	いいねした日時(nice_time)
}
