<?php

namespace App\Http\Controllers;

use App\Responses\RegisterResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;


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

            $user = $creator->create($request->all());

            $user->email_verified = false;
            $user->verification_token = Str::random(40);
            $user->save();

            Mail::to($user->email)->send(new VerifyEmail($user));

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('')->with('status', '登録が完了しました。メールを確認してください。');
        }
    }

