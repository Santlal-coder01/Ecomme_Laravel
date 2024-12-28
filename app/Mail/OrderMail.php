<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ordersend;

    public function __construct($ordersend)
    {
        $this->ordersend = $ordersend;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Invoice',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.ordermail',
            with: [
                'order' => $this->ordersend,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
