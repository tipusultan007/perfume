@extends('admin.layouts.app')

@section('title', 'Edit Attribute')
@section('page_title', 'Update Attribute')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.attributes.index') }}" class="w-10 h-10 border border-black/5 flex items-center justify-center hover:bg-black hover:text-white transition-all">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-serif text-xl">Edit Attribute: {{ $attribute->name }}</h3>
    </div>

    <div class="bg-white border border-black/5 p-10">
        <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Attribute Name</label>
                <input type="text" name="name" value="{{ old('name', $attribute->name) }}" required
                    class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                @error('name')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Attribute Values</label>
                <div id="values-container" class="space-y-4">
                    @foreach($attribute->values as $index => $val)
                    <div class="flex items-center gap-4">
                        <input type="text" name="values[]" value="{{ $val->value }}" required
                            class="flex-1 py-3 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        <button type="button" @if($index > 0) onclick="this.parentElement.remove()" @endif 
                            class="w-10 h-10 flex items-center justify-center text-red-300 {{ $index == 0 ? 'opacity-0 cursor-default' : 'hover:text-red-500 transition-colors' }}">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addValueField()" class="mt-6 text-[10px] uppercase tracking-widest text-luxury-accent hover:text-luxury-black transition-colors flex items-center">
                    <i class="ri-add-line mr-1"></i> Add Another Value
                </button>
                @error('values')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
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
        div.className = 'flex items-center gap-4 animate-in fade-in slide-in-from-top-1';
        div.innerHTML = `
            <input type="text" name="values[]" required placeholder="Value"
                class="flex-1 py-3 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
            <button type="button" onclick="this.parentElement.remove()" class="w-10 h-10 flex items-center justify-center text-red-300 hover:text-red-500 transition-colors"><i class="ri-delete-bin-line"></i></button>
        `;
        container.appendChild(div);
    }
</script>
@endsection
