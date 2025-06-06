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
<!--会員登録画面-->
<header class="header">
    <div class="header__inner">
        <div class="header-logo">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
    </div>
</header>
<main>
    <div class="register">
        <div class="register-title">
            <h2 class="register-title__item">
                会員登録
            </h2>
        </div>
        <form class="register-form" action="" method="post">
            <div class="register-form__name">
                <label class="register-form__name-label">
                    ユーザー名
                    <input class="register-form__name-label--item" type="text">
                </label>
            </div>
            <div class="register-form__email">
                <label class="register-form__email-label">
                    メールアドレス
                    <input class="register-form__email-label--item" type="email">
                </label>
            </div>
            <div class="register-form__password">
                <label class="register-form__password-label">
                    パスワード
                    <input class="register-form__password-label--item" type="text">
                </label>
            </div>
            <div class="register-form__confirmation">
                <label class="register-form__confirmation-label">
                    確認用パスワード
                    <input class="register-form__confirmation-label--item" type="text">
                </label>
            </div>
            <div class="register-form__button">
                <button class="register-form__button-item">

                </button>
            </div>
        </form>
        <div class="register-link">
            <a href="">
                ログインはこちら
            </a>
        </div>
    </div>
</main>
</body>
</html>