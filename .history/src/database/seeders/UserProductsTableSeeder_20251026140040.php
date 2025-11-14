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

    $productIdsNotInUserProducts = Product::whereNotIn('id', DB::table('user_products')->pluck('product_id'))
    ->pluck('id')->toArray();

    for ($i = 0; $i < min(5, count($productIdsNotInUserProducts)); $i++) { // 5件まで、または残りの商品数まで
            $productId = collect($productIdsNotInUserProducts)->random();
            $product = Product::find($productId);

            if ($product) {
                $sellerId = $product->user_id; // 出品者
                $potentialBuyers = array_diff($userIds, [$sellerId]); // 出品者以外のユーザー
                if (empty($potentialBuyers)) {
                    continue; // 買い手がいなければスキップ
                }
                $buyerId = collect($potentialBuyers)->random(); // 出品者ではないユーザーを買い手とする

                Product::where('id', $productId)->update([
                    'considerId' => $buyerId,
                ]);

                // user_products には挿入しない (まだ購入完了していないため)
            }
        }
}
}