<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 出品者ID（外部キー）
            $table->string('image'); // 商品画像（ファイルパスやURL）
            $table->string('brand_name'); // ブランド名
            $table->string('situation'); // 商品の状態（例：良好）
            $table->string('product_name'); // 商品名
            $table->text('explanation'); // 商品の説明
            $table->integer('price'); // 販売価格
            $table->string('status'); // 販売状況（例：売り切れ・販売中）
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
