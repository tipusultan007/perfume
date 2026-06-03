<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable implements ShouldQueue
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
        $template = \App\Models\EmailTemplate::where('name', 'order_created')->first();
        $subject = 'Order Confirmation #' . $this->order->order_number;
        
        if ($template) {
            $subject = str_replace(
                ['{customer_name}', '{order_number}', '{order_date}', '{order_total}', '{site_name}'],
                [
                    $this->order->user ? $this->order->user->name : 'Customer',
                    $this->order->order_number,
                    $this->order->created_at->format('M d, Y'),
                    '$' . number_format($this->order->grand_total, 2),
                    \App\Models\Setting::get('site_name', 'NewKirk NYC')
                ],
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
        $template = \App\Models\EmailTemplate::where('name', 'order_created')->first();
        
        if (!$template) {
            return new Content(view: 'emails.orders.created');
        }

        $itemsHtml = '<table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">';
        foreach($this->order->items as $item) {
            $itemsHtml .= '<tr style="border-bottom: 1px solid #f3f4f6;">';
            $itemsHtml .= '<td style="padding: 15px 0; text-align: left;">';
            $itemsHtml .= '<span style="font-weight: 600; font-size: 14px; display: block;">' . htmlspecialchars($item->product_name) . '</span>';
            if ($item->variant_name) {
                $itemsHtml .= '<span style="font-size: 11px; color: #9ca3af; text-transform: uppercase;">' . htmlspecialchars($item->variant_name) . '</span>';
            }
            $itemsHtml .= '</td>';
            $itemsHtml .= '<td style="padding: 15px 0; text-align: right; font-size: 14px;">' . $item->quantity . ' &times; $' . number_format($item->price, 2) . '</td>';
            $itemsHtml .= '</tr>';
        }
        $itemsHtml .= '</table>';

        $body = str_replace(
            ['{customer_name}', '{order_number}', '{order_date}', '{order_total}', '{order_items}', '{tracking_url}'],
            [
                $this->order->user ? $this->order->user->name : 'Customer', 
                $this->order->order_number, 
                $this->order->created_at->format('M d, Y'), 
                '$' . number_format($this->order->grand_total, 2), 
                $itemsHtml,
                route('order.track.guest', ['order_number' => $this->order->order_number, 'email' => $this->order->shipping_address['email'] ?? ''])
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
