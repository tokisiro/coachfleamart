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
        <form class="transaction-main__message" id="messageForm" action="{{ route('messages', $detail->id) }}" method="POST" >
            @csrf
            <div class="transaction-main__message-chat" id="chatMessages">
                @forelse($messages as $message)
                    @php
                        $sender = $message->sender;
                        $senderIcon = $sender->icon ? asset('storage/' . $sender->icon) : asset('storage/default.png');
                        $isMyMessage = ($message->sender_id === Auth::id());
                    @endphp
                    <div class="transaction-main__message-chat--item @if($message->sender_id === Auth::id()) message-item--right @else message-item--left @endif" data-message-id="{{ $message->id }}">
                        <div class="transaction-main__message-chat--item-user">
                            <img class="transaction-main__message-chat--item-user-img" src="{{ $senderIcon }}" alt="{{ $sender->name }}のアイコン">
                            <p class="transaction-main__message-chat--item-user-name">
                                {{ $sender->name }}
                            </p>
                        </div>
                        @if ($message->message)
                            <p class="transaction-main__message-chat--item-content">
                                {{ $message->message }}
                            </p>
                            @endif
                            @if ($message->image)
                            <img src="{{ asset($message->image) }}" alt="送信画像" class="transaction-main__message-chat--item-image">
                            @endif
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
            <div class="transaction-main__message-input">
                <input class="transaction-main__message-input--text" name="message" type="text" id="messageInput" placeholder="取引メッセージを入力してください" value="{{ old('message') }}">
                <input type="file" id="imageInput" accept="image/*" style="display: none;" >
                <button class="transaction-main__message-input--img" type="button" id="selectImageButton">
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
    const imageInput = document.getElementById('imageInput');
    const selectImageButton = document.getElementById('selectImageButton');
    let selectedImageFile = null;

    // ページロード時に LocalStorage からメッセージを読み込む
    const savedMessage = localStorage.getItem('chatMessageInput_' + {{ $detail->id }});
    if (savedMessage) {
        messageInput.value = savedMessage;
    }

    // 2. 入力欄の値が変更されるたびに LocalStorage に保存
    messageInput.addEventListener('input', function() {
        localStorage.setItem('chatMessageInput_' + {{ $detail->id }}, messageInput.value); // ★商品IDごとに保存★
    });

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
        if (messageContent === '' && !selectedImageFile) {
            return;
        }

        // Bladeファイルから商品IDを取得
        const productId = {{ $detail->id }};

        // メッセージを送信するためのURLを組み立てる
        const url = `/messages/${productId}`;

        const formData = new FormData();
        formData.append('message', messageContent);
        formData.append('product_id', productId);
        // 画像ファイルが選択されていればFormDataに追加
        if (selectedImageFile) {
            formData.append('image', selectedImageFile);
        }

        // サーバーへメッセージを送信するための準備（Ajaxリクエスト）
        //指定したURLへデータを送る
        fetch(url, {
            // HTTPメソッドをPOSTにする
            method: 'POST',

            // サーバーに送る情報（ヘッダー）を設定
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

            },
            body: formData
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

            newMessageElement.setAttribute('data-message-id', data.message.id);

            // メッセージ内容と画像の両方を表示できるようにHTMLを調整
            let messageHtml = '';
            if (data.message.message) {
                messageHtml += `<p class="transaction-main__message-chat--item-content">${data.message.message}</p>`;
            }
            // 画像がある場合、<img>タグを追加
            // data.message.image には保存された画像のURLが返されることを想定
            if (data.message.image) {
                messageHtml += `
                <div class="transaction-main__message-chat--item-image">
                    <img src="${data.message.image}" alt="送信画像">
                </div>`;
            }

            //作ったHTML要素の中に、サーバーから受け取ったメッセージ情報（アイコン、名前、内容、時刻）を埋め込む
            newMessageElement.innerHTML = `
                <div class="transaction-main__message-chat--item-user">
                    <img class="transaction-main__message-chat--item-user-img" src="${data.sender_icon}" alt="${data.sender_name}のアイコン">
                    <p class="transaction-main__message-chat--item-user-name">
                        ${data.sender_name}
                    </p>
                </div>
                <div>
                    <p class="transaction-main__message-chat--item-content">
                        ${data.message.message}
                    </p>
                    <div class="transaction-main__message-chat--item-action">
                        <button type="button" class="transaction-main__message-chat--item-action-edit" data-message-id="${data.message.id}">編集</button>
                        <button type="button" class="transaction-main__message-chat--item-action-delete" data-message-id="${data.message.id}">削除</button>
                    </div>
                </div>
            `;

            // チャットエリアに新しいメッセージを追加
            chatMessages.appendChild(newMessageElement);

            // メッセージ入力フィールドをクリア
            messageInput.value = '';
            imageInput.value = ''; // 選択されたファイルをクリア
            selectedImageFile = null;

            // チャットエリアを一番下までスクロール
            scrollToBottom();

            // 「まだメッセージはありません」の表示を削除（もし存在すれば）
            const emptyMessage = chatMessages.querySelector('.transaction-main__message-chat--empty');
            if (emptyMessage) {
                emptyMessage.remove();
            }

             // chatMessages 全体ではなく、新しく追加した要素のみに登録
            addMessageActionListeners(newMessageElement);
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
        const editButtons = container.querySelectorAll('.transaction-main__message-chat--item-action-edit');
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

        console.log('クリックされたメッセージID:', messageId); // 追加

        const messageItem = chatMessages.querySelector(`[data-message-id="${messageId}"]`); // メッセージ全体を取得

        // メッセージのテキスト部分を探す
        const messageContentElement = messageItem.querySelector('.transaction-main__message-chat--item-content');

        // 画像部分を探す (編集不可なので、存在チェックのみ)
        const messageImageElement = messageItem.querySelector('.transaction-main__message-chat--item-image');

        // テキストコンテンツがない（画像のみのメッセージ）場合は編集不可
        if (!messageContentElement) {
            alert('このメッセージには編集可能なテキストがありません。');
            return; // 処理を中断
        }

        // そのメッセージの現在の内容（テキスト）を取得する
        const currentMessage = messageContentElement.innerText;

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
                // 成功した場合は、サーバーからの応答をJSON形式に変換して次の処理に渡す
                return response.json();
            })

            // サーバーからのJSONデータ（更新されたメッセージ情報など）を受け取った後の処理
            .then(data => {
                // 画面上のメッセージ本文を、サーバーから返ってきた新しいメッセージ内容で更新する
                messageContentElement.innerText = data.message.message;
            })
            .catch(error => {
                console.error('メッセージ編集エラー:', error);
            });
        }
    }

    // 削除ボタンがクリックされた時の処理
    function handleDeleteClick(event) {
        //`data-message-id` 属性から、そのメッセージのIDを取得する
        const messageId = event.target.dataset.messageId;

        //本当に削除するかどうかユーザーに確認するダイアログを表示する
        if (confirm('このメッセージを削除してもよろしいですか？')) {
            // サーバーに削除を送信
            fetch(`/messages/${messageId}`, {
                method: 'DELETE',
                headers: {
                    // セキュリティのためのトークン
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            // サーバーからの応答を受け取った後の処理
            .then(response => {
                //サーバーからのresponseが成功（OK）ではない場合
                if (!response.ok) {
                    // エラーメッセージをJSON形式で受け取り、エラーとして処理を中断する
                    return response.json().then(err => { throw new Error(err.error || 'Server error'); });
                }
                // 成功時はJSONデータはないので空のオブジェクトを返す
                return response.status === 204 ? {} : response.json();
            })

            // サーバーからのresponse（削除成功の確認など）を受け取った後の処理
            .then(() => {
                // 該当するメッセージの要素全体を探す
                const messageItem = event.target.closest('.transaction-main__message-chat--item');
                if (messageItem) {
                    messageItem.remove();
                }

                if (chatMessages.children.length === 0) {
                    const emptyMessageElement = document.createElement('p');
                    emptyMessageElement.classList.add('transaction-main__message-chat--empty');
                    chatMessages.appendChild(emptyMessageElement);
                }
            })
            // 途中でエラーが発生した場合の処理
            .catch(error => {
                console.error('メッセージ削除エラー:', error);
                alert('メッセージの削除に失敗しました。');
            });
        }
    }
    // 隠れているファイル選択inputをクリック
    selectImageButton.addEventListener('click', function() {
    imageInput.click();
    });

    imageInput.addEventListener('change', function(event) {
    // ファイルが選択されたら
    if (event.target.files.length > 0) {
        selectedImageFile = event.target.files[0];
        // ユーザーに選択されたことを視覚的にフィードバック
        alert(`画像が選択されました: ${selectedImageFile.name}`);
    } else {
        selectedImageFile = null;
    }
});
});
</script>
@endsection