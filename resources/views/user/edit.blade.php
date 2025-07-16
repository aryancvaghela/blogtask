@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="form-control" placeholder="New Password">
        </div>

        <div class="form-group">
            <label>Mobile *</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}" required>
        </div>

        <div class="form-group">
            <label>DOB *</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->dob) }}" required>
        </div>

        <div class="form-group">
            <label>Gender *</label>
            <select name="gender" class="form-control" required>
                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Profile Image</label><br>
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" width="100"><br>
            @endif
            <input type="file" name="profile_image" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
