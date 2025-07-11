
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection

<!--商品一覧画面（トップ）-->


@section('content')
    <div class="product">
        <div class="product-tag">
            <a href="/" class="product-tag__recommendation {{ $currentTab !== 'mylist' ? 'active' : '' }}" id="recommendationBtn">
                おすすめ
            </a>
            <a href="/?tab=mylist" class="product-tag__myList {{ $currentTab === 'mylist' ? 'active' : '' }}" id="myListBtn">
                マイリスト
            </a>
        </div>
        <div class="product-list">
            <!--マイリストで表示するリスト-->
            @if($currentTab === 'mylist')
            <div class="product-list__myList" >
                @foreach ($liked_products as $product)
                    <a class="product-list__myList-card" href="/item/{{ $product->id }}" >
                        <div class="product-list__myList-card--img">
                            <img class="product-list__myList-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                            @if($product->isSoldOut)
                                <span class="product-list__myList-card--img-sold">sold</span>
                            @endif
                        </div>
                        <div class="product-list__myList-card--content">
                            <p class="product-list__myList-card--content-name">
                                {{ $product->product_name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            @else
            <!--おすすめで表示するリスト-->
            <div class="product-list__recommendation">
                @foreach ($products as $product)
                    <a class="product-list__recommendation-card" href="/item/{{ $product->id }}">
                        <div class="product-list__recommendation-card--img">
                            <img class="product-list__recommendation-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                            @if($product->isSoldOut)
                                <span class="product-list__recommendation-card--content-sold">sold</span>
                            @endif
                        </div>
                        <div class="product-list__recommendation-card--content">
                            <p class="product-list__recommendation-card--content-name">
                                {{ $product->product_name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
<script>
    document.querySelector('#searchForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ
        this.submit(); // 検索を送信
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
    const recommendationDiv = document.querySelector('.product-list__recommendation');
    const likedDiv = document.querySelector('.product-list__myList');
    const myListDiv = document.querySelector('.product-list__myList');

    const recommendationBtn = document.getElementById('recommendationBtn');
    const myListBtn = document.getElementById('myListBtn');


    const urlParams = new URLSearchParams(window.location.search);
    const currentQuery = urlParams.get('query');


    if (currentQuery) {
        // 例: マイリストタブを開く
        document.getElementById('myListBtn').click(); 
    }

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

        const params = new URLSearchParams(window.location.search);

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