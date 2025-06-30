<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>
<body>
<!--商品一覧画面（トップ）-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
        <form class="header-inner__search" id="searchForm" action="/search" method="GET">
            <input class="header-inner__search-input" type="text" placeholder="何をお探しですか？">
        </form>
        <div class="header-inner__metastasis">
            @if (Auth::check())
            <form class="header-inner__metastasis-situation" action="/logout" method="post">
                @csrf
                <button class="header-inner__metastasis-situation--logout">
                    ログアウト
                </button>
                @else
                <a class="header-inner__metastasis-situation--login" href="/login">
                    ログイン
                </a>
            </form>
            @endif
            <div class="header-inner__metastasis-page">
                <a class="header-inner__metastasis-page--link" href="/mypage">
                    マイページ
                </a>
            </div>
            <div class="header-inner__metastasis-listing">
                <a class="header-inner__metastasis-listing--button" href="/sell">
                    出品
                </a>
            </div>
        </div>
    </div>
</header>
<main>
@yield('content')
</main>
@yield('script')
</body>
</html>