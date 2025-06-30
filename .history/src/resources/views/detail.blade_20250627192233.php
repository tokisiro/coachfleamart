
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/detail.css">
@endsection



<!--商品詳細画面（ログイン後）-->

@section('content')
    <div class="detail">
        <div class="detail-img">
            <img class="detail-img__item" alt="商品画像" src="{{ asset($detail->image) }}">
        </div>
        <div class="detail-content">
            <form class="detail-content__product" method="post" action="{{ route('product.toggleNice', ['product' => $detail->id]) }}">
            @csrf
                <div class="detail-content__product-name">
                    <h3 class="detail-content__product-name--title">
                    {{$detail->product_name}}
                    </h3>
                    <p class="detail-content__product-name--brand">
                    {{$detail->brand_name}}
                    </p>
                </div>
                <div class="detail-content__product-price">
                    ¥
                    <span class="detail-content__product-price--item">
                        {{number_format($detail->price)}}
                    </span>
                    (税込)
                </div>
                <div class="detail-content__product-evaluation">
                    <div class="detail-content__product-evaluation--nice"  >
                        @if($hasNice)
                            <button type="submit" class="detail-content__product-evaluation--nice-img">
                                <img class="detail-content__product-evaluation--nice-img-item" src="/storage/star_filled.png" alt="いいね済み" />
                            </button>
                        @else
                            <button type="submit" class="detail-content__product-evaluation--nice-img">
                                <img class="detail-content__product-evaluation--nice-img-item" src="/storage/star.png" alt="星">
                            </button>
                        @endif
                        <div class="detail-content__product-evaluation--nice-count">
                            {{ $niceCount }}
                        </div>
                    </div>
                    <div class="detail-content__product-evaluation--comment">
                        <div class="detail-content__product-evaluation--comment-button">
                            <img class="detail-content__product-evaluation--comment-button-img" src="/storage/comment.png" alt="吹き出し">
                        </div>
                        <div class="detail-content__product-evaluation--comment-count">
                            {{$commentsCount}}
                        </div>
                    </div>
                </div>
            </form>
            <form class="detail-content__information" action="{{ url('/purchase/' . $detail->id) }}" method="get">
                <div class="detail-content__information-button">
                    <button class="detail-content__information-button--item" type="submit">
                        購入手続きへ
                    </button>
                </div>
                <div class="detail-content__information-index">
                    <h3 class="detail-content__information-index--item">
                        商品説明
                    </h3>
                </div>
                <div class="detail-content__information-explanation">
                    <div class="detail-content__information-explanation--item">
                    {{$detail->explanation}}
                    </div>
                </div>
                <div class="detail-content__information-index">
                    <h3 class="detail-content__information-index--item">
                        商品の情報
                    </h3>
                </div>
                <div class="detail-content__information-category">
                    <label class="detail-content__information-category--label">
                        カテゴリー
                    </label>
                    <div class="detail-content__information-category--item">
                    @foreach($categoriesArray as $category)
                        <span class="detail-content__information-category--item-parts">
                            {{$category}}
                        </span>
                    @endforeach
                    </div>
                </div>
                <div class="detail-content__information-status">
                    <label class="detail-content__information-status--label">
                        商品の状態
                    </label>
                    <div class="detail-content__information-status--item">
                        {{$situation}}
                    </div>
                </div>
            </form>
            <form class="detail-content__comment" action="/comment" method="post">
                @csrf
                <div class="detail-content__comment-index">
                    <h3 class="detail-content__comment-index--item">
                        コメント({{$commentsCount}})
                    </h3>
                </div>
                <div class="detail-content__comment-existing">
                @foreach ($comments as $comment)
                    <div class="detail-content__comment-existing--icon">
                        <img class="detail-content__comment-existing--icon-img" src="{{$comment->user->icon}}" alt="アイコン">
                        <label>{{$comment->user->name}}</label>
                    </div>
                    <div class="detail-content__comment-existing--message">
                    {{$comment->content}}
                    </div>
                    @endforeach
                </div>
                <div class="detail-comment__new">
                    <label class="detail-content__comment-new--label">
                        商品へのコメント
                    </label>
                    <textarea class="detail-content__comment-new--input" name="content"></textarea>
                    <input type="hidden" name="product_id" value="{{ $detail->id }}">
                    
                    <div class="detail-content__comment-new--error">
                @error('price')
                    {{$message}}
                @enderror
            </div>
                </div>
                <div class="detail-content__comment-button">
                    <button class="detail-content__comment-button--item" type="submit">
                        コメントを送信する
                    </button>
                </div>
            </form>
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
