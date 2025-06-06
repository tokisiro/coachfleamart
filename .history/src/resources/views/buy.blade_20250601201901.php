<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/buy.css">
</head>
<body>
<!--商品購入画面-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <img src="storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-inner__search">
            <input class="header-inner__search-input" type="text" placeholder="何をお探しですか？">
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
    <div class="buy">
        <div class="buy-content">
            <div class="buy-content__product">
                <div class="buy-content__product-image">
                    <img src="" alt="商品画像">
                </div>
                <div class="buy-content__product-name">
                    <div class="buy-content__product-name--item">
                        商品名
                    </div>
                    <div class="buy-content__product-name--price">
                    値段
                </div>
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
                <div class="buy-content__delivery-item">
                    <label class="buy-content__delivery-item--label">
                        配送先
                    </label>
                    <a class="buy-content__delivery-item--change" href="">
                        変更する
                    </a>
                </div>
                <div class="buy-content__delivery-item">
                    住所を表示
                </div>
            </div>
        </div>
        <form class="buy-accounting" action="">
            <table class="buy-accounting-table">
                <tr>
                    商品代金
                </tr>
                <tr>
                    支払い方法
                </tr>
            </table>
            <div class="buy-accounting__button">
                <button class="buy-account__button-item">
                    購入する
                </button>
            </div>
        </form>
    </div>
</main>
</body>
</html>