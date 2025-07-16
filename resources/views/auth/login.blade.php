@extends('layout.master')
@section('title','Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div>
    <h3 class="mb-3 text-center">Login</h3>

    @if(session('msg'))
      <div class="alert alert-info mb-3 small">{{ session('msg') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" style="max-width:360px; min-width:280px;">
      @csrf
      <input type="email" name="email" placeholder="Email" class="form-control mb-2" value="{{ old('email') }}" required>
      <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>

      <button class="btn btn-primary w-100">Login</button>

      @if($errors->any())
        <div class="alert alert-danger mt-3 small">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </form>
  </div>
</div>
@endsection