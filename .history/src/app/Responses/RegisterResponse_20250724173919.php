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
        $user = auth()->user();
    $verificationUrl = route('emaildisplay', ['id' => $user->id, 'token' => $user->verification_token]);

    return redirect()->route('register')->with('status', '入力いただいたメールアドレスに認証用メールを送信しました');
    }
}