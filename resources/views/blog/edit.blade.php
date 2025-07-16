@extends('layout.master')
@section('content')
<div class="container mt-4">
    <h2>Edit Blog</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Please fix the following:
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Description *</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $blog->description) }}</textarea>
        </div>

        <div class="form-group mb-2">
            <label>Tags / Categories</label>
            <input type="text" name="tags[]" class="form-control mb-1" placeholder="Enter tags separated by commas" value="{{ implode(', ', old('tags', $blog->tags ?? [])) }}">
        </div>

        <div class="form-group mb-3">
            <label>Blog Images (Multiple)</label>
            @if ($blog->image)
                <div class="mb-2">
                    @foreach ($blog->image as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Blog Image" width="100" class="me-2 mb-1">
                    @endforeach
                </div>
            @endif
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
