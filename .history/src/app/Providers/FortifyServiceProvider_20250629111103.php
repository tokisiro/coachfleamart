<?php

namespace App\Providers;


use Illuminate\Http\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::verifyEmailView(function(){
            return view('email');
        });

        Fortify::loginView(function () {
            return view('login');
        });



    RateLimiter::for('login', function (Request $request) {
        $email = (string) $request->email;

        return Limit::perMinute(10)->by($email . $request->ip());
        });

    Fortify::authenticateUsing(function (Request $request) {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return $user;
        }

        // 認証失敗した場合には例外を投げ、エラーメッセージにカスタムメッセージ
        throw ValidationException::withMessages([
            'email' => ['ログイン情報が登録されていません。'],
        ]);
    });
}
}
