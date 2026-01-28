<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order) // Changed type hint to App\Models\Order
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Changed from 'mail' to 'database'
    }

    /**
     * Get the mail representation of the notification.
     */
    // Removed toMail method as it's no longer needed for database channel

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => ($this->order->shipping_address['first_name'] ?? '') . ' ' . ($this->order->shipping_address['last_name'] ?? ''),
            'grand_total' => $this->order->grand_total,
            'message' => "New order #{$this->order->order_number} received from " . ($this->order->shipping_address['first_name'] ?? 'Customer'),
            'type' => 'order_success'
        ];
    }
}
