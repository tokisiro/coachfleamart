<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>
<body>
<!--商品一覧画面（トップ）-->
<header class="header">
    <div class="header__inner">
        <div class="header-title">
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
    </div>
</header>
<main>
@yield('content')
</main>
@yield('script')
</body>
</html>