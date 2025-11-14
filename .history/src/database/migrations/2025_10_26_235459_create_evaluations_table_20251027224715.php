<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating');
            $table->string('role_as_reviewed', 50);
            $table->timestamps();

            // 同じ取引で同じユーザーが同じユーザーを2回評価できないようにユニーク制約を追加
            // ただし、buyer_id と seller_id がある商品テーブルのIDを指すため、
            // 1つのproduct_idに対して評価は2つ発生する (出品者→購入者、購入者→出品者)
            // そのため、ユニーク制約は product_id, reviewer_id, reviewed_user_id の組み合わせに対して設定する方が安全
            $table->unique(['product_id', 'reviewer_id', 'reviewed_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
