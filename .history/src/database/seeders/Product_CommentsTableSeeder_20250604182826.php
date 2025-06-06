<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Product_CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        <?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class ProductCommentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();
        $userIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $productIds = range(1, 10); // 例：商品IDは1から10

        // 例えば各商品に対して複数コメント入れる
        foreach ($productIds as $productId) {
            $commentsCount = rand(1, 5);  // 商品ごとに1-5コメント
            for ($i=0; $i<$commentsCount; $i++) {
                DB::table('product_comments')->insert([
                    'user_id' => $faker->randomElement($userIds),
                    'product_id' => $productId,
                    'content' => $faker->paragraph(),
                ]);
            }
        }
    }
}
    }
}
