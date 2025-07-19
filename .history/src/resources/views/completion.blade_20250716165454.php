
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/sending.css">
@endsection


<!--送付先住所変更-->

@section('content')
    <div class="completion">
        <div class="sending-title">
            <h2 class="sending-title__item">
                住所の変更
            </h2>
        </div>
        <form class="sending-form" action="{{ url('/mypage/address/' . $product) }}" method="post">
            @csrf
            
        </form>
    </div>
@endsection
@section('script')

@endsection