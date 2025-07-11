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
            <p>以下のリンクをクリックしてメールアドレスを認証してください。</p>
        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
        </div>
        <div class="email-resend">
        <a href="{{ route('email', ['id' => $user->id, 'token' => $user->verification_token]) }}">{{ route('email', ['id' => $user->id, 'token' => $user->verification_token]) }}</a>
                認証メールを再送する
            </a>
        </div>
    </div>
    @endsection

