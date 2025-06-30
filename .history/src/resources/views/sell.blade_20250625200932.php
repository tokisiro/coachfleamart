@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/sell.css">
@endsection

<!--商品出品画面-->

@section('content')
    <form class="sell">
        <div class="sell-title">
            <h2 class="sell-title__item">
                商品の出品
            </h2>
        </div>
        <div class="sell-img">
            <label class="sell-img__label">
                商品画像
            </label>
            <div class="sell-img__icon">
                <img class="sell-img__icon-item" src="" alt="">
                <input class="sell-img__icon-input" type="file" name="image" style="display: none;">
                <!-- カスタムボタン -->
                <button type="button" class="sell-img__icon-button">画像を選択する</button>
            </div>
        </div>
        <div class="sell-index">
            <h3 class="sell-index__item">
                商品の詳細
            </h3>
        </div>
        <div class="sell-category">
            <div class="sell-category__label">
                <label class="sell-category__label-item">
                    カテゴリー
                </label>
            </div>
            <div class="sell-category__checkbox">
                <input class="sell-category__checkbox-input" type="checkbox" id="category-fashion" name="category" value="fashion">
                <label class="sell-category__checkbox-label" for="category-fashion">
                    ファッション
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-appliances" name="category" value="appliances">
                <label class="sell-category__checkbox-label" for="category-appliances">
                    家電
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-interior" name="category" value="interior">
                <label class="sell-category__checkbox-label" for="category-interior">
                    インテリア
                </label>
                <input class="sell-category__checkbox-input" type="checkbox"
                for="category-ladies" name="category" value="ladies">
                <label class="sell-category__checkbox-label" for="category-ladies">
                    レディース
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-mens" name="category" value="mens">
                <label class="sell-category__checkbox-label" for="category-mens">
                    メンズ
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-cosmetics" name="category" value="cosmetics">
                <label class="sell-category__checkbox-label" for="category-cosmetics">
                    コスメ
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-book" name="category" value="book">
                <label class="sell-category__checkbox-label" for="category-book">
                    本
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-game" name="category" value="game">
                <label class="sell-category__checkbox-label" for="category-game">
                    ゲーム
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-sports" name="category" value="sports">
                <label class="sell-category__checkbox-label" for="category-sports">
                    スポーツ
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-kitchen" name="category" value="kitchen">
                <label class="sell-category__checkbox-label" for="category-kitchen">
                    キッチン
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-handmade" name="category" value="handmade">
                <label class="sell-category__checkbox-label" for="category-handmade">
                    ハンドメイド
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-accessories" name="category" value="accessories">
                <label class="sell-category__checkbox-label" for="category-accessories">
                    アクセサリー
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-toy" name="category" value="toy">
                <label class="sell-category__checkbox-label" for="category-toy">
                    おもちゃ
                </label>
                <input class="sell-category__checkbox-input" type="checkbox" id="category-child" name="category" value="child">
                <label class="sell-category__checkbox-label" for="category-child">
                    ベビー・キッズ
                </label>
            </div>
        </div>
        <div class="sell-status">
                <label class="sell-status__label">
                    商品の状態
                </label>
                <select class="sell-status__select" name="situation" id="situation">
                    <option value=""></option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
        </div>
        <div class="sell-index">
            <h3 class="sell-index__item">
                商品名と説明
            </h3>
        </div>
        <div class="sell-name">
            <label class="sell-name__label">
                商品名
            </label>
            <input class="sell-name__input" type="text" name="product_name" id="product_name">
            </label>
        </div>
        <div class="sell-brand">
            <label class="sell-brand__label">
                ブランド名
                </label>
                <input class="sell-brand__input" type="text" name="brand_name" id="brand_name">
        </div>
        <div class="sell-explanation">
            <label class="sell-explanation__label">
                商品の説明
                </label>
                <input class="sell-explanation__input" type="textarea" name="explanation" id="explanation">
        </div>
        <div class="sell-price">
            <label class="sell-price__label">
                販売価格
                </label>
                <input class="sell-price__input" type="text" placeholder="¥" name="price" id="price">
        </div>
        <div class="sell-button">
            <button class="sell-button__item">
                出品する
            </button>
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

    // 画像選択とプレビュー表示のためのイベントリスナーを追加
document.querySelector('.sell-img__icon-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        // ファイルの種類が画像かどうか確認（任意）
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // 画像のsrcに読み込んだデータURLを設定
                document.querySelector('.sell-img__icon-item').src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            alert('画像ファイルを選択してください');
        }
    }
});
</script>
@endsection

