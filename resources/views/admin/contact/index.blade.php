@extends('admin.layouts.app')

@section('title', 'Contact Submissions')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Contact Inquiries</h1>
            <p class="text-slate-500 font-medium mt-1">Manage and respond to customer messages and support tickets</p>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col transition-all">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
            <h3 class="text-lg font-bold text-slate-900">Inbox</h3>
            <span class="px-3 py-1 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-sm">
                {{ $submissions->total() }} total inquiries
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5">Sender</th>
                        <th class="px-8 py-5">Contact Details</th>
                        <th class="px-8 py-5">Subject</th>
                        <th class="px-8 py-5">Received At</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($submissions as $submission)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-4">
                            @if($submission->status === 'unread')
                                <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm">
                                    New
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-500 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                    Read
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4 font-bold text-slate-900">{{ $submission->name }}</td>
                        <td class="px-8 py-4 text-slate-500 font-medium">{{ $submission->email }}</td>
                        <td class="px-8 py-4">
                            <span class="text-slate-900 font-bold">{{ $submission->subject ?? 'General Inquiry' }}</span>
                        </td>
                        <td class="px-8 py-4 text-slate-500 font-medium text-xs">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.contact-submissions.show', $submission->id) }}" 
                                    class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-lg transition-all shadow-sm" 
                                    title="View Message">
                                    <i class="ri-eye-line text-lg"></i>
                                </a>
                                <button onclick="confirmDelete('{{ $submission->id }}')" 
                                    class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all shadow-sm" 
                                    title="Delete Submission">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                                <form id="delete-form-{{ $submission->id }}" action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                    <i class="ri-inbox-line text-3xl text-slate-200"></i>
                                </div>
                                <p>No inquiries found in your inbox</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($submissions->hasPages())
        <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id) {
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
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
