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
<!--商品出品画面-->
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
    <form class="sell">
        <div class="sell-title">
            <h2 class="sell-title__item">
                商品の出品
            </h2>
        </div>
        <div class="sell-img">
            <label class="sell-img__label">
                商品画像
            </label>
            <div class="sell-img__range">
                <input class="sell-img__range-input" type="file">
            </div>
        </div>
        <div class="sell-index">
            <h3 class="sell-index__item">
                商品の詳細
            </h3>
        </div>
        <div class="sell-category">
            <div class="sell-category__label">
                <label class="sell-category__label-item">
                    カテゴリー
                </label>
            </div>
            <div class="sell-category__checkbox">
                <label class="sell-category__checkbox-label">
                    ファッション
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    家電
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    インテリア
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    レディース
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    メンズ
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    コスメ
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    本
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    ゲーム
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    スポーツ
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    キッチン
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    ハンドメイド
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    アクセサリー
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    おもちゃ
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
                <label class="sell-category__checkbox-label">
                    ベビー・キッズ
                    <input class="sell-category__checkbox-label--input" type="checkbox">
                </label>
            </div>
        </div>
        <div class="sell-status">
            <div class="sell-status__range">
                <label class="sell-status__range-label">
                    商品の状態
                </label>
                <select class="sell-status__range-select" name="" >
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
            </div>
        </div>
        <div class="sell-index">
            <h3 class="sell-index__item">
                商品名と説明
            </h3>
        </div>
        <div class="sell-name">
            <label class="sell-name__label">
                商品名
                <input class="sell-name__label-input" type="text">
            </label>
        </div>
        <div class="sell-brand">
            <label class="sell-brand__label">
                ブランド名
                <input class="sell-brand__label-input" type="text">
            </label>
        </div>
        <div class="sell-explanation">
            <label class="sell-explanation__label">
                商品の説明
                <input class="sell-explanation__label-input" type="textarea">
            </label>
        </div>
        <div class="sell-price">
            <label class="sell-price__label">
                販売価格
                <input class="sell-price__label-input" type="text">
            </label>
        </div>
        <div class="sell">

        </div>
    </form>
</main>
</body>
</html>