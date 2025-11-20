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
            <button class="transaction-main__title-button" id="completeTransactionButton">
                取引を完了する
            </button>
        </div>
        {{-- 評価モーダル --}}
        <div id="ratingModal" class="transaction-main__modal" style="display: none;">
            <div class="transaction-main__modal-content">
                <div class="transaction-main__modal-content--title">
                    <h3>取引が完了しました。</h3>
                </div>
                <p class="transaction-main__modal-content--message">今回の取引相手はどうでしたか？</p>
                <form id="ratingForm" class="transaction-main__modal-content--form">
                @csrf
                {{-- hiddenで評価対象のユーザーIDと役割を送信 --}}
                    <input type="hidden" name="product_id" value="{{ $detail->id }}">
                    <input type="hidden" name="reviewer_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="reviewed_user_id" id="reviewedUserId" value="{{ $reviewedUserIdForModal }}">
                    <input type="hidden" name="role_as_reviewed" id="roleAsReviewed" value="{{ $roleAsReviewedForModal }}">
                    <div class="transaction-main__modal-content--form-select">
                        <div class="star-rating" id="starRating">
                            <span class="star" data-value="1"></span>
                            <span class="star" data-value="2"></span>
                            <span class="star" data-value="3"></span>
                            <span class="star" data-value="4"></span>
                            <span class="star" data-value="5"></span>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="0">
                    </div>
                    <div class="transaction-main__modal-content--form-button">
                        <button type="submit" class="transaction-main__modal-content--form-button-item">送信する</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="transaction-main__product">
            <img class="transaction-main__product-img" src="{{ asset($detail->image) }}" alt="商品画像">
            <div class="transaction-main__product-tag">
                <p class="transaction-main__product-tag--name">{{$detail->product_name}}</p>
                <p class="transaction-main__product-tag--price">{{$detail->price}}</p>
            </div>
        </div>
        <form class="transaction-main__message" id="messageForm" action="{{ route('messages', $detail->id) }}" method="POST" enctype="multipart/form-data">
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
            <span id="messageError" class="transaction-main__message-input--error"></span>
                    <span id="imageError" class="transaction-main__message-input--error"></span>
            <div class="transaction-main__message-input">
                <div class="transaction-main__message-input--group">
                    <input class="transaction-main__message-input--text" name="message" type="text" id="messageInput" placeholder="取引メッセージを入力してください" value="{{ old('message') }}">
                    <input type="file" id="imageInput" accept="image/*" style="display: none;" name="image">
                </div>
                <button class="transaction-main__message-input--img" type="button" id="selectImageButton">
                    画像を追加
                </button>
                <button class="transaction-main__message-button" type="submit">
                    <img class="transaction-main__message-button--item" src="{{ asset('storage/paperairplane.png') }}" alt="紙飛行機">
                </button>
            </div>
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
    const messageErrorElement = document.getElementById('messageError');
    const imageErrorElement = document.getElementById('imageError');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let selectedImageFile = null;
    const productId = {{ $detail->id }};

    console.log('messageErrorElement:', messageErrorElement);
    console.log('imageErrorElement:', imageErrorElement);

    // ページロード時に LocalStorage からメッセージを読み込む
    const savedMessage = localStorage.getItem('chatMessageInput_' + {{ $detail->id }});
    if (savedMessage) {
        messageInput.value = savedMessage;
    }

    // 入力欄の値が変更されるたびに LocalStorage に保存
    messageInput.addEventListener('input', function() {
        localStorage.setItem('chatMessageInput_' + {{ $detail->id }}, messageInput.value);
    });

    // チャットエリアを一番下までスクロールする関数
    function scrollToBottom() {
        //チャット全体のスクロール位置を一番下に設定して、自動で一番下までスクロールするようにする
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // 要素がビューポートの最下部に表示されるようにスクロール
    function scrollIntoViewInputArea() {
        const messageInputArea = document.querySelector('.transaction-main__message-input');
        if (messageInputArea) {
            messageInputArea.scrollIntoView({ behavior: 'smooth', block: 'end' });
        }
    }

    // 初期ロード時にスクロール
    scrollToBottom();

    //メッセージ送信された時
    messageForm.addEventListener('submit', function(event) {
        //通常の送信動作を止める
        event.preventDefault();

        //メッセージ内容を取得し、前後の空白を取り除く
        const messageContent = messageInput.value.trim();

        // メッセージを送信するためのURLを組み立てる
        const url = `/messages/${productId}`;

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('message', messageContent);
        formData.append('product_id', productId);
        // 画像ファイルが選択されていればFormDataに追加
        if (selectedImageFile) {
            formData.append('image', selectedImageFile);
        }

        // サーバーへメッセージを送信するための準備（Ajaxリクエスト）
        //指定したURLへデータを送る
        fetch(`/messages/${productId}`, {
            // HTTPメソッドをPOSTにする
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',        // これがあるか確認
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        //サーバーからの応答（レスポンス）を受け取った後の処理
        .then(response => {
            // もしサーバーからの応答がエラー
            if (!response.ok) {
            // エラーメッセージを取得して、次の処理にエラーを渡す
                return response.json().then(errorData => { throw errorData;; });
            }
            //サーバーからの応答をJSON形式に変換して、次の処理に渡す
            return response.json();
        })

        //成功の応答（JSONデータ）を受け取った後の処理
        .then(data => {
            console.log('メッセージ送信成功:', data);

            // バリデーションエラー表示をクリア
            messageErrorElement.textContent = '';
            imageErrorElement.textContent = '';

            // フォームの入力内容をクリア
            messageInput.value = '';
            imageInput.value = '';
            selectedImageFile = null;

            // 保持した値はフォーム送信時にクリア
            localStorage.removeItem('chatMessageInput_' + {{ $detail->id }});

            // 新しいメッセージを表示するためのHTML要素をJavaScriptで作る
            const newMessageElement = document.createElement('div');

            //作ったHTML要素にCSSのクラスを追加する（見た目を整えるため）
            newMessageElement.classList.add('transaction-main__message-chat--item');
            // 自分のメッセージは右寄せ
            newMessageElement.classList.add('message-item--right');

            newMessageElement.setAttribute('data-message-id', data.data.id);

            // メッセージ内容と画像の両方を表示できるようにHTMLを調整
            let contentAndImageHtml = '';
            if (data.data.message) {
                contentAndImageHtml += `<p class="transaction-main__message-chat--item-content">${data.data.message}</p>`;
            }
            // 画像がある場合、<img>タグを追加
            // data.message.image には保存された画像のURLが返されることを想定
            if (data.data.image) {
                contentAndImageHtml += `<img src="${data.data.image}" alt="送信画像" class="transaction-main__message-chat--item-image">`;
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
                    ${contentAndImageHtml}
                </div>
                <div class="transaction-main__message-chat--item-action">
                    <button type="button" class="transaction-main__message-chat--item-action-edit" data-message-id="${data.data.id}">編集</button>
                    <button type="button" class="transaction-main__message-chat--item-action-delete" data-message-id="${data.data.id}">削除</button>
                </div>
            `;

            // チャットエリアに新しいメッセージを追加
            chatMessages.appendChild(newMessageElement);

            // チャットエリアを一番下までスクロール
            scrollToBottom();
            // その後、入力エリアまでスクロール
            scrollIntoViewInputArea();

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

            messageErrorElement.textContent = "";
            imageErrorElement.textContent = "";

            // FormRequestのバリデーションエラーの場合
            if (error && error.errors) { // ★error.errors をチェックする
                if (error.errors.message) {
                    messageErrorElement.textContent = error.errors.message[0];
                }
                if (error.errors.image) {
                    imageErrorElement.textContent = error.errors.image[0];
                }
            } else if (error && error.message) { // その他のエラーメッセージ
                // 例えば throw new Error('Server error'); の場合
                alert(error.message);
            } else { // 予期せぬエラー
                alert('メッセージの送信に失敗しました。');
            }
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



    const completeTransactionButton = document.getElementById('completeTransactionButton');
    const ratingModal = document.getElementById('ratingModal');
    const closeButtons = document.querySelectorAll('.close-button');
    const ratingForm = document.getElementById('ratingForm');
    const reviewedUserIdInput = document.getElementById('reviewedUserId');
    const roleAsReviewedInput = document.getElementById('roleAsReviewed');

    // BladeからPHPの変数をJavaScriptに渡す
    const currentUserId = {{ Auth::id() ?? 'null' }};
    const sellerId = {{ $detail->user_id ?? 'null' }};
    const buyerId = {{ $actualBuyer ? $actualBuyer->id : 'null' }};
    const considerUserId = {{ $considerUser ? $considerUser->id : 'null' }};
    const productStatus = '{{ $detail->transaction_status ?? '' }}';
    const Status = '{{ $detail->status ?? '' }}';
    const shouldShowRatingModal = {{ $shouldShowRatingModal ? 'true' : 'false' }};
    let currentRating = 0; // 現在選択されている評価値
    const ratingValueInput = document.getElementById('ratingValue');
    const starRatingContainer = document.getElementById('starRating');
    const stars = starRatingContainer.querySelectorAll('.star');

    // $isCurrentUserRated は、ログインユーザーが「取引相手」を評価済みかどうかのフラグ
    const isCurrentUserRated = {{ $isCurrentUserRated ? 'true' : 'false' }};

    // --- ログインユーザーの役割を特定 ---
    let currentUserRole = null; // 'seller' または 'buyer'
    if (currentUserId === sellerId) {
        currentUserRole = 'seller';
    } else if ((buyerId !== null && currentUserId === buyerId) ||
        (considerUserId !== null && currentUserId === considerUserId)
    ) {
        currentUserRole = 'buyer';
    }

    // --- ボタンの初期表示とテキストの制御 ---
    if (!completeTransactionButton) {
        return; // ボタンがない場合は処理を終了
    }

    // デフォルトでボタンを非表示にし、条件に応じて表示する
    completeTransactionButton.style.display = 'none';

    // ログインユーザーが取引の当事者でない場合は何もしない
    if (!currentUserRole) {
        console.warn('あなたはこの取引の当事者ではありません。');
        return;
    }

    // 商品ステータスが 'negotiation' の場合
    if (shouldShowRatingModal) {
        // ボタンを表示せず、次の自動表示ロジックに任せるため、ここで処理を終了
        completeTransactionButton.style.display = 'none';
    }
    // 商品ステータスが 'negotiation' の場合 (購入者のみ「取引完了」ボタン)
    else if (productStatus === 'negotiation') {
        if (currentUserRole === 'buyer') {
            completeTransactionButton.textContent = '取引を完了する';
            completeTransactionButton.style.display = 'block';
        }
    }

            // コントローラーから渡された変数を使用（より確実）
            if (reviewedUserIdInput && roleAsReviewedInput) {
                reviewedUserIdInput.value = {{ $reviewedUserIdForModal ?? 'null' }};
                roleAsReviewedInput.value = '{{ $roleAsReviewedForModal ?? '' }}';
            }

            // モーダルを初期化して表示
            currentRating = 0;
            ratingValueInput.value = 0;
            updateStarDisplay(currentRating);
            starRatingContainer.classList.remove('disabled-hover');


    // 星の表示を更新する関数
    function updateStarDisplay(ratingToHighlight, isHovering = false) {
        stars.forEach(star => {
            const value = parseInt(star.dataset.value);
            if (value <= ratingToHighlight) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
        // ホバー中でなく、選択済みの状態が確定している場合は、ホバーイベントを無効化
        if (!isHovering && currentRating > 0) {
            starRatingContainer.classList.add('disabled-hover');
        } else {
            starRatingContainer.classList.remove('disabled-hover');
        }
    }

    // 星の初期状態を設定（hidden inputの初期値0に合わせて）
    updateStarDisplay(currentRating);

    // ホバーイベント
    starRatingContainer.addEventListener('mouseover', function(e) {
        if (!starRatingContainer.classList.contains('disabled-hover')) {
            return;
        }

        const hoveredStar = e.target.closest('.star');
        if (hoveredStar) {
            const value = parseInt(hoveredStar.dataset.value);
            updateStarDisplay(value, true); // ホバー中であることを伝える
        }
    });

    // ホバーが外れた時のイベント
    starRatingContainer.addEventListener('mouseout', function() {
        if (!starRatingContainer.classList.contains('disabled-hover')) {
            return;
        }

        updateStarDisplay(currentRating, false);
    });

    // クリックイベント
    starRatingContainer.addEventListener('click', function(e) {
        const clickedStar = e.target.closest('.star');
        if (clickedStar) {
            currentRating = parseInt(clickedStar.dataset.value);
            ratingValueInput.value = currentRating; // 隠しフィールドに値を設定
            updateStarDisplay(currentRating, false); // 選択状態を更新

            // 星が選択されたらホバーエフェクトを一時的に無効化
            starRatingContainer.classList.add('disabled-hover');
        }
    });

    // 星の表示を更新する関数
    function updateStarDisplay(rating, type = 'click') {
        stars.forEach(star => {
            const value = parseInt(star.dataset.value);
            if (type === 'hover') {
                if (value <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            } else { // type === 'click' または初期表示
                if (value <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            }
        });
    }

    // --- 「取引を完了する」/「相手を評価する」ボタンのクリックイベント ---
    completeTransactionButton.addEventListener('click', function(e) {
        e.preventDefault();


        console.log('completeTransactionButton clicked!');
        console.log('productId:', productId);
        console.log('currentUserId:', currentUserId);
        console.log('sellerId:', sellerId);
        console.log('buyerId:', buyerId);
        console.log('productStatus (from $detail->transaction_status):', productStatus);
        console.log('Status (from $detail->status):', Status);

        // 評価対象のユーザーIDと役割を設定
        let targetReviewedUserId = null;
        let targetRoleAsReviewed = null;

        if (currentUserRole === 'seller') {
            // 出品者は購入者を評価する
            targetReviewedUserId = buyerId;
            targetRoleAsReviewed = 'buyer';
        } else if (currentUserRole === 'buyer') {
            // 購入者が出品者を評価する
            targetReviewedUserId = sellerId;
            targetRoleAsReviewed = 'seller';
        }



        // --- products.status に応じたモーダルの表示分岐 ---


        //自分が取引完了のアクションをした後、モーダルを表示させる
        if (Status === 'sold' && productStatus === 'negotiation' && currentUserRole === 'buyer') {
            console.log('Entered: Status === "sold" block');
                // 取引完了APIを呼び出す
                fetch(`/api/transaction/${productId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({}) // 送るデータがなければ空オブジェクト
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);

                        // ★★★ 取引完了後、すぐに評価モーダルを表示 ★★★
                        reviewedUserIdInput.value = targetReviewedUserId; // 購入者なので出品者ID
                        roleAsReviewedInput.value = targetRoleAsReviewed; // 評価される側は出品者

                        currentRating = 0;
                        ratingValueInput.value = 0;
                        updateStarDisplay(currentRating);
                        starRatingContainer.classList.remove('disabled-hover');

                        ratingModal.style.display = 'flex'; // 評価モーダルを表示

                        // ボタンのテキストも更新 (見た目の更新)
                        completeTransactionButton.textContent = '相手を評価する';

                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error completing transaction:', error);
                    alert('取引完了処理中にエラーが発生しました。');
                });
            }
        // case 2: products.status が 'evaluation' の場合（全員が「評価モーダル」を表示）
        else if (isBuyerRated && currentUserRole === 'seller' && productStatus === "evaluation") {
            if (isCurrentUserRated) {
                alert('あなたはすでに評価済みです。');
                return;
            } else {
                reviewedUserIdInput.value = targetReviewedUserId;
                roleAsReviewedInput.value = targetRoleAsReviewed;

                currentRating = 0;
                ratingValueInput.value = 0;
                updateStarDisplay(currentRating);
                starRatingContainer.classList.remove('disabled-hover');

                ratingModal.style.display = 'flex'; // 評価モーダルを表示
                }
        }
        // case 3: その他のステータスの場合 (ボタンが表示されないはずだが念のため)
        else {
            alert('この商品はまだ購入されていないか、取引が開始されていません。');
        }
    })

    //取引相手から評価を受けていた場合、評価モーダルを自動表示する
    if (shouldShowRatingModal && currentUserRole === 'seller') {
        console.log('Auto-opening rating modal because partner rated the seller.');

        // 評価対象のユーザーIDと役割を設定（コントローラーで渡された $reviewedUserIdForModal を使う）
        if (reviewedUserIdInput && roleAsReviewedInput) {
            // PHP変数を直接使う場合は、DOMContentLoadedの最後で実行されるように
            reviewedUserIdInput.value = {{ $reviewedUserIdForModal ?? 'null' }};
            roleAsReviewedInput.value = '{{ $roleAsReviewedForModal ?? '' }}';
        }

        // モーダルを初期化して表示
        currentRating = 0;
        ratingValueInput.value = 0;
        updateStarDisplay(currentRating);
        starRatingContainer.classList.remove('disabled-hover');

        if (ratingModal) {
            ratingModal.style.display = 'flex';
        }
    }



    // --- 評価モーダルのフォーム送信処理 ---
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (ratingValueInput.value === '0' || ratingValueInput.value === '') {
                alert('評価を選択してください。');
                return; // 送信を中断
            }

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch(`/api/transaction/${productId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                if (result.success) {
                    window.location.href = '{{ route("top") }}'; // 評価成功したらページをリロードして最新の状態に更新
                } else {
                    ratingModal.style.display = 'none';
                    currentRating = 0;
                    ratingValueInput.value = 0;
                    updateStarDisplay(currentRating);
                    starRatingContainer.classList.remove('disabled-hover');
                }
            })
            .catch(error => {
                console.error('Error submitting rating:', error);
                alert('評価送信中にエラーが発生しました。');
                ratingModal.style.display = 'none';

                currentRating = 0;
                ratingValueInput.value = 0;
                updateStarDisplay(currentRating);
                //starRatingContainer.classList.remove('disabled-hover');
            });
        });
    }
});

</script>
@endsection