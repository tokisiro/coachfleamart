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
            <button class="product-tag__recommendation">
                おすすめ
            </button>
            <button class="product-tag__myList">
                マイリスト
            </button>
        </div>
        <!--おすすめで表示するリスト-->
        <div class="product-recommendation">
        
        
            <div class="card">
                <div class="card__img">
                    <img src="img/card.jpg" alt="" />
                </div>
                <div class="card__content">
                    <div class="card__content-cat">商品名</div>
                    
                    <div class="card__content-tag">
                        <p class="card__content-tag-item">#朝ごはん</p>
                        <p class="card__content-tag-item card__content-tag-item--last">
                            2021/01/01
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <!--マイリストで表示するリスト-->
        <div class="product-myList">
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
        </div>
    </div>
</main>
</body>
</html>