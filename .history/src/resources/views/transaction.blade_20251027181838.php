@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/transaction.css">
@endsection

@section('content')
<div class="transaction">
    <div class="transaction-side">
        <p class="transaction-side__title">
            その他の取引
        </p>
    </div>
    <div class="transaction-main">
        <div class="transaction-main__title">
            <img class="transaction-main__title-img" src="{{  asset('storage/default.png') }}" alt="アイコン">
            <p class="transaction-main__title-name">「」さんとの取引画面</p>
            <a class="transaction-main__title-button" href="">
                取引を完了する
            </a>
        </div>
        <div class="transaction-main__product">
            <img class="transaction-main__product-img" src="{{ asset($detail->image) }}" alt="商品画像">
            <div class="transaction-main__product-tag">
                <p class="transaction-main__product-tag--name">{{$detail->product_name}}</p>
                <p class="transaction-main__product-tag--price">{{$detail->price}}</p>
            </div>
        </div>
        <form class="transaction-main__message" action="">
            <div class="transaction-main__message-chat">

            </div>
            <input class="transaction-main__message_item" type="text">
            <button class="transaction-main__message_img">
                画像を追加
            </button>
            <button class="transaction-main__message-button">
                <img class="transaction-main__message-button--item" src="{{ asset('storage/paperairplane.png') }}" alt="紙飛行機">
            </button>
        </form>
    </div>
</div>

@endsection