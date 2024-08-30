<header>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <!-- Left-aligned logo -->
      <a class="navbar-brand" href="#">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
      </a>

      <!-- Right-aligned links -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item me-4">
          <a class="nav-link" href="#">Order Management</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" href="{{ route('products.index') }}">Product Management</a>
        </li>
        <li class="nav-item me-5">
          <a class="nav-link" href="{{ route('slider.index') }}">Slider Management</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
