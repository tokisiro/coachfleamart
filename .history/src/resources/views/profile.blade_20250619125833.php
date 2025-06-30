
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img src="" alt="">
                <label class="profile-image__icon-label">
                    ユーザー名
                </label>
                <div class="profile-image__icon_link">
                    <a href="">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-tag">
            <button id="recommendationBtn" class="-tag__recommendation active">
                おすすめ
            </button>
            <button id="myListBtn" class="product-tag__myList">
                マイリスト
            </button>
        </div>
        <div class="product-list">

        <!--おすすめで表示するリスト-->
        <div class="product-recommendation">
        @foreach ($products as $product)
                <a class="product-recommendation__card" href="/item/{{ $product->id }}">
                    <div class="product-recommendation__card-img">
                        <img class="product-recommendation__card-img--item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                    </div>
                    <div class="product-recommendation__card-content">
                        <p class="product-recommendation__card-content--name">
                            {{ $product->product_name }}
                            @if(isset($product->isSold) && $product->isSold)
                    <span style="color:red; font-weight:bold;"> sold</span>
                @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>


        <!--マイリストで表示するリスト-->
        <div class="product-myList" >
            @foreach ($liked_products as $product)
                <a class="product-myList__card" href="/item/{{ $product->id }}" >
                    <div class="product-myList__card-img">
                        <img class="product-myList__card-img--item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                    </div>
                    <div class="product-myList__card-content">
                        <p class="product-myList__card-content--name">
                            {{ $product->product_name }}
                            @if(isset($product->isSold) && $product->isSold)
                    <span style="color:red; font-weight:bold;"> sold</span>
                @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        </div>
    </div>
@endsection



</body>
</html>