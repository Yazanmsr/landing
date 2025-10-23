@extends('adminlte::page')

@section('title', 'My Pages')

@section('content_header')
    <h1>My Pages</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<table id="projectsTable" class="table table-bordered table-striped">
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
                <!-- Edit Button: direct to edit/create page -->
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>

                <!-- Delete Button -->
                <form action="{{ route('pages.delete', $project) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger delete-btn" data-title="{{ $project->title }}">
                        Delete
                    </button>
                </form>

                <!-- View Public -->
                <a href="{{ route('projects.show.public', ['user_id' => $project->user_id, 'slug' => $project->slug]) }}" target="_blank" class="btn btn-sm btn-info">View Public</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // تفعيل DataTables
    $('#projectsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

    // SweetAlert confirm
    document.querySelectorAll('.delete-btn').forEach(function(button){
        button.addEventListener('click', function(e){
            e.preventDefault();
            let form = this.closest('form');
            let title = this.getAttribute('data-title');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete your project: " + title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@stop
