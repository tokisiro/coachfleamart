<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Fortify;
use Illuminate\Routing\Pipeline;
use Laravel\Fortify\Features;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\ServiceProvider;

class LoginController extends Controller
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function create(LoginRequest $request): LoginViewResponse
    {
        return app(LoginViewResponse::class);
    }

    public function store(LoginRequest $request)
    {
        return $this->loginPipeline($request)->then(function ($request) {
            return app(LoginResponse::class);
        });
    }

    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }

    
}

class FortifyServiceProvider extends ServiceProvider{

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

    Fortify::authenticateUsing(function (loginRequest $request) {
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
