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
        // 既存のユーザーを取得
        $userA = User::where('email', 'seller_a@example.com')->first();
        $userB = User::where('email', 'seller_b@example.com')->first();

        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        // ユーザーAが出品した商品の中からいくつか取得
        $product1_by_A = Product::where('user_id', $userA->id)->first(); // 例: ユーザーAの最初の商品
        $product2_by_A = Product::where('user_id', $userA->id)->skip(1)->first(); // 例: ユーザーAの2番目の商品

        // ユーザーBが出品した商品の中からいくつか取得
        $product1_by_B = Product::where('user_id', $userB->id)->first(); // 例: ユーザーBの最初の商品

        // userA (出品者) と noProductUser (購入者) の取引メッセージ
        if ($userA && $noProductUser && $product1_by_A) {
            Message::create([
                'product_id' => $product1_by_A->id,
                'sender_id' => $noProductUser->id, // 購入者がメッセージを送る
                'receiver_id' => $userA->id,
                'message' => 'こんにちは！こちらの商品、購入を検討しています。少しお値下げ可能でしょうか？',
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ]);
            Message::create([
                'product_id' => $product1_by_A->id,
                'sender_id' => $userA->id, // 出品者が返信する
                'receiver_id' => $noProductUser->id,
                'message' => 'お問い合わせありがとうございます。現状、提示価格でのご検討をお願いしております。',
                'read_at' => Carbon::now()->subDays(5)->addHours(1),
                'created_at' => Carbon::now()->subDays(5)->addHours(1),
                'updated_at' => Carbon::now()->subDays(5)->addHours(1),
            ]);
            Message::create([
                'product_id' => $product1_by_A->id,
                'sender_id' => $noProductUser->id,
                'receiver_id' => $userA->id,
                'message' => '承知いたしました。このまま購入します！',
                'read_at' => Carbon::now()->subDays(5)->addHours(2),
                'created_at' => Carbon::now()->subDays(5)->addHours(2),
                'updated_at' => Carbon::now()->subDays(5)->addHours(2),
            ]);
        }

        // userB (出品者) と userA (購入者) の取引メッセージ
        if ($userB && $userA && $product1_by_B) {
            Message::create([
                'product_id' => $product1_by_B->id,
                'sender_id' => $userA->id, // userAが購入者役
                'receiver_id' => $userB->id,
                'message' => 'はじめまして。この商品の使用期間はどれくらいでしょうか？',
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ]);
            Message::create([
                'product_id' => $product1_by_B->id,
                'sender_id' => $userB->id, // userBが出品者役
                'receiver_id' => $userA->id,
                'message' => '約半年ほどです。目立った傷や汚れはありません。',
                'read_at' => Carbon::now()->subDays(3)->addMinutes(30),
                'created_at' => Carbon::now()->subDays(3)->addMinutes(30),
                'updated_at' => Carbon::now()->subDays(3)->addMinutes(30),
            ]);
        }

        // さらに別のユーザーとのメッセージも追加できます
        // 例: Fakerで作成されたユーザーを取得して利用
        $randomUser = User::where('email', '!=', 'seller_a@example.com')
                        ->where('email', '!=', 'seller_b@example.com')
                        ->where('email', '!=', 'no_product_user@example.com')
                        ->inRandomOrder()->first();

        if ($randomUser && $userA && $product2_by_A) {
            Message::create([
                'product_id' => $product2_by_A->id,
                'sender_id' => $randomUser->id,
                'receiver_id' => $userA->id,
                'message' => 'この商品まだありますか？',
                'read_at' => Carbon::now()->subDays(1)->subHours(2),
                'created_at' => Carbon::now()->subDays(1)->subHours(2),
                'updated_at' => Carbon::now()->subDays(1)->subHours(2),
            ]);
            Message::create([
                'product_id' => $product2_by_A->id,
                'sender_id' => $userA->id,
                'receiver_id' => $randomUser->id,
                'message' => 'はい、まだございます。',
                'read_at' => null, // まだ既読になっていないメッセージの例
                'created_at' => Carbon::now()->subDays(1)->subHours(1),
                'updated_at' => Carbon::now()->subDays(1)->subHours(1),
            ]);
        }
    }
}
