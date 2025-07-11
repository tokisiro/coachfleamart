<?php

namespace App\Http\Controllers;


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
    
        public function store(RegisterRequest $request,
                            CreatesNewUsers $creator): RegisterResponse
        {
            if (config('fortify.lowercase_usernames')) {
                $request->merge([
                    Fortify::username() => Str::lower($request->{Fortify::username()}),
                ]);
            }
    
            event(new Registered($user = $creator->create($request->all())));

            Auth::login($user);
    
            return app(RegisterResponse::class);
        }
    }

