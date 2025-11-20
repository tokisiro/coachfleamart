<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>取引完了のお知らせ</title>
</head>
<body>

<p>{{ $seller->name }}様</p>

<p>いつもCoachFleaMartをご利用いただき、誠にありがとうございます。</p>

<p>ご連絡が遅くなり恐縮ですが、この度、{{ $seller->name }}様が出品された商品「{{ $product->product_name }}」の取引が無事に完了いたしました。</p>
<p>おめでとうございます！</p>

<p>ご購入いただいた{{ $buyer->name }}様より、取引完了のご連絡をいただきました。</p>

つきましては、お手数をおかけしますが、{{ $buyer->name }}様への評価をお願いいたします。
評価が完了次第、取引は完全に終了し、売上金に反映されます。

▼商品の詳細

商品名: {{ $product->product_name }}
価格: [販売価格]円
取引ID: [取引ID]
商品ページ: [商品ページへのURL]
▼購入者様への評価はこちらから
[評価ページへのURL]

今後とも[アプリ名]をよろしくお願いいたします。

[アプリ名]運営事務局
[お問い合わせURL]
[アプリの公式サイトURL]



</body>
</html>
