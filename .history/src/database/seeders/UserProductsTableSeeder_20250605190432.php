<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('userproducts')->truncate();
        $faker = FakerFactory::create('ja_JP');
        $userIds = \App\Models\User::pluck('id')->toArray();
        $productIds = \App\Models\Product::pluck('id')->toArray();

        // 例：50件の購入履歴を作る
    for ($i = 0; $i < 15; $i++) {
        \DB::table('user_products')->insert([
            'user_id' => collect($userIds)->random(),
            'product_id' => collect($productIds)->random(), // これがポイント
            'shipping_address' => $faker->address(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}