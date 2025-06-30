
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img class="profile-image__icon-item" src="" alt="">
                <label class="profile-image__icon-label">
                    ユーザー名
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
                <a class="profile-list__Listing-card" href="">
                    <div class="profile-list__Listing-card--img">
                        <img class="profile-list__Listing-card--img-item" src="" alt="" />
                    </div>
                    <div class="profile-list__Listing-card--content">
                        <p class="profile-list__Listing-card--content-name">
                            商品名
                        </p>
                    </div>
                </a>
            </div>
            <!--購入した商品で表示するリスト-->
            <div class="profile-list__purchase" >
                <a class="profile-list__purchase-card" href="" >
                    <div class="profile-list__purchase-card--img">
                        <img class="profile-list__purchase-card--img-item" src="" alt="" />
                    </div>
                    <div class="profile-list__purchase-card--content">
                        <p class="profile-list__purchase-card-content--name">
                            商品名
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection



</body>
</html>