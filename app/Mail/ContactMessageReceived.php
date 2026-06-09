<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->contactMessage->email, $this->contactMessage->name),
            ],
            subject: 'Portfolio message: '.$this->contactMessage->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message-received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
