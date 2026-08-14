<header>
<nav>
  <div class="brand">
    <div class="brand-mark"><img src="{{ asset('images/logo-sweet-paradise.png') }}" alt="Sweet Paradise logo"></div>
    <div class="brand-text">Sweet Paradise<small>Pastelería artesanal premium</small></div>
  </div>
    <ul class="nav-links">
      <li><a class="nav-link nav-link-home" href="{{ route('home') }}">Home</a></li>
      <li><a class="nav-link nav-link-productos" href="{{ route('products') }}">Productos</a></li>
      <li><a class="nav-link nav-link-mesa-dulce" href="{{ route('home') }}#catering">Mesa dulce</a></li>
      <li><a href="{{ route('home') }}#nosotros">Nosotros</a></li>
    <li><a href="{{ route('home') }}#opiniones">Opiniones</a></li>
    <li><a href="{{ route('home') }}#instagram">Instagram</a></li>
    <li><a href="{{ route('home') }}#contacto">Contacto</a></li>
  </ul>
  <div class="header-actions">
    <a class="header-icon" href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}" aria-label="Iniciar sesión" title="Iniciar sesión">👤</a>
    <a class="cart-link" href="{{ route('cart') }}" aria-label="Ir al carrito" title="Carrito">
      <span class="cart-icon">🛒</span>
      <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
    </a>
  </div>
</nav>
</header>
