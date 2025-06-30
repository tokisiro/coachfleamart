@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection


<!--メール認証誘導画面-->

@section('content')
    <div class="email">
        <div class="email-message">
            <p class="email-message__item">
                登録して頂いたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </p>
        </div>
        <div class="email-certification">
            <button class="email-certification__button">
                認証はこちらから
            </button>
        </div>
        <div class="email-resend">
            <a class="email-resend__button" href="">
                認証メールを再送する
            </a>
        </div>
    </div>
    @endsection

