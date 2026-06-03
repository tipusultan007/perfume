<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('templates'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email_templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $emailTemplate->update([
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated successfully.');
    }

    public function preview(Request $request)
    {
        $body = $request->body;
        
        $dummyData = [
            '{site_name}' => \App\Models\Setting::get('site_name', 'NewKirk NYC'),
            '{customer_name}' => 'John Doe',
            '{order_number}' => 'ORD-123456',
            '{order_date}' => now()->format('M d, Y'),
            '{order_total}' => '$125.00',
            '{order_status}' => 'Processing',
            '{shipping_address}' => '123 Luxury Lane<br>New York, NY 10001',
            '{tracking_url}' => '#',
            '{shop_url}' => '#',
            '{login_url}' => '#',
            '{admin_order_url}' => '#',
            '{note}' => 'This is a sample note added to your order by our concierge.',
            '{order_items}' => '<table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;"><tr style="border-bottom: 1px solid #f3f4f6;"><td style="padding: 15px 0; text-align: left;"><span style="font-weight: 600; font-size: 14px; display: block;">Signature Oudh</span><span style="font-size: 11px; color: #9ca3af; text-transform: uppercase;">50ML</span></td><td style="padding: 15px 0; text-align: right; font-size: 14px;">1 &times; $125.00</td></tr></table>'
        ];
        
        $body = str_replace(array_keys($dummyData), array_values($dummyData), $body);

        return view('emails.dynamic', ['body' => $body]);
    }
}
