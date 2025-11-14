<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as FakerFactory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = FakerFactory::create('ja_JP');

        //'腕時計', 'HDD', '玉ねぎ３束', '革靴', 'ノートPC' を出品するユーザー
        $user1 = User::create([
            'name' => '商品出品ユーザーA',
            'email' => 'seller_a@example.com',
            'password' => Hash::make('password'),
            'icon' => null,
            'post_code' => '106-0032',
            'address' => '東京都港区六本木1-1-1',
            'building' => 'アークヒルズフロントタワー',
            'email_verified' => true,
            'verification_token' => null,
        ]);

        $products1_data = [
            [
                'image' => 'storage/Clock.jpg',
                'situation' => '良好',
                'product_name' => '腕時計',
                'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
            ],
            [
                'image' => 'storage/Disk.jpg',
                'situation' => '目立った傷や汚れなし',
                'product_name' => 'HDD',
                'explanation' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
            ],
            [
                'image' => 'storage/onion.jpg',
                'situation' => 'やや傷や汚れあり',
                'product_name' => '玉ねぎ３束',
                'explanation' => '新鮮な玉ねぎ３束セット',
                'price' => '300',
            ],
            [
                'image' => 'storage/Shoes.jpg',
                'situation' => '状態が悪い',
                'product_name' => '革靴',
                'explanation' => 'クラシックなデザインの革靴',
                'price' => '4000',
            ],
            [
                'image' => 'storage/Computer.jpg',
                'situation' => '良好',
                'product_name' => 'ノートPC',
                'explanation' => '高性能なノートパソコン',
                'price' => '45000',
            ],
        ];

        // ユーザー1のproductsリレーションを通じて商品を作成
        foreach ($products1_data as $product_info) {
            $user1->products()->create([
                'image' => $product_info['image'],
                'brand_name' => '',
                'situation' => $product_info['situation'],
                'product_name' => $product_info['product_name'],
                'explanation' => $product_info['explanation'],
                'price' => $product_info['price'],
                'status' => '販売中',
                // 'created_at', 'updated_at' はEloquentが自動で設定
            ]);
        }

        // 'マイク', 'ショルダーバック', 'タンブラー', 'コーヒーミル', 'メイクセット' を出品するユーザー
        $user2 = User::create([
            'name' => '商品出品ユーザーB',
            'email' => 'seller_b@example.com',
            'password' => Hash::make('password'),
            'icon' => null,
            'post_code' => '150-0043',
            'address' => '東京都渋谷区道玄坂1-1-1',
            'building' => '渋谷スクランブルスクエア',
            'email_verified' => true,

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // パスワードは必ずハッシュ化する
            'icon' => null, // null許容カラムはnullを明示的に指定するか、省略してもOK
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'テストビル101',
            'email_verified' => true, // 必要に応じてtrueに設定
            'verification_token' => null,
        ]);

        \App\Models\User::factory()->count(10)->create();
    }
}
