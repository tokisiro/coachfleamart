@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="/css/transaction.css">
@endsection

@section('content')
<div class="transaction">
    <div class="transaction-side">
        <p class="transaction-side__title">
            その他の取引
        </p>
        <div class="transaction-side__list">
            @forelse($otherTransactions as $otherProduct)
                <a href="{{ route('transaction', $otherProduct->id) }}" class="transaction-side__list-link">
                    <p class="transaction-side__list-link--name">{{ $otherProduct->product_name }}</p>
                </a>
            @empty
                <p class="transaction-side__list-empty">その他の取引中の商品はありません。</p>
            @endforelse
        </div>
    </div>
    <div class="transaction-main">
        <div class="transaction-main__title">
            <img class="transaction-main__title-img" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="アイコン">
            <p class="transaction-main__title-name">
                @if ($transactionPartner)
                    「{{ $transactionPartner->name }}」さんとの取引画面
                @else
                    取引相手が不明です
                @endif
            </p>
            <a class="transaction-main__title-button" href="">
                取引を完了する
            </a>
        </div>
        <div class="transaction-main__product">
            <img class="transaction-main__product-img" src="{{ asset($detail->image) }}" alt="商品画像">
            <div class="transaction-main__product-tag">
                <p class="transaction-main__product-tag--name">{{$detail->product_name}}</p>
                <p class="transaction-main__product-tag--price">{{$detail->price}}</p>
            </div>
        </div>
        <form class="transaction-main__message" id="messageForm" action="{{ route('messages', $detail->id) }}" method="POST">
            @csrf
            <div class="transaction-main__message-chat" id="chatMessages">
                @forelse($messages as $message)
                    <div class="transaction-main__message-chat--item @if($message->sender_id === Auth::id()) message-item--right @else message-item--left @endif">
                        <div class="transaction-main__message-chat--item-user">
                            <img class="transaction-main__message-chat--item-user-img" src="{{ $user->icon ? asset('storage/' . $user->icon) : asset('storage/default.png') }}" alt="">
                            <p class="transaction-main__message-chat--item-user-name">
                                {{ $message->sender->name }}
                            </p>
                        </div>
                        <p class="transaction-main__message-chat--item-content">
                            {{ $message->message }}
                        </p>
                    </div>
                @empty
                    <p class="transaction-main__message-chat--empty">まだメッセージはありません。</p>
                @endforelse
            </div>
            <input class="transaction-main__message_item" name="message" type="text" id="messageInput" placeholder="メッセージを入力">
            <button class="transaction-main__message_img" type="button">
                画像を追加
            </button>
            <button class="transaction-main__message-button" type="submit">
                <img class="transaction-main__message-button--item" src="{{ asset('storage/paperairplane.png') }}" alt="紙飛行機">
            </button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');

    // チャットエリアを一番下までスクロールする関数
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // 初期ロード時にスクロール
    scrollToBottom();

    messageForm.addEventListener('submit', function(event) {
        event.preventDefault(); // フォームのデフォルト送信をキャンセル

        const messageContent = messageInput.value.trim();
        if (messageContent === '') {
            return; // メッセージが空の場合は何もしない
        }

        const productId = {{ $detail->id }}; // Bladeから商品IDを取得
        const url = `/messages/${productId}`; // メッセージ送信先のURL

        // Ajaxリクエストの準備
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRFトークン
            },
            body: JSON.stringify({ message: messageContent })
        })
        .then(response => {
            if (!response.ok) {
                // HTTPエラーの場合
                return response.json().then(err => { throw new Error(err.error || 'Server error'); });
            }
            return response.json();
        })
        .then(data => {
            // サーバーから返されたメッセージデータを使って新しいメッセージ要素を作成
            const newMessageElement = document.createElement('div');
            newMessageElement.classList.add('transaction-main__message-chat--item');
            // 自分のメッセージは右寄せ
            newMessageElement.classList.add('message-item--right');

            newMessageElement.innerHTML = `
                <div class="transaction-main__message-chat--item-user">
                    <img class="transaction-main__message-chat--item-user-img" src="${data.sender_icon}" alt="${data.sender_name}のアイコン">
                    <p class="transaction-main__message-chat--item-user-name">
                        ${data.sender_name}
                    </p>
                </div>
                <p class="transaction-main__message-chat--item-content">
                    ${data.message.message}
                </p>
                <span class="transaction-main__message-chat--item-time">
                    ${data.created_at_formatted}
                </span>
            `;

            // チャットエリアに新しいメッセージを追加
            chatMessages.appendChild(newMessageElement);

            // メッセージ入力フィールドをクリア
            messageInput.value = '';

            // チャットエリアを一番下までスクロール
            scrollToBottom();

            // 「まだメッセージはありません」の表示を削除（もし存在すれば）
            const emptyMessage = chatMessages.querySelector('.transaction-main__message-chat--empty');
            if (emptyMessage) {
                emptyMessage.remove();
            }

        })
        .catch(error => {
            console.error('メッセージ送信エラー:', error);
            alert('メッセージの送信に失敗しました。');
        });
    });
});
</script>
@endsection