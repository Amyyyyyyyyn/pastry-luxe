@extends('layouts.shop')
@section('title', config('app.name'))
@section('content')
<section class="shop-hero mx-auto max-w-7xl items-center gap-8 px-4 pt-12 lg:grid-cols-2">
  <div>
    <h1 class="font-display text-5xl font-semibold leading-tight">The Taste of Home-Baked Goodness</h1>
    <p class="mt-4 text-stone-600">High-end pastries with premium ingredients and elegant presentation.</p>
    <div class="mt-6 flex gap-3">
      <a class="rounded-2xl px-5 py-3 text-sm font-semibold" style="background:#103e3f;color:#edd6a7;" href="{{ route('shop.products') }}">Order Now</a>
      <a class="rounded-2xl border bg-white/70 px-5 py-3 text-sm font-semibold" href="#products">View Menu</a>
    </div>
  </div>
  <div class="flex items-center justify-center">
    @php
      $usable = static fn (string $path): bool => is_file($path) && filesize($path) > 0;

      $brandPath = public_path('Caramella-Sweets.png');

      if ($usable($brandPath)) {
        $heroSrc = '/Caramella-Sweets.png?v=' . filemtime($brandPath);
        $heroImgClass = 'h-[30rem] w-full max-h-[30rem] object-contain object-center p-4 sm:p-6';
      } else {
        $heroImg = $heroProduct?->image;

        $heroSrc = $heroImg
          ? (str_starts_with($heroImg, 'http')
              ? $heroImg
              : asset('storage/' . ltrim($heroImg, '/')))
          : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=1300&q=80';

        $heroImgClass = 'h-[30rem] w-full object-cover object-center';
      }
    @endphp

    <img 
      src="{{ $heroSrc }}" 
      class="{{ $heroImgClass }} rounded-3xl "
      alt="{{ config('app.name') }}"
      width="520" 
      height="416"
    >
  </div>
</section>

<section class="shop-section mx-auto mt-16 max-w-7xl px-4">
  <div class="shop-card-grid shop-card-grid--3 gap-4 sm:grid-cols-3">
    <div class="glass rounded-3xl p-6"><div class="text-2xl">🌿</div><h3 class="mt-2 font-display text-xl">Fresh products</h3></div>
    <div class="glass rounded-3xl p-6"><div class="text-2xl">🍫</div><h3 class="mt-2 font-display text-xl">Premium ingredients</h3></div>
    <div class="glass rounded-3xl p-6"><div class="text-2xl">💖</div><h3 class="mt-2 font-display text-xl">Made with Love</h3></div>
  </div>
</section>

<section id="categories" class="shop-section mx-auto mt-16 max-w-7xl px-4">
  <h2 class="font-display text-3xl">Categories</h2>
  @if($categories->isEmpty())
    <p class="mt-4 rounded-2xl border border-stone-300 bg-white/80 p-4 text-stone-600">No categories yet. Run <code class="rounded bg-stone-100 px-1">php artisan migrate --seed</code> or add categories in the admin panel.</p>
  @else
  <div class="shop-cat-grid mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach($categories as $c)
      <a class="group rounded-3xl border bg-white/70 p-5 transition hover:-translate-y-1" href="{{ route('shop.products',['categorie'=>$c->slug]) }}">
        <h3 class="font-display text-xl">{{ $c->name }}</h3><p class="mt-2 text-sm text-stone-600">{{ $c->excerpt }}</p>
      </a>
    @endforeach
  </div>
  @endif
</section>

<section id="products" class="shop-section mx-auto mt-16 max-w-7xl px-4">
  <h2 class="font-display text-3xl">Products</h2>
  @if($products->isEmpty())
    <p class="mt-4 rounded-2xl border border-stone-300 bg-white/80 p-4 text-stone-600">No products yet. Seed the database or add products in admin.</p>
  @else
  <div class="shop-prod-grid mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($products as $p)
      @php
        $img = $p->image;
        $src = $img ? (str_starts_with($img, 'http') ? $img : asset('storage/'.ltrim($img, '/'))) : 'https://images.unsplash.com/photo-1509440159591-0e7e0b7e0d4d?auto=format&fit=crop&w=1000&q=80';
      @endphp
      <article class="rounded-3xl border bg-white/80 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
        <img src="{{ $src }}" class="mb-4 h-44 w-full rounded-2xl object-cover" alt="{{ $p->name }}">
        <h3 class="font-display text-xl">{{ $p->name }}</h3>
        <p class="mt-2 text-sm text-stone-600">{{ $p->description }}</p>
        <p class="mt-3 font-semibold">{{ number_format($p->price,2,',',' ') }} TND</p>
        <a
          class="mt-4 inline-flex w-full items-center justify-center rounded-2xl border border-stone-200/80 bg-white/80 px-4 py-2 text-sm font-semibold text-stone-900 transition hover:bg-stone-50"
          href="{{ route('shop.product.show', $p) }}"
        >View</a>
      </article>
    @endforeach
  </div>
  @endif
</section>
@endsection
