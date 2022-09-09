<?php

namespace App\Mail\User;

use App\Models\Eloquent\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    public function __construct(
        string $token
    )
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Şifrenizi Sıfırlayın!');
        return $this->view('user.emails.forgotPassword', [
            'token' => $this->token,
        ]);
    }
}
