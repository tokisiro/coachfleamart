<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $addressFull = $faker->address();
        
        return [
            'user_name' => $faker->name(),
            'icon' => $faker->imageUrl(100, 100), // アイコン用のランダムな画像URL
            'post_code' => $faker->postcode(),
            'address' => $faker->address(),
            'email' => $faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // パスワードを一定にしたい場合
        ];
    }

}
