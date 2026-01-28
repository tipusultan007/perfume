@extends('admin.layouts.app')

@section('title', 'Notifications Archive')
@section('page_title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-slate-900">Communication Center</h3>
            <p class="text-sm text-slate-500 mt-1">Manage your atelier's real-time alerts and history.</p>
        </div>
        
        @if(auth('admin')->user()->unreadNotifications->count() > 0)
            <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 bg-white border border-slate-200 text-[10px] font-bold uppercase tracking-widest text-slate-600 hover:bg-slate-900 hover:text-white transition-all rounded-xl shadow-sm flex items-center gap-2">
                    <i class="ri-check-double-line text-sm"></i> Mark All as Read
                </button>
            </form>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notif)
            <div class="bg-white border {{ $notif->read_at ? 'border-slate-100 opacity-70' : 'border-slate-200 shadow-sm' }} rounded-2xl p-6 transition-all hover:border-luxury-accent group relative overflow-hidden">
                @if(!$notif->read_at)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-luxury-accent"></div>
                @endif
                
                <div class="flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-xl {{ $notif->read_at ? 'bg-slate-50 text-slate-400' : 'bg-luxury-cream text-luxury-accent' }} flex items-center justify-center flex-shrink-0 transition-colors">
                        <i class="ri-{{ $notif->data['type'] == 'order_success' ? 'shopping-cart-2-line' : 'notification-3-line' }} text-xl"></i>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest {{ $notif->read_at ? 'text-slate-400' : 'text-luxury-accent' }}">
                                {{ $notif->data['type'] == 'order_success' ? 'Sales Inquiry' : 'System Update' }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400 uppercase">{{ $notif->created_at->format('M d, H:i') }} ({{ $notif->created_at->diffForHumans() }})</span>
                        </div>
                        
                        <p class="text-sm font-bold text-slate-900 leading-relaxed mb-4">{{ $notif->data['message'] }}</p>
                        
                        <div class="flex items-center gap-4">
                            @if(isset($notif->data['order_id']))
                                <a href="{{ route('admin.orders.show', $notif->data['order_id']) }}" class="text-[10px] font-bold uppercase tracking-widest text-slate-600 hover:text-black flex items-center gap-1.5 transition-colors">
                                    <i class="ri-external-link-line"></i> View Order Details
                                </a>
                            @endif
                            
                            @if(!$notif->read_at)
                                <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-luxury-accent hover:underline flex items-center gap-1.5">
                                        <i class="ri-check-line"></i> Mark as Read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-3xl p-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ri-notification-off-line text-3xl text-slate-200"></i>
                </div>
                <h4 class="font-bold text-slate-900 uppercase tracking-widest text-sm mb-2">No notifications found</h4>
                <p class="text-xs text-slate-500 max-w-xs mx-auto">Your communication channel is currently quiet. Everything is running smoothly.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
