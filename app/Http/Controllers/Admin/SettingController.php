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

        return back();
    }
}
