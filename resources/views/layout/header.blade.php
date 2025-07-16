<!-- resources/views/layout/header.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">

    <a class="navbar-brand" href="{{ route('home') }}">BlogSite</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          </li>
        @else
          <li class="nav-item me-2">
            <span class="nav-link">Hi {{ auth()->user()->name }}</span>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>

  </div>
</nav>
