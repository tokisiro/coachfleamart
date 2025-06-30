
@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/login.css">
@endsection

<!--ログイン画面-->

@section('content')
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
    @endsection
