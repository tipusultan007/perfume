@extends('admin.layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">New Campaign</h1>
            <p class="text-slate-500 font-medium mt-1">Compose your message and select your target audience</p>
        </div>
        <a href="{{ route('admin.newsletter.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-10">
        @if ($errors->any())
            <div class="mb-10 bg-rose-50 border border-rose-100 text-rose-600 p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-3">
                    <i class="ri-error-warning-fill text-xl"></i>
                    <span class="text-xs font-bold uppercase tracking-widest">Action Required</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.newsletter.store') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="space-y-10">
                <!-- Subject -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Email Subject Line</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold"
                        placeholder="e.g. Discover our New Winter Collection" required>
                    @error('subject') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Content -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Campaign Content</label>
                    <textarea name="content" rows="12"
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium leading-relaxed"
                        placeholder="Write your email content here (HTML supported)..." required>{{ old('content') }}</textarea>
                    <div class="flex items-center gap-2 text-slate-400">
                        <i class="ri-information-line"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Basic HTML tags are allowed. An unsubscribe link will be automatically appended.</p>
                    </div>
                    @error('content') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Recipients -->
                <div class="space-y-6">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Target Audience</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-5 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-50 transition-all group">
                            <input type="radio" name="recipient_type" value="all" {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }}
                                onchange="toggleSubscribersList(false)" class="w-4 h-4 text-slate-900 focus:ring-slate-900 border-slate-300">
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-900">Broadcast to All</span>
                                <span class="text-xs text-slate-400 font-medium">All {{ $subscribers->count() }} active subscribers</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-5 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-50 transition-all group">
                            <input type="radio" name="recipient_type" value="select" {{ old('recipient_type') == 'select' ? 'checked' : '' }}
                                onchange="toggleSubscribersList(true)" class="w-4 h-4 text-slate-900 focus:ring-slate-900 border-slate-300">
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-900">Targeted Selection</span>
                                <span class="text-xs text-slate-400 font-medium">Select specific subscribers manually</span>
                            </div>
                        </label>
                    </div>
                    @error('recipient_type') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror

                    <div id="subscribersList" class="transition-all duration-300 {{ old('recipient_type') == 'select' ? 'block' : 'hidden' }}">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                            <div class="max-h-80 overflow-y-auto pr-4 custom-scrollbar">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($subscribers as $subscriber)
                                    <label class="flex items-center gap-4 p-4 bg-white border border-slate-100 rounded-xl cursor-pointer hover:border-slate-900 transition-all group shadow-sm">
                                        <input type="checkbox" name="recipients[]" value="{{ $subscriber->id }}" 
                                            class="subscriber-checkbox w-4 h-4 text-slate-900 focus:ring-slate-900 border-slate-300 rounded" 
                                            {{ (is_array(old('recipients')) && in_array($subscriber->id, old('recipients'))) ? 'checked' : '' }}
                                            {{ old('recipient_type') == 'select' ? '' : 'disabled' }}>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900">{{ $subscriber->email }}</span>
                                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-tight">Joined {{ $subscriber->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('recipients') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Actions -->
                <div class="pt-10 flex flex-col md:flex-row justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('admin.newsletter.index') }}" 
                        class="px-10 py-4 bg-slate-50 border border-slate-200 text-slate-600 text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-slate-200 transition-all text-center">
                        Discard
                    </a>
                    <button type="submit" class="px-10 py-4 bg-slate-900 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-slate-800 transition-all shadow-xl hover:shadow-slate-900/20 active:scale-[0.98]">
                        <i class="ri-save-line mr-2"></i> Save Campaign Draft
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleSubscribersList(show) {
        const list = document.getElementById('subscribersList');
        const checkboxes = document.querySelectorAll('.subscriber-checkbox');

        if (show) {
            list.classList.remove('hidden');
            list.classList.add('block');
            checkboxes.forEach(cb => cb.disabled = false);
        } else {
            list.classList.add('hidden');
            list.classList.remove('block');
            checkboxes.forEach(cb => cb.disabled = true);
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection
