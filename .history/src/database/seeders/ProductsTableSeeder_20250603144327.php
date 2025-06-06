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
        //
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
        DB::table('')->insert($param);
    }
}
