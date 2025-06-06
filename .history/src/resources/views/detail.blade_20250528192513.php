<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/address.css">
</head>
<body>
<!--商品詳細画面（ログイン後）-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-search">
            <input class="header-search__input" type="text">
        </div>
        <div class="header-logout">
            <a class="header-logout__link" href="">
                ログアウト
            </a>
        </div>
        <div class="header-page">
            <a class="header-page__link" href="">
                マイページ
            </a>
        </div>
        <div class="header-listing">
            <button class="header-listing__button">
                出品
            </button>
        </div>
    </div>
</header>
<main>
    <div class="detail">
        <form class="detail-product" method="post">
            <div class="detail-product__img">
                <img src="" alt="商品画像">
            </div>
            <div class="detail-product__name">
                <h3 class="detail-product__name-title">
                    商品名が入る
                </h3>
                <p class="detail-product__name-brand">
                    ブランド名
                </p>
            </div>
            <div class="detail-product__price">

            </div>
            <div class="detail-product__evaluation">
                <div class="detail-product__evaluation-nice">
                    <button class="detail-product__evaluation-nice--button">
                        ☆
                    </button>
                    <span class="detail-product__evaluation-nice--count">
                        0
                    </span>
                </div>
                <div class="detail-product__evaluation-comment">
                    <div class="detail-product__evaluation-comment--button">
                        フキダシ
                    </div>
                    <span class="detail-product__evaluation-comment--count">
                        0
                    </span>
                </div>
            </div>
            <div class="detail-product__button">
                <a class="detail-product__button-item">
                    購入手続きへ
                </a>
            </div>
        </form>
        <div class="detail-information">
            <div class="detail-information__index">
                <h3 class="detail-information__index-item">
                    商品説明
                </h3>
            </div>
            <div class="detail-information__explanation">
                <div class="detail-information__explanation-item">
                    <!--商品説明を表示-->
                </div>
            </div>
            <div class="detail-information__index">
                <h3 class="detail-information__index-item">
                    商品の情報
                </h3>
            </div>
            <div class="detail-information__category">
                <label class="detail-information__category-item">
                    カテゴリー
                </label>
                <div >

                </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>