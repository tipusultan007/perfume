<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNoteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $note;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\Order $order, \App\Models\OrderNote $note)
    {
        $this->order = $order;
        $this->note = $note;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $template = \App\Models\EmailTemplate::where('name', 'order_note_added')->first();
        $subject = "New Update for your Order #{$this->order->order_number}";
        
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
        $template = \App\Models\EmailTemplate::where('name', 'order_note_added')->first();
        
        if (!$template) {
            return new Content(view: 'emails.orders.note-added');
        }

        $body = str_replace(
            ['{customer_name}', '{order_number}', '{note}', '{tracking_url}', '{site_name}'],
            [
                $this->order->shipping_address['first_name'] ?? 'there',
                $this->order->order_number,
                $this->note->note,
                route('order.track.guest', ['order_number' => $this->order->order_number, 'email' => $this->order->shipping_address['email'] ?? '']),
                \App\Models\Setting::get('site_name', "NewKirk NYC")
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
