<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

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
