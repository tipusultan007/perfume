<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Store a contact submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactSubmission::create($validated);

        return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you shortly.');
    }
}
