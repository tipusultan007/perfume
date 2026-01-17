<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = ucfirst($this->order->status);
        return new Envelope(
            subject: "Your Order #{$this->order->order_number} is {$status}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Simple mapping of status to view
        // We will create these views next
        $view = match ($this->order->status) {
            'processing' => 'emails.orders.processing',
            'shipped' => 'emails.orders.shipped',
            'completed' => 'emails.orders.completed',
            'cancelled' => 'emails.orders.cancelled',
            'refunded' => 'emails.orders.refunded',
            default => 'emails.orders.processing', // Fallback
        };

        return new Content(
            view: $view,
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
