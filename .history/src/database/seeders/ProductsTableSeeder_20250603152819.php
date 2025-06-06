<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //腕時計
        $param =[
            'user_id' => '',
            'image' => 'storage/Clock.jpg',
            'brand_name' => '',
            'situation' => '良好',
            'product_name' => '腕時計',
            'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15,000',
            'status' => '販売中',
        ];
        DB::table('products')->insert($param);
        //ハードディスク
        $param =[
            'user_id' => '',
            'image' => 'storage/Disk.jpg',
            'brand_name' => '',
            'situation' => '目立った傷や汚れなし',
            'product_name' => 'HDD',
            'explanation' => '高速で信頼性の高いハードディスク',
            'price' => '5,000',
            'status' => '販売中',
        ];
        DB::table('products')->insert($param);
        //玉ねぎ３束
        $param =[
            'user_id' => '',
            'image' => 'storage/Onion.jpg',
            'brand_name' => '',
            'situation' => 'やや傷や汚れなし',
            'product_name' => '玉ねぎ３束',
            'explanation' => '新鮮な玉ねぎ３束セット',
            'price' => '300',
            'status' => '販売中',
        ];
        DB::table('products')->insert($param);
        //革靴
        $param =[
            'user_id' => '',
            'image' => 'storage/Shoes.jpg',
            'brand_name' => '',
            'situation' => '状態が悪い',
            'product_name' => '革靴',
            'explanation' => 'クラシックな',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //ノートPC
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //マイク
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //ショルダーバック
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //タンブラー
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //コーヒーミル
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
        //メイクセット
        $param =[
            'user_id' => '',
            'image' => '',
            'brand_name' => '',
            'situation' => '',
            'product_name' => '',
            'explanation' => '',
            'price' => '',
            'status' => '',
        ];
        DB::table('products')->insert($param);
    }
}
