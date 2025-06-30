
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
                    <a class="profile-image__icon-link--item" href="/mypage/profile">
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
            @forelse($purchasedProducts as $product)
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
                            出品履歴はありません。
                        </p>
                    </div>
                </a>
                @endforelse
            </div>
            <!--購入した商品で表示するリスト-->
            <div class="profile-list__purchase" >
            @forelse($listedProducts as $product)
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
                @endforelse
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    // 初期状態
document.querySelector('.profile-list__Listing').classList.add('visible');
document.querySelector('.profile-list__purchase').classList.add('hidden');

function toggleTabs(tabName) {
  const listing = document.querySelector('.profile-list__Listing');
  const purchase = document.querySelector('.profile-list__purchase');

  if (tabName === 'listing') {
    listing.classList.add('visible');
    listing.classList.remove('hidden');
    purchase.classList.remove('visible');
    purchase.classList.add('hidden');

    // タブのスタイルも切り替える
    document.getElementById('ListingBtn').classList.add('active');
    document.getElementById('purchaseBtn').classList.remove('active');
  } else {
    listing.classList.remove('visible');
    listing.classList.add('hidden');
    purchase.classList.add('visible');
    purchase.classList.remove('hidden');

    // タブのスタイルも切り替える
    document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('ListingBtn').addEventListener('click', () => toggleTabs('listing'));
  document.getElementById('purchaseBtn').addEventListener('click', () => toggleTabs('purchase'));
});
  }
}
</script>
@endsection
</body>
</html>