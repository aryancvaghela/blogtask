@extends('layout.master')
@section('title','Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div>
    <h3 class="mb-3 text-center">Register</h3>

    <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" style="max-width:420px; min-width:300px;">
      @csrf

      <input name="name" class="form-control mb-2" placeholder="Name" value="{{ old('name') }}" required>
      <input type="email" name="email" class="form-control mb-2" placeholder="Email" value="{{ old('email') }}" required>
      <input type="password" name="password" class="form-control mb-2" placeholder="Password (min 8, alpha‑num)" required>
      <input name="mobile" class="form-control mb-2" placeholder="Mobile (10 digit)" value="{{ old('mobile') }}" required>
      <input type="date" name="dob" class="form-control mb-2" value="{{ old('dob') }}" required>

      <div class="mb-2">
        <label class="me-3"><input type="radio" name="gender" value="male"   {{ old('gender','male')=='male' ? 'checked' : '' }}> Male</label>
        <label class="me-3"><input type="radio" name="gender" value="female" {{ old('gender')=='female' ? 'checked' : '' }}> Female</label>
        <label><input type="radio" name="gender" value="other" {{ old('gender')=='other' ? 'checked' : '' }}> Other</label>
      </div>

      <input type="file" name="profile_image" class="form-control mb-2">
      <button class="btn btn-success w-100">Register</button>

      @if ($errors->any())
        <div class="alert alert-danger mt-3">
          <ul class="mb-0 small">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif
    </form>
  </div>
</div>
@endsection
