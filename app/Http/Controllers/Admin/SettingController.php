<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // General Settings
        if ($request->has('update_general')) {
            Setting::set('site_name', $request->input('site_name'), 'general');
            Setting::set('site_description', $request->input('site_description'), 'general');

            if ($request->hasFile('site_logo')) {
                $path = $request->file('site_logo')->store('settings', 'public');
                Setting::set('site_logo', 'storage/' . $path, 'general');
            }
            
            return back()->with('success', 'General settings updated.');
        }

        // Contact Settings
        if ($request->has('update_contact')) {
            Setting::set('contact_email', $request->input('contact_email'), 'contact');
            Setting::set('contact_phone', $request->input('contact_phone'), 'contact');
            Setting::set('contact_address', $request->input('contact_address'), 'contact');
            return back()->with('success', 'Contact settings updated.');
        }

        // Social Settings
        if ($request->has('update_social')) {
            Setting::set('social_facebook', $request->input('social_facebook'), 'social');
            Setting::set('social_instagram', $request->input('social_instagram'), 'social');
            Setting::set('social_twitter', $request->input('social_twitter'), 'social');
            Setting::set('social_pinterest', $request->input('social_pinterest'), 'social');
            return back()->with('success', 'Social media settings updated.');
        }

        // Footer Settings
        if ($request->has('update_footer')) {
            Setting::set('footer_copyright', $request->input('footer_copyright'), 'footer');
            return back()->with('success', 'Footer settings updated.');
        }

        // Navigation Settings (Dynamic Menu)
        if ($request->has('update_nav')) {
            // Prioritize JSON input from AlpineJS
            if ($request->has('nav_menu_json')) {
                 Setting::set('nav_menu_json', $request->input('nav_menu_json'), 'navigation', 'json');
            } else {
                // Fallback for non-JS / old method
                $labels = $request->input('nav_label', []);
                $urls = $request->input('nav_url', []);
                $menu = [];
                
                for ($i = 0; $i < count($labels); $i++) {
                    if (!empty($labels[$i])) {
                        $menu[] = [
                            'label' => $labels[$i],
                            'url' => $urls[$i] ?? '#',
                            'children' => [] // Consistent structure
                        ];
                    }
                }
                Setting::set('nav_menu_json', json_encode($menu), 'navigation', 'json');
            }
            return back()->with('success', 'Navigation menu updated.');
        }

        // Tax Settings
        if ($request->has('update_tax_settings')) {
            Setting::set('tax_enabled', $request->has('tax_enabled') ? 1 : 0, 'tax', 'boolean');
            return back()->with('success', 'Tax settings updated');
        }

        // Announcement Bar Settings
        if ($request->has('update_announcement_bar')) {
            Setting::set('topbar_visible', $request->has('topbar_visible') ? 1 : 0, 'announcement', 'boolean');
            Setting::set('topbar_bg', $request->input('topbar_bg', '#D4AF37'), 'announcement');
            Setting::set('topbar_text_color', $request->input('topbar_text_color', '#000000'), 'announcement');
            return back()->with('success', 'Announcement bar settings updated.');
        }

        // Integrations Settings
        if ($request->has('update_integrations')) {
            Setting::set('google_analytics_id', $request->input('google_analytics_id'), 'integration');
            Setting::set('recaptcha_site_key', $request->input('recaptcha_site_key'), 'integration');
            Setting::set('recaptcha_secret_key', $request->input('recaptcha_secret_key'), 'integration');
            Setting::set('google_ads_id', $request->input('google_ads_id'), 'integration');
            Setting::set('facebook_pixel_id', $request->input('facebook_pixel_id'), 'integration');
            return back()->with('success', 'Integration settings updated.');
        }

        // Site Status Settings
        if ($request->has('update_site_status')) {
            Setting::set('site_status', $request->input('site_status', 'live'), 'status');
            return back()->with('success', 'Site visibility status updated.');
        }

        // Mail Settings
        if ($request->has('update_mail')) {
            Setting::set('mail_mailer', $request->input('mail_mailer'), 'mail');
            Setting::set('mail_host', $request->input('mail_host'), 'mail');
            Setting::set('mail_port', $request->input('mail_port'), 'mail');
            Setting::set('mail_username', $request->input('mail_username'), 'mail');
            Setting::set('mail_password', $request->input('mail_password'), 'mail');
            Setting::set('mail_encryption', $request->input('mail_encryption'), 'mail');
            Setting::set('mail_from_address', $request->input('mail_from_address'), 'mail');
            Setting::set('mail_from_name', $request->input('mail_from_name'), 'mail');
            return back()->with('success', 'Mail settings updated.');
        }

        return back();
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        return back()->with('success', 'Application cache cleared successfully.');
    }

    public function createStorageLink()
    {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        
        return back()->with('success', 'Storage symbolic link created successfully.');
    }

    public function testSmtp(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            \Illuminate\Support\Facades\Mail::raw('This is a test email to verify your SMTP settings at ' . config('app.name'), function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('SMTP Connection Test');
            });

            return back()->with('success', 'Test email sent successfully! Please check your inbox.');
        } catch (\Exception $e) {
            return back()->with('error', 'SMTP Error: ' . $e->getMessage());
        }
    }
}
