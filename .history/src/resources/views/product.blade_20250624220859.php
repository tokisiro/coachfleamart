<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="/css/product.css">
</head>
<body>
<!--商品一覧画面（トップ）-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
        <form class="header-inner__search" id="searchForm" action="/search" method="post">
            @csrf
            <input class="header-inner__search-input" type="text" name="query" placeholder="何をお探しですか？" value="{{ old('query', isset($searchTerm) ? $searchTerm : '') }}">
        </form>
        <div class="header-inner__metastasis">
            @if (Auth::check())
            <form class="header-inner__metastasis-situation" action="/logout" method="post" >
                @csrf
                <button class="header-inner__metastasis-situation--logout" type="submit" v>
                    ログアウト
                </button>
                @else
                <a class="header-inner__metastasis-situation--login" href="/login">
                    ログイン
                </a>
            </form>
            @endif
            <div class="header-inner__metastasis-page">
                <a class="header-inner__metastasis-page--link" href="/mypage">
                    マイページ
                </a>
            </div>
            <div class="header-inner__metastasis-listing">
                <a class="header-inner__metastasis-listing--button" href="/sell">
                    出品
                </a>
            </div>
        </div>
    </div>
</header>
<main>
<!--商品一覧画面（トップ）-->
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
            <div class="product-list__recommendation">
                @foreach ($products as $product)
                    <a class="product-list__recommendation-card" href="/item/{{ $product->id }}">
                        <div class="product-list__recommendation-card--img">
                            <img class="product-list__recommendation-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                        </div>
                        <div class="product-list__recommendation-card--content">
                            <p class="product-list__recommendation-card--content-name">
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
            <div class="product-list__myList" >
                @foreach ($liked_products as $product)
                    <a class="product-list__myList-card" href="/item/{{ $product->id }}" >
                        <div class="product-list__myList-card--img">
                            <img class="product-list__myList-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                        </div>
                        <div class="product-list__myList-card--content">
                            <p class="product-list__myList-card--content-name">
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
</main>
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
</body>
</html>