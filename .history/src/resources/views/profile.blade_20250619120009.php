
@extends('layouts.app')


    <link rel="stylesheet" href="/css/address.css">
</head>
<body>
<!--プロフィール画面-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <img src="/storage/logo.svg" alt="ヘッダーの画像" />
        </div>
        <div class="header-search">
            <input class="header-search__input" type="text" placeholder="何をお探しですか？">
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
    </div>
</header>
<main>
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img src="" alt="">
                <label class="profile-image__icon-label">
                    ユーザー名
                </label>
                <div class="profile-image__icon_link">
                    <a href="">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-listing">
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
        </div>
        <div class="profile-purchase">
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
        </div>
    </div>
</main>
</body>
</html>