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
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
        <div class="header-inner__search">
            <input class="header-inner__search-input" type="text" placeholder="何をお探しですか？">
        </div>
        <div class="header-inner__metastasis">
        @if (Auth::check())
            <form class="header-inner__metastasis-logout" action="/logout" method="post">
                @csrf
                <button class="header-inner__metastasis-logout--link" href="/logout">
                    ログアウト
                </button>
            </form>
            @else
            <a class="header-inner__metastasis-login" href="/login">
                ログイン
            </a>
            @endif
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
                    <img class="buy-content__product-image--item" src="{{ asset($detail->image) }}" alt="商品画像">
                </div>
                <div class="buy-content__product-name">
                    <div class="buy-content__product-name--item">
                    {{ $detail->product_name }}
                    </div>
                    <div class="buy-content__product-name--price">
                    ¥{{ number_format($detail->price) }}
                </div>
                </div>
            </div>
            <div class="buy-content__payment">
                <label class="buy-content__payment-label">
                    支払い方法
                </label>
                <div class="buy-content__payment-select">
                    <select class="buy-content__payment-select--option" name="" id="">
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
                    <a class="buy-content__delivery-item--change" href="/purchase/address/{product}">
                        変更する
                    </a>
                </div>
                <div class="buy-content__delivery-item">
                〒{{ $post_code }}<br>
                {{ $address }}
                {{ $building }}
                </div>
            </div>
        </div>
        <form class="buy-accounting" action="/buy">
            <table class="buy-accounting__table">
                <tr class="buy-accounting__table-tr">
                    <th>
                        商品代金
                    </th>
                    <td>
                    ¥{{ number_format($detail->price) }}
                    </td>
                </tr>
                <tr class="buy-accounting__table-tr">
                    <th >
                        支払い方法
                    </th>
                    <td>
                        例 コンビニ払い
                    </td>
                </tr>
            </table>
            <div class="buy-accounting__button">
                <button class="buy-account__button-item" type="submit">
                    購入する
                </button>
            </div>
        </form>
    </div>
</main>
</body>
</html>