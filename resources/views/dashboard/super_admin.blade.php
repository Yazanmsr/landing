@extends('adminlte::page')

@section('title', 'Super Admin - Approve Pages')

@section('content_header')
    <h1>Pending Pages</h1>
@stop

@section('content')
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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
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
            <td>{{ $project->user->name }}</td>
            <td>{{ $project->type }}</td>
            <td>{{ $project->title }}</td>
            <td>{{ $project->slug }}</td>
            <td>{{ $project->status }}</td>
            <td>
                @if($project->status == 'pending')
                <form action="{{ route('projects.approve', $project) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button class="btn btn-sm btn-success">Approve</button>
                </form>
                <form action="{{ route('projects.reject', $project) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </form>
                @endif
            </td>
            

        </tr>
        @endforeach
    </tbody>
</table>
@stop
