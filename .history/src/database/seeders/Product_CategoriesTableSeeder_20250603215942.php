<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Product_CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'product_id' => '1',
            'category_id' => '1'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '1',
            'category_id' => '5'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '1',
            'category_id' => '12'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '2',
            'category_id' => '2'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '4',
            'category_id' => '1'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '4',
            'category_id' => '5'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '5',
            'category_id' => '2'
        ];
        DB::table('product_categories')->insert($param);

        
    }
}
