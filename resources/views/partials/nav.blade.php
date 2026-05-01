<header class="sticky top-0 z-40 border-b backdrop-blur-md" style="background:#103e3f;color:#edd6a7;border-color:rgba(237,214,167,0.45);">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
    <a href="{{ route('home') }}" class="font-display text-2xl font-semibold" style="color:#edd6a7;">{{ config('app.name') }}</a>
    <nav class="hidden gap-6 text-sm font-medium md:flex" style="color:#edd6a7;">
      <a href="{{ route('home') }}#categories" style="color:#edd6a7;">Categories</a>
      <a href="{{ route('shop.products') }}" style="color:#edd6a7;">Menu</a>
      <a href="{{ route('home') }}#products" style="color:#edd6a7;">Products</a>
    </nav>
    <div class="flex items-center gap-2">
      @auth
        <a class="rounded-xl border px-3 py-2 text-xs" style="border-color:rgba(237,214,167,0.75);color:#edd6a7;" href="{{ route('dashboard') }}">Dashboard</a>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="rounded-xl border px-3 py-2 text-xs" style="border-color:rgba(237,214,167,0.75);color:#edd6a7;">Logout</button></form>
      @else
        <a class="rounded-xl border px-3 py-2 text-xs" style="border-color:rgba(237,214,167,0.75);color:#edd6a7;" href="{{ route('login') }}">Login</a>
      @endauth
      <a class="relative rounded-xl border px-3 py-2 text-xs" style="border-color:rgba(237,214,167,0.75);color:#edd6a7;" href="{{ route('cart.index') }}">Cart
        @if(($cartItemCount ?? 0)>0)<span class="absolute -right-1 -top-1 rounded-full px-1 text-[10px]" style="background:#edd6a7;color:#103e3f;">{{ $cartItemCount }}</span>@endif
      </a>
    </div>
  </div>
</header>
