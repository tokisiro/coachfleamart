
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
            <button id="ListingBtn" class="profile-tag__Listing active" type="button">
                出品した商品
            </button>
            <button id="purchaseBtn" class="profile-tag__purchase" type="button">
                購入した商品
            </button>
        </div>
        <div class="profile-list">
            <!--出品した商品で表示するリスト-->
            <div class="profile-list__Listing">
            @forelse($listedProducts as $product)
                <a class="profile-list__Listing-card" href="/item/{{ $product->id }}">
                    <div class="profile-list__Listing-card--img">
                        <img class="profile-list__Listing-card--img-item" src="{{ $product->image }}" alt="" />
                    </div>
                    <div class="profile-list__Listing-card--content">
                        <p class="profile-list__Listing-card--content-name">
                        {{ $product->product_name }}
                        </p>
                        @empty
                        <p class="profile-list__purchase-card--content-name">
                            出品履歴はありません。
                        </p>
                    </div>
                </a>
                @endforelse
            </div>
            <!--購入した商品で表示するリスト-->
            <div class="profile-list__purchase">
            @forelse($purchasedProducts as $product)
                <a class="profile-list__purchase-card" href="/item/{{ $product->id }}" >
                    <div class="profile-list__purchase-card--img">
                        <img class="profile-list__purchase-card--img-item" src="{{ $product->image }}" alt="商品画像" />
                    </div>
                    <div class="profile-list__purchase-card--content">
                        <p class="profile-list__purchase-card--content-name">
                        {{ $product->product_name }}
                        </p>
                        @empty
                        <p class="profile-list__purchase-card--content-name">
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
    document.querySelector('#searchForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ
        this.submit(); // 検索を送信
        }
    });
    // タブのスタイルも切り替える
    document.addEventListener('DOMContentLoaded', () => {
        // 「出品した商品」ボタンをクリックしたときtoggleTabs('listing')が呼ばれる
        document.getElementById('ListingBtn').addEventListener('click', () => toggleTabs('listing'));
        // 「購入した商品」ボタンをクリックしたときtoggleTabs('purchase')が呼ばれる
        document.getElementById('purchaseBtn').addEventListener('click', () => toggleTabs('purchase'));

        // 初期状態:出品リストを表示し、購入リストは隠す
    document.querySelector('.profile-list__Listing').classList.add('visible');
    document.querySelector('.profile-list__purchase').classList.add('hidden');

    
    });
    

    
}
</script>
@endsection