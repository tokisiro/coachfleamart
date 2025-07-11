
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection

<!--商品一覧画面（トップ）-->


@section('content')
    <div class="product">
        <div class="product-tag">
            <a href="/" class="product-tag__recommendation {{ $currentTab !== 'mylist' ? 'active' : '' }}">
                おすすめ
            </a>
            <a href="/?tab=mylist" class="product-tag__myList {{ $currentTab === 'mylist' ? 'active' : '' }}">
                マイリスト
            </a>
        </div>
        <div class="product-list">
            
            <!--マイリストで表示するリスト-->
            @if($currentTab === 'mylist')
            <div class="product-list__myList" >
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
            @endif
            
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