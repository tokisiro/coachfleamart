<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('nices')->truncate();
        // 例：ユーザ数や商品数に応じて生成
        $userIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $productIds = range(1, 10);
        $faker = \Faker\Factory::create();

        // 例：20〜50個の「いいね」を生成
        $count = rand(20, 50);
        for ($i=0; $i<$count; $i++) {
            DB::table('nices')->insert([
                'user_id' => $faker->randomElement($userIds),
                'product_id' => $faker->randomElement($productIds),
            ]);
        }
    }
}