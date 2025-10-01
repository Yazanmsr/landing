@extends('adminlte::page')

@section('title', 'User Dashboard')

@section('content_header')
    <h1>Create Your Page</h1>
@stop

@section('content')
<p>Welcome, {{ $user->name }}</p>

<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="type" class="form-label">Page Type</label>
        <select name="type" id="type" class="form-control" required>
            <option value="landing_page">Landing Page</option>
            <option value="cv">CV</option>
            <option value="website">Website</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Page Title</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label">URL Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" placeholder="example: yazan-rababah" required>
        <small>URL will be like: domain.com/user/{{ $user->id }}/slug</small>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content / Info</label>
        <textarea name="content" id="content" class="form-control" rows="5" placeholder="Enter your information"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Create Page</button>
</form>
@stop
