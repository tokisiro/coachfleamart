
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/setting.css">
@endsection


<!--送付先住所変更-->

@section('content')
    <div class="setting">
        <div class="setting-title">
            <h2 class="setting-title__item">
                住所の変更
            </h2>
        </div>
        <form class="setting-form" action="/mypage/action" method="post">
            @csrf
            
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

@endsection
