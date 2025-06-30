
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
            <div class="profile-list__Listing" ">
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
    // ページロード時に出品リストを表示し、購入リストを隠す
    document.addEventListener('DOMContentLoaded', () => {
        // 初期状態：出品リスト表示、購入リスト非表示
        toggleTabs('profile-list__purchase');
    });

    function toggleTabs(tabName) {
        const listingDiv = document.querySelector('.profile-list__Listing');
        const purchaseDiv = document.querySelector('.profile-list__purchase');

        if (tabName === 'listing') {
            listingDiv.style.display = 'block';
            purchaseDiv.style.display = 'none';

            document.getElementById('ListingBtn').classList.add('active');
            document.getElementById('purchaseBtn').classList.remove('active');
        } else {
            listingDiv.style.display = 'none';
            purchaseDiv.style.display = 'block';

            document.getElementById('ListingBtn').classList.remove('active');
            document.getElementById('purchaseBtn').classList.add('active');
        }
    }

    document.getElementById('ListingBtn').addEventListener('click', () => toggleTabs('listing'));
    document.getElementById('purchaseBtn').addEventListener('click', () => toggleTabs('purchase'));
</script>
@endsection
</body>
</html>