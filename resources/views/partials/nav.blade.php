<header class="sticky top-0 z-40 border-b backdrop-blur-md" style="background:#103e3f;color:#edd6a7;border-color:rgba(237,214,167,0.45);">
  <div class="shop-nav-shell">
    <a href="{{ route('home') }}" class="shop-logo font-display">{{ config('app.name') }}</a>

    <div class="shop-nav-mobile-btns">
      @auth
        <a class="shop-nav-btn" href="{{ route('dashboard') }}">Dashboard</a>
        <form method="post" action="{{ route('logout') }}" style="display:inline;">@csrf<button type="submit" class="shop-nav-btn">Logout</button></form>
      @else
        <a class="shop-nav-btn" href="{{ route('login') }}">Login</a>
      @endauth
      <a class="shop-nav-btn relative inline-block" href="{{ route('cart.index') }}">Cart
        @if(($cartItemCount ?? 0)>0)<span class="absolute -right-1 -top-1 rounded-full px-1 text-[10px]" style="background:#edd6a7;color:#103e3f;">{{ $cartItemCount }}</span>@endif
      </a>
    </div>

    <nav class="shop-nav-links">
      <a href="{{ route('home') }}#categories">Categories</a>
      <a href="{{ route('shop.products') }}">Menu</a>
      <a href="{{ route('home') }}#products">Products</a>
    </nav>

    <div class="shop-nav-desktop-btns">
      @auth
        <a class="shop-nav-btn" href="{{ route('dashboard') }}">Dashboard</a>
        <form method="post" action="{{ route('logout') }}" style="display:inline;">@csrf<button type="submit" class="shop-nav-btn">Logout</button></form>
      @else
        <a class="shop-nav-btn" href="{{ route('login') }}">Login</a>
      @endauth
      <a class="shop-nav-btn relative inline-block" href="{{ route('cart.index') }}">Cart
        @if(($cartItemCount ?? 0)>0)<span class="absolute -right-1 -top-1 rounded-full px-1 text-[10px]" style="background:#edd6a7;color:#103e3f;">{{ $cartItemCount }}</span>@endif
      </a>
    </div>
  </div>
</header>
