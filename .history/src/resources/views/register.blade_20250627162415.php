
@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/register.css">
@endsection

<!--会員登録画面-->

@section('content')
    <div class="register">
        <div class="register-title">
            <h2 class="register-title__item">
                会員登録
            </h2>
        </div>
        <form class="register-form" action="/register" method="post" novalidate="novalidate">
        @csrf
            <div class="register-form__name">
                <label class="register-form__name-label">
                    ユーザー名
                </label>
                <input class="register-form__name-item" type="text" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    {{$errors->first('name')}}
                @endif
            </div>
            <div class="register-form__email">
                <label class="register-form__email-label">
                    メールアドレス
                </label>
                <input class="register-form__email-item" type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    {{$errors->first('email')}}
                @endif
            </div>
            <div class="register-form__password">
                <label class="register-form__password-label">
                    パスワード
                </label>
                <input class="register-form__password-item" type="password" name="password">
                @error('password')
                    {{$errors->first('password')}}
                @endif
            </div>
            <div class="register-form__confirmation">
                <label class="register-form__confirmation-label">
                    確認用パスワード
                </label>
                <input class="register-form__confirmation-item" type="password" name="password_confirmation">
                @error ('password_confirmation')
                    {{$errors->first('password_confirmation')}}
                @endif
            </div>
            <div class="register-form__button">
                <button class="register-form__button-item">
                    登録する
                </button>
            </div>
        </form>
        <div class="register-link">
            <a class="register-link__login" href="/login">
                ログインはこちら
            </a>
        </div>
    </div>
@endsection
