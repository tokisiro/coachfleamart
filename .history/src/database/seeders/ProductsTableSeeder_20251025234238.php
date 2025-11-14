<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    }

    public function seedUserProducts(int $userId, array $productsData)
    {
        // Product モデルの fillable に 'status' が含まれていることを確認

        foreach ($productsData as $product_info) {
            Product::create([
                'user_id' => $userId, // ここで引数で受け取ったuserIdを使用
                'image' => $product_info['image'],
                'brand_name' => $product_info['brand_name'] ?? '', // brand_nameがない場合を考慮
                'situation' => $product_info['situation'],
                'product_name' => $product_info['product_name'],
                'explanation' => $product_info['explanation'],
                'price' => $product_info['price'],
                'status' => '販売中', // デフォルト値
            ]);
        }
    }
}
