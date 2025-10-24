<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証のお願い</title>
</head>
<body>
    <p>※このメールは、にご登録いただいたメールアドレス宛に自動的に送信しています。</p>
    <p>{{ $user->name }}様</p>
    <p>この度はご登録いただき、誠にありがとうございます。</p>
    <p>下記リンクをクリックして、メールアドレスの認証を完了してください。</p>

    <p style="text-align: center;">
        <a href="{{ $verificationUrl }}" style="
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        ">メールアドレスを認証する</a>
    </p>

    <p>このメールに心当たりのない場合は、お手数ですが破棄してください。</p>
    <p>よろしくお願いいたします。</p>
</body>
</html>