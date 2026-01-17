<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(3)->get();
        return view('shop.account.dashboard', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('shop.account.orders', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product');
        return view('shop.account.order-show', compact('order'));
    }

    public function addresses()
    {
        $user = Auth::user();
        $billingAddress = $user->billing_address;
        $shippingAddress = $user->shipping_address;

        return view('shop.account.addresses', compact('user', 'billingAddress', 'shippingAddress'));
    }

    public function editAddress($type)
    {
        if (!in_array($type, ['shipping', 'billing'])) {
            abort(404);
        }

        $user = Auth::user();
        $address = $type === 'shipping' ? $user->shipping_address : $user->billing_address;
        $typeName = ucfirst($type) . ' Address';

        return view('shop.account.edit-address', compact('user', 'address', 'type', 'typeName'));
    }

    public function updateAddress(Request $request, $type)
    {
        if (!in_array($type, ['shipping', 'billing'])) {
            abort(404);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:2',
        ]);

        $user = Auth::user();
        $addressData = $request->only(['first_name', 'last_name', 'address', 'apartment', 'city', 'state', 'zip', 'country']);

        if ($type === 'shipping') {
            $user->shipping_address = $addressData;
        } else {
            $user->billing_address = $addressData;
        }

        $user->save();

        return redirect()->route('account.addresses')->with('success', ucfirst($type) . ' address updated successfully.');
    }

    public function editDetails()
    {
        $user = Auth::user();
        return view('shop.account.details', compact('user'));
    }

    public function updateDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password does not match.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Account details updated successfully.');
    }
}
