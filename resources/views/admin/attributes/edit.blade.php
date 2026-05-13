@extends('admin.layouts.app')

@section('title', 'Edit Attribute')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">Attributes</a></li>
                        <li class="breadcrumb-item active">Edit Attribute</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Attribute: {{ $attribute->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Update Details</h5>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Attribute Name</label>
                            <input type="text" name="name" value="{{ old('name', $attribute->name) }}" required
                                class="form-control form-control-lg fs-14">
                            @error('name')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold d-block border-bottom pb-2 mb-3">Attribute Values</label>
                            <div id="values-container">
                                @foreach($attribute->values as $index => $val)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="text" name="values[]" value="{{ $val->value }}" required
                                        class="form-control fs-14">
                                    <button type="button" @if($index > 0) onclick="this.parentElement.remove()" @endif 
                                        class="btn {{ $index == 0 ? 'btn-soft-secondary disabled' : 'btn-soft-danger' }}" style="width: 45px; height: 38px;">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            
                            <button type="button" onclick="addValueField()" class="btn btn-soft-dark btn-sm mt-2 fw-bold text-uppercase fs-10 tracking-widest">
                                <i class="ri-add-line me-1"></i> Add Another Value
                            </button>
                            
                            @error('values')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="btn btn-dark w-100 py-3 text-uppercase tracking-widest fs-11 fw-bold shadow-lg">
                                <i class="ri-refresh-line me-1"></i> Update Attribute
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function addValueField() {
        const container = document.getElementById('values-container');
        const div = document.createElement('div');
        div.className = 'd-flex align-items-center gap-2 mb-2 animate__animated animate__fadeInDown animate__faster';
        div.innerHTML = `
            <input type="text" name="values[]" required placeholder="Value" class="form-control fs-14">
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-soft-danger" style="width: 45px; height: 38px;">
                <i class="ri-delete-bin-line"></i>
            </button>
        `;
        container.appendChild(div);
    }
</script>
<style>
    .btn-soft-secondary.disabled {
        opacity: .5;
        cursor: not-allowed;
    }
</style>
@endsection
