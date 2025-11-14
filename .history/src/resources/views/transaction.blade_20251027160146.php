@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/transaction.css">
@endsection

@section('content')
<div class="transaction">
    <div class="transaction-side">

    </div>
    <div class="transaction-main">
        <div class="transaction-main__title">
            <img src="" alt="アイコン">
            <p>「」さんとの取引画面</p>
            <a href="">
                取引を完了する
            </a>
        </div>
        <div class="transaction-main__product">
            <img src="{{ asset($detail->image) }}" alt="商品画像">
            <p>商品名</p>
            <p>表品価格</p>
        </div>
        <form class="transaction-main__message" action="">
            <input class="transaction-main__message_item" type="text">
            <button>
                画像を追加
            </button>
            <button>
                <img src="" alt="">
            </button>
        </form>
    </div>
</div>

@endsection