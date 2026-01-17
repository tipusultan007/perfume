@extends('admin.layouts.app')

@section('title', 'Newsletter')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
        <div>
            <h1 class="text-2xl font-serif text-black">Newsletter</h1>
            <p class="text-sm text-gray-500 mt-1">Manage subscribers and campaigns</p>
        </div>
        <a href="{{ route('admin.newsletter.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-sm font-medium rounded-xl hover:bg-gray-900 transition-colors">
            <i class="ri-mail-send-line text-lg"></i>
            Create Campaign
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Subscribers List -->
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-6">
            <h2 class="text-lg font-serif mb-4">Latest Subscribers</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="py-3 font-medium">Email</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-black/5">
                        @forelse($subscribers as $subscriber)
                        <tr>
                            <td class="py-3 text-gray-900">{{ $subscriber->email }}</td>
                            <td class="py-3">
                                @if($subscriber->is_subscribed)
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">Subscribed</span>
                                @else
                                <span class="px-2 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-medium">Unsubscribed</span>
                                @endif
                            </td>
                            <td class="py-3 text-gray-500">{{ $subscriber->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No subscribers yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $subscribers->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Campaigns List -->
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-6">
            <h2 class="text-lg font-serif mb-4">Recent Campaigns</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="py-3 font-medium">Subject</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 font-medium">Sent At</th>
                            <th class="py-3 font-medium">Recipients</th>
                            <th class="py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-black/5">
                        @forelse($campaigns as $campaign)
                        <tr>
                            <td class="py-3 text-gray-900 font-medium">{{ $campaign->subject }}</td>
                            <td class="py-3">
                                @if($campaign->status === 'sent')
                                    <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">Sent</span>
                                @elseif($campaign->status === 'sending')
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium">Sending</span>
                                @elseif($campaign->status === 'error')
                                    <span class="px-2 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-medium">Error</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">Draft</span>
                                @endif
                            </td>
                            <td class="py-3 text-gray-500">{{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y H:i') : '-' }}</td>
                            <td class="py-3 text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <i class="ri-user-line"></i> {{ $campaign->recipient_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    @if($campaign->status === 'draft' || $campaign->status === 'error')
                                    <form action="{{ route('admin.newsletter.send', $campaign->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-luxury-accent hover:text-black transition-colors" title="Send Now" onclick="return confirm('Send this campaign?')">
                                            <i class="ri-send-plane-fill text-xl"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.newsletter.edit', $campaign->id) }}" class="text-gray-500 hover:text-black transition-colors" title="Edit">
                                        <i class="ri-edit-line text-xl"></i>
                                    </a>
                                    @endif
                                    
                                    <button onclick="confirmDelete('{{ $campaign->id }}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                        <i class="ri-delete-bin-line text-xl"></i>
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
                            <td colspan="5" class="py-4 text-center text-gray-500">No campaigns found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-black/5">
                {{ $campaigns->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
```
