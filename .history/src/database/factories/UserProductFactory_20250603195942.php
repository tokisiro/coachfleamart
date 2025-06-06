<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserProductFactory extends Factory
{
    protected $model = \App\Models\UserProduct::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // 直接ファクトリで作成も可
            'product_id' => \App\Models\Product::factory(),
            'purchase_date' => $this->faker->dateTimeBetween('-1 years'), // 過去一年以内の購入日
            'shipping_address' => $this->faker->address(),
            // 'created_at'と'updated_at'は$fakerに含まれるtimestamps()自動適用
        ];
    }
}
