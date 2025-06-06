<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param =[
            'user_name' => '$faker->randomElement($userIds)',
            'icon' => 'storage/Clock.jpg',
            'brand_name' => '',
            'situation' => '良好',
            'product_name' => '腕時計',
            'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15,000',
            'status' => '販売中',
        ];
        DB::table('products')->insert($param);
    }
}
