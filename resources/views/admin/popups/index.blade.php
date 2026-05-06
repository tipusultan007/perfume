@extends('admin.layouts.app')

@section('title', 'Manage Popups')
@section('page_title', 'Popups')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-bold text-2xl text-slate-900">Popups</h3>
    <a href="{{ route('admin.popups.create') }}" class="px-6 py-3 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg shadow-xl hover:bg-slate-800 transition-all">
        Add New Popup
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-6 mb-10 rounded-xl border border-emerald-100 shadow-sm flex items-center space-x-3">
        <i class="ri-checkbox-circle-line text-xl"></i>
        <span class="text-[11px] uppercase tracking-widest font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Image</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Title / Link</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Schedule</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Status</th>
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($popups as $popup)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <div class="w-24 h-14 rounded-lg border border-slate-100 overflow-hidden bg-white shadow-sm transition-transform group-hover:scale-105">
                            @if($popup->hasMedia('popup'))
                                <img src="{{ $popup->getFirstMediaUrl('popup') }}" alt="Popup Image" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300">
                                    <i class="ri-image-line"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-6">
                        <div class="font-bold text-slate-900 group-hover:text-slate-700 transition-colors">{{ $popup->title }}</div>
                        <div class="text-[10px] text-slate-400 font-bold mt-1 truncate max-w-xs">{{ $popup->link }}</div>
                    </td>
                    <td class="py-6">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Start: {{ $popup->start_date ? $popup->start_date->format('M d, Y H:i') : 'Immediate' }}</span>
                            <span class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">End: {{ $popup->end_date ? $popup->end_date->format('M d, Y H:i') : 'Never' }}</span>
                        </div>
                    </td>
                    <td class="py-6">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                class="sr-only peer status-toggle" 
                                data-id="{{ $popup->id }}"
                                data-url="{{ route('admin.popups.toggle-status', $popup) }}"
                                {{ $popup->is_active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                        </label>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('admin.popups.edit', $popup) }}" 
                                class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-slate-900 hover:border-slate-900 hover:shadow-lg transition-all shadow-sm">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.popups.destroy', $popup) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white hover:shadow-lg transition-all shadow-sm">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="ri-notification-badge-line text-3xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-400 text-[11px] uppercase tracking-widest font-bold">No popups discovered</p>
                            <a href="{{ route('admin.popups.create') }}" class="mt-4 text-[10px] text-slate-900 font-bold uppercase tracking-widest hover:underline">Create your first popup</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const url = this.getAttribute('data-url');
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: result.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    this.checked = !this.checked; // Revert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status.',
                        toast: true,
                        position: 'top-end'
                    });
                }
            } catch (error) {
                this.checked = !this.checked; // Revert
                console.error('Toggle error:', error);
            }
        });
    });
</script>
@endsection
