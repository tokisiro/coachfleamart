<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Evaluation;
use Carbon\Carbon;


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

        foreach ($soldProducts as $product) {
            $sellerId = $product->user_id; // 出品者
            $buyerId = $product->consider_id; // 購入者 (UserProductsTableSeederで設定されたconsider_id)

            // 出品者と購入者が両方存在することを確認
            if ($sellerId && $buyerId) {

                // 購入者が出品者を評価する
                Evaluation::create([
                    'product_id' => $product->id,
                    'reviewed_id' => $buyerId, // 評価者: 購入者
                    'reviewed_user_id' => $sellerId, // 評価されたユーザー: 出品者
                    'rating' => rand(4, 5), // 良い評価を多めに
                    'comment' => $this->getRandomSellerComment(rand(4, 5)),
                    'role_as_reviewed' => 'seller', // 評価されたsellerの役割はseller
                    'created_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23)),
                ]);

                // 出品者が購入者を評価する
                Evaluation::create([
                    'product_id' => $product->id,
                    'reviewed_id' => $sellerId, // 評価者: 出品者
                    'reviewed_user_id' => $buyerId, // 評価されたユーザー: 購入者
                    'rating' => rand(4, 5), // 良い評価を多めに
                    'comment' => $this->getRandomBuyerComment(rand(4, 5)), // 評価に応じたコメント
                    'role_as_reviewed' => 'buyer', // 評価されたbuyerの役割はbuyer
                    'created_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23))->addMinutes(rand(10, 60)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 3))->subHours(rand(0, 23))->addMinutes(rand(10, 60)),
                ]);
            }
        }
}
