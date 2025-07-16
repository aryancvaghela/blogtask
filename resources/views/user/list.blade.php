@extends('layout.master')
@section('title', 'User List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>User List</h2>
        <a href="{{ route('blogs.index') }}" class="btn btn-primary">Blog List</a>
    </div>
    <table class="display table table-striped table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Blog Count</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>


@endsection
@section('js')
    <script>
        $(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'blogs_count',
                        name: 'blogs_count'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


        });

        function getUser(id) {
            window.location.href = `/users/${id}/edit`;
        }

        function deleteConfirm(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: `/users/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.data-table').DataTable().ajax.reload();
                        alert('User deleted successfully.');
                    },
                    error: function(xhr) {
                        alert('Something went wrong.');
                    }
                });
            }
        }
    </script>

@endsection
