<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Evaluation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EvaluationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Evaluation::truncate();

        $soldProducts = Product::where('status', '売却済み')->get();


        $user1 = User::where('email', 'seller_a@example.com')->first();
        $user2 = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        foreach ($soldProducts as $product) {
            $sellerId = $product->user_id; // 出品者
            $buyerId = $product->consider_id; // 購入者 (UserProductsTableSeederで設定されたconsider_id)

            // 出品者と購入者が両方存在することを確認
            if ($sellerId && $buyerId) {

                // 購入者が出品者を評価する
                Evaluation::create([
                    'product_id' => $product->id,
                    'reviewer_id' => $buyerId, // 評価者: 購入者
                    'reviewed_user_id' => $sellerId, // 評価されたユーザー: 出品者
                    'rating' => rand(4, 5), // 良い評価を多めに
                    'role_as_reviewed' => 'seller', // 評価されたsellerの役割はseller
                    'created_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23)),
                ]);

                // 出品者が購入者を評価する
                Evaluation::create([
                    'product_id' => $product->id,
                    'reviewer_id' => $sellerId, // 評価者: 出品者
                    'reviewed_user_id' => $buyerId, // 評価されたユーザー: 購入者
                    'rating' => rand(4, 5), // 良い評価を多めに
                    'role_as_reviewed' => 'buyer', // 評価されたbuyerの役割はbuyer
                    'created_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23))->addMinutes(rand(10, 60)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23))->addMinutes(rand(10, 60)),
                ]);
            }
        }

        $availableProducts = Product::where('status', '販売中')
                                    ->whereNull('consider_id')
                                    ->get();

        if ($user1 && $user2 && $availableProducts->isNotEmpty()) {
            // user1が出品している商品を取得、または一般の商品を取得
            $productForUser1Seller = $availableProducts->where('user_id', $user1->id)->first();
            if (!$productForUser1Seller) {
                // user1が出品している商品がなければ、他の販売中の商品をランダムに選んでuser1の出品とする
                $productForUser1Seller = $availableProducts->random();
                if($productForUser1Seller) {
                    $productForUser1Seller->user_id = $user1->id; // 出品者を user1 に変更 (あくまでシーダー内での擬似的な変更)
                }
            }

            if ($productForUser1Seller) {
                // user2 を購入者として設定し、ステータスを「売却済み」にする
                $productForUser1Seller->consider_id = $user2->id;
                $productForUser1Seller->status = '売却済み';
                $productForUser1Seller->save(); // データベースに保存

                // user2 が user1 を評価
                Evaluation::create([
                    'product_id' => $productForUser1Seller->id,
                    'reviewer_id' => $user2->id, // 評価者: user2 (購入者)
                    'reviewed_user_id' => $user1->id, // 評価されたユーザー: user1 (出品者)
                    'rating' => rand(4, 5),
                    'role_as_reviewed' => 'seller',
                    'created_at' => Carbon::now()->subDays(5),
                    'updated_at' => Carbon::now()->subDays(5),
                ]);

                // user1 が user2 を評価
                Evaluation::create([
                    'product_id' => $productForUser1Seller->id,
                    'reviewer_id' => $user1->id, // 評価者: user1 (出品者)
                    'reviewed_user_id' => $user2->id, // 評価されたユーザー: user2 (購入者)
                    'rating' => rand(3, 4), // 少し低い評価も
                    'role_as_reviewed' => 'buyer',
                    'created_at' => Carbon::now()->subDays(5)->addMinutes(rand(10, 60)),
                    'updated_at' => Carbon::now()->subDays(5)->addMinutes(rand(10, 60)),
                ]);

                // 既に売却済みになった商品は availableProducts から除外
                $availableProducts = $availableProducts->except($productForUser1Seller->id);
            }
        }

        // user2 が出品者となる「売却済み」商品を作成し、user1 が購入者となる評価を追加
        if ($user1 && $user2 && $availableProducts->isNotEmpty()) {
            // user2が出品している商品を取得、または一般の商品を取得
            $productForUser2Seller = $availableProducts->where('user_id', $user2->id)->first();
            if (!$productForUser2Seller) {
                $productForUser2Seller = $availableProducts->random();
                if($productForUser2Seller) {
                    $productForUser2Seller->user_id = $user2->id; // 出品者を user2 に変更
                }
            }

            if ($productForUser2Seller) {
                // user1 を購入者として設定し、ステータスを「売却済み」にする
                $productForUser2Seller->consider_id = $user1->id;
                $productForUser2Seller->status = '売却済み';
                $productForUser2Seller->save(); // データベースに保存

                // user1 が user2 を評価
                Evaluation::create([
                    'product_id' => $productForUser2Seller->id,
                    'reviewer_id' => $user1->id, // 評価者: user1 (購入者)
                    'reviewed_user_id' => $user2->id, // 評価されたユーザー: user2 (出品者)
                    'rating' => rand(5, 5), // 高い評価
                    'role_as_reviewed' => 'seller',
                    'created_at' => Carbon::now()->subDays(7),
                    'updated_at' => Carbon::now()->subDays(7),
                ]);

                // user2 が user1 を評価
                Evaluation::create([
                    'product_id' => $productForUser2Seller->id,
                    'reviewer_id' => $user2->id, // 評価者: user2 (出品者)
                    'reviewed_user_id' => $user1->id, // 評価されたユーザー: user1 (購入者)
                    'rating' => rand(4, 5),
                    'role_as_reviewed' => 'buyer',
                    'created_at' => Carbon::now()->subDays(7)->addMinutes(rand(10, 60)),
                    'updated_at' => Carbon::now()->subDays(7)->addMinutes(rand(10, 60)),
                ]);

                // 既に売却済みになった商品は availableProducts から除外
                $availableProducts = $availableProducts->except($productForUser2Seller->id);
            }
        }
    }
}