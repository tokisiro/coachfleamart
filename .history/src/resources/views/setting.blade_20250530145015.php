<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/setting.css">
</head>
<body>
<!--プロフィール設定画面（初回ログイン時）-->
<header class="header">
    <div class="header__inner">
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
    <div class="setting">
        <div class="setting-title">
            <h2 class="setting-title__item">
                プロフィール設定
            </h2>
        </div>
        <form class="setting-form">
            <div class="setting-form__icon">
            <img class="setting-form__icon-img" src="" alt="">
            <!-- 目立たない隠しinput -->
            <input class="setting-form__icon-input" type="file">
            <!-- カスタムボタン -->
            <button type="button" class="setting-form__icon-button">画像を選択する</button>
            <!-- 非表示のテキスト -->
            <span class="setting-form__icon-text" >選択されていません</span>
            </div>
            <div class="setting-form__name">
                <label class="setting-form__name-label">
                    ユーザー名
                </label>
                <input class="setting-form__name-input" type="text">
            </div>
            <div class="setting-form__post">
                <label class="setting-form__post-label">
                    郵便番号
                </label>
                <input class="setting-form__post-input" type="text">
            </div>
            <div class="setting-form__address">
                <label class="setting-form__address-label">
                    住所
                </label>
                <input class="setting-form__address-input" type="text">
            </div>
            <div class="setting-form__building">
                <label class="setting-form__building-label">
                    建物名
                </label>
                <input class="setting-form__building-input" type="text">
            </div>
            <div class="setting-form__button">
                <button class="setting-form__button-item">
                    更新する
                </button>
            </div>
        </form>
    </div>
</main>
</body>
</html>