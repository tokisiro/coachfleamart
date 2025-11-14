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
        DB::table('user_products')->truncate();
        DB::table('products')->update(['consider_id' => null, 'status' => '販売中']);
        Schema::enableForeignKeyConstraints();

        $faker = FakerFactory::create('ja_JP');
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        // 例：15件の購入履歴を作る
    for ($i = 0; $i < 15; $i++) {

        $considerId = collect($userIds)->random();
        $productId = collect($productIds)->random();

        Product::where('id', $productId)->update([
                'consider_id' => $buyerId,
            ]);

        $addressFull = $faker->address();
        $cleanAddress = preg_replace('/^\d+\s*/', '', $addressFull);
        $address = preg_replace('/^\d+\s*/', '', $cleanAddress);
        $buildingValue = (rand(0, 1) === 0) ? '' : $faker->secondaryAddress();

        \DB::table('user_products')->insert([
            'user_id' => $considerId,
            'product_id' => $productId,
            'address' => $address,
            'post_code' => $faker->postcode(),
            'building' => $buildingValue,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}