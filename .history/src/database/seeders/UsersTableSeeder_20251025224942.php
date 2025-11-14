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
