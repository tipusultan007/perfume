@extends('admin.layouts.app')

@section('title', 'Newsletter')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Newsletter</h1>
            <p class="text-slate-500 font-medium mt-1">Manage your subscriber base and email marketing campaigns</p>
        </div>
        <a href="{{ route('admin.newsletter.create') }}" class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3.5 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
            <i class="ri-mail-send-line text-lg"></i>
            Create Campaign
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Subscribers List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col transition-all">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-lg font-bold text-slate-900">Active Subscribers</h3>
                <span class="px-3 py-1 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-sm">{{ $subscribers->total() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                            <th class="px-8 py-5">Email Address</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5">Subscribed On</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($subscribers as $subscriber)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                            <td class="px-8 py-6 font-bold text-slate-900">{{ $subscriber->email }}</td>
                            <td class="px-8 py-6">
                                @if($subscriber->is_subscribed)
                                <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-600 px-3 py-1 border border-emerald-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Active</span>
                                @else
                                <span class="inline-flex items-center justify-center bg-rose-50 text-rose-500 px-3 py-1 border border-rose-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Unsubscribed</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-slate-500 font-medium text-xs">{{ $subscriber->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                        <i class="ri-user-add-line text-3xl text-slate-200"></i>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-widest">No subscribers found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
                {{ $subscribers->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Campaigns List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col transition-all">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-lg font-bold text-slate-900">Marketing Campaigns</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                            <th class="px-8 py-5">Campaign Name</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($campaigns as $campaign)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 text-base mb-1">{{ $campaign->subject }}</span>
                                    <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                        <span class="flex items-center gap-1.5"><i class="ri-user-follow-line"></i> {{ $campaign->recipient_count }} Recipients</span>
                                        <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                        <span>{{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y') : 'Draft Created' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($campaign->status === 'sent')
                                    <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-600 px-3 py-1 border border-emerald-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Sent</span>
                                @elseif($campaign->status === 'sending')
                                    <span class="inline-flex items-center justify-center bg-blue-50 text-blue-700 px-3 py-1 border border-blue-100 rounded-full text-[10px] uppercase tracking-widest font-bold animate-pulse">Sending</span>
                                @elseif($campaign->status === 'error')
                                    <span class="inline-flex items-center justify-center bg-rose-50 text-rose-500 px-3 py-1 border border-rose-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Failure</span>
                                @else
                                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-500 px-3 py-1 border border-slate-200 rounded-full text-[10px] uppercase tracking-widest font-bold">Draft</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-3 transition-all">
                                    @if($campaign->status === 'draft' || $campaign->status === 'error')
                                    <form action="{{ route('admin.newsletter.send', $campaign->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-lg transition-all shadow-sm" title="Send Now" onclick="return confirm('Launch this campaign?')">
                                            <i class="ri-send-plane-fill text-lg"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.newsletter.edit', $campaign->id) }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-lg transition-all shadow-sm" title="Edit">
                                        <i class="ri-edit-line text-lg"></i>
                                    </a>
                                    @endif
                                    
                                    <button onclick="confirmDelete('{{ $campaign->id }}')" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all shadow-sm" title="Delete">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                    <form id="delete-form-{{ $campaign->id }}" action="{{ route('admin.newsletter.destroy', $campaign->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                        <i class="ri-mail-line text-3xl text-slate-200"></i>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-widest">No campaigns created yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
                {{ $campaigns->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Campaign',
            text: "This action cannot be undone. Are you sure you want to proceed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-lg px-6 py-3 text-xs uppercase font-bold tracking-widest',
                cancelButton: 'rounded-lg px-6 py-3 text-xs uppercase font-bold tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
