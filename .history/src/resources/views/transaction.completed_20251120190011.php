@component('mail::message')
# 取引完了のお知らせ

{{ $product->user->name }}様

いつも{{ config('app.name') }}をご利用いただきありがとうございます。

出品中の商品 **「{{ $product->name }}」** の取引が、購入者 **{{ $buyer->name }}** 様によって完了されました。

## 次のステップ：相手の評価をお願いします！

取引完了後、相手の評価を行うことができます。
評価は、より良い取引環境のために重要な要素となります。

[商品の詳細ページへ移動する]({{url('/item/'.$product->id.'/transaction') }})

引き続き、{{ config('app.name') }}をよろしくお願いいたします。

@endcomponent