@extends('admin.layouts.app')

@section('title', 'Import Products')
@section('page_title', 'Import Products')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-6">
            <h3 class="font-bold text-xl text-slate-900">Import from Excel/CSV</h3>
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-slate-50 border border-slate-200 flex items-center justify-center rounded-lg hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                <i class="ri-arrow-left-line"></i>
            </a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 text-rose-600 p-6 mb-10 rounded-xl border border-rose-100 shadow-sm">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-10">
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Select File (Excel or CSV)</label>
                <div class="relative">
                    <input type="file" name="file" id="file" required
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-lg focus:border-slate-900 outline-none transition-all text-sm text-slate-900">
                </div>
                <p class="mt-3 text-[10px] text-slate-400 font-medium italic">Supported formats: .xlsx, .xls, .csv (Max 10MB)</p>
            </div>

            <div class="bg-slate-50 rounded-xl p-8 mb-10 border border-slate-100">
                <h4 class="text-[10px] uppercase tracking-widest font-bold text-slate-900 mb-5 border-b border-slate-200 pb-3">File Requirements</h4>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">Your file must contain the following headers in the first row:</p>
                <div class="flex flex-wrap gap-2">
                    @php
                        $headers = ['Brand', 'Name', 'Size', 'Gender', 'Notes', 'Description', 'Concentration', 'Season', 'Top Notes', 'Heart Notes', 'Base Notes', 'Intensity'];
                    @endphp
                    @foreach($headers as $header)
                        <span class="px-3 py-1 bg-white border border-slate-200 rounded text-[10px] font-bold text-slate-900">{{ $header }}</span>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                Start Import Process
            </button>
        </form>
    </div>
</div>
@endsection
