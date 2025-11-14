<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;



class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 全てのメッセージを削除
        Message::truncate();

        // '取引中' の商品を取得
        $inTransactionProducts = Product::where('transaction_status', 'negotiation')->get();

        foreach ($inTransactionProducts as $product) {
            $sellerId = $product->user_id; // 出品者
            $buyerId = $product->consider_id; // 購入検討者

            // 出品者と購入者が両方存在することを確認
            if ($sellerId && $buyerId) {
                // 購入検討者がメッセージを送信
                Message::create([
                    'product_id' => $product->id,
                    'sender_id' => $buyerId,
                    'receiver_id' => $sellerId,
                    'message' => 'こんにちは！この商品についていくつか質問させてください。',
                    'sender_read_at' => Carbon::now()->subDays(2)->subHours(1),
                    'receiver_read_at' => Carbon::now()->subDays(2)->subHours(1),
                    'created_at' => Carbon::now()->subDays(2)->subHours(3),
                    'updated_at' => Carbon::now()->subDays(2)->subHours(3),
                ]);

                // 出品者が返信
                Message::create([
                    'product_id' => $product->id,
                    'sender_id' => $sellerId,
                    'receiver_id' => $buyerId,
                    'message' => 'ご質問ありがとうございます。どのような点でしょうか？',
                    'sender_read_at' => null,
                    'receiver_read_at' => null,
                    'created_at' => Carbon::now()->subDays(2)->subHours(2),
                    'updated_at' => Carbon::now()->subDays(2)->subHours(2),
                ]);

                // 購入検討者がさらに質問
                Message::create([
                    'product_id' => $product->id,
                    'sender_id' => $buyerId,
                    'receiver_id' => $sellerId,
                    'message' => '商品の使用頻度と、付属品について教えていただけますか？',
                    'sender_read_at' => null,
                    'receiver_read_at' => null,
                    'created_at' => Carbon::now()->subDays(2)->subHours(1),
                    'updated_at' => Carbon::now()->subDays(2)->subHours(1),
                ]);

            }
        }

        // ここから、UserProductsTableSeederに関わらない、一般的なメッセージの例も追加できます。
        $userA = User::where('email', 'seller_a@example.com')->first();
        $userB = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        // userAが出品した、まだ取引中でない商品を取得
        $availableProductByA = Product::where('user_id', $userA->id)
            ->where('status', 'sale')
            ->whereNull('consider_id')
            ->first();

        if ($userA && $noProductUser && $availableProductByA) {
            Message::create([
                'product_id' => $availableProductByA->id,
                'sender_id' => $noProductUser->id,
                'receiver_id' => $userA->id,
                'message' => 'この商品、まだ残っていますか？',
                'sender_read_at' => Carbon::now()->subDays(2)->subHours(1),
                'receiver_read_at' => Carbon::now()->subDays(2)->subHours(1),
                'created_at' => Carbon::now()->subDays(1)->subHours(5),
                'updated_at' => Carbon::now()->subDays(1)->subHours(5),
            ]);
            Message::create([
                'product_id' => $availableProductByA->id,
                'sender_id' => $userA->id,
                'receiver_id' => $noProductUser->id,
                'message' => 'はい、まだございます。ご検討よろしくお願いします。',
                
                'created_at' => Carbon::now()->subDays(1)->subHours(4),
                'updated_at' => Carbon::now()->subDays(1)->subHours(4),
            ]);
        }
    }
}