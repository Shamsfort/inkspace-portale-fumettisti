<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $contact,
        public bool $confirmation = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->confirmation ? 'Abbiamo ricevuto il tuo messaggio' : 'Nuovo messaggio dal portale fumettisti',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.contact-message');
    }
}
