<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function shipping()
    {
        return view('pages.shipping');
    }

    public function refunds()
    {
        return view('pages.refunds');
    }

    public function authenticity()
    {
        return view('pages.authenticity');
    }

    public function accessibility()
    {
        return view('pages.accessibility');
    }
}
