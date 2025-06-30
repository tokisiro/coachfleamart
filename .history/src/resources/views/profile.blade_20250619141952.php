
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

<!--プロフィール画面-->

@section('content')
    <div class="profile">
        <div class="profile-image">
            <div class="profile-image__icon">
                <img class="profile-image__icon-item" src="" alt="">
                <label class="profile-image__icon-label">
                    ユーザー名
                </label>
                <div class="profile-image__icon-link">
                    <a class="profile-image__icon-link--item" href="">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-tag">
            <button id="recommendationBtn" class="profile-tag__recommendation active">
                出品した商品
            </button>
            <button id="myListBtn" class="profile-tag__myList">
                購入した商品
            </button>
        </div>
        <div class="profile-list">

        <!--出品した商品で表示するリスト-->
        <div class="profile-recommendation">
        
                <a class="profile-Listing__card" href="">
                    <div class="profile-Listing__card-img">
                        <img class="profile-Listing__card-img--item" src="" alt="" />
                    </div>
                    <div class="profile-Listing__card-content">
                        <p class="profile-Listing__card-content--name">
                            商品名
                        </p>
                    </div>
                </a>
            
        </div>


        <!--購入した商品で表示するリスト-->
        <div class="profile-myList" >
            
                <a class="profile-myList__card" href="" >
                    <div class="profile-myList__card-img">
                        <img class="profile-myList__card-img--item" src="" alt="" />
                    </div>
                    <div class="profile-myList__card-content">
                        <p class="profile-myList__card-content--name">
                            
                            
                    <span style="color:red; font-weight:bold;"> sold</span>
                
                        </p>
                    </div>
                </a>
            
        </div>
        </div>
    </div>
@endsection



</body>
</html>