<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $template = \App\Models\EmailTemplate::where('name', 'customer_welcome')->first();
        $subject = 'Welcome to ' . \App\Models\Setting::get('site_name', "NewKirk NYC");
        
        if ($template) {
            $subject = str_replace(
                ['{site_name}'],
                [\App\Models\Setting::get('site_name', "NewKirk NYC")],
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
        $template = \App\Models\EmailTemplate::where('name', 'customer_welcome')->first();
        
        if (!$template) {
            return new Content(view: 'emails.customer.welcome');
        }

        $customerName = explode(' ', $this->user->name)[0];
        $siteName = \App\Models\Setting::get('site_name', "NewKirk NYC");
        $loginUrl = url('/account/dashboard');

        $body = str_replace(
            ['{site_name}', '{customer_name}', '{login_url}'],
            [$siteName, $customerName, $loginUrl],
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
