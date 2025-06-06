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
        $address = preg_replace('/^\d+\s*/', '', $addressFull); // 先頭の数字と空白を除去
        return [
            'user_name' => $faker->name(),
            'icon' => $faker->imageUrl(100, 100), // アイコン用のランダムな画像URL
            'post_code' => $faker->postcode(),
            'address' => $address(),
            'email' => $faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // パスワードを一定にしたい場合
        ];
    }

}
