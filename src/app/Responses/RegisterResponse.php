<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

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
        $user = auth()->user(); // 登録したユーザを取得
    $verificationUrl = route('email', ['id' => $user->id, 'token' => $user->verification_token]);

    return response()->view('email', [
        'verificationUrl' => $verificationUrl,
        'user' => $user,
    ]);
    }
}