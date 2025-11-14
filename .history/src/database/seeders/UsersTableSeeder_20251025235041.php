<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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

        $productsSeeder = new ProductsTableSeeder();

        $allProducts = ProductsTableSeeder::getAllProductDefinitions();

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
        ]);

        $user1ProductsData = array_slice($allProducts, 0, 5);

        $productsSeeder->seedUserProducts($user1->id, $user1ProductsData);

        $user2 = User::create([
            'name' => '商品出品ユーザーB',
            'email' => 'seller_b@example.com',
            'password' => Hash::make('password'),
            'icon' => null,
            'post_code' => '150-0043',
            'address' => '東京都渋谷区道玄坂1-1-1',
            'building' => '渋谷スクランブルスクエア',
            'email_verified' => true,
        ]);

        $user2ProductsData = array_slice($allProducts, 5, 5);

        $productsSeeder->seedUserProducts($user2->id, $user2ProductsData);


        // 3. 何も紐づけられていないユーザー
        User::create([
            'name' => '紐付けなしユーザー',
            'email' => 'no_product_user@example.com',
            'password' => Hash::make('password'),
            'icon' => null,
            'post_code' => '100-0001',
            'address' => '千葉県千葉市稲毛1-1-12',
            'building' => 'メゾン海',
            'email_verified' => true,
        ]);

        \App\Models\User::factory()->count(5)->create();
    }
}
