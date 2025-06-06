<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/register.css">
</head>
<body>
<!--会員登録画面-->
<header class="header">
    <div class="header__inner">
        <div class="header-inner__logo">
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
                </label>
                <input class="register-form__name-item" type="text">
            </div>
            <div class="register-form__email">
                <label class="register-form__email-label">
                    メールアドレス
                </label>
                <input class="register-form__email-item" type="email">
            </div>
            <div class="register-form__password">
                <label class="register-form__password-label">
                    パスワード
                </label>
                <input class="register-form__password-item" type="text">
            </div>
            <div class="register-form__confirmation">
                <label class="register-form__confirmation-label">
                    確認用パスワード
                </label>
                <input class="register-form__confirmation-item" type="text">
            </div>
            <div class="register-form__button">
                <button class="register-form__button-item">
                    登録する
                </button>
            </div>
        </form>
        <div class="register-link">
            <a class="register-lin" href="">
                ログインはこちら
            </a>
        </div>
    </div>
</main>
</body>
</html>