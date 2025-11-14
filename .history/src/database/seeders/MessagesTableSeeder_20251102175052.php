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

        $sellerA = User::where('email', 'seller_a@example.com')->first();
        $sellerB = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        // ユーザーが存在することを確認
        if (!$sellerA || !$sellerB || !$noProductUser) {
            $this->command->error('必要なユーザー (seller_a, seller_b, no_product_user) が見つかりません。UsersTableSeeder が正しく実行されていることを確認してください。');
            return;
        }

        // sellerAが出品した、まだ交渉中でない商品を取得
        $productA_for_negotiation = Product::where('user_id', $sellerA->id)
                                          ->where('status', 'sale')
                                          ->whereNull('consider_id')
                                          ->where('transaction_status', 'available')
                                          ->first();


        if (!$productA_for_negotiation) {
            $this->command->error('sellerAが出品した、メッセージ生成用の利用可能な既存の商品が見つかりませんでした。シーダーを中断します。');
            return; // 該当商品がない場合はシーダーを中断
        }

        // productA_for_negotiation を交渉中の状態に更新
        $productA_for_negotiation->update([
            'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
            'transaction_status' => 'negotiation',
        ]);
        $this->command->info("Product '{$productA_for_negotiation->product_name}' (ID: {$productA_for_negotiation->id}) の transaction_status を 'negotiation' に更新しました。");


        // sellerBが出品した、まだ交渉中でない既存の商品を取得
        $productB_for_negotiation = Product::where('user_id', $sellerB->id)
            ->where('status', '販売中')
                                          ->whereNull('consider_id')
                                          ->where('transaction_status', 'available')
                                          ->first();

        if (!$productB_for_negotiation) {
            $this->command->error('sellerBが出品した、メッセージ生成用の利用可能な既存の商品が見つかりませんでした。シーダーを中断します。');
            return; // 該当商品がない場合はシーダーを中断
        }

        // productB_for_negotiation を交渉中の状態に更新
        $productB_for_negotiation->update([
            'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
            'transaction_status' => 'negotiation',
        ]);
        $this->command->info("Product '{$productB_for_negotiation->product_name}' (ID: {$productB_for_negotiation->id}) の transaction_status を 'negotiation' に更新しました。");


        // ----------------------------------------------------
        // メッセージデータの作成
        // ----------------------------------------------------

        // --- シナリオ1: sellerAとnoProductUser間の交渉中メッセージ ---
        // 1. noProductUserからsellerAへ質問 (sellerAは未読)
        Message::create([
            'product_id' => $productA_for_negotiation->id,
            'sender_id' => $noProductUser->id,
            'receiver_id' => $sellerA->id,
            'message' => 'こちらの商品について質問があります。(noProductUser → sellerA)',
            'sender_read_at' => Carbon::now()->subDays(2)->subHours(3),
            'receiver_read_at' => null,
            'created_at' => Carbon::now()->subDays(2)->subHours(3),
            'updated_at' => Carbon::now()->subDays(2)->subHours(3),
        ]);

        // 2. sellerAからnoProductUserへ返信 (両者既読)
        Message::create([
            'product_id' => $productA_for_negotiation->id,
            'sender_id' => $sellerA->id,
            'receiver_id' => $noProductUser->id,
            'message' => 'ご質問ありがとうございます。どのような内容でしょうか？(sellerA → noProductUser)',
            'sender_read_at' => Carbon::now()->subDays(2)->subHours(2),
            'receiver_read_at' => Carbon::now()->subDays(2)->subHours(1),
            'created_at' => Carbon::now()->subDays(2)->subHours(2),
            'updated_at' => Carbon::now()->subDays(2)->subHours(2),
        ]);

        // 3. noProductUserからsellerAへ追加質問 (sellerAは未読)
        Message::create([
            'product_id' => $productA_for_negotiation->id,
            'sender_id' => $noProductUser->id,
            'receiver_id' => $sellerA->id,
            'message' => '商品の状態について詳しく教えていただけますか？(noProductUser → sellerA)',
            'sender_read_at' => Carbon::now()->subHours(5),
            'receiver_read_at' => null,
            'created_at' => Carbon::now()->subHours(5),
            'updated_at' => Carbon::now()->subHours(5),
        ]);


        // --- シナリオ2: sellerBとnoProductUser間の交渉中メッセージ ---
        // 1. noProductUserからsellerBへ値下げ交渉 (sellerBは未読)
        Message::create([
            'product_id' => $productB_for_negotiation->id,
            'sender_id' => $noProductUser->id,
            'receiver_id' => $sellerB->id,
            'message' => '値下げ交渉は可能でしょうか？(noProductUser → sellerB)',
            'sender_read_at' => Carbon::now()->subDays(1)->subHours(4),
            'receiver_read_at' => null,
            'created_at' => Carbon::now()->subDays(1)->subHours(4),
            'updated_at' => Carbon::now()->subDays(1)->subHours(4),
        ]);

        // 2. sellerBからnoProductUserへ返答 (noProductUserは未読)
        Message::create([
            'product_id' => $productB_for_negotiation->id,
            'sender_id' => $sellerB->id,
            'receiver_id' => $noProductUser->id,
            'message' => '少しであれば検討可能です。ご希望額をお聞かせください。(sellerB → noProductUser)',
            'sender_read_at' => Carbon::now()->subHours(2),
            'receiver_read_at' => null,
            'created_at' => Carbon::now()->subHours(2),
            'updated_at' => Carbon::now()->subHours(2),
        ]);
}