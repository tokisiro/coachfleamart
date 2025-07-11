<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse;

class RegisterController extends Controller
{
    

        public function create(Request $request): RegisterViewResponse
        {
            return app(RegisterViewResponse::class);
        }
    
        public function store(RegisterRequest $request,CreatesNewUsers $creator): RegisterResponse
        {
            if (config('fortify.lowercase_usernames')) {
                $request->merge([
                    Fortify::username() => Str::lower($request->{Fortify::username()}),
                ]);
            }

            // ユーザを作成
            $user = $creator->create($request->all());

            // email_verifiedをfalseに設定（必要なら）
            $user->email_verified = false;
            $user->save();

            // メール送信
            Mail::to($user->email)->send(new VerifyEmail($user));
    
            event(new Registered($user));

            Auth::login($user);
    
            return app(RegisterResponse::class, [
                $id = $user->id,
                $token = $request->_token,
            ]);
        }
    }

