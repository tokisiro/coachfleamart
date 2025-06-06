<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category' => 'ファッション'
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '家電'
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => 'インテリア'
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => 'レディース'
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => 'ファッション'
        ];
        DB::table('categories')->insert($param);
    }
}
