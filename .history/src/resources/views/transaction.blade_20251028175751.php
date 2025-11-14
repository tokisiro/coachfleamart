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
        <div class="transaction-side__list">
            @forelse($otherTransactions as $otherProduct)
                <a href="{{ route('transaction', $otherProduct->id) }}" class="transaction-side__list-link">
                    <p class="transaction-side__list-lin">{{ $otherProduct->product_name }}</p>
                </a>
            @empty
                <p class="transaction-side__empty">その他の取引中の商品はありません。</p>
            @endforelse
        </div>
    </div>
    <div class="transaction-main">
        <div class="transaction-main__title">
            <img class="transaction-main__title-img" src="{{  asset('storage/default.png') }}" alt="アイコン">
            <p class="transaction-main__title-name">
                @if ($transactionPartner)
                    「{{ $transactionPartner->name }}」さんとの取引画面
                @else
                    取引相手が不明です
                @endif
            </p>
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
                @forelse($messages as $message)
                    <div class="message-item @if($message->sender_id === Auth::id()) message-item--right @else message-item--left @endif">
                        <img src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                        <p class="message-item__sender">
                            {{ $message->sender->name }}
                        </p>
                        <p class="message-item__content">
                            {{ $message->message }}
                        </p>
                    </div>
                @empty
                    <p class="transaction-main__message-empty">まだメッセージはありません。</p>
                @endforelse
            </div>
            <input class="transaction-main__message_item" type="text" placeholder="メッセージを入力">
            <button class="transaction-main__message_img" type="button">
                画像を追加
            </button>
            <button class="transaction-main__message-button" type="submit">
                <img class="transaction-main__message-button--item" src="{{ asset('storage/paperairplane.png') }}" alt="紙飛行機">
            </button>
        </form>
    </div>
</div>

@endsection