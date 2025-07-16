@extends('layout.master')
@section('content')
<div class="container mt-4">
    <h2>Create Blog</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Please fix the following:
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-2">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Description *</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-2">
            <label>Tags / Categories</label>
            <input type="text" name="tags[]" class="form-control mb-1" placeholder="Enter tags separated by commas (e.g. Laravel, PHP)" value="{{ old('tags') ? implode(', ', old('tags')) : '' }}">
        </div>

        <div class="form-group mb-3">
            <label>Blog Images (Multiple)</label>
            <input type="file" name="image[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
