<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function name_field_validation_shows_error_message()
    {
        // 例：ブラウザ操作のために Laravel Dusk か、HTTPリクエストでやる
        // ここではDuskの例を示します。Laravel Duskが使えない場合は補足情報を教えてください。

        $this->browse(function ($browser) {
            // 【1】会員登録ページを開く
            $browser->visit('/register')

                // 【2】名前入力を空にして、他の必須項目を入力
                ->type('email', 'test@example.com') // 例
                // 他必要項目も入力
                ->type('password', 'password')
                ->press('登録') // ボタンのテキストやCSSセレクタを使って
                // 【3】登録ボタンを押す
                ->assertSee('お名前を入力してください'); // バリデーションメッセージの確認
        });
    }
}
