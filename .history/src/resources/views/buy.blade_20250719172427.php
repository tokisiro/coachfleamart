
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
                    <input type="hidden" name="address" id="address" value="{{$address}}">
                    {{ $building }}
                    <input type="hidden" name="building" id="building" value="{{ $building }}">
                </div>
                <div class="buy-content__delivery-error">
                @error('address')
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
                    <td id="payment-method__display"></td>
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

    document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('buy-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // まずフォームのデフォルト送信を止める

        // 住所情報のセット
        const addressDiv = document.querySelector('.buy-content__delivery > div:nth-of-type(2)');
        const addressText = addressDiv.innerText.replace(/\n/g, ' ').trim();
        document.getElementById('address').value = addressText;
        document.getElementById('post_code').value = '{{ $post_code }}';
        document.getElementById('building').value = '{{ $building }}';

        // 支払い方法の取得
        const paymentSelect = document.getElementById('payment-method');
        const paymentMethod = paymentSelect.value;

        if (!paymentMethod) {
            alert('支払い方法を選択してください');
            return;
        }

        // 例外処理：支払い方法に応じて処理
        try {
            const checkoutUrl = await createStripeCheckoutSession(paymentMethod);
            window.location.href = checkoutUrl;
            } catch (error) {
            alert('Stripeの決済ページ作成に失敗しました');
            console.error(error);
            }
        });
    });

    // Stripeの決済ページのURLを取得
    async function createStripeCheckoutSession(paymentMethod) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch('/create-checkout-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: '{{ $detail->id }}',
            payment_method: paymentMethod,
            shipping_address: document.getElementById('address').value,
            post_code: document.getElementById('post_code').value,
            building: document.getElementById('building').value
        })
        });
        const data = await response.json();
        console.log('APIレスポンス:', data);
            if (response.ok && data.checkoutUrl) {
                return data.checkoutUrl;
            } else {
        console.error('エラー:', data);
            throw new Error(data.error || 'Checkout URLが取得できませんでした');
        }
    }


    // 支払い方法選択時に表示も更新
    const selectElement = document.getElementById('payment-method');
const displayTd = document.getElementById('payment-method__display');

if (selectElement && displayTd) {
    selectElement.addEventListener('change', () => {
        displayTd.textContent = selectElement.value;
    });
    }


console.log(@json($post_code));
console.log(@json($building));
console.log(@json($address));
</script>
    @endsection
