<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse;

class CustomRegisterResponse implements RegisterResponse
{
    public function toResponse($request)
    {
        // ここにリダイレクトのURLを記述
        return redirect('/mypage/profile');
    }
}