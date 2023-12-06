<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Greenwich Lands Market</a>
    <ul class="navbar-nav mr-auto">
      &nbsp; &nbsp; &nbsp; &nbsp;
      <form class="form-inline" method="GET" action="{{ route('home') }}">
        <input class="form-control mr-sm-2" name="search" type="text" placeholder="Search Lands">
        <button class="btn btn-success" type="submit">Search</button>
      </form>
    </ul>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span
        class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        @auth
          @can('admin-access')
            <li class="nav-item">

              <a href="/admin" class="nav-link" title="Add User" data-toggle="tooltip" data-placement="bottom">
                Admin Dashboard
              </a>
            </li>
          @else
            <li class="nav-item">
              <a href="/cart" class="nav-link">
                <i class="fa fa-shopping-cart"></i> Cart
                <span class="badge badge-light">@include('components.cart-total')</span>
              </a>
            </li>
          @endcan

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-tie"></i>
              {{ Auth::user()->username }}</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/profile">Profile</a>
              <a class="dropdown-item" href="#">Orders</a>
              <div class="dropdown-divider"></div>
              <form action="/logout" method="POST" style="display: none;" id="logout-form">
                @csrf
              </form>
              <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
            </div>
          </li>
        @else
          <li class="nav-item">
            <a href="/login" class="btn btn-primary">Login</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
