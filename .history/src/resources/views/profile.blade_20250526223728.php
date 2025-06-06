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
<!--プロフィール設定画面（初回ログイン時）-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
    </div>
</header>
<main>
    <div class="profile">
        <div class="profile-title">
            <h2 class="profile-title__item">
                プロフィール設定
            </h2>
        </div>
        <form class="profile-form">
            <div class="profile-form__icon">
                <img class="profile-form__icon-img" src="" alt="">
                <label class="profile-form__icon-label">
                    画像を選択する
                    <input class="profile-form__icon-label--input" type="file">
                </label>
            </div>
            <div class="profile-form__name">
                <label class="profile-form__name-label">
                    ユーザー名
                    <input class="profile-form__name-label--input" type="text">
                </label>
            </div>
            <div class="profile-form__post">
                <label class="profile-form__post-label">
                    郵便番号
                    <input class="profile-form__post-label--input" type="text">
                </label>
            </div>
            <div class="profile-form__address">
                <label class="profile-form__address-label">
                    住所
                    <input type="text">
                </label>

            </div>
        </form>
    </div>
</main>
</body>
</html>