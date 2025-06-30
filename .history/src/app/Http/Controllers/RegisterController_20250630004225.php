<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
    
            $this->guard->login($user);
    
            return app(RegisterResponse::class);
        }
    }

