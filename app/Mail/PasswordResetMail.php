<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $resetUrl = url('/password/reset/' . $this->token . '?email=' . urlencode($this->email));

        return $this->subject('Password Reset Request - FYP-GATE')
            ->view('emails.password_reset')
            ->with([
                'resetUrl' => $resetUrl,
                'email' => $this->email,
            ]);
    }
}
