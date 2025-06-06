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
            <div class="header-inner__metastasis-logout">
            <a class="header-inner__metastasis-logout--link" href="">
                ログアウト
            </a>
        </div>
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
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
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