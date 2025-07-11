
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection


<!--プロフィール設定画面（初回ログイン時）-->

@section('content')
    <div class="address">
        <div class="address-title">
            <h2 class="address-title__item">
                プロフィール設定
            </h2>
        </div>
        <form id="iconForm" class="address-form" action="/mypage/icon" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="address-form__icon">
                <img id="iconPreview" class="address-form__icon-img" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                <!-- 目立たない隠しinput -->
                <input id="iconInput" class="address-form__icon-input" type="file" name="icon" accept="image/*" style="display: none;">
                <!-- カスタムボタン -->
                <button id="selectImageBtn"  type="button" class="setting-form__icon-button">画像を選択する</button>
                @error('icon')
                        {{$message}}
                @enderror
            </div>
        </form>
        <form class="setting-form" action="/mypage/profile" method="post">
        @csrf
            <div class="setting-form__name">
                <label class="setting-form__name-label">
                    ユーザー名
                </label>
                <input class="setting-form__name-input" type="text" value="{{ old('name', $user->name ?? '') }}" name="name">
                @error('name')
                        {{$message}}
                @enderror
            </div>
            <div class="setting-form__post">
                <label class="setting-form__post-label">
                    郵便番号
                </label>
                <input class="setting-form__post-input" type="text" value="{{ old('post_code', $user->post_code ?? '') }}" name="post_code">
                @error('post_code')
                        {{$message}}
                @enderror
            </div>
            <div class="setting-form__address">
                <label class="setting-form__address-label">
                    住所
                </label>
                <input class="setting-form__address-input" type="text" value="{{ old('address', $user->address ?? '') }}" name="address">
                @error('address')
                        {{$message}}
                @enderror
            </div>
            <div class="setting-form__building">
                <label class="setting-form__building-label">
                    建物名
                </label>
                <input class="setting-form__building-input" type="text" value="{{ old('building', $user->building ?? '') }}" name="building">
                @error('building')
                        {{$message}}
                @enderror
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

    document.getElementById('iconInput').addEventListener('change', function() {
        this.form.submit(); // 画像選択後に自動送信
});
</script>
@endsection
