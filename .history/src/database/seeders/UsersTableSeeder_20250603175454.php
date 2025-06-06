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
            'icon' => '',
            'post_code' => '',
            'address' => '',
            'email' => '',
            'password' => '',
        
        ];
        DB::table('products')->insert($param);
    }
}
