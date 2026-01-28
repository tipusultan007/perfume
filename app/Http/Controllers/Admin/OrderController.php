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
        $order->load(['items.product', 'items.variant', 'user', 'orderNotes.author']);
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
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusMail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send order status email: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function downloadInvoice(Order $order)
    {
        $order->load(['items.product', 'items.variant', 'user']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shop.account.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function resendDetails(Order $order)
    {
        if ($order->user) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderCreatedMail($order));
                return back()->with('success', 'Order details resent successfully.');
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to resend details: ' . $e->getMessage());
            }
        }
        return back()->with('error', 'No user associated with this order.');
    }

    public function addNote(Request $request, Order $order)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $note = $order->orderNotes()->create([
            'author_id' => \Illuminate\Support\Facades\Auth::id(),
            'note' => $request->note,
            'is_customer_notified' => $request->has('is_customer_notified'),
        ]);

        if ($note->is_customer_notified && $order->user) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderNoteMail($order, $note));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send order note notification: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Order note added.');
    }
}
