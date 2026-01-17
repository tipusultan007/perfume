@extends('admin.layouts.app')

@section('title', 'Customers')
@section('page_title', 'Customers')

@section('content')
<div class="bg-white border border-black/10">
    <!-- Header/Search -->
    <div class="p-6 border-b border-black/10 flex justify-between items-center bg-gray-50/30">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-2 max-w-md w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full py-2 px-4 border border-black/10 focus:border-luxury-black outline-none text-xs tracking-wider">
            <button type="submit" class="bg-luxury-black text-white px-6 py-2 text-xs uppercase tracking-widest hover:bg-black/80 transition-colors">Search</button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-black/10 text-[10px] uppercase tracking-widest text-black/60 bg-gray-50/50">
                    <th class="p-6 font-medium">ID</th>
                    <th class="p-6 font-medium">Name</th>
                    <th class="p-6 font-medium">Email</th>
                    <th class="p-6 font-medium">Joined</th>
                    <th class="p-6 font-medium text-center">Orders</th>
                    <th class="p-6 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($customers as $customer)
                <tr class="border-b border-black/5 hover:bg-gray-50/30 transition-colors group">
                    <td class="p-6 text-black/50 mono">#{{ $customer->id }}</td>
                    <td class="p-6 font-medium">{{ $customer->name }}</td>
                    <td class="p-6 text-black/60">{{ $customer->email }}</td>
                    <td class="p-6 text-black/50 text-xs">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="p-6 text-center">
                        @if($customer->orders_count > 0)
                            <span class="inline-flex items-center justify-center bg-green-50 text-green-700 px-2 py-1 rounded text-xs font-medium">{{ $customer->orders_count }}</span>
                        @else
                            <span class="text-black/30">-</span>
                        @endif
                    </td>
                    <td class="p-6 text-right">
                        <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-black hover:text-luxury-black" title="View Details">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600" title="Delete Customer">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-black/40">
                        <div class="flex flex-col items-center gap-2">
                            <i class="ri-user-search-line text-3xl mb-2"></i>
                            <p class="text-sm">No customers found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div class="p-6 border-t border-black/10">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
