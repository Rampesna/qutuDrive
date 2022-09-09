<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $email;
    protected string $password;

    public function __construct(
        string $email,
        string $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        $this->subject('Hoşgeldiniz!');
        return $this->view('user.emails.welcome', [
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }
}
