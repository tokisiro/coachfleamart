
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img class="profile-image__icon-item" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                <label class="profile-image__icon-label">
                {{ $user->name }}
                </label>
                <div class="profile-image__icon-link">
                    <a class="profile-image__icon-link--item" href="/mypage/profile">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-tag">
            <a id="ListingBtn" class="{{ $mode == 'Listing' ? 'active' : '' }}" href="/mypage/?tab=sell">
                出品した商品
            </a>
            <a id="purchaseBtn" class="{{ $mode = 'purchase' ? 'active' : '' }}" href="/mypage/?tab=buy">
                購入した商品
            </a>
        </div>
        <div class="profile-list">
            <!--出品した商品で表示するリスト-->
            
            @forelse($listedProducts as $product)
                <a class="profile-list__Listing-card" href="/item/{{ $product->id }}">
                    <div class="profile-list__Listing-card--img">
                        <img class="profile-list__Listing-card--img-item" src="{{ $product->image }}" alt="" />
                    </div>
                    <div class="profile-list__Listing-card--content">
                        <p class="profile-list__Listing-card--content-name">
                        {{ $product->product_name }}
                        </p>
                    </div>
                </a>
                @empty
                        <p class="profile-list__purchase-none">
                            出品履歴はありません。
                        </p>
                @endforelse
            </div>
            <!--購入した商品で表示するリスト-->
            
            @forelse($purchasedProducts as $product)
                <a class="profile-list__purchase-card" href="/item/{{ $product->id }}" >
                    <div class="profile-list__purchase-card--img">
                        <img class="profile-list__purchase-card--img-item" src="{{ $product->image }}" alt="商品画像" />
                    </div>
                    <div class="profile-list__purchase-card--content">
                        <p class="profile-list__purchase-card--content-name">
                        {{ $product->product_name }}
                        </p>
                    </div>
                </a>
                @empty
                    <p class="profile-list__purchase-card--none">
                        購入履歴はありません。
                    </p>
                @endforelse
            </div>
        </div>
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
</script>
@endsection