<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Orderinfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $data;
    protected $ord_id;
    public function __construct($data, $id)
    {
        $this->data = $data;
        $this->ord_id = $id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Info #OD-0' . $this->ord_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.orderinfo-temp',
            with: [
                'ordresult' => $this->data['ordresult'],
                'billingresult' => $this->data['billingresult'],
                'shippingresult' => $this->data['shippingresult'],
                'prdresult' => $this->data['prdresult'],
                'couponresult' => $this->data['couponresult'] ?? false,
                'date' => $this->data['date'],
                'time' => $this->data['time'],
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
