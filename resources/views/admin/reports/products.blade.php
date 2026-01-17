@extends('admin.layouts.app')

@section('title', 'Products Report')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-serif text-black">Products Report</h1>
            <p class="text-sm text-gray-500 mt-1">Inventory status and product performance</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:text-black transition-colors">
            <i class="ri-arrow-left-line"></i> Back to Reports
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Best Sellers -->
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-black/5 flex justify-between items-center">
                <h3 class="text-lg font-serif">Top 10 Best Sellers</h3>
                <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-lg">By Quantity</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3 font-medium">Product</th>
                            <th class="px-6 py-3 font-medium text-right">Sold</th>
                            <th class="px-6 py-3 font-medium text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-black/5">
                        @forelse($bestSellers as $index => $item)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-3 font-medium text-black flex items-center gap-3">
                                <span class="text-gray-400 font-mono text-xs">#{{ $index + 1 }}</span>
                                {{ $item->product_name }}
                            </td>
                            <td class="px-6 py-3 text-right font-medium text-gray-700">{{ $item->total_qty }}</td>
                            <td class="px-6 py-3 text-right font-medium text-black">${{ number_format($item->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No sales data yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-black/5 flex justify-between items-center bg-red-50/30">
                <h3 class="text-lg font-serif text-red-700">Low Stock Alerts</h3>
                <span class="px-2 py-1 bg-red-50 text-red-700 text-xs font-medium rounded-lg">Quantity <= 10</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3 font-medium">Product</th>
                            <th class="px-6 py-3 font-medium text-right">Current Stock</th>
                            <th class="px-6 py-3 font-medium text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-black/5">
                        @forelse($lowStockProducts as $product)
                        <tr class="hover:bg-red-50/10">
                            <td class="px-6 py-3 font-medium text-black">{{ $product->name }}</td>
                            <td class="px-6 py-3 text-right font-bold {{ $product->stock_quantity == 0 ? 'text-red-600' : 'text-orange-600' }}">
                                {{ $product->stock_quantity }}
                            </td>
                            <td class="px-6 py-3 text-right">
                                @if($product->stock_quantity == 0)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">Out of Stock</span>
                                @else
                                    <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-medium">Low Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">All products are well stocked.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
