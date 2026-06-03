<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'customer_welcome',
                'subject' => 'Welcome to {site_name}',
                'variables' => ['{site_name}', '{customer_name}', '{login_url}'],
                'body' => '<div style="text-align: center;">
    <h1 style="font-size: 32px; letter-spacing: -0.5px; margin-bottom: 24px;">Welcome to {site_name}</h1>
    
    <p style="font-style: italic; color: #111827; margin-bottom: 30px;">Bonjour, {customer_name}.</p>
    
    <p style="margin-bottom: 30px;">
        It is a pleasure to welcome you to the {site_name} community. 
        Here, we believe a fragrance is more than a scent—it is a signature of identity and a companion to memory.
    </p>
    
    <p style="margin-bottom: 40px;">
        Your account has been successfully curated. You may now explore our collection of signature objects, track your personal orders, and manage your preferences through your private dashboard.
    </p>
    
    <div style="margin: 45px 0;">
        <a href="{login_url}" class="btn">Explore the Collection</a>
    </div>
    
    <p style="font-size: 13px; opacity: 0.8; margin-top: 50px;">
        Should you require personal assistance or have inquiries regarding our olfactory creations, our team is always at your service.
    </p>
    
    <p style="margin-top: 30px; font-family: \'Georgia\', serif; color: #111827;">
        With appreciation,<br>
        <strong>The {site_name} Team</strong>
    </p>
</div>',
            ],
            [
                'name' => 'admin_new_order',
                'subject' => 'New Order Received #{order_number}',
                'variables' => ['{order_number}', '{customer_name}', '{order_total}', '{order_status}', '{admin_order_url}'],
                'body' => '<h2>New Order Received</h2>
<p>Hello Admin,</p>
<p>A new order #{order_number} has been placed by {customer_name}.</p>

<div class="order-details">
    <p><strong>Order Number:</strong> {order_number}</p>
    <p><strong>Total:</strong> {order_total}</p>
    <p><strong>Status:</strong> {order_status}</p>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="{admin_order_url}" class="btn">Manage Order</a>
</p>',
            ],
            [
                'name' => 'order_created',
                'subject' => 'Order #{order_number} Confirmed - {site_name}',
                'variables' => ['{customer_name}', '{order_number}', '{order_date}', '{order_total}', '{order_items}', '{tracking_url}'],
                'body' => '<div style="text-align: center;">
    <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #9ca3af; margin-bottom: 20px;">Order Confirmation</p>
    <h1 style="font-size: 28px; margin-bottom: 30px;">Thank You for Your Order</h1>
    
    <p style="margin-bottom: 30px;">
        Dear {customer_name}, your order has been successfully placed and is currently being prepared for shipping.
    </p>

    <div class="order-details" style="background: #fdfcf8; border: 1px solid #f3f4f6; padding: 30px; margin: 40px 0; text-align: left;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Order Number</td>
                <td style="padding: 5px 0; text-align: right; font-weight: 600;">#{order_number}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Date</td>
                <td style="padding: 5px 0; text-align: right;">{order_date}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Total amount</td>
                <td style="padding: 5px 0; text-align: right; font-weight: 600; color: #d4af37;">{order_total}</td>
            </tr>
        </table>
    </div>

    <h3 style="text-align: left; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px; margin-bottom: 20px;">Curated Items</h3>
    
    {order_items}

    <div style="margin: 50px 0;">
        <a href="{tracking_url}" class="btn">View Your Order Details</a>
    </div>

    <p style="font-size: 13px; font-style: italic; color: #9ca3af; margin-top: 40px;">
        You will receive another notification as soon as your items have been shipped.
    </p>
</div>',
            ],
            [
                'name' => 'order_processing',
                'subject' => 'Your Order #{order_number} is Processing',
                'variables' => ['{customer_name}', '{order_number}', '{order_date}', '{order_total}', '{tracking_url}', '{site_name}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Order #{order_number} Confirmed.</h2>

<p>Hello {customer_name},</p>
<p>Thank you for choosing {site_name}. We have received your order and our team has begun the preparation process.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0; font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Order Summary</p>
    <div style="margin-top: 15px;">
        <p style="margin: 5px 0;"><strong>Order Number:</strong> {order_number}</p>
        <p style="margin: 5px 0;"><strong>Total Amount:</strong> {order_total}</p>
        <p style="margin: 5px 0;"><strong>Date:</strong> {order_date}</p>
    </div>
</div>

<p>We will notify you with a shipping confirmation as soon as your signature objects are ready for transit.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{tracking_url}" class="btn">View Your Order</a>
</p>',
            ],
            [
                'name' => 'order_shipped',
                'subject' => 'Your Order #{order_number} is Shipped',
                'variables' => ['{customer_name}', '{order_number}', '{shipping_address}', '{tracking_url}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Your Order has Shipped.</h2>

<p>Hello {customer_name},</p>
<p>Wonderful news! Your order #{order_number} has been carefully prepared and is now en route to your destination.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0; font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Destination</p>
    <div style="margin-top: 15px;">
        <p style="margin: 5px 0;"><strong>Address:</strong><br>
        {shipping_address}
        </p>
    </div>
</div>

<p>You can track the progress of your delivery by visiting your order status page below.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{tracking_url}" class="btn">Track Your Delivery</a>
</p>',
            ],
            [
                'name' => 'order_completed',
                'subject' => 'Your Order #{order_number} is Completed',
                'variables' => ['{customer_name}', '{order_number}', '{shop_url}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Delivered & Complete.</h2>

<p>Hello {customer_name},</p>
<p>Your order #{order_number} has been successfully delivered. We hope your new signature objects bring a touch of luxury to your daily rituals.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0; text-align: center;">
    <p style="margin: 0; font-style: italic;">"Fragrance is the most intense form of memory."</p>
</div>

<p>We would be honored to hear about your experience. Feel free to share your thoughts or revisit the collection for your next inspiration.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{shop_url}" class="btn">Return to the Collection</a>
</p>',
            ],
            [
                'name' => 'order_cancelled',
                'subject' => 'Your Order #{order_number} is Cancelled',
                'variables' => ['{customer_name}', '{order_number}', '{order_status}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Order Update.</h2>

<p>Hello {customer_name},</p>
<p>This message is to confirm that your order #{order_number} has been officially {order_status}.</p>

<div class="order-details" style="background: #fafafa; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0;"><strong>Status:</strong> <span style="text-transform: uppercase; color: #999;">{order_status}</span></p>
</div>

<p>If you have any questions or would like to discuss this further, our concierge team is always available at <a href="mailto:info@newkirkperfumesusa.com">info@newkirkperfumesusa.com</a>.</p>',
            ],
            [
                'name' => 'order_refunded',
                'subject' => 'Your Order #{order_number} is Refunded',
                'variables' => ['{customer_name}', '{order_number}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Refund Processed.</h2>

<p>Hello {customer_name},</p>
<p>We are writing to inform you that a refund has been issued for your order #{order_number}.</p>

<div class="order-details" style="background: #fafafa; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0;"><strong>Status:</strong> <span style="text-transform: uppercase; color: #D4AF37;">Refunded</span></p>
</div>

<p>The funds should appear in your original payment method shortly, depending on your financial institution\'s processing times.</p>',
            ],
            [
                'name' => 'order_note_added',
                'subject' => 'Update on your Order #{order_number}',
                'variables' => ['{customer_name}', '{order_number}', '{note}', '{tracking_url}', '{site_name}'],
                'body' => '<h2 style="font-family: \'Cormorant Garamond\', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">An update regarding your Order #{order_number}.</h2>
    
<p>Hello {customer_name},</p>

<p>Our team has added a new update to your order:</p>

<div class="order-details" style="font-style: italic; color: #555; border-left: 2px solid #D4AF37; background: #fafafa; padding: 20px; margin: 30px 0;">
    "{note}"
</div>

<p>You can view the full details of your order and its history by visiting your account dashboard.</p>

<div style="margin-top: 40px; text-align: center;">
    <a href="{tracking_url}" class="btn">View Order Details</a>
</div>

<p style="margin-top: 40px;">Sincerely,<br>The {site_name} Team</p>',
            ]
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }
}
