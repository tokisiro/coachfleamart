@extends('layouts.common')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
                    @php
                        $sender = $message->sender;
                        $senderIcon = $sender->icon ? asset('storage/' . $sender->icon) : asset('storage/default.png');
                        $isMyMessage = ($message->sender_id === Auth::id());
                    @endphp
                    <div class="transaction-main__message-chat--item @if($message->sender_id === Auth::id()) message-item--right @else message-item--left @endif">
                        <div class="transaction-main__message-chat--item-user">
                            <img class="transaction-main__message-chat--item-user-img" src="{{ $senderIcon }}" alt="{{ $sender->name }}のアイコン">
                            <p class="transaction-main__message-chat--item-user-name">
                                {{ $sender->name }}
                            </p>
                        </div>
                        <p class="transaction-main__message-chat--item-content">
                            {{ $message->message }}
                        </p>
                        @if($isMyMessage)
                        <div class="transaction-main__message-chat--item-action">
                            <button type="button" class="transaction-main__message-chat--item-action-edit" data-message-id="{{ $message->id }}">編集</button>
                            <button type="button" class="transaction-main__message-chat--item-action-delete" data-message-id="{{ $message->id }}">削除</button>
                        </div>
                        @endif
                    </div>
                @empty
                    <p class="transaction-main__message-chat--empty">まだメッセージはありません。</p>
                @endforelse
            </div>
            <input class="transaction-main__message_item" name="message" type="text" id="messageInput" placeholder="メッセージを入力">
            <button class="transaction-main__message_img">
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

//新規チャット送信・表示機能
document.addEventListener('DOMContentLoaded', function() {
    //必要な要素をHTMLから取得する
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');

    // チャットエリアを一番下までスクロールする関数
    function scrollToBottom() {
        //チャット全体のスクロール位置を一番下に設定して、自動で一番下までスクロールするようにする
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // 初期ロード時にスクロール
    scrollToBottom();

    //メッセージ送信された時
    messageForm.addEventListener('submit', function(event) {
        //通常の送信動作を止める
        event.preventDefault();

        //メッセージ内容を取得し、前後の空白を取り除く
        const messageContent = messageInput.value.trim();

        // メッセージが空の場合は何もしない
        if (messageContent === '') {
            return;
        }

        // Bladeファイルから商品IDを取得
        const productId = {{ $detail->id }};

        // メッセージを送信するためのURLを組み立てる
        const url = `/messages/${productId}`;

        // サーバーへメッセージを送信するための準備（Ajaxリクエスト）
        //指定したURLへデータを送る
        fetch(url, {
            // HTTPメソッドをPOSTにする
            method: 'POST',

            // サーバーに送る情報（ヘッダー）を設定
            headers: {
                // 送信するデータの形式がJSONであると伝える
                'Content-Type': 'application/json',

                // セキュリティのためのおまじない（Laravelが自動で設定してくれるトークン）
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRFトークン
            },

            // 送信するメッセージの内容をJSON形式に変換してbodyに含める
            body: JSON.stringify({ message: messageContent })
        })

        //サーバーからの応答（レスポンス）を受け取った後の処理
        .then(response => {

            // もしサーバーからの応答がエラー
            if (!response.ok) {

                // エラーメッセージを取得して、次の処理にエラーを渡す
                return response.json().then(err => { throw new Error(err.error || 'Server error'); });
            }

            //サーバーからの応答をJSON形式に変換して、次の処理に渡す
            return response.json();
        })

        //成功の応答（JSONデータ）を受け取った後の処理
        .then(data => {
            // 新しいメッセージを表示するためのHTML要素をJavaScriptで作る
            const newMessageElement = document.createElement('div');

            //作ったHTML要素にCSSのクラスを追加する（見た目を整えるため）
            newMessageElement.classList.add('transaction-main__message-chat--item');
            // 自分のメッセージは右寄せ
            newMessageElement.classList.add('message-item--right');

            //作ったHTML要素の中に、サーバーから受け取ったメッセージ情報（アイコン、名前、内容、時刻）を埋め込む
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
        //もしメッセージ送信中に何かエラーが起きたら
        .catch(error => {
            console.error('メッセージ送信エラー:', error);
            alert('メッセージの送信に失敗しました。');
        });
    });





    // 編集・削除ボタンにイベントリスナー(処理機能)を付与する
    function addMessageActionListeners(container) {
        // container の中から、全ての「編集」ボタンを探す
        const editButtons = container.querySelectorAll('transaction-main__message-chat--item-action-edit');
        //編集ボタンに付与する動作
        editButtons.forEach(button => {

            //もし既にイベントが登録されていたら、一度削除して、重複して動かないようにする
            button.removeEventListener('click', handleEditClick);
            //`handleEditClick` という関数を動かすように設定する
            button.addEventListener('click', handleEditClick);
        });

        // container の中から、全ての「削除」ボタンを探す
        const deleteButtons = container.querySelectorAll('.transaction-main__message-chat--item-action-delete');
        //削除ボタンに付与する動作
        deleteButtons.forEach(button => {
            button.removeEventListener('click', handleDeleteClick);
            button.addEventListener('click', handleDeleteClick);
        });
    }

    // 初期ロード時、既存のすべてのメッセージに動作を付与
    addMessageActionListeners(chatMessages);


    // 編集ボタンがクリックされた時の処理
    function handleEditClick(event) {
        //`data-message-id` 属性から、そのメッセージのIDを取得する
        const messageId = event.target.dataset.messageId;
        // メッセージIDを使って、該当するメッセージの「本文」部分を探す
        const messageElement = chatMessages.querySelector(`[data-message-id="${messageId}"] .transaction-main__message-chat--item-content`);
        //// そのメッセージの現在の内容（テキスト）を取得する
        const currentMessage = messageElement.innerText;

        //  prompt を使ってユーザーに新しいメッセージの入力を求めるダイアログを表示する
        const newMessage = prompt('メッセージを編集してください:', currentMessage);

        //・キャンセルしない・新しいメッセが空要素ではない・前のメッセージと値が違う
        //全ての条件を満たした場合の動作
        if (newMessage !== null && newMessage.trim() !== '' && newMessage.trim() !== currentMessage) {
            // サーバーに編集リクエストを送信
            fetch(`/messages/${messageId}`, {
                method: 'PUT',
                headers: {
                    // 送るデータはJSON形式であると伝える
                    'Content-Type': 'application/json',
                    // セキュリティのためのトークン
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                // JSON形式で「message」という名前で新しいメッセージ内容を送る
                body: JSON.stringify({ message: newMessage.trim() })
            })

            // サーバーからのresponseを受け取った後の処理
            .then(response => {
                //サーバーからの応答が成功（OK）ではない場合
                if (!response.ok) {
                    // エラーメッセージをJSON形式で受け取り、エラーとして処理を中断する
                    return response.json().then(err => { throw new Error(err.error || 'Server error'); });
                }
                return response.json();
            })
            .then(data => {
                messageElement.innerText = data.message.message; // サーバーからの更新されたメッセージを反映
                alert('メッセージを編集しました。');
            })
            .catch(error => {
                console.error('メッセージ編集エラー:', error);
                alert('メッセージの編集に失敗しました。');
            });
        }
    }

    // 削除ボタンがクリックされた時の処理
    function handleDeleteClick(event) {
        const messageId = event.target.dataset.messageId;

        if (confirm('このメッセージを削除してもよろしいですか？')) {
            // サーバーに削除を送信
            fetch(`/messages/${messageId}`, { // サーバー側のエンドポイントに合わせて変更
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Server error'); });
                }
                // 成功時は204 No Contentなど、レスポンスボディがない場合もある
                return response.status === 204 ? {} : response.json();
            })
            .then(() => {
                // フロントエンドからメッセージ要素を削除
                const messageItem = chatMessages.querySelector(`[data-message-id="${messageId}"]`);
                if (messageItem) {
                    messageItem.remove();
                    alert('メッセージを削除しました。');
                }
            })
            .catch(error => {
                console.error('メッセージ削除エラー:', error);
                alert('メッセージの削除に失敗しました。');
            });
        }
    }
});
</script>
@endsection