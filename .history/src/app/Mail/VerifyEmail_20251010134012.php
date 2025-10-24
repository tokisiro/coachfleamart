<?php
// app/Mail/VerifyEmail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verificationUrl = route('mypage.profile', ['id' => $this->user->id, 'token' => md5($this->user->email)]);
        return $this->subject('メールアドレスのご確認をお願いいたします')->view('veri', compact('verificationUrl'));
    }
}
