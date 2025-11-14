<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;



class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            [
                'product_id' => 2001,
                'sender_id' => 101,
                'receiver_id' => 102,
                'message' => 'こんにちは！この商品に興味があります。',
                'read_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2001,
                'sender_id' => 102,
                'receiver_id' => 101,
                'message' => 'お問い合わせありがとうございます。何かご不明な点がありますか？',
                'read_at' => null,
                'created_at' => Carbon::now()->addMinutes(5), // 時間差をつける例
                'updated_at' => Carbon::now()->addMinutes(5),
            ],
            [
                'product_id' => 2001,
                'sender_id' => 101,
                'receiver_id' => 102,
                'message' => '商品の状態についてもう少し詳しく教えていただけますか？',
                'read_at' => null,
                'created_at' => Carbon::now()->addMinutes(10),
                'updated_at' => Carbon::now()->addMinutes(10),
            ],
            [
                'product_id' => 2002,
                'sender_id' => 103,
                'receiver_id' => 104,
                'message' => '購入を検討しています。お値下げは可能でしょうか？',
                'read_at' => Carbon::now()->addDays(1)->format('Y-m-d H:i:s'), // 既読日時を指定する例
                'created_at' => Carbon::now()->addDays(1)->subMinutes(30),
                'updated_at' => Carbon::now()->addDays(1)->subMinutes(30),
            ],
            [
                'product_id' => 2002,
                'sender_id' => 104,
                'receiver_id' => 103,
                'message' => '申し訳ありませんが、現時点では値下げは考えておりません。',
                'read_at' => Carbon::now()->addDays(1)->addMinutes(5)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->addDays(1)->addMinutes(5),
                'updated_at' => Carbon::now()->addDays(1)->addMinutes(5),
            ],
            [
                'product_id' => 2002,
                'sender_id' => 103,
                'receiver_id' => 104,
                'message' => '承知いたしました。このまま購入させていただきます。',
                'read_at' => Carbon::now()->addDays(1)->addMinutes(10)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->addDays(1)->addMinutes(10),
                'updated_at' => Carbon::now()->addDays(1)->addMinutes(10),
            ],
        ]);
    }
}
