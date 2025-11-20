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

<p>つきましては、お手数をおかけしますが、{{ $buyer->name }}様への評価をお願いいたします。
評価が完了次第、取引は完全に終了し、売上金に反映されます。

今後ともCoachFleaMartをよろしくお願いいたします。

<p>※ご注意</p>
<p>本メールに身に覚えの無い場合は、本メールを破棄していただきますようお願いいたします。</p>
<p>＊＊＊お問い合わせ先＊＊＊</p>
<p>住所：東京都〇〇区〇〇町○ー○ー○</p>
<p>株式会社 CoachFleaMart サポートセンター</p>
<p>TEL：0120-000-0000</p>
<p>*お急ぎの方は上の電話番号に連絡ください。</p>

</body>
</html>
