@extends('adminlte::page')

@section('title', isset($project) ? 'Edit Page' : 'Create Page')

@section('content_header')
    <h1>{{ isset($project) ? 'Edit Your Page' : 'Create Your Page' }}</h1>
@stop

@section('content')
<p>Welcome, {{ $user->name }}</p>

@php
    // بيانات الحقول القديمة مع project و cvEntry
    $oldFields = old() ?: [];
    if(isset($project)) {
        $oldFields = array_merge($oldFields, $project->toArray());
        if($project->type === 'cv' && $project->cvEntry) {
            $oldFields = array_merge($oldFields, $project->cvEntry->toArray());
        }
    }
@endphp

<form action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($project))
        @method('PUT')
    @endif

    {{-- Type --}}
    <div class="mb-3">
        <label for="type" class="form-label">Page Type</label>
        <select name="type" id="type" class="form-control" required>
            <option value="">-- Select Type --</option>
            <option value="landing_page" {{ ($oldFields['type'] ?? '') == 'landing_page' ? 'selected' : '' }}>Landing Page</option>
            <option value="cv" {{ ($oldFields['type'] ?? '') == 'cv' ? 'selected' : '' }}>CV</option>
            <option value="website" {{ ($oldFields['type'] ?? '') == 'website' ? 'selected' : '' }}>Website</option>
        </select>
        @error('type') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    {{-- Title --}}
    <div class="mb-3">
        <label for="title" class="form-label">Page Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $oldFields['title'] ?? '' }}" required>
        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-3">
        <label for="slug" class="form-label">URL Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{ $oldFields['slug'] ?? '' }}" placeholder="example: yazan-rababah" required>
        <small>URL will be like: domain.com/user/{{ $user->id }}/slug</small>
        @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    {{-- Dynamic Fields --}}
    <div id="extra-fields"></div>

    <button type="submit" class="btn btn-primary mt-2">{{ isset($project) ? 'Update Page' : 'Create Page' }}</button>
</form>

<script>
function renderExtraFields(type, old = {}) {
    const container = document.getElementById('extra-fields');
    container.innerHTML = '';

    if(type === 'cv') {
        container.innerHTML = `
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="${old.name ?? ''}">
            </div>
            <div class="mb-3">
                <label>Headline</label>
                <input type="text" name="headline" class="form-control" value="${old.headline ?? ''}">
            </div>
            <div class="mb-3">
                <label>About</label>
                <textarea name="about" class="form-control">${old.about ?? ''}</textarea>
            </div>
            <div class="mb-3">
                <label>Profile Image</label>
                <input type="file" name="image" class="form-control">
                ${old.image ? `<p>Current Image: <img src="/storage/${old.image}" width="100"></p>` : ''}
            </div>
            <div class="mb-3">
                <label>Skills (JSON)</label>
                <textarea name="skills" class="form-control" rows="5" placeholder='["PHP","Laravel","React"]'>${old.skills ?? ''}</textarea>
            </div>
            <div class="mb-3">
                <label>Work Experience (JSON)</label>
                <textarea name="work_experience" class="form-control" rows="5" placeholder='[{"company":"ABC","role":"Dev"}]'>${old.work_experience ?? ''}</textarea>
            </div>
            <div class="mb-3">
                <label>Facebook URL</label>
                <input type="url" name="facebook_url" class="form-control" value="${old.facebook_url ?? ''}">
            </div>
            <div class="mb-3">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin_url" class="form-control" value="${old.linkedin_url ?? ''}">
            </div>
            <div class="mb-3">
                <label>WhatsApp Number</label>
                <input type="text" name="whatsapp_number" class="form-control" value="${old.whatsapp_number ?? ''}" placeholder="e.g. +9627XXXXXXXX">
            </div>
        `;
    } else if(type === 'landing_page') {
        container.innerHTML = `
            <div class="mb-3">
                <label>Headline</label>
                <input type="text" name="headline" class="form-control" value="${old.headline ?? ''}">
            </div>
            <div class="mb-3">
                <label>CTA Button Text</label>
                <input type="text" name="cta_text" class="form-control" value="${old.cta_text ?? ''}">
            </div>
            <div class="mb-3">
                <label>CTA Button Link</label>
                <input type="url" name="cta_link" class="form-control" value="${old.cta_link ?? ''}">
            </div>
        `;
    } else if(type === 'website') {
        container.innerHTML = `
            <div class="mb-3">
                <label>Homepage Title</label>
                <input type="text" name="homepage_title" class="form-control" value="${old.homepage_title ?? ''}">
            </div>
            <div class="mb-3">
                <label>Navigation Links (JSON)</label>
                <textarea name="nav_links" class="form-control" rows="5" placeholder='[{"label":"Home","url":"/"},{"label":"About","url":"/about"}]'>${old.nav_links ?? ''}</textarea>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const oldType = '{{ $oldFields["type"] ?? "" }}';
    if(oldType) {
        typeSelect.value = oldType;
        renderExtraFields(oldType, @json($oldFields));
    }
});

document.getElementById('type').addEventListener('change', function () {
    renderExtraFields(this.value, @json($oldFields));
});
</script>
@stop
