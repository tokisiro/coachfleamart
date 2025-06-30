
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/setting.css">
@endsection


<!--プロフィール設定画面（初回ログイン時）-->

@section('content')
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
                <img class="setting-form__icon-img" src="" alt="">
                <!-- 目立たない隠しinput -->
                <input class="setting-form__icon-input" type="file" name="icon">
                <!-- カスタムボタン -->
                <button type="button" class="setting-form__icon-button">画像を選択する</button>
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
</main>
@
<script>
    document.querySelector('.setting-form__icon-button').addEventListener('click', () => {
    // 隠しているファイル入力をクリック
    document.querySelector('.setting-form__icon-input').click();
    });
</script>
</body>
</html>