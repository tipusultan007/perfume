<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('shop.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('shipping_address->email', $request->email)
            ->first();

        if (!$order) {
            return back()->with('error', 'No order found with those details. Please check your Order ID and Email.')->withInput();
        }

        return view('shop.track-results', compact('order'));
    }
}
