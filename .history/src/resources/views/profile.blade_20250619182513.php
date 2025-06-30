
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img class="profile-image__icon-item" src="{{ asset('images/default.png') }}" alt="">
                <label class="profile-image__icon-label">
                {{ $user->name }}
                </label>
                <div class="profile-image__icon-link">
                    <a class="profile-image__icon-link--item" href="">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-tag">
            <button id="ListingBtn" class="profile-tag__Listing active">
                出品した商品
            </button>
            <button id="purchaseBtn" class="profile-tag__purchase">
                購入した商品
            </button>
        </div>
        <div class="profile-list">
            <!--出品した商品で表示するリスト-->
            <div class="profile-list__Listing">
            @foreach($purchasedProducts as $product)
                <a class="profile-list__Listing-card" href="">
                    <div class="profile-list__Listing-card--img">
                        <img class="profile-list__Listing-card--img-item" src="" alt="" />
                    </div>
                    <div class="profile-list__Listing-card--content">
                        <p class="profile-list__Listing-card--content-name">
                        {{ $product->product_name }}
                        </p>
                        @empty
                        <p>
                            履歴はありません。
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            <!--購入した商品で表示するリスト-->
            <div class="profile-list__purchase" >
            @foreach($listedProducts as $product)
                <a class="profile-list__purchase-card" href="" >
                    <div class="profile-list__purchase-card--img">
                        <img class="profile-list__purchase-card--img-item" src="" alt="" />
                    </div>
                    <div class="profile-list__purchase-card--content">
                        <p class="profile-list__purchase-card--content-name">
                        {{ $product->product_name }}
                        </p>
                        @empty
                        <p>
                            購入履歴はありません。
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection



</body>
</html>