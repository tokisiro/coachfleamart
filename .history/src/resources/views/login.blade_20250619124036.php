
@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
<!--ログイン画面-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
    </div>
</header>
<main>
    <div class="login">
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
        <div class="login-title">
            <h2 class="login-title__item">
                ログイン
            </h2>
        </div>
        <form class="login-form" action="/login" method="post">
        @csrf
            <div class="login-form__email">
                <label class="login-form__email-label">
                    メールアドレス
                </label>
                <input class="login-form__email-item" type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="login-form__password">
                <label class="login-form__password-label">
                    パスワード
                </label>
                <input class="login-form__password-item" type="password" name="password">
            </div>
            <div class="login-form__button">
                <button class="login-form__button-item">
                    ログインする
                </button>
            </div>
        </form>
        <div class="login-link">
            <a class="login-link__button" href="/register">
                会員登録はこちら
            </a>
        </div>
    </main>
</body>
</html>