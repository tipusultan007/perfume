@extends('admin.layouts.app')

@section('title', 'Customers')
@section('page_title', 'Customers')

@section('content')
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <!-- Header/Search -->
    <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3 max-w-md w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." 
                class="w-full px-5 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
            <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-lg text-[11px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg">Search</button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                    <th class="px-8 py-6">ID</th>
                    <th class="px-8 py-6">Name</th>
                    <th class="px-8 py-6">Email</th>
                    <th class="px-8 py-6">Joined Date</th>
                    <th class="px-8 py-6 text-center">Total Orders</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($customers as $customer)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6 text-slate-400 font-mono text-xs">#{{ $customer->id }}</td>
                    <td class="px-8 py-6 font-bold text-slate-900">{{ $customer->name }}</td>
                    <td class="px-8 py-6 text-slate-600 font-medium">{{ $customer->email }}</td>
                    <td class="px-8 py-6 text-slate-500 text-xs font-semibold">{{ $customer->created_at->format('M d, Y') }}</td>
                    <td class="px-8 py-6 text-center">
                        @if($customer->orders_count > 0)
                            <span class="inline-flex items-center justify-center bg-slate-900 text-white w-8 h-8 rounded-full text-xs font-bold shadow-md">{{ $customer->orders_count }}</span>
                        @else
                            <span class="text-slate-300 font-medium">-</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.customers.show', $customer) }}" 
                                class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-lg transition-all shadow-sm group/btn" 
                                title="View Details">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this customer?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all shadow-sm" 
                                    title="Delete Customer">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                                <i class="ri-user-search-line text-4xl text-slate-200"></i>
                            </div>
                            <p class="text-sm font-bold uppercase tracking-widest">No customers found</p>
                            <p class="text-xs text-slate-400 -mt-2">Try adjusting your search criteria</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div class="p-8 border-t border-slate-100 bg-slate-50/30">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
