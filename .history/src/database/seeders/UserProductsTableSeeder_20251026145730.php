<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;

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

        $availableProducts = Product::whereNull('consider_id')
            ->orWhere('status', '販売中')
            ->pluck('id')->toArray();

            if (empty($availableProducts)) {
                break;
            }

            $productId = collect($availableProducts)->random();
            $product = Product::find($productId);

            if (!$product) {
                continue;
            }

            $sellerId = $product->user_id;
            $potentialBuyers = array_diff($userIds, [$sellerId]);

            if (empty($potentialBuyers)) {
                // 出品者以外の購入者がいない場合（例：ユーザーが1人しかいないなど）
                continue;
            }
            $considerId = collect($potentialBuyers)->random();

        Product::where('id', $productId)->update([
                'consider_id' => $considerId,
                'status' => '売却済み',
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

    $availableForTransaction = Product::whereNull('consider_id')
        ->where('status', '販売中')
        ->pluck('id')->toArray();


    for ($i = 0; $i < min(5, count($availableForTransaction)); $i++) {

        if (empty($availableForTransaction)) {
                break; // 利用可能な商品がなければループを抜ける
            }
            $productId = collect($availableForTransaction)->random();
            $product = Product::find($productId);

            if (!$product) {
                    continue;
                }
                $sellerId = $product->user_id; // 出品者
            $potentialBuyers = array_diff($userIds, [$sellerId]); // 出品者以外のユーザー
            if (empty($potentialBuyers)) {
                continue; // 買い手がいなければスキップ
            }
            $considerId = collect($potentialBuyers)->random(); // 出品者ではないユーザーを買い手とする

            Product::where('id', $productId)->update([
                'consider_id' => $considerId,
                'status' => '取引中', // 取引中としてマーク
            ]);
        }
}
}