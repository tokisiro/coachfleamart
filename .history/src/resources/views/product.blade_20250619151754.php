
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection


<!--商品一覧画面（トップ）-->


@section('content')
    <div class="product">
        <div class="product-tag">
            <button id="recommendationBtn" class="product-tag__recommendation active">
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

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const recommendationDiv = document.querySelector('.product-recommendation');
    const likedDiv = document.querySelector('.product-myList');
    const myListDiv = document.querySelector('.product-myList');

    const recommendationBtn = document.getElementById('recommendationBtn');
    const myListBtn = document.getElementById('myListBtn');

    // 初期状態：recommendationボタンにactiveクラスを付与
    recommendationBtn.classList.add('active');

    // おすすめボタン
    recommendationBtn.addEventListener('click', () => {
        // ボタンの見た目変更
        recommendationBtn.classList.add('active');
        myListBtn.classList.remove('active');

        // リストの切り替え
        recommendationDiv.classList.add('showRecommendation');
        recommendationDiv.classList.remove('showMyList');

        myListDiv.classList.remove('showRecommendation');
        myListDiv.classList.add('showMyList');

        // いいねリスト非表示
        likedDiv.style.display = 'none';
    });

    // マイリストボタン
    myListBtn.addEventListener('click', () => {
        // ボタンの見た目変更
        myListBtn.classList.add('active');
        recommendationBtn.classList.remove('active');

        // リストの切り替え
        recommendationDiv.classList.remove('showRecommendation');
        recommendationDiv.classList.add('showMyList');

        myListDiv.classList.remove('showMyList');
        myListDiv.classList.add('showRecommendation');

        // いいねリストだけ表示
        likedDiv.style.display = 'block';
    });
});
</script>
@endsection
</body>
</html>