<?php

namespace App\Models;



class User extends Model
{
    use HasFactory;

    protected $fillable =['user_name','icon','post_code','address','email','password'];
}
