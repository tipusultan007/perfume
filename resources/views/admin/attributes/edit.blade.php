@extends('admin.layouts.app')

@section('title', 'Edit Attribute')
@section('page_title', 'Update Attribute')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.attributes.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-bold text-2xl text-slate-900">Edit Attribute: <span class="text-slate-400 font-medium">{{ $attribute->name }}</span></h3>
    </div>

    <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
        <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Attribute Name</label>
                <input type="text" name="name" value="{{ old('name', $attribute->name) }}" required
                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                @error('name')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-4 text-slate-500 font-bold tracking-widest">Attribute Values</label>
                <div id="values-container" class="space-y-3">
                    @foreach($attribute->values as $index => $val)
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="values[]" value="{{ $val->value }}" required
                                class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <button type="button" @if($index > 0) onclick="this.parentElement.remove()" @endif 
                            class="w-12 h-12 flex items-center justify-center rounded-lg transition-all shadow-sm {{ $index == 0 ? 'bg-slate-50 text-slate-200 cursor-not-allowed' : 'bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white' }}">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addValueField()" class="mt-6 px-4 py-2 bg-slate-50 border border-slate-200 text-[10px] uppercase tracking-widest text-slate-600 font-bold rounded-lg hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all flex items-center shadow-sm">
                    <i class="ri-add-line mr-2 text-sm"></i> Add Another Value
                </button>
                @error('values')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-100 mt-10">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                    Update Attribute
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function addValueField() {
        const container = document.getElementById('values-container');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3 group animate-in slide-in-from-top-2 duration-300';
        div.innerHTML = `
            <div class="relative flex-1">
                <input type="text" name="values[]" required placeholder="Value"
                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="w-12 h-12 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all shadow-sm">
                <i class="ri-delete-bin-line text-lg"></i>
            </button>
        `;
        container.appendChild(div);
    }
</script>
@endsection
