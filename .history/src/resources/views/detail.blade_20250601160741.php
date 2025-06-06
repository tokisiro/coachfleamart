<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/detail.css">
</head>
<body>
<!--商品詳細画面（ログイン後）-->
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
    <div class="detail">
        <div class="detail-img">
            <img class="detail-img__item" src="" alt="商品画像">
        </div>
        <div class="detail-content">
            <form class="detail-content__product" method="post">
                <div class="detail-content__product-name">
                    <h3 class="detail-content__product-name--title">
                        商品名が入る
                    </h3>
                    <p class="detail-content__product-name--brand">
                    ブランド名
                    </p>
                </div>
                <div class="detail-content__product-price">

                </div>
                <div class="detail-content__product-evaluation">
                    <div class="detail-content__product-evaluation--nice">
                        <button class="detail-content__product-evaluation--nice-button">
                            <img src="/storage/star.png" alt="">
                        </button>
                        <span class="detail-content__product-evaluation--nice-count">
                            0
                        </span>
                    </div>
                    <div class="detail-content__product-evaluation--comment">
                        <div class="detail-content__product-evaluation--comment-button">
                            <img src="/storage/comment.png" alt="">
                        </div>
                        <span class="detail-content__product-evaluation--comment-count">
                            0
                        </span>
                    </div>
                </div>
            </form>
            <form class="detail-content__information" action="">
                <div class="detail-content__information-button">
                    <a class="detail-content__information-button--item">
                        購入手続きへ
                    </a>
                </div>
                <div class="detail-content__information-index">
                <h3 class="detail-content__information-index--item">
                    商品説明
                </h3>
            </div>
            <div class="detail-content__information-explanation">
                <div class="detail-content__information-explanation--item">
                    <!--商品説明を表示-->
                </div>
            </div>
            <div class="detail-content__information-index">
                <h3 class="detail-content__information-index--item">
                    商品の情報
                </h3>
            </div>
            <div class="detail-content__information-category">
                <label class="detail-content__information-category--label">
                    カテゴリー
                </label>
                <div class="detail-content__information-category--item">
                    <!--カテゴリーを表示-->
                </div>
            </div>
            <div class="detail-content__information-status">
                <label class="detail-content__information-status--label">
                    商品の状態
                </label>
                <div class="detail-content__information-status--item">
                    <!--商品の状態を表示-->
                </div>
            </div>
        </form>
        <form class="detail-content__comment" action="">
            <div class="detail-content__comment-index">
                <h3 class="detail-content__comment-index--item">
                    コメント()
                </h3>
            </div>
            <div class="detail-content__comment-existing">
                <div class="detail-content__comment-existing--icon">
                    <label><img src="" alt="アイコン"><!--ユーザー名--></label>
                </div>
                <div class="detail-content__comment-existing--message">
                    <!--コメント表示-->
                </div>
            </div>
            <div class="detail-comment__new">
                <label class="detail-content__comment-new--label">
                    商品へのコメント
                    <input type="textarea">
                </label>
            </div>
            <div class="detail-content__comment-button">
                <button class="detail-content__comment-button--item">
                    コメントを送信する
                </button>
            </div>
        </form>
        </div>
    </div>
</main>
</body>
</html>