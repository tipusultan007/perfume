@extends('admin.layouts.app')

@section('title', 'View Submission')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.contact-submissions.index') }}" 
                class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                <i class="ri-arrow-left-line text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">View Submission</h1>
                <p class="text-slate-500 font-medium mt-1">Received from {{ $submission->name }} &bull; {{ $submission->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="confirmDelete()" 
                class="px-8 py-3.5 text-[11px] font-bold uppercase tracking-widest text-white bg-rose-500 rounded-xl hover:bg-rose-600 transition-all shadow-lg hover:shadow-rose-500/20 active:scale-[0.98]">
                Delete Submission
            </button>
            <form id="delete-form" action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <!-- Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <!-- Message Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-10 group">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-slate-100">
                    <div class="w-1.5 h-6 bg-slate-900 rounded-full"></div>
                    <h2 class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">Message Content</h2>
                </div>
                
                <div class="space-y-10">
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-3">Topic / Subject</span>
                        <p class="text-2xl font-bold text-slate-900 tracking-tight leading-tight">{{ $submission->subject ?? 'No Subject Specified' }}</p>
                    </div>

                    <div class="relative">
                        <span class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-4">Original Message</span>
                        <div class="text-slate-700 text-lg leading-relaxed whitespace-pre-wrap bg-slate-50/50 p-10 rounded-2xl border border-slate-100 font-medium shadow-inner">
                            {{ $submission->message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-10">
            <!-- Sender Card -->
            <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm text-center">
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-24 flex items-center justify-center rounded-full bg-slate-900 border-8 border-slate-50 text-white text-3xl font-bold shadow-xl">
                        {{ strtoupper(substr($submission->name, 0, 1)) }}
                    </div>
                </div>
                
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-2">{{ $submission->name }}</h3>
                <p class="text-slate-500 font-medium text-sm mb-8">{{ $submission->email }}</p>
                
                <div class="grid grid-cols-1 gap-4">
                    <a href="mailto:{{ $submission->email }}" 
                        class="flex items-center justify-center gap-3 py-4 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20 active:scale-[0.98]">
                        <i class="ri-mail-send-line text-lg"></i>
                        Send Direct Reply
                    </a>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="bg-white p-10 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-8 flex items-center gap-3">
                    <i class="ri-information-line text-lg"></i> Submission Meta
                </h3>
                <div class="space-y-6">
                    <div class="flex justify-between items-center group">
                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest group-hover:text-slate-900 transition-colors">Received</span>
                        <span class="text-sm text-slate-900 font-bold">{{ $submission->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center group">
                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest group-hover:text-slate-900 transition-colors">Platform Status</span>
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border shadow-sm
                            {{ $submission->status === 'unread' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                            {{ $submission->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Delete Submission',
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
                document.getElementById('delete-form').submit();
            }
        })
    }
</script>
@endsection
