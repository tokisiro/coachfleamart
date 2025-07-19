
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
            か
        </p>
        <form class="sending-form" action="{{ url('/mypage/address/' . $product) }}" method="post">
            @csrf
            
        </form>
    </div>
@endsection
@section('script')

@endsection