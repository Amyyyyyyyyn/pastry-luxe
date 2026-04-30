<header class="sticky top-0 z-40 border-b border-stone-200/70 bg-[#fbf6ef]/80 backdrop-blur-md">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
    <a href="{{ route('home') }}" class="font-display text-2xl font-semibold">{{ config('app.name') }}</a>
    <nav class="hidden gap-6 text-sm font-medium md:flex">
      <a href="{{ route('home') }}#categories">Categories</a>
      <a href="{{ route('shop.products') }}">Menu</a>
      <a href="{{ route('home') }}#products">Products</a>
    </nav>
    <div class="flex items-center gap-2">
      @auth
        <a class="rounded-xl border px-3 py-2 text-xs" href="{{ route('dashboard') }}">Dashboard</a>
        <form method="post" action="{{ route('logout') }}">@csrf<button class="rounded-xl border px-3 py-2 text-xs">Logout</button></form>
      @else
        <a class="rounded-xl border px-3 py-2 text-xs" href="{{ route('login') }}">Login</a>
      @endauth
      <a class="relative rounded-xl border px-3 py-2 text-xs" href="{{ route('cart.index') }}">Cart
        @if(($cartItemCount ?? 0)>0)<span class="absolute -right-1 -top-1 rounded-full bg-stone-900 px-1 text-[10px] text-white">{{ $cartItemCount }}</span>@endif
      </a>
    </div>
  </div>
</header>
