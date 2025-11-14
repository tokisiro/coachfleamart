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
            ->whereIn('status', ['sale', 'sold'])
            ->whereNull('consider_id')
            ->where('transaction_status', 'available')
            ->take(2)
            ->get();


        if ($productsA_for_negotiation->count() < 2) {
            $this->command->error('sellerAが出品した、メッセージ生成用の利用可能な商品が2つ見つかりませんでした。現在 ' . $productsA_for_negotiation->count() . ' 個です。シーダーを中断します。');
            return;
        }

        // 取得した各商品を交渉中の状態に更新し、メッセージを作成
        foreach ($productsA_for_negotiation as $productA) {
            $productA->update([
                'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
                'transaction_status' => 'negotiation',
            ]);
            $this->command->info("Product '{$productA->product_name}' (ID: {$productA->id}) の transaction_status を 'negotiation' に更新しました。");
        }


        // sellerBが出品した、まだ交渉中でない既存の商品を取得
        productsB_for_negotiation = Product::where('user_id', $sellerB->id)
            ->whereIn('status', ['sale', 'sold']) // ここを修正: 'sale'または'sold'
            ->whereNull('consider_id')
            ->where('transaction_status', 'available')
            ->take(2) // 2つの商品を取得
            ->get();

        if ($productsB_for_negotiation->count() < 2) {
            $this->command->error('sellerBが出品した、メッセージ生成用の利用可能な商品が2つ見つかりませんでした。現在 ' . $productsB_for_negotiation->count() . ' 個です。シーダーを中断します。');
            return;
        }

        // 取得した各商品を交渉中の状態に更新し、メッセージを作成
        foreach ($productsB_for_negotiation as $productB) {
            $productB->update([
                'consider_id' => $noProductUser->id, // noProductUserを交渉相手とする
                'transaction_status' => 'negotiation',
            ]);
            $this->command->info("Product '{$productB->product_name}' (ID: {$productB->id}) の transaction_status を 'negotiation' に更新しました。");
        }

        // メッセージデータの作成

        $productA_1 = $productsA_for_negotiation[0];
        $productB_1 = $productsB_for_negotiation[0];

        
}