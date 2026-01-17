<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterCampaign;
use App\Models\Subscriber;
use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index()
    {
        $campaigns = NewsletterCampaign::latest()->paginate(10, ['*'], 'campaigns_page');
        $subscribers = Subscriber::latest()->paginate(20, ['*'], 'subscribers_page');
        return view('admin.newsletter.index', compact('campaigns', 'subscribers'));
    }

    public function create()
    {
        $subscribers = Subscriber::active()->get();
        return view('admin.newsletter.create', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
            'recipient_type' => 'required|in:all,select',
            'recipients' => 'required_if:recipient_type,select|array'
        ]);

        NewsletterCampaign::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'recipient_type' => $request->recipient_type,
            'target_recipients' => $request->recipient_type === 'select' ? $request->recipients : null,
            'status' => 'draft'
        ]);

        return redirect()->route('admin.newsletter.index')->with('success', 'Campaign draft created successfully.');
    }

    public function send($id)
    {
        $campaign = NewsletterCampaign::findOrFail($id);
        
        if ($campaign->status === 'sent') {
             return back()->with('error', 'Campaign already sent.');
        }

        // Dispatch Job
        \App\Jobs\SendNewsletterCampaign::dispatch($campaign);

        return back()->with('success', 'Campaign sending started in the background.');
    }

    public function edit($id)
    {
        $campaign = NewsletterCampaign::findOrFail($id);
        if ($campaign->status === 'sent') {
            return redirect()->route('admin.newsletter.index')->with('error', 'Cannot edit sent campaigns.');
        }

        $subscribers = Subscriber::active()->get();
        return view('admin.newsletter.edit', compact('campaign', 'subscribers'));
    }

    public function update(Request $request, $id)
    {
        $campaign = NewsletterCampaign::findOrFail($id);
        if ($campaign->status === 'sent') {
            return back()->with('error', 'Cannot edit sent campaigns.');
        }

        $request->validate([
            'subject' => 'required',
            'content' => 'required',
            'recipient_type' => 'required|in:all,select',
            'recipients' => 'required_if:recipient_type,select|array'
        ]);

        $campaign->update([
            'subject' => $request->subject,
            'content' => $request->content,
            'recipient_type' => $request->recipient_type,
            'target_recipients' => $request->recipient_type === 'select' ? $request->recipients : null,
        ]);

        return redirect()->route('admin.newsletter.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy($id)
    {
        $campaign = NewsletterCampaign::findOrFail($id);
        $campaign->delete();
        return back()->with('success', 'Campaign deleted successfully.');
    }
}
