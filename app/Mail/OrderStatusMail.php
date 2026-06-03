<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable implements ShouldQueue
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
        $status = strtolower($this->order->status);
        $templateName = "order_{$status}";
        
        $template = \App\Models\EmailTemplate::where('name', $templateName)->first();
        
        $defaultSubject = "Your Order #{$this->order->order_number} is " . ucfirst($this->order->status);
        
        if ($template) {
            $defaultSubject = str_replace(
                ['{order_number}', '{customer_name}', '{site_name}'],
                [$this->order->order_number, $this->order->shipping_address['first_name'] ?? 'there', \App\Models\Setting::get('site_name', 'NewKirk NYC')],
                $template->subject
            );
        }

        return new Envelope(
            subject: $defaultSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $status = strtolower($this->order->status);
        $templateName = "order_{$status}";
        
        $template = \App\Models\EmailTemplate::where('name', $templateName)->first();
        
        if (!$template) {
            $view = match ($this->order->status) {
                'processing' => 'emails.orders.processing',
                'shipped' => 'emails.orders.shipped',
                'completed' => 'emails.orders.completed',
                'cancelled' => 'emails.orders.cancelled',
                'refunded' => 'emails.orders.refunded',
                default => 'emails.orders.processing',
            };
            return new Content(view: $view);
        }

        $address = "";
        if (isset($this->order->shipping_address['address'])) {
            $address = $this->order->shipping_address['address'] . "<br>" . ($this->order->shipping_address['city'] ?? '') . ", " . ($this->order->shipping_address['zip'] ?? '');
        }

        $body = str_replace(
            ['{customer_name}', '{order_number}', '{order_date}', '{order_total}', '{order_status}', '{shipping_address}', '{tracking_url}', '{shop_url}', '{site_name}'],
            [
                $this->order->shipping_address['first_name'] ?? 'there',
                $this->order->order_number,
                $this->order->created_at->format('M d, Y'),
                '$' . number_format($this->order->grand_total, 2),
                ucfirst($this->order->status),
                $address,
                route('order.track.guest', ['order_number' => $this->order->order_number, 'email' => $this->order->shipping_address['email'] ?? '']),
                url('/shop'),
                \App\Models\Setting::get('site_name', 'NewKirk NYC')
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
