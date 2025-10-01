@extends('adminlte::page')

@section('title', 'Super Admin - Approve Pages')

@section('content_header')
    <h1>Pending Pages</h1>
@stop

@section('content')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- AdminLTE CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<table id="projectsTable" class="table table-bordered table-striped">
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
                <form action="{{ route('projects.approve', $project) }}" method="POST" class="d-inline confirm-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success confirm-btn" data-action="approve" data-title="{{ $project->title }}">Approve</button>
                </form>

                <form action="{{ route('projects.reject', $project) }}" method="POST" class="d-inline confirm-form">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm confirm-btn" data-action="reject" data-title="{{ $project->title }}">Reject</button>
                </form>

                <form action="{{ route('projects.delete', $project) }}" method="POST" class="d-inline confirm-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger confirm-btn" data-action="delete" data-title="{{ $project->title }}">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('js')
<!-- jQuery (يجب أن يكون قبل DataTables) -->
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
    // تفعيل DataTables بعد التأكد من تحميل jQuery و DataTables
    $('#projectsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

    // SweetAlert confirm
    document.querySelectorAll('.confirm-btn').forEach(function(button){
        button.addEventListener('click', function(e){
            e.preventDefault(); 
            let form = this.closest('form');
            let action = this.getAttribute('data-action');
            let title = this.getAttribute('data-title');

            let text = '', confirmButtonText = '', icon = '';

            if(action === 'approve'){
                text = "You are about to approve the page: " + title;
                confirmButtonText = "Yes, approve it!";
                icon = "success";
            } else if(action === 'reject'){
                text = "You are about to reject the page: " + title;
                confirmButtonText = "Yes, reject it!";
                icon = "warning";
            } else if(action === 'delete'){
                text = "You are about to delete the page: " + title;
                confirmButtonText = "Yes, delete it!";
                icon = "error";
            }

            Swal.fire({
                title: 'Are you sure?',
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: action === 'approve' ? '#28a745' : '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: confirmButtonText
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
