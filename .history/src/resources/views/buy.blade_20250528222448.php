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
<!--商品購入画面-->
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
    <div class="buy">
        <div class="buy-content">
            <div class="buy-content__product">
                <div class="buy-content__product-image">
                    <img src="" alt="商品画像">
                </div>
                <div class="buy-content__product-name">
                    <p class="buy-content__product-name--item">
                        <!--商品名-->
                    </p>
                </div>
                <div class="buy-content__product-price">
                    <!--値段-->
                </div>
            </div>
            <div class="buy-content__payment">
                <label class="buy-content__payment-label">
                    支払い方法
                </label>
                <div class="buy-content__payment-select">
                    <select class="buy-content__payment-select-option" name="" id="">
                        <option value="選択してください">
                            選択してください
                        </option>
                        <option value="コンビニ払い">
                            コンビニ払い
                        </option>
                        <option value="カード払い">
                            カード払い
                        </option>
                    </select>

                </div>
            </div>
            <div class="buy-content__delivery">
                <label class="buy-content__delivery-label">
                    配送先
                </label>
                <a class="buy-content__delivery-change" href="">
                    変更する
                </a>
                <div class="buy-content__delivery-item">
                    <!--住所を表示-->
                </div>
            </div>
        </div>
        <form class="buy-accounting" action="">
            <table class="buy-acco">

            </table>
        </form>
    </div>
</main>
</body>
</html>