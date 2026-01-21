<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = ContactSubmission::latest('created_at')->paginate(20);
        return view('admin.contact.index', compact('submissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        
        if ($submission->status === 'unread') {
            $submission->update(['status' => 'read']);
        }

        return view('admin.contact.show', compact('submission'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->delete();

        return redirect()->route('admin.contact-submissions.index')->with('success', 'Submission deleted successfully.');
    }
}
