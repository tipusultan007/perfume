@extends('admin.layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-serif text-black">New Campaign</h1>
            <p class="text-sm text-gray-500 mt-1">Compose and send email to all subscribers</p>
        </div>
        <a href="{{ route('admin.newsletter.index') }}" class="text-sm text-gray-500 hover:text-black transition-colors">
            <i class="ri-arrow-left-line"></i> Back to list
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-8">
        @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.newsletter.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-black focus:ring-0 transition-colors"
                        placeholder="Enter email subject" required>
                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content" id="content" rows="12"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-black focus:ring-0 transition-colors"
                        placeholder="Write your email content here (HTML supported)..." required>{{ old('content') }}</textarea>
                    <p class="text-xs text-gray-400 mt-2">Basic HTML tags are allowed. An unsubscribe link will be automatically appended.</p>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Recipients -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recipient_type" value="all" {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }}
                                onchange="toggleSubscribersList(false)" class="text-black focus:ring-black">
                            <span>All Subscribers ({{ $subscribers->count() }})</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="recipient_type" value="select" {{ old('recipient_type') == 'select' ? 'checked' : '' }}
                                onchange="toggleSubscribersList(true)" class="text-black focus:ring-black">
                            <span>Select Subscribers</span>
                        </label>
                    </div>
                    @error('recipient_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div id="subscribersList" class="{{ old('recipient_type') == 'select' ? '' : 'hidden' }} mt-4 pl-6 space-y-2 max-h-60 overflow-y-auto border border-gray-100 p-4 rounded-xl">
                        @foreach($subscribers as $subscriber)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="recipients[]" value="{{ $subscriber->id }}" 
                                class="subscriber-checkbox text-black focus:ring-black" 
                                {{ (is_array(old('recipients')) && in_array($subscriber->id, old('recipients'))) ? 'checked' : '' }}
                                {{ old('recipient_type') == 'select' ? '' : 'disabled' }}>
                            <span class="text-sm">{{ $subscriber->email }} <span class="text-xs text-gray-400">({{ $subscriber->created_at->format('M d, Y') }})</span></span>
                        </label>
                        @endforeach
                    </div>
                    @error('recipients') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Actions -->
                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.newsletter.index') }}" class="px-6 py-3 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-black text-white text-sm font-medium rounded-xl hover:bg-gray-900 transition-colors shadow-lg shadow-black/10">
                        <i class="ri-save-line mr-2"></i> Save Draft
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
            checkboxes.forEach(cb => cb.disabled = false);
        } else {
            list.classList.add('hidden');
            checkboxes.forEach(cb => cb.disabled = true);
        }
    }
</script>
@endsection
