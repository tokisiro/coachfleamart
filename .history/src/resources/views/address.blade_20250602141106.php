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
<!--送信先住所変更画面-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-search">
            <input class="header-search__input" type="text">
        </div>
        <div class="header-inner__metastasis">
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
    </div>
</header>
<main>
<div class="address">
        <div class="address-title">
            <h2 class="address-title__item">
                住所の変更
            </h2>
        </div>
        <form class="address-form" action="" method="post">
            <div class="address-form__post">
                <label class="address-form__post-label">
                    郵便番号
                    <input class="address-form__post-label--item" type="text">
                </label>
            </div>
            <div class="address-form__residence">
                <label class="address-form__residence-label">
                    住所
                    <input class="address-form__residence-label--item" type="text">
                </label>
            </div>
            <div class="address-form__building">
                <label class="address-form__building-label">
                    建物名
                    <input class="address-form__building-label--item" type="text">
                </label>
            </div>
            <div class="address-form__button">
                <button class="address-form__button-item">
                    更新する
                </button>
            </div>
        </form>
</main>
</body>
</html>