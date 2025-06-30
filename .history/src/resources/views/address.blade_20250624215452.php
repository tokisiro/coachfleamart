<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachfleamart</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="/css/setting.css">
</head>
<!--プロフィール設定画面（初回ログイン時）-->
<body>
<!--商品一覧画面（トップ）-->
<header class="header">
    <div class="header-inner">
        <div class="header-inner__title">
            <a href="/">
                <img src="/storage/logo.svg" alt="ヘッダーの画像" />
            </a>
        </div>
        <form class="header-inner__search" id="searchForm" action="/search" method="post">
            @csrf
            <input class="header-inner__search-input" type="text" name="query" placeholder="何をお探しですか？" value="{{ old('query', isset($searchTerm) ? $searchTerm : '') }}">
        </form>
        <div class="header-inner__metastasis">
            @if (Auth::check())
            <form class="header-inner__metastasis-situation" action="/logout" method="post" >
                @csrf
                <button class="header-inner__metastasis-situation--logout" type="submit">
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
    <div class="setting">
        <div class="setting-title">
            <h2 class="setting-title__item">
                プロフィール設定
            </h2>
        </div>
        <form class="setting-form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="setting-form__icon">
                <img id="iconPreview" class="setting-form__icon-img" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                <!-- 目立たない隠しinput -->
                <input id="iconInput" class="setting-form__icon-input" type="file" name="icon" accept="image/*" style="display: none;">
                <!-- カスタムボタン -->
                <button id="selectImageBtn"  type="button" class="setting-form__icon-button">画像を選択する</button>
            </div>
            <div class="setting-form__name">
                <label class="setting-form__name-label">
                    ユーザー名
                </label>
                <input class="setting-form__name-input" type="text" value="{{ old('name', $user->name ?? '') }}" name="name">
            </div>
            <div class="setting-form__post">
                <label class="setting-form__post-label">
                    郵便番号
                </label>
                <input class="setting-form__post-input" type="text" value="{{ old('post_code', $user->post_code ?? '') }}" name="post_code">
            </div>
            <div class="setting-form__address">
                <label class="setting-form__address-label">
                    住所
                </label>
                <input class="setting-form__address-input" type="text" value="{{ old('address', $user->address ?? '') }}" name="address">
            </div>
            <div class="setting-form__building">
                <label class="setting-form__building-label">
                    建物名
                </label>
                <input class="setting-form__building-input" type="text" value="{{ old('building', $user->building ?? '') }}" name="building">
            </div>
            <div class="setting-form__button">
                <button class="setting-form__button-item" type="submit">
                    更新する
                </button>
            </div>
        </form>
    </div>
    @endsection
    @section('script')
<script>
    document.querySelector('#searchForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ
        this.submit(); // 検索を送信
        }
    });
    document.getElementById('selectImageBtn').addEventListener('click', function() {
        document.getElementById('iconInput').click();
    });

    document.getElementById('iconInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('iconPreview').setAttribute('src', e.target.result);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
</main>
</body>
</html>