<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user'];
}
