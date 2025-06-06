<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'user_name' => $this->faker->name(),
            'icon' => $this->faker->imageUrl(100, 100), // アイコン用のランダムな画像URL
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // パスワードを一定にしたい場合
        ];
    }

}
