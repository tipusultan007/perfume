<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\NewsletterCampaign;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(NewsletterCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaign = $this->campaign;

        // Ensure status is sending
        $campaign->update(['status' => 'sending']);

        try {
            if ($campaign->recipient_type === 'all') {
                $subscribers = Subscriber::active()->get();
            } else {
                $ids = $campaign->target_recipients ?? [];
                $subscribers = Subscriber::active()->whereIn('id', $ids)->get();
            }

            foreach ($subscribers as $subscriber) {
                // Using Mail::queue implies individual jobs for each mail if Mailable is queueable
                // OR we can just use send() here because the JOB itself is running in background.
                // Using send() is simpler here as we are already in a worker.
                Mail::to($subscriber->email)->send(new NewsletterMail($campaign, $subscriber));
            }

            $campaign->update([
                'sent_at' => now(),
                'status' => 'sent',
                'recipient_count' => $subscribers->count()
            ]);

        } catch (\Exception $e) {
            $campaign->update(['status' => 'error']);
            // Log error
            \Illuminate\Support\Facades\Log::error("Campaign sending failed: " . $e->getMessage());
        }
    }
}
