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
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
        <div class="header-inner__search">
            <input class="header-inner__search-input" type="text">
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
    <div class="detail">
        <div class="detail-img">
            <img class="detail-img__item" alt="商品画像" src="{{ asset($detail->image) }}">
        </div>
        <div class="detail-content">
            <form class="detail-content__product" method="post" action="{{ route('product.toggleNice', ['product' => $detail->id]) }}">
            @csrf
                <div class="detail-content__product-name">
                    <h3 class="detail-content__product-name--title">
                    {{$detail->product_name}}
                    </h3>
                    <p class="detail-content__product-name--brand">
                    {{$detail->brand_name}}
                    </p>
                </div>
                <div class="detail-content__product-price">
                    ¥
                    <span class="detail-content__product-price--item">
                        {{number_format($detail->price)}}
                    </span>
                    (税込)
                </div>
                <div class="detail-content__product-evaluation">
                    <div class="detail-content__product-evaluation--nice"  >
                        @if($hasNice)
                            <button type="submit" class="detail-content__product-evaluation--nice-img">
                                <img class="detail-content__product-evaluation--nice-img-item" src="/storage/star_filled.png" alt="いいね済み" />
                            </button>
                        @else
                            <button type="submit" class="detail-content__product-evaluation--nice-img">
                                <img class="detail-content__product-evaluation--nice-img-item" src="/storage/star.png" alt="星">
                            </button>
                        @endif
                        <div class="detail-content__product-evaluation--nice-count">
                            {{ $niceCount }}
                        </div>
                    </div>
                    <div class="detail-content__product-evaluation--comment">
                        <div class="detail-content__product-evaluation--comment-button">
                            <img class="detail-content__product-evaluation--comment-button-img" src="/storage/comment.png" alt="吹き出し">
                        </div>
                        <div class="detail-content__product-evaluation--comment-count">
                            {{$commentsCount}}
                        </div>
                    </div>
                </div>
            </form>
            <form class="detail-content__information" action="{{ url('/purchase/' . $detail->id) }}" method="get">
                <div class="detail-content__information-button">
                    <button class="detail-content__information-button--item" type="submit">
                        購入手続きへ
                    </button>
                </div>
                <div class="detail-content__information-index">
                    <h3 class="detail-content__information-index--item">
                        商品説明
                    </h3>
                </div>
                <div class="detail-content__information-explanation">
                    <div class="detail-content__information-explanation--item">
                    {{$detail->explanation}}
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
            <form class="detail-content__comment" action="/comment" method="">
                <div class="detail-content__comment-index">
                    <h3 class="detail-content__comment-index--item">
                        コメント()
                    </h3>
                </div>
                <div class="detail-content__comment-existing">
                @foreach ($comments as $comment)
                    <div class="detail-content__comment-existing--icon">
                        <img class="detail-content__comment-existing--icon-img" src="{{$comment->user->icon}}" alt="アイコン">
                        <label>{{$comment->user->name}}</label>
                    </div>
                    <div class="detail-content__comment-existing--message">
                    {{$comment->content}}
                    </div>
                    @endforeach
                </div>
                <div class="detail-comment__new">
                    <label class="detail-content__comment-new--label">
                        商品へのコメント
                    </label>
                    <input class="detail-content__comment-new--input" type="textarea">
                </div>
                <div class="detail-content__comment-button">
                    <button class="detail-content__comment-button--item" type="submit">
                        コメントを送信する
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>