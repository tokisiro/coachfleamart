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
                <div class="product-recommendation__card">
                    <div class="product-recommendation__card-img">
                        <img class="product-recommendation__card-img--item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                    </div>
                    <div class="product-recommendation__card-content">
                        <p class="product-recommendation__card-content--name">
                            {{ $product->product_name }}
                        </p>
                    </div>
                </div>
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
    const recommendationBtn = document.getElementById('recommendationBtn');
    const myListBtn = document.getElementById('myListBtn');
    const recommendationDiv = document.querySelector('.product-recommendation');
    const myListDiv = document.querySelector('.product-myList');

    recommendationBtn.addEventListener('click', () => {
        recommendationDiv.style.display = 'block';
        myListDiv.style.display = 'none';
    });

    myListBtn.addEventListener('click', () => {
        recommendationDiv.style.display = 'none';
        myListDiv.style.display = 'block';
    });
    });
</script>
</body>
</html>