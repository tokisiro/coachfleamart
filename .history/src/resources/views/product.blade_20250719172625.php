
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection

<!--商品一覧画面（トップ）-->


@section('content')
    <div class="product">
        @if(session('error'))
        <div>
            <p class="email-Resend">
                {{ session('error') }}
            </p>
        </div>
        @endif
        <div class="product-tag">
            <a href="/{{ $searchTerm ? '?query=' . urlencode($searchTerm) : '' }}" class="{{ $mode == 'recommendation' ? 'active' : '' }}"  id="recommendationBtn">
                おすすめ
            </a>
            <a href="/?page=mylist{{ $searchTerm ? '&query=' . urlencode($searchTerm) : '' }}" class="{{ $mode == 'liked' ? 'active' : '' }}" id="myListBtn">
                マイリスト
            </a>
        </div>
        <div class="product-list">
            <!--マイリストで表示するリスト-->
            <div class="product-list__myList" style="{{ $mode == 'liked' ? '' : 'display:none;' }}">
                @foreach ($liked_products as $product)
                    <a class="product-list__myList-card" href="/item/{{ $product->id }}" >
                        <div class="product-list__myList-card--img">
                            <img class="product-list__myList-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                            @if($product->isSoldOut)
                                <span class="product-list__myList-card--img-sold">sold</span>
                            @endif
                        </div>
                        <div class="product-list__myList-card--content">
                            <p class="product-list__myList-card--content-name">
                                {{ $product->product_name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            <!--おすすめで表示するリスト-->
            <div class="product-list__recommendation" style="{{ $mode == 'recommendation' ? '' : 'display:none;' }}">
                @foreach ($products as $product)
                    <a class="product-list__recommendation-card" href="/item/{{ $product->id }}">
                        <div class="product-list__recommendation-card--img">
                            <img class="product-list__recommendation-card--img-item" src="{{ asset( $product->image) }}" alt="{{ $product->product_name }}" />
                            @if($product->isSoldOut)
                                <span class="product-list__recommendation-card--content-sold">sold</span>
                            @endif
                        </div>
                        <div class="product-list__recommendation-card--content">
                            <p class="product-list__recommendation-card--content-name">
                                {{ $product->product_name }}
                            </p>
                        </div>
                    </a>
                @endforeach
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