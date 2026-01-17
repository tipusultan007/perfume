<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'items.variant', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus,
            'payment_status' => $request->payment_status,
        ]);

        if ($oldStatus !== $newStatus && $order->user) {
            try {
                // Determine if we should send email for this status
                // If we implemented all views, we can send for all unique statuses
                // excluding 'pending' maybe, but let's send for all changes for now
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusMail($order));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Illuminate\Support\Facades\Log::error("Failed to send order status email: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
}
