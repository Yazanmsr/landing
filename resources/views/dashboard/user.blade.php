@extends('adminlte::page')

@section('title', isset($project) ? 'Edit Page' : 'Create Page')

@section('content_header')
    <h1>{{ isset($project) ? 'Edit Your Page' : 'Create Your Page' }}</h1>
@stop

@section('content')
<p>Welcome, {{ $user->name }}</p>

@php
    $oldFields = old() ?: [];
    if(isset($project)) {
        $oldFields = array_merge($oldFields, $project->toArray());

        // CV Entry
        if($project->type === 'cv' && $project->cvEntry) {
            $oldFields = array_merge($oldFields, $project->cvEntry->toArray());
        }

        // Landing Page Entry
        if($project->type === 'landing_page' && isset($project->landingPage)) {
            $oldFields = array_merge($oldFields, $project->landingPage->toArray());
        }
    }
@endphp

<form action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($project))
        @method('PUT')
    @endif

    {{-- Page Type --}}
    <div class="mb-3">
        <label for="type" class="form-label">Page Type</label>
        <select name="type" id="type" class="form-control" required>
            <option value="">-- Select Type --</option>
            <option value="landing_page" {{ ($oldFields['type'] ?? '') == 'landing_page' ? 'selected' : '' }}>Landing Page</option>
            <option value="cv" {{ ($oldFields['type'] ?? '') == 'cv' ? 'selected' : '' }}>CV</option>
          <!--  <option value="website" {{ ($oldFields['type'] ?? '') == 'website' ? 'selected' : '' }}>Website</option>-->
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

    {{-- Extra Fields --}}
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
                <label>Skills </label>
                <textarea name="skills" class="form-control" rows="5" placeholder='["PHP","Laravel","React"]'>${old.skills ?? ''}</textarea>
            </div>
            <div class="mb-3">
                <label>Work Experience</label>
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
            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="${old.phone_number ?? ''}" placeholder="e.g. +9627XXXXXXXX">
            </div>
        `;
    } else if(type === 'landing_page') {
        container.innerHTML = `
            <div class="mb-3">
                <label>Header Title (H1)</label>
                <input type="text" name="header_title" class="form-control" value="${old.title ?? ''}">
            </div>
            <div class="mb-3">
                <label>Header Description</label>
                <textarea name="header_description" class="form-control">${old.description ?? ''}</textarea>
            </div>
            <div class="mb-3">
                <label>Header Image</label>
                <input type="file" name="header_image" class="form-control">
                ${old.image ? `<p>Current Image: <img src="/storage/${old.image}" width="100"></p>` : ''}
            </div>
            <div class="mb-3">
                <label>Main Button Text</label>
                <input type="text" name="cta_text" class="form-control" value="${old.button_text ?? ''}">
            </div>
            <div class="mb-3">
                <label>Main Button Link</label>
                <input type="url" name="cta_link" class="form-control" value="${old.button_link ?? ''}">
            </div>

            <hr>
            <h4>About Section</h4>
            <div class="mb-3">
                <label>About Title (H2)</label>
                <input type="text" name="about_title" class="form-control" value="${old.about_title ?? ''}">
            </div>
            <div class="mb-3">
                <label>About Description</label>
                <textarea name="about_description" class="form-control">${old.about_description ?? ''}</textarea>
            </div>

            <hr>
            <h4>Services Section</h4>
            <div class="mb-3">
                <label>Services Heading (H2)</label>
                <input type="text" name="services_heading" class="form-control" value="${old.services_heading ?? 'خدماتي'}">
            </div>

            ${[1,2,3].map(i => `
                <div class="mb-3">
                    <label>Service ${i} Title</label>
                    <input type="text" name="service${i}_title" class="form-control" value="${old[`service${i}_title`] ?? ''}">
                </div>
                <div class="mb-3">
                    <label>Service ${i} Description</label>
                    <textarea name="service${i}_description" class="form-control">${old[`service${i}_description`] ?? ''}</textarea>
                </div>
            `).join('')}
        `;
    } else if(type === 'website') {
        container.innerHTML = `
            <div class="mb-3">
                <label>Homepage Title</label>
                <input type="text" name="homepage_title" class="form-control" value="${old.homepage_title ?? ''}">
            </div>
            <div class="mb-3">
                <label>Navigation Links </label>
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
