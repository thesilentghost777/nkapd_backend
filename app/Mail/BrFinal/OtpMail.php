<?php

namespace App\Mail\BrFinal;

use App\Models\BrFinal\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $code
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code de connexion Business Room — ' . $this->code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'br-final.emails.otp',
        );
    }
}