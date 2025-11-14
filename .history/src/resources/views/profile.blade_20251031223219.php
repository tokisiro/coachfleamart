
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

<!--プロフィール画面-->

@section('content')
        <div class="profile-image">
            <div class="profile-image__icon">
                <img class="profile-image__icon-item" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                <label class="profile-image__icon-label">
                    {{ $user->name }}
                </label>
                <div class="profile-rating">
                @if ($averageRating !== null && $evaluationsCount > 0)
        <div class="profile-rating__item">
                @php
                    $filledStars = floor($averageRating);
                    $emptyStars = 5 - $filledStars;
                @endphp

                {{-- 塗りつぶされた星の表示 --}}
                @for ($i = 0; $i < $filledStars; $i++)
                    <span class="profile-rating__star filled"></span>
                @endfor
                {{-- 空の星の表示 --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <span class="profile-rating__star empty"></span>
                @endfor
                </div>
                <p class="profile-rating__text">平均評価: {{ number_format($averageRating, 1) }} / 5</p>
                @else
                <p class="no-rating-message">まだ評価がありません。</p>
                @endif
            </div>
            <div class="profile-image__icon-link">
                <a class="profile-image__icon-link--item" href="/mypage/profile">
                    プロフィールを編集
                </a>
            </div>
        </div>
        <div class="profile-tag">
            <a id="ListingBtn" class="{{ $mode == 'sell' ? 'active' : '' }}" href="/mypage?page=sell">
                出品した商品
            </a>
            <a id="purchaseBtn" class="{{ $mode == 'buy' ? 'active' : '' }}" href="/mypage?page=buy">
                購入した商品
            </a>
            <a id="transactionBtn" class="{{ $mode == 'transaction' ? 'active' : '' }}" href="/mypage?page=transaction">
                取引中の商品
            @if ($totalUnreadTransactionMessages > 0)
            <span class="profile-tag__badge">
                {{ $totalUnreadTransactionMessages }}
            </span>
        @endif
            </a>
        </div>
        <div class="profile-list">
            <!--出品した商品で表示するリスト-->
            <div class="profile-list__Listing" style="{{ $mode == 'sell' ? '' : 'display:none;' }}">
            @forelse($listedProducts as $product)
                <a class="profile-list__Listing-card" href="/item/{{ $product->id }}">
                    <div class="profile-list__Listing-card--img">
                        <img class="profile-list__Listing-card--img-item" src="{{ asset($product->image) }}" alt="" />
                    </div>
                    <div class="profile-list__Listing-card--content">
                        <p class="profile-list__Listing-card--content-name">
                        {{ $product->product_name }}
                        </p>
                    </div>
                </a>
                @empty
                    <p class="profile-list__purchase-card--none">
                        出品履歴はありません。
                    </p>
                @endforelse
            </div>
            <!--購入した商品で表示するリスト-->
            <div class="profile-list__purchase" style="{{ $mode == 'buy' ? '' : 'display:none;' }}">
            @forelse($purchasedProducts as $product)
                <a class="profile-list__purchase-card" href="/item/{{ $product->id }}" >
                    <div class="profile-list__purchase-card--img">
                        <img class="profile-list__purchase-card--img-item" src="{{ asset($product->image) }}" alt="商品画像" />
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
            <!--取引中の商品で表示するリスト-->
            <div class="profile-list__transaction" style="{{ $mode == 'transaction' ? '' : 'display:none;' }}">
            @forelse($transactionProducts as $product)
                <a class="profile-list__transaction-card" href="/item/{{ $product->id }}/transaction" >
                    <div class="profile-list__transaction-card--img">
                        @if (isset($unreadCounts[$product->id]) && $unreadCounts[$product->id] > 0)
                        <span class="profile-list__transaction-card--img-item-badge">{{ $unreadCounts[$product->id] }}</span>
                        @endif
                        <img class="profile-list__transaction-card--img-item" src="{{ asset($product->image) }}" alt="商品画像" />
                    </div>
                    <div class="profile-list__transaction-card--content">
                        <p class="profile-list__transaction-card--content-name">
                        {{ $product->product_name }}
                        </p>
                    </div>
                </a>
                @empty
                    <p class="profile-list__transaction-card--none">
                        取引中の商品はありません。
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