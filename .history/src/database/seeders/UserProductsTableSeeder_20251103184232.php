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
            ->get();
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
            $this->command->info("Product ID {$product->id} (sellerB) set to 'sold' by noProductUser.");
        }

        if (count($productsToSell) < $targetSoldCount) {
            $this->command->warn("注意: sellerBが出品した商品を{$targetSoldCount}個 'sold' にできませんでした。作成できたのは" . count($productsToSell) . "個です。MessagesTableSeederが失敗する可能性があります。");
        }

        //その他のランダムな sold 商品を作成するロジック
        $additionalSoldProductsCount = 1; // 必要に応じて調整

        $availableProducts = Product::where('status', 'sale')
            ->whereNull('consider_id')
            ->where('transaction_status', 'available')
            ->inRandomOrder() // ランダムに並び替える
            ->take($additionalSoldProductsCount)
            ->get();

        foreach ($availableProducts as $product) {
            $sellerId = $product->user_id;
            $potentialBuyers = array_diff($userIds, [$sellerId]); // 出品者以外から購入者を選択

            if (empty($potentialBuyers)) {
                $this->command->warn("Product ID {$product->id}: 購入者が見つからないためスキップします。");
                continue;
            }

            $considerId = collect($potentialBuyers)->random();

            $product->update([
                'consider_id' => $considerId,
                'status' => 'sold',
                'transaction_status' => 'negotiation',
            ]);

            UserProduct::create([
                'user_id' => $considerId,
                'product_id' => $product->id,
                'address' => $faker->address(),
                'post_code' => $faker->postcode(),
                'building' => (rand(0, 1) === 0) ? null : $faker->secondaryAddress(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Product ID {$product->id} (random) set to 'sold' by random user.");
        }
    }
}