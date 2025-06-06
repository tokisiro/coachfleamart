<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/sell.css">
</head>
<body>
<!--商品出品画面-->
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
            <div class="sell-img__icon">
                <img class="sell-img__icon-item" src="" alt="">
                <!-- 目立たない隠しinput -->
                <input class="sell-img__icon-input" type="file">
                <!-- カスタムボタン -->
                <button type="button" class="sell-img__icon-button">画像を選択する</button>
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
                <label class="sell-category__checkbox-label" for="category-fashion">
                    ファッション
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-fashion" name="category" value="fashion">
                </label>
                <label class="sell-category__checkbox-label" id="category-appliances">
                    家電
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-appliances" name="category" value="appliances">
                </label>
                <label class="sell-category__checkbox-label" id="category-interior">
                    インテリア
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-interior" name="category" value="interior">
                </label>
                <label class="sell-category__checkbox-label" id="category-ladies">
                    レディース
                    <input class="sell-category__checkbox-label--input" type="checkbox"
                    id="category-ladies" name="category" value="ladies">
                </label>
                <label class="sell-category__checkbox-label" id="category-mens">
                    メンズ
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-mens" name="category" value="mens">
                </label>
                <label class="sell-category__checkbox-label" id="category-cosmetics">
                    コスメ
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-cosmetics" name="category" value="cosmetics">
                </label>
                <label class="sell-category__checkbox-label" id="category-book">
                    本
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-book" name="category" value="book">
                </label>
                <label class="sell-category__checkbox-label" id="category-game">
                    ゲーム
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-game" name="category" value="game">
                </label>
                <label class="sell-category__checkbox-label" id="category-sports">
                    スポーツ
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-sports" name="category" value="sports">
                </label>
                <label class="sell-category__checkbox-label">
                    キッチン
                    <input class="sell-category__checkbox-label--input" type="checkbox" id="category-kitchen" name="category" value="ki">
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
                    <option value="">選択してください</option>
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
        <div class="sell-button">
            <button class="sell-button__item">
                出品する
            </button>
        </div>
    </form>
</main>
<script>
    document.querySelector('.sell-img__icon-button').addEventListener('click', () => {
    // 隠しているファイル入力をクリック
    document.querySelector('.sell-img__icon-input').click();
    });
</script>
</body>
</html>