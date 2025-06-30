
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection


<!--送信先住所変更画面-->

@section('content')
<div class="address">
        <div class="address-title">
            <h2 class="address-title__item">
                住所の変更
            </h2>
        </div>
        <form class="address-form" action="" method="post">
            <div class="address-form__post">
                <label class="address-form__post-label">
                    郵便番号
                </label>
                <input class="address-form__post-item" type="text">
            </div>
            <div class="address-form__residence">
                <label class="address-form__residence-label">
                    住所
                </label>
                <input class="address-form__residence-item" type="text">
            </div>
            <div class="address-form__building">
                <label class="address-form__building-label">
                    建物名
                </label>
                <input class="address-form__building-item" type="text">
            </div>
            <div class="address-form__button">
                <button class="address-form__button-item">
                    更新する
                </button>
            </div>
        </form>
</main>
</body>
</html>