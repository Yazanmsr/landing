@extends('adminlte::page')

@section('title', 'My Projects')

@section('content_header')
    <h1>My Projects</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Form إنشاء مشروع جديد --}}

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- AdminLTE CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<div class="card mb-4">
    <div class="card-header">Create New Project</div>
    <div class="card-body">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label>Type</label>
                    <select name="type" class="form-control" required>
                        <option value="landing_page">Landing Page</option>
                        <option value="cv">CV</option>
                        <option value="website">Website</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="example: my-page" required>
                </div>
                <div class="col-md-3">
                    <label>Content</label>
                    <input type="text" name="content" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
</div>

{{-- جدول المشاريع --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Type</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
        <tr>
            <td>{{ $project->type }}</td>
            <td>{{ $project->title }}</td>
            <td>{{ $project->slug }}</td>
            <td>{{ $project->status }}</td>
            <td>
                {{-- تعديل --}}
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $project->id }}">Edit</button>
                {{-- حذف --}}
                <form action="{{ route('pages.delete', $project) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
                <a href="{{ route('projects.show.public', ['user_id' => $project->user_id, 'slug' => $project->slug]) }}" target="_blank" class="btn btn-sm btn-info">View Public</a>

                {{-- Modal تعديل --}}
                <div class="modal fade" id="editModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('pages.update', $project) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Project</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          @method('POST')
                          <div class="mb-2">
                              <label>Type</label>
                              <select name="type" class="form-control" required>
                                  <option value="landing_page" {{ $project->type=='landing_page'?'selected':'' }}>Landing Page</option>
                                  <option value="cv" {{ $project->type=='cv'?'selected':'' }}>CV</option>
                                  <option value="website" {{ $project->type=='website'?'selected':'' }}>Website</option>
                              </select>
                          </div>
                          <div class="mb-2">
                              <label>Title</label>
                              <input type="text" name="title" class="form-control" value="{{ $project->title }}" required>
                          </div>
                          <div class="mb-2">
                              <label>Slug</label>
                              <input type="text" name="slug" class="form-control" value="{{ $project->slug }}" required>
                          </div>
                          <div class="mb-2">
                              <label>Content</label>
                              <textarea name="content" class="form-control">{{ $project->content }}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
