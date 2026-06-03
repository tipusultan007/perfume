@extends('admin.layouts.app')

@section('title', 'Edit Email Template')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 400px; font-size: 14px; background: white; }
    .shortcode-badge { cursor: pointer; user-select: none; }
    .shortcode-badge:hover { background-color: #f3f4f6 !important; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.email-templates.index') }}">Email Templates</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Template: {{ ucwords(str_replace('_', ' ', $emailTemplate->name)) }}</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.email-templates.update', $emailTemplate) }}" method="POST" id="template-form">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <ul class="mb-0 fs-13">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Subject Line</label>
                            <input type="text" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required class="form-control form-control-lg fs-14">
                        </div>

                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold mb-2 d-block border-bottom pb-2">Email Body</label>
                            <div id="body-editor" class="bg-white">{!! old('body', $emailTemplate->body) !!}</div>
                            <input type="hidden" name="body" id="body-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-12 text-uppercase tracking-widest fw-bold shadow-lg mb-3">
                            <i class="ri-save-line me-1"></i> Save Changes
                        </button>
                        <button type="button" id="preview-btn" class="btn btn-info w-100 py-2 fs-12 text-uppercase tracking-widest fw-bold mb-3">
                            <i class="ri-eye-line me-1"></i> Preview Template
                        </button>
                        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-light w-100 py-2 fs-12 text-uppercase tracking-widest fw-bold">
                            Cancel
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm bg-light-subtle">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">Available Shortcodes</h5>
                        <p class="text-muted fs-11 mb-0 mt-1">Click to copy a shortcode and paste it into the editor.</p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @if(is_array($emailTemplate->variables))
                                @foreach($emailTemplate->variables as $variable)
                                    <span class="badge border border-secondary text-secondary p-2 fs-11 font-monospace shortcode-badge" onclick="copyShortcode(this, '{{ $variable }}')">
                                        {{ $variable }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted fs-12 italic">No specific shortcodes available.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill;
    if (!document.querySelector('#body-editor').classList.contains('ql-container')) {
        quill = new Quill('#body-editor', {
            theme: 'snow',
            placeholder: 'Enter email body content...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'clean']
                ]
            }
        });
    } else {
        // If already initialized by a global script, try to get the instance or just use DOM for body
        // But assuming we want our custom toolbar, we can clear existing toolbar and re-init
        var editor = document.querySelector('#body-editor');
        if (editor.previousElementSibling && editor.previousElementSibling.classList.contains('ql-toolbar')) {
            editor.previousElementSibling.remove();
        }
        editor.className = 'bg-white';
        editor.innerHTML = editor.querySelector('.ql-editor').innerHTML;
        
        quill = new Quill('#body-editor', {
            theme: 'snow',
            placeholder: 'Enter email body content...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'clean']
                ]
            }
        });
    }

    document.getElementById('template-form').onsubmit = function() {
        document.getElementById('body-input').value = quill.root.innerHTML;
    };

    document.getElementById('preview-btn').addEventListener('click', function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.email-templates.preview") }}';
        form.target = '_blank';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const bodyInput = document.createElement('input');
        bodyInput.type = 'hidden';
        bodyInput.name = 'body';
        bodyInput.value = quill.root.innerHTML;
        
        form.appendChild(csrfToken);
        form.appendChild(bodyInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    function copyShortcode(element, code) {
        navigator.clipboard.writeText(code).then(() => {
            const originalText = element.innerText;
            element.innerText = 'Copied!';
            element.classList.replace('text-secondary', 'text-success');
            element.classList.replace('border-secondary', 'border-success');
            setTimeout(() => {
                element.innerText = originalText;
                element.classList.replace('text-success', 'text-secondary');
                element.classList.replace('border-success', 'border-secondary');
            }, 1000);
        });
    }
</script>
@endsection
