
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
        <div class="profile-tag">
            <button id="recommendationBtn" class="profile-tag__recommendation active">
                出品した商品
            </button>
            <button id="myListBtn" class="product-tag__myList">
                購入した商品
            </button>
        </div>
        <div class="profile-list">

        <!--出品した商品で表示するリスト-->
        <div class="profile-recommendation">
        
                <a class="profile-recommendation__card" href="">
                    <div class="profile-recommendation__card-img">
                        <img class="profile-recommendation__card-img--item" src="" alt="" />
                    </div>
                    <div class="profile-recommendation__card-content">
                        <p class="profile-recommendation__card-content--name">
                            
                            
                    <span style="color:red; font-weight:bold;"> sold</span>
                
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