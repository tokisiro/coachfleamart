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
    <div class="setting">
        <div class="setting-title">
            <h2 class="setting-title__item">
                プロフィール設定
            </h2>
        </div>
        <form class="setting-form">
            <div class="setting-form__icon">
                <img class="setting-form__icon-img" src="" alt="">
                <label class="setting-form__icon-label">
                    画像を選択する
                </label>
                <input class="setting-form__icon-label--input" type="file">
            </div>
            <div class="setting-form__name">
                <label class="setting-form__name-label">
                    ユーザー名
                </label>
                <input class="setting-form__name-label--input" type="text">
            </div>
            <div class="setting-form__post">
                <label class="setting-form__post-label">
                    郵便番号
                </label>
                <input class="setting-form__post-label--input" type="text">
            </div>
            <div class="setting-form__address">
                <label class="setting-form__address-label">
                    住所
                </label>
                <input class="setting-form__address-label--input" type="text">
            </div>
            <div class="setting-form__building">
                <label class="setting-form__building-label">
                    建物名
                </label>
                <input class="setting-form__building-label--input" type="text">
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