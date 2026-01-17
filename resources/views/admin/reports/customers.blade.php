@extends('admin.layouts.app')

@section('title', 'Customers Report')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-serif text-black">Customers Report</h1>
            <p class="text-sm text-gray-500 mt-1">Top spending customers and insights</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:text-black transition-colors">
            <i class="ri-arrow-left-line"></i> Back to Reports
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-black/5 flex justify-between items-center bg-purple-50/30">
            <h3 class="text-lg font-serif text-purple-900">Top 20 Customers by Spend</h3>
            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-lg">Lifetime Value</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Customer</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 font-medium">Location</th>
                        <th class="px-6 py-3 font-medium text-right">Orders</th>
                        <th class="px-6 py-3 font-medium text-right">Total Spent</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-black/5">
                    @forelse($topCustomers as $index => $customer)
                    <tr class="hover:bg-purple-50/10">
                        <td class="px-6 py-3 font-medium text-black flex items-center gap-3">
                            <span class="text-gray-400 font-mono text-xs">#{{ $index + 1 }}</span>
                            {{ $customer->shipping_address['first_name'] ?? 'Guest' }} {{ $customer->shipping_address['last_name'] ?? '' }}
                        </td>
                        <td class="px-6 py-3 text-gray-500">{{ $customer->shipping_address['email'] ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-500">
                            {{ $customer->shipping_address['city'] ?? '' }}, {{ $customer->shipping_address['country'] ?? '' }}
                        </td>
                        <td class="px-6 py-3 text-right font-medium text-gray-700">{{ $customer->order_count }}</td>
                        <td class="px-6 py-3 text-right font-medium text-black">${{ number_format($customer->total_spent, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No customer data available yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
