<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User_product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable =['user_name','icon','post_code','address','email','password'];
}
