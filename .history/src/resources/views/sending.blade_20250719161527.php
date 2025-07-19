
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/sending.css">
@endsection


<!--送付先住所変更-->

@section('content')
    <div class="sending">
        <div class="sending-title">
            <h2 class="sending-title__item">
                住所の変更
            </h2>
        </div>
        <form class="sending-form" action="{{ url('/mypage/address/' . ) }}" method="post">
            @csrf
            <div class="sending-form__post">
                <label class="sending-form__post-label">
                    郵便番号
                </label>
                <input class="sending-form__post-input" type="text" value="{{ old('post_code', $user->post_code ?? '') }}" name="post_code">
            </div>
            <div class="sending-form__address">
                <label class="sending-form__address-label">
                    住所
                </label>
                <input class="sending-form__address-input" type="text" value="{{ old('address', $user->address ?? '') }}" name="address">
            </div>
            <div class="sending-form__building">
                <label class="sending-form__building-label">
                    建物名
                </label>
                <input class="sending-form__building-input" type="text" value="{{ old('building', $user->building ?? '') }}" name="building">
            </div>
            <div class="sending-form__button">
                <button class="sending-form__button-item" type="submit">
                    更新する
                </button>
            </div>
        </form>
    </div>
@endsection
@section('script')

@endsection
