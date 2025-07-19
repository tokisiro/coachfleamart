
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/sending.css">
@endsection


<!--送付先住所変更-->

@section('content')
    <div class="completion">
        <h3 class="completion-title">
            決済完了
        </h3>
        <p class="completion-message">
            ご注文ありがとうございました。
            下記ボタンより購入を完了してください。
        </p>
        <form class="completion-form" action="{{ url('/purchase/complete' . $product) }}" method="post">
            @csrf
            <button class="completion-form__button">
                購入を完了する
            </button>
        </form>
    </div>
@endsection
@section('script')

@endsection