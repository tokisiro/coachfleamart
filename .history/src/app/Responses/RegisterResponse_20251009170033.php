<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected $id;
    protected $token;

    public function __construct($id, $token)
    {
        $this->id = $id;
        $this->token = $token;
    }

    public function toResponse($request)
    {
        $user = auth()->user();
        $verificationUrl = route('emaildisplay', ['id' => $user->id, 'token' => $user->verification_token]);

    return view('email')->with([
            'user' => $user,
            'verificationLink' => $verificationLink, // 必要であれば
            // 他にも email.blade.php で必要なデータがあればここに追加
        ]);
    }
}