<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<p># 取引完了のお知らせ</p>

<p>{{ $seller->name }}様</p>

<p>いつも{{ config('app.name') }}をご利用いただきありがとうございます。</p>

<p>出品中の商品 **「{{ $product->product_name }}」** の取引が、購入者 **{{ $buyer->name }}** 様によって完了されました。</p>

<p>## 次のステップ：相手の評価をお願いします！</p>

<p>取引完了後、相手の評価を行うことができます。</p>
<p>評価は、より良い取引環境のために重要な要素となります。</p>

<p>[商品の詳細ページへ移動する]({{url('/item/'.$product->id.'/transaction') }})</p>

<p>引き続き、{{ config('app.name') }}をよろしくお願いいたします。</p>


</body>
</html>
