@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/email.css">
@endsection


<!--メール認証誘導画面-->

@section('content')
    <div class="email">
        <div class="email-function">
            <div class="email-message">
                <p class="email-message__item">
                    登録して頂いたメールアドレスに認証メールを送付しました。<br>
                    メール認証を完了してください。
                </p>
            </div>
            <div class="email-certification">
                <a href="{{ $verificationUrl }}">認証はこちら</a>
            </div>
            <div class="email-resend">
                <a href="{{ route('email', ['id' => $user->id, 'token' => $user->verification_token]) }}">認証メールを再送する</a>
                </a>
            </div>
        </div>
    </div>
    @endsection

