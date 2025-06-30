<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
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
        Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('user_products')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = FakerFactory::create('ja_JP');
        $userIds = \App\Models\User::pluck('id')->toArray();
        $productIds = \App\Models\Product::pluck('id')->toArray();

        // 例：15件の購入履歴を作る
    for ($i = 0; $i < 15; $i++) {
        $addressFull = $faker->address();
        // 例として、「マンション」や「ルーム」などのキーワードを除去
        $cleanAddress = preg_replace('/[^ ]+[0-9]+号/', '', $addressFull);
        $address = preg_replace('/\s+/', ' ', trim($cleanAddress)); // 先頭の数字と空白を除去

        \DB::table('user_products')->insert([
            'user_id' => collect($userIds)->random(),
            'product_id' => collect($productIds)->random(), // これがポイント
            'shipping_address' => trim($address),
            'post_code' => $faker->postcode(),
            'building' => $faker->secondaryAddress(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}