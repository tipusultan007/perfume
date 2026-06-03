<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewOrderMail extends Mailable implements ShouldQueue
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
        $template = \App\Models\EmailTemplate::where('name', 'admin_new_order')->first();
        $subject = 'New Order Received #' . $this->order->order_number;
        
        if ($template) {
            $subject = str_replace(
                ['{order_number}'],
                [$this->order->order_number],
                $template->subject
            );
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $template = \App\Models\EmailTemplate::where('name', 'admin_new_order')->first();
        
        if (!$template) {
            return new Content(view: 'emails.admin.new_order');
        }

        $body = str_replace(
            ['{order_number}', '{customer_name}', '{order_total}', '{order_status}', '{admin_order_url}'],
            [
                $this->order->order_number, 
                $this->order->user ? $this->order->user->name : 'Guest', 
                '$' . number_format($this->order->grand_total, 2), 
                ucfirst($this->order->status), 
                route('admin.orders.show', $this->order->id)
            ],
            $template->body
        );

        return new Content(
            view: 'emails.dynamic',
            with: ['body' => $body],
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
