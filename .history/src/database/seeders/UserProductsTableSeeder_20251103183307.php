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

        // 全ての商品のステータスを'sale'にリセット (consider_id, transaction_status も null/available に)
        DB::table('products')->update(['consider_id' => null, 'status' => 'sale', 'transaction_status' => 'available']);

        Schema::enableForeignKeyConstraints();

        $faker = FakerFactory::create('ja_JP');
        $userIds = User::pluck('id')->toArray();
        $sellerB = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        // --- sellerBが出品した商品を2つ'sold'にするロジック ---
        // sellerBが出品した、かつ'sale'状態の商品のIDを取得
        $sellerBSaleProducts = Product::where('user_id', $sellerB->id)
            ->where('status', 'sale')
            ->where('transaction_status', 'available')
            ->pluck('id')->toArray();

        // MessagesTableSeederが求める2つのsold商品を作成するため
        $targetSoldCount = 2; // sellerBの商品を sold にする目標数

        // ランダムに $targetSoldCount 個の商品を選択
        $productsToSell = $sellerBSaleProducts->shuffle()->take($targetSoldCount);

        foreach ($productsToSell as $product) {
            $considerId = $noProductUser->id;

            // Product モデルを直接更新
            $product->update([
                'consider_id' => $considerId,
                'status' => 'sold',
                'transaction_status' => 'negotiation',
            ]);

            UserProduct::create([
                'user_id' => $considerId,
                'product_id' => $product->id,
                'address' => $faker->address(), // faker->address() は郵便番号も含めて返す場合があるので注意
                'post_code' => $faker->postcode(),
                'building' => (rand(0, 1) === 0) ? null : $faker->secondaryAddress(), // nullを許容
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            

            // 購入者として noProductUser を設定
            $considerId = $noProductUser->id;

            Product::where('id', $productId)->update([
                'consider_id' => $considerId,
                'status' => 'sold',
                'transaction_status' => 'negotiation', // sold にするなら negotiation にするのが自然
            ]);

            // user_products テーブルに購入履歴を挿入
            $this->insertUserProductRecord($considerId, $productId, $faker);

            $this->command->info("Product ID {$productId} (sellerB) set to 'sold' by noProductUser.");
        }

        if (count($productsToSell) < $targetSoldCount) {
            $this->command->warn("注意: sellerBが出品した商品を{$targetSoldCount}個 'sold' にできませんでした。作成できたのは" . count($productsToSell) . "個です。MessagesTableSeederが失敗する可能性があります。");
        }
        // --- ここまでで sellerB の指定数の sold 商品が作成されます ---


        // --- 残りのランダムなsold商品作成ロジック (オプション) ---
        // 上記で noProductUser が購入した sellerB の sold 商品を生成したので、
        // 元々あったランダムなsold商品の生成ロジックは必要に応じて調整するか削除します。
        // もし他の出品者のsold商品もランダムに作りたいなら、以下のロジックを続けることができます。

        // 'status' が 'sale' で、かつ 'consider_id' が nullの商品IDを全て取得
        // (sellerBの商品で'sold'になったものは含まれない)
        $remainingSellingProductIds = Product::where('status', 'sale')
            ->whereNull('consider_id')
            ->where('transaction_status', 'available')
            ->pluck('id')->toArray();

        // ランダムにさらに sold 商品を作成する場合 (例: 1つ)
        // $additionalSoldCount = min(1, count($remainingSellingProductIds));
        // 今回は MessagesTableSeeder の要件を満たしたので、追加のランダム sold は作成しない (0)
        $additionalSoldCount = 0;


        for ($i = 0; $i < $additionalSoldCount; $i++) {
            if (empty($remainingSellingProductIds)) {
                break;
            }

            $productId = collect($remainingSellingProductIds)->random();
            $product = Product::find($productId);

            if (!$product) {
                $remainingSellingProductIds = array_diff($remainingSellingProductIds, [$productId]);
                continue;
            }

            $sellerId = $product->user_id;
            $potentialBuyers = array_diff($userIds, [$sellerId]);

            if (empty($potentialBuyers)) {
                $remainingSellingProductIds = array_diff($remainingSellingProductIds, [$productId]);
                continue;
            }

            $considerId = collect($potentialBuyers)->random();

            Product::where('id', $productId)->update([
                'consider_id' => $considerId,
                'status' => 'sold',
                'transaction_status' => 'negotiation',
            ]);

            $this->insertUserProductRecord($considerId, $productId, $faker);

            $remainingSellingProductIds = array_diff($remainingSellingProductIds, [$productId]);
            $this->command->info("Product ID {$productId} (random seller) set to 'sold' by random user.");
        }
    }

    // user_products レコード挿入用のヘルパーメソッド
    private function insertUserProductRecord($considerId, $productId, $faker)
    {
        $addressFull = $faker->address();
        $cleanAddress = preg_replace('/^\d+\s*/', '', $addressFull);
        $address = preg_replace('/^\d+\s*/', '', $cleanAddress);
        $buildingValue = (rand(0, 1) === 0) ? '' : $faker->secondaryAddress();

        DB::table('user_products')->insert([
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