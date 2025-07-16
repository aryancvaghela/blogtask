@extends('layout.master')
@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Blog List</h2>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">+ Create Blog</a>
        </div>
        <table class="table table-bordered" id="blogs-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $('#blogs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('blogs.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'tags',
                        name: 'tags'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        // function getBlog(id) {
        //     window.location.href = `/blogs/${id}/edit`;
        // }

        function deleteConfirm(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: `/blogs/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.data-table').DataTable().ajax.reload();
                        alert('Blog deleted successfully.');
                    },
                    error: function(xhr) {
                        alert('Something went wrong.');
                    }
                });
            }
        }
    </script>
@endsection
