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

    // 作成したい「売却済み」の商品の数を設定
    $numberOfSoldProducts = min(2, count($sellingProductIds));

    // $numberOfSoldProducts の回数だけループして、「売却済み」の商品と購入履歴を作成
    for ($i = 0; $i < $numberOfSoldProducts; $i++) {

            if (empty($sellingProductIds)) {
                break;
            }

            // 利用可能な商品IDの中からランダムに1つ選ぶ
            $productId = collect($sellingProductIds)->random();

            // 選んだ商品IDを使って、Productモデルからその商品の詳細情報を取得
            $product = Product::find($productId);

            // もし商品が見つからなかった場合、そのIDをリストから除外して、次のループに
            if (!$product) {
                $sellingProductIds = array_diff($sellingProductIds, [$productId]);
                continue;
            }

            // 選ばれた商品の出品者（user_id）を取得
            $sellerId = $product->user_id;

            // 全ユーザーIDから出品者を除外したリストを作成
            //出品者自身が購入者になることを防ぐ
            $potentialBuyers = array_diff($userIds, [$sellerId]);

            // もし出品者以外の購入者が誰もいない場合、スキップして次のループに
            if (empty($potentialBuyers)) {
                $sellingProductIds = array_diff($sellingProductIds, [$productId]);
                continue;
            }

            //出品者以外の購入者候補の中からランダムに1人を選び、そのIDを $considerId（購入者ID）とする
            $considerId = collect($potentialBuyers)->random();

            // 選ばれた商品の 'consider_id' を購入者IDに設定し、'status' を '売却済み' にします。
            Product::where('id', $productId)->update([
                'consider_id' => $considerId,
                'status' => '売却済み',
            ]);


    // 'user_products' テーブルに購入履歴のレコードを挿入


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

        // 処理が完了した商品IDを $sellingProductIds のリストから削除し、同じ商品が再度「売却済み」として選択されるのを防ぐ
        $sellingProductIds = array_diff($sellingProductIds, [$productId]);
    }

    //取引中」の商品を作成

        //'consider_id' が null で、かつ 'status' が '販売中' の商品IDを全て取得
        $availableForTransaction = Product::where('status', '販売中')
        ->whereNull('consider_id')
        ->pluck('id')->toArray();

        // 作成したい「取引中」の商品の数を設定
        $numberOfTransactionProducts = min(5, count($availableForTransactionIds));

        // $numberOfTransactionProducts の回数だけループ
        for ($i = 0; $i < $numberOfTransactionProducts; $i++) {

        if (empty($availableForTransactionIds)) {
                break;
            }

            // 利用可能な商品IDの中からランダムに1つ選択
            $productId = collect($availableForTransactionIds)->random();

            // 選んだ商品IDを使って、Productモデルからその商品の詳細情報を取得
            $product = Product::find($productId);

            // もし商品が見つからなかった場合、そのIDをリストから除外して次のループに
            if (!$product) {
                    $availableForTransactionIds = array_diff($availableForTransactionIds, [$productId]);
                    continue;
                }


            // 選ばれた商品の出品者（user_id）を取得
            $sellerId = $product->user_id;
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