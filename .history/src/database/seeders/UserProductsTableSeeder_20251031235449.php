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
    $numberOfSoldProducts = min(count($sellingProductIds), (int)(count($productIds) * 0.2));

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

    //取引中の商品を作成

        $userTransactionCounts = array_fill_keys($userIds, 0);
        //'consider_id' が null で、かつ 'status' が '販売中' の商品IDを全て取得
        $availableForTransactionIds = Product::where('status', '販売中')
        ->whereNull('consider_id')
        ->pluck('id')->toArray();

        $maxTotalTransactions = count($userIds) * 3;
        // 実際に作成する取引中商品の目標数 (利用可能な商品数やユーザー数に応じて調整)
        $targetNumberOfTransactions = min(count($availableForTransactionIds), $maxTotalTransactions);


        // 作成した取引中商品の総数
        $currentTransactionCount = 0;

        // 全てのユーザーに対して、取引中商品を割り当てるループ
        foreach ($userIds as $userId) {
            // このユーザーに割り当てる取引中商品の数をランダムに決定 (1～3件)
            $transactionCountForUser = rand(1, 3);

            // このユーザーに割り当てるべき件数になるまでループ
            while ($userTransactionCounts[$userId] < $transactionCountForUser && $currentTransactionCount < $targetNumberOfTransactions) {
                if (empty($availableForTransactionIds)) {
                    break 2; // 利用可能な商品がなくなったら、全てのループを抜ける
                }

                // 利用可能な商品IDの中からランダムに1つ選択
                $productId = collect($availableForTransactionIds)->random();

                // 選んだ商品IDを使って、Productモデルからその商品の詳細情報を取得
                $product = Product::find($productId);

                // もし商品が見つからなかった場合、そのIDをリストから除外して、次のループに
                if (!$product) {
                    $availableForTransactionIds = array_diff($availableForTransactionIds, [$productId]);
                    continue;
                }

                // 選ばれた商品の出品者（user_id）を取得
                $sellerId = $product->user_id;

                // 出品者自身が購入者になることを防ぐ
                if ($sellerId == $userId) {
                    // この商品は選んだユーザーの出品物なので、別の商品を選ぶ
                    $availableForTransactionIds = array_diff($availableForTransactionIds, [$productId]);
                    continue;
                }

                // 'products' テーブルを更新
                Product::where('id', $productId)->update([
                    'consider_id' => $userId, // このユーザーを購入者として設定
                    'status' => '取引中',
                ]);

                // ユーザーの取引中商品数をインクリメント
                $userTransactionCounts[$userId]++;
                // 全体の取引中商品数もインクリメント
                $currentTransactionCount++;

                // 処理が完了した商品IDをリストから削除
                $availableForTransactionIds = array_diff($availableForTransactionIds, [$productId]);
            }
        }
}
}