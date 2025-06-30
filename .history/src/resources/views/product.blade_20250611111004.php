<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/product.css">
</head>
<body>
<!--商品一覧画面（トップ）-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-inner__search">
            <input class="header-inner__search-input" type="text">
        </div>
        <div class="header-inner__metastasis">
            @if (Auth::check())
            <form class="header-inner__metastasis-logout" action="/logout" method="post">
                @csrf
                <button class="header-inner__metastasis-logout--link" href="">
                    ログアウト
                </button>
            </form>
            @else
            <a class="header-inner__metastasis-login" href="/login">
                ログイン
            </a>
            @endif
            <div class="header-inner__metastasis-page">
                <a class="header-inner__metastasis-page--link" href="">
                    マイページ
                </a>
            </div>
            <div class="header-inner__metastasis-listing">
                <button class="header-inner__metastasis-listing--button">
                    出品
                </button>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="product">
        <div class="product-tag">
            <button id="recommendationBtn" class="product-tag__recommendation">
                おすすめ
            </button>
            <button id="myListBtn" class="product-tag__myList">
                マイリスト
            </button>
        </div>
        <!--おすすめで表示するリスト-->
        <div class="product-recommendation">
        @foreach ($products as $product)
                <a class="product-recommendation__card" >
                    <div class="product-recommendation__card-img">
                        <img class="product-recommendation__card-img--item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                    </div>
                    <div class="product-recommendation__card-content">
                        <p class="product-recommendation__card-content--name">
                            {{ $product->product_name }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>


        <!--マイリストで表示するリスト-->
        <div class="product-myList" >
            @foreach ($liked_products as $product)
                <div class="product-myList__card">
                    <div class="product-myList__card-img">
                        <img class="product-myList__card-img--item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                    </div>
                    <div class="product-myList__card-content">
                        <p class="product-myList__card-content--name">
                            {{ $product->product_name }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const recommendationDiv = document.querySelector('.product-recommendation');
    const myListDiv = document.querySelector('.product-myList');

    document.getElementById('recommendationBtn').addEventListener('click', () => {
        // おすすめを見せて、マイリストを隠す
        recommendationDiv.style.opacity = '1';
        recommendationDiv.style.pointerEvents = 'auto';
        recommendationDiv.style.visibility = 'visible';

        myListDiv.style.opacity = '0';
        myListDiv.style.pointerEvents = 'none';
        myListDiv.style.visibility = 'hidden';
    });

    document.getElementById('myListBtn').addEventListener('click', () => {
        // マイリストを見せて、おすすめを隠す
        recommendationDiv.style.opacity = '0';
        recommendationDiv.style.pointerEvents = 'none';
        recommendationDiv.style.visibility = 'hidden';

        myListDiv.style.opacity = '1';
        myListDiv.style.pointerEvents = 'auto';
        myListDiv.style.visibility = 'visible';
    });
});
</script>
</body>
</html>