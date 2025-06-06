<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \Illuminate\Support\Facades\DB::table('product_categories')->truncate();
        Schema::enableForeignKeyConstraints();

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

        $param = [
            'product_id' => '7',
            'category_id' => '1'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '7',
            'category_id' => '4'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '8',
            'category_id' => '10'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '9',
            'category_id' => '10'
        ];
        DB::table('product_categories')->insert($param);

        $param = [
            'product_id' => '10',
            'category_id' => '6'
        ];
        DB::table('product_categories')->insert($param);
    }
}
