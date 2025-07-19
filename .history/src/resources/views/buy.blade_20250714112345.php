
@extends('layouts.app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/buy.css">
@endsection


<!--商品購入画面-->


@section('content')
    <form class="buy" action="/create-checkout-session" id="buy-form" method="post">
    @csrf
        <div class="buy-content">
            <div class="buy-content__product">
                <div class="buy-content__product-image">
                    <img class="buy-content__product-image--item" src="{{ asset($detail->image) }}" alt="商品画像">
                </div>
                <div class="buy-content__product-name">
                    <div class="buy-content__product-name--item">
                    {{ $detail->product_name }}
                    </div>
                    <div class="buy-content__product-name--price">
                    ¥{{ number_format($detail->price) }}
                </div>
                </div>
            </div>
            <div class="buy-content__payment">
                <label class="buy-content__payment-label" for="payment-method">
                    支払い方法
                </label>
                <div class="buy-content__payment-select">
                    <select class="buy-content__payment-select--option" name="payment-method" id="payment-method">
                        <option value="" selected hidden>
                            選択してください
                        </option>
                        <option value="コンビニ払い" class="buy-content__payment-select--option-item">
                            コンビニ払い
                        </option>
                        <option value="カード払い" class="buy-content__payment-select--option-item">
                            カード払い
                        </option>
                    </select>
                </div>
                <div class="buy-content__payment-error">
                    @error('payment-method')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <div class="buy-content__delivery">
                <div class="buy-content__delivery-item">
                    <label class="buy-content__delivery-item--label">
                        配送先
                    </label>
                    <a class="buy-content__delivery-item--change" href="{{ url('/purchase/address/' . $detail->id) }}">
                        変更する
                    </a>
                </div>
                <div class="buy-content__delivery-item">
                    〒{{ $post_code }}<br>
                    <input type="hidden" name="post_code" id="post_code" value="{{ $post_code }}">
                    {{ $address }}
                    <input type="hidden" name="shipping_address" id="shipping_address" value="{{$address}}">
                    {{ $building }}
                    <input type="hidden" name="building" id="building" value="{{ $building }}">
                </div>
                <div class="buy-content__delivery-error">
                @error('shipping_address')
                        {{$message}}
                @enderror
                @error('post_code')
                        {{$message}}
                @enderror
                </div>
            </div>
        </div>
        <div class="buy-accounting">
            <table class="buy-accounting__table">
                <tr class="buy-accounting__table-tr">
                    <th>
                        商品代金
                    </th>
                    <td>
                    ¥{{ number_format($detail->price) }}
                    </td>
                </tr>
                <tr class="buy-accounting__table-tr">
                    <th >
                        支払い方法
                    </th>
                    <td id="payment-method-display"></td>
                    <input type="hidden" name="product_id" value="{{ $detail->id }}">
                </tr>
            </table>
            <div class="buy-accounting__button">
                <button class="buy-account__button-item" type="submit" id="purchase-button">
                    購入する
                </button>
            </div>
        </div>
</form>
    @endsection
    @section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
    document.querySelector('#searchForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ
        this.submit(); // 検索を送信
        }
    });

    
</script>
    @endsection
