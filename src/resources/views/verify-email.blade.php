<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証のお願い</title>
</head>
<body>
    <p>※このメールは、CoachFleaMartにご登録いただいたメールアドレス宛に自動的に送信しています。</p>
    <p>{{ $user->name }}様</p>
    <p>この度は、CoachFleaMartの会員登録にお申込みいただきまして誠にありがとうございます。<br>
    現在、仮登録の状態です。</p>
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

    <p>※ご注意</p>
    <p>本メールに身に覚えの無い場合は、本メールを破棄していただきますようお願いいたします。</p>
    <p>＊＊＊お問い合わせ先＊＊＊</p>
    <p>住所：東京都〇〇区〇〇町○ー○ー○</p>
    <p>株式会社 CoachFleaMart サポートセンター</p>
    <p>TEL：0120-000-0000</p>
    <p>*お急ぎの方は上の電話番号に連絡ください。</p>
</body>
</html>