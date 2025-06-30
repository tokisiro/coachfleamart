
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection


<!--送信先住所変更画面-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <img src="/storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-inner__search">
            <input class="header-inner__search-input" type="text" placeholder="何をお探しですか？">
        </div>
        <div class="header-inner__metastasis">
            @if (Auth::check())
            <form class="header-inner__metastasis-logout" action="/logout" method="post">
                @csrf
                <button class="header-inner__metastasis-logout--link" href="/logout">
                    ログアウト
                </button>
            </form>
            @else
            <a class="header-inner__metastasis-login" href="/login">
                ログイン
            </a>
            @endif
            <div class="header-inner__metastasis-page">
                <a class="header-inner__metastasis-page--link" href="">
                    マイページ
                </a>
            </div>
            <div class="header-inner__metastasis-listing">
                <button class="header-inner__metastasis-listing--button">
                    出品
                </button>
            </div>
        </div>
    </div>
</header>
<main>
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