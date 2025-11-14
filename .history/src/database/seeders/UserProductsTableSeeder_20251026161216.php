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
        // 外部キー制約を一時的に無効に
        Schema::disableForeignKeyConstraints();

        // 'user_products' テーブルのデータを全て削除
        DB::table('user_products')->truncate();

        DB::table('products')->update(['consider_id' => null, 'status' => '販売中']);

        // 外部キー制約を再度有効に
        Schema::enableForeignKeyConstraints();

        // FakerFactory を使って日本語のダミーデータを生成
        $faker = FakerFactory::create('ja_JP');

        // User モデルから全てのユーザーIDを取得し、配列として $userIds に格納
        $userIds = User::pluck('id')->toArray();

        // Product モデルから全ての商品IDを取得し、配列として $productIds に格納
        $productIds = Product::pluck('id')->toArray();

    //購入履歴を作成

    // 'status' が '販売中' で、かつ 'consider_id' が nullの商品IDを全て取得
    $sellingProductIds = Product::where('status', '販売中')
        ->whereNull('consider_id')
        ->pluck('id')->toArray();

    $numberOfSoldProducts = min(4, count($sellingProductIds));

    // 例：15件の購入履歴を作る
    for ($i = 0; $i < 4; $i++) {

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

            $availableForTransaction = array_diff($availableForTransaction, [$productId]);
        }
}
}