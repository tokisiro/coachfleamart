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
        Message::truncate();

        $sellerA = User::where('email', 'seller_a@example.com')->first();
        $sellerB = User::where('email', 'seller_b@example.com')->first();
        $noProductUser = User::where('email', 'no_product_user@example.com')->first();

        // ユーザーが存在することを確認
        if (!$sellerA || !$sellerB || !$noProductUser) {
            $this->command->error('必要なユーザー (seller_a, seller_b, no_product_user) が見つかりません。UsersTableSeeder が正しく実行されていることを確認してください。');
            return;
        }

        // --- シナリオ1: sellerAが出品者 (status: sale, transaction_status: negotiation) ---
        // sellerAが出品した、まだ交渉中でない商品を2つ取得
        // statusはsaleに限定し、transaction_statusはavailableからnegotiationへ変更
        $products_sellerA_sale = Product::where('user_id', $sellerA->id)
            ->where('status', 'sale') // sale に限定
            ->whereNull('consider_id')
            ->where('transaction_status', 'available')
            ->take(2)
            ->get();

        if ($products_sellerA_sale->count() < 2) {
            $this->command->error('sellerAが出品した、statusがsaleで利用可能な商品が2つ見つかりませんでした。現在 ' . $products_sellerA_sale->count() . ' 個です。シーダーを中断します。');
            return;
        }

        // 取得した各商品を交渉中の状態に更新し、noProductUserを交渉相手とする
        foreach ($products_sellerA_sale as $product) {
            $product->update([
                'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
                'transaction_status' => 'negotiation',
            ]);
            $this->command->info("Product '{$product->product_name}' (ID: {$product->id}) の transaction_status を 'negotiation' に更新しました。(出品者: sellerA, 相手: noProductUser, status: sale)");
        }


        // --- シナリオ2: sellerBが出品者 (status: sold, transaction_status: negotiation) ---
        // sellerBが出品した、まだ交渉中でない商品を2つ取得
        // statusはsoldに限定し、transaction_statusはavailableからnegotiationへ変更
        dd()
        $products_sellerB_sold = Product::where('user_id', $sellerB->id)
            ->where('status', 'sold') // sold に限定
            ->whereNull('consider_id')
            ->where('transaction_status', 'negotiation')
            ->take(2)
            ->get();

        if ($products_sellerB_sold->count() < 2) {
            $this->command->error('sellerBが出品した、statusがsoldで利用可能な商品が2つ見つかりませんでした。現在 ' . $products_sellerB_sold->count() . ' 個です。シーダーを中断します。');
            return;
        }

        // 取得した各商品を交渉中の状態に更新し、noProductUserを交渉相手とする
        foreach ($products_sellerB_sold as $product) {
            $product->update([
                'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
                'transaction_status' => 'negotiation',
            ]);
            $this->command->info("Product '{$product->product_name}' (ID: {$product->id}) の transaction_status を 'negotiation' に更新しました。(出品者: sellerB, 相手: noProductUser, status: sold)");
        }

        // --- メッセージデータの作成 (シナリオ1: sellerAが出品者) ---
        foreach ($products_sellerA_sale as $index => $product) {
            $this->command->info("Creating messages for sellerA's product (ID: {$product->id}) - Scenario " . ($index + 1));

            // 1. noProductUserからsellerAへ質問 (sellerAは未読)
            Message::create([
                'product_id' => $product->id,
                'sender_id' => $noProductUser->id,
                'receiver_id' => $sellerA->id,
                'message' => "商品「{$product->product_name}」について質問があります。",
                'sender_read_at' => Carbon::now()->subDays(2)->subHours(3)->addMinutes($index * 10),
                'receiver_read_at' => null,
                'created_at' => Carbon::now()->subDays(2)->subHours(3)->addMinutes($index * 10),
                'updated_at' => Carbon::now()->subDays(2)->subHours(3)->addMinutes($index * 10),
            ]);

            // 2. sellerAからnoProductUserへ返信 (両者既読)
            Message::create([
                'product_id' => $product->id,
                'sender_id' => $sellerA->id,
                'receiver_id' => $noProductUser->id,
                'message' => "商品「{$product->product_name}」についてのご質問ありがとうございます。どのような内容でしょうか？",
                'sender_read_at' => Carbon::now()->subDays(2)->subHours(2)->addMinutes($index * 10),
                'receiver_read_at' => Carbon::now()->subDays(2)->subHours(1)->addMinutes($index * 10),
                'created_at' => Carbon::now()->subDays(2)->subHours(2)->addMinutes($index * 10),
                'updated_at' => Carbon::now()->subDays(2)->subHours(2)->addMinutes($index * 10),
            ]);

            // 3. noProductUserからsellerAへ追加質問 (sellerAは未読)
            Message::create([
                'product_id' => $product->id,
                'sender_id' => $noProductUser->id,
                'receiver_id' => $sellerA->id,
                'message' => "「{$product->product_name}」の状態について詳しく教えていただけますか？",
                'sender_read_at' => Carbon::now()->subHours(5)->addMinutes($index * 10),
                'receiver_read_at' => null,
                'created_at' => Carbon::now()->subHours(5)->addMinutes($index * 10),
                'updated_at' => Carbon::now()->subHours(5)->addMinutes($index * 10),
            ]);
        }

        // --- メッセージデータの作成 (シナリオ2: sellerBが出品者) ---
        foreach ($products_sellerB_sold as $index => $product) {
            $this->command->info("Creating messages for sellerB's product (ID: {$product->id}) - Scenario " . ($index + 1));

            // 1. noProductUserからsellerBへ値下げ交渉 (sellerBは未読)
            Message::create([
                'product_id' => $product->id,
                'sender_id' => $noProductUser->id,
                'receiver_id' => $sellerB->id,
                'message' => "商品「{$product->product_name}」の値下げ交渉は可能でしょうか？",
                'sender_read_at' => Carbon::now()->subDays(1)->subHours(4)->addMinutes($index * 10),
                'receiver_read_at' => null,
                'created_at' => Carbon::now()->subDays(1)->subHours(4)->addMinutes($index * 10),
                'updated_at' => Carbon::now()->subDays(1)->subHours(4)->addMinutes($index * 10),
            ]);

            // 2. sellerBからnoProductUserへ返答 (noProductUserは未読)
            Message::create([
                'product_id' => $product->id,
                'sender_id' => $sellerB->id,
                'receiver_id' => $noProductUser->id,
                'message' => "「{$product->product_name}」について、少しであれば検討可能です。ご希望額をお聞かせください。",
                'sender_read_at' => Carbon::now()->subHours(2)->addMinutes($index * 10),
                'receiver_read_at' => null,
                'created_at' => Carbon::now()->subHours(2)->addMinutes($index * 10),
                'updated_at' => Carbon::now()->subHours(2)->addMinutes($index * 10),
            ]);
        }
    }
}