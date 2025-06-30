
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/address.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img src="" alt="">
                <label class="profile-image__icon-label">
                    ユーザー名
                </label>
                <div class="profile-image__icon_link">
                    <a href="">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-listing">
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
        </div>
        <div class="profile-purchase">
            <ul>
                <label>
                    <li></li>
                </label>
                <label>
                    <li></li>
                </label>
            </ul>
        </div>
    </div>
</main>
</body>
</html>