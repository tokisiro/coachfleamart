
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/buy.css">
@endsection


<!--商品購入画面-->


@section('content')
    <form class="buy" action="{{ route('product.purchase', ['product' => $detail->id]) }}" id="buy-form" method="post">
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
                        <option value="選択してください" selected hidden>
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
                @error('shipping_address','post_code')
                        {{$message}}
                @enderror
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
                </tr>
            </table>
            <div class="buy-accounting__button">
                <button class="buy-account__button-item" type="submit">
                    購入する
                </button>
            </div>
        </div>
</form>
    @endsection
    @section('script')
    <script>
    document.querySelector('#searchForm').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ
        this.submit(); // 検索を送信
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
    // フォームの送信前に住所情報を取得して設定
    const form = document.getElementById('buy-form');
    form.addEventListener('submit', () => {
        const addressDiv = document.querySelector('.buy-content__delivery > div:nth-of-type(2)');

      const addressText = addressDiv.innerText.replace(/\n/g, ' ').trim(); // 改行を除去して1行に
        document.getElementById('shipping_address').value = addressText;

      // 住所の郵便番号や建物名が必要なら、同様に設定
        document.getElementById('post_code').value = '{{ $post_code }}';
        document.getElementById('building').value = '{{ $building }}';

    });

    const selectElement = document.getElementById('payment-method');
    const displayTd = document.getElementById('payment-method-display');

    if (selectElement && displayTd) {
    selectElement.addEventListener('change', () => {
    const selectedValue = selectElement.value;
    // 選択された値を td に表示
    displayTd.textContent = selectedValue;
    });
    }
});
</script>
    @endsection
