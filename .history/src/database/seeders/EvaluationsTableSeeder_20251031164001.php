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

        $user1 = User::where('email', 'seller_a@example.com')->first();
        $user2 = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        if (!$user1 || !$user2) {
            $this->command->warn('User "seller_a@example.com" or "seller_b@example.com" not found. Skipping specific user evaluations.');
            return;
        }

        $soldProducts = Product::where('status', '売却済み')->get();

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

        $this->createSpecificEvaluation($user1, $user2, 'seller', 'buyer');
        $this->createSpecificEvaluation($user2, $user1, 'seller', 'buyer');
        $this->createSpecificEvaluation($user2, $user1, 'seller', 'buyer', rand(1, 3));

        $this->createSpecificEvaluation($user1, $user2, 'seller', 'buyer', rand(3, 5));

    }

    protected function createSpecificEvaluation(User $seller, User $buyer, string $sellerRole, string $buyerRole, ?int $buyerToSellerRating = null)
    {
        // 外部キー制約を一時的に無効化（既存の商品を更新するため）
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // まず、販売中の商品を取得します。
        // 出品者自身の商品を優先的に選択、なければ他の販売中の商品を選択
        $product = Product::where('status', '販売中')
                          ->whereNull('consider_id')
                          ->where('user_id', $seller->id)
                          ->first();

        if (!$product) {
            // 出品者自身の販売中商品がない場合、他の販売中の商品をランダムに選ぶ
            $product = Product::where('status', '販売中')
                            ->whereNull('consider_id')
                              ->inRandomOrder()
                              ->first();
        }

        if (!$product) {
            // 販売中の商品が全くない場合、評価データを作成できない
            $this->command->warn("No available products to simulate a transaction for user {$seller->name} and {$buyer->name}.");
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return;
        }

        // 既に存在する商品を使用する場合、一時的に出品者を変更（シーダー内でのみ）
        $originalSellerId = $product->user_id;
        $product->user_id = $seller->id;

        // 商品を「売却済み」状態にし、購入者を割り当てる
        $product->consider_id = $buyer->id;
        $product->status = '売却済み';
        $product->save(); // データベースに保存

        // UserProductsTableSeeder のロジックのように、user_products テーブルにもレコードを挿入
        // ただし、すでに user_products にレコードがある可能性もあるため、存在しない場合のみ
        if (!DB::table('user_products')->where('user_id', $buyer->id)->where('product_id', $product->id)->exists()) {
             // FakerFactory は使えないのでダミーデータを直接設定
            DB::table('user_products')->insert([
                'user_id' => $buyer->id,
                'product_id' => $product->id,
                'address' => '東京都港区六本木1-1-1', // ダミー住所
                'post_code' => '106-0032', // ダミー郵便番号
                'building' => null,
                'created_at' => Carbon::now()->subDays(rand(6, 10)),
                'updated_at' => Carbon::now()->subDays(rand(6, 10)),
            ]);
        }


        // 購入者 (buyer) が出品者 (seller) を評価
        Evaluation::create([
            'product_id' => $product->id,
            'reviewer_id' => $buyer->id,
            'reviewed_user_id' => $seller->id,
            'rating' => $buyerToSellerRating ?? rand(4, 5), // 指定があればそれを使用、なければランダム
            'role_as_reviewed' => $sellerRole,
            'created_at' => Carbon::now()->subDays(rand(6, 10)),
            'updated_at' => Carbon::now()->subDays(rand(6, 10)),
        ]);

        // 出品者 (seller) が購入者 (buyer) を評価
        Evaluation::create([
            'product_id' => $product->id,
            'reviewer_id' => $seller->id,
            'reviewed_user_id' => $buyer->id,
            'rating' => rand(4, 5),
            'role_as_reviewed' => $buyerRole,
            'created_at' => Carbon::now()->subDays(rand(6, 10))->addMinutes(rand(10, 60)),
            'updated_at' => Carbon::now()->subDays(rand(6, 10))->addMinutes(rand(10, 60)),
        ]);

        // 元の出品者IDに戻す (ProductsTableSeederからの影響を避けるため)
        // ただし、Productテーブルは既に上書きされているので、ここは厳密には不要かもしれません。
        // 必要であれば、元のuser_idを保存しておいて、ここで元に戻すロジックを追加できますが、
        // シーダー全体でデータが作り直される前提であれば不要です。
        $product->user_id = $originalSellerId; // 元に戻しておく
        $product->save(); // データベースに保存

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 外部キー制約を有効に戻す
    }
}