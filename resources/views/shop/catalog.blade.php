@extends('layouts.shop')
@section('title', 'Menu — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-7xl px-4 py-12">
  <h1 class="font-display text-4xl">Full Menu</h1>
  <form class="mt-4" method="get">
    <select class="rounded-xl border bg-white/80 px-3 py-2" name="categorie" onchange="this.form.submit()">
      <option value="">All categories</option>
      @foreach($categories as $c)<option value="{{ $c->slug }}" @selected($slug===$c->slug)>{{ $c->name }}</option>@endforeach
    </select>
  </form>
  <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($products as $p)
      @php
        $img = $p->image;
        $src = $img ? (str_starts_with($img, 'http') ? $img : asset('storage/'.ltrim($img, '/'))) : 'https://images.unsplash.com/photo-1509440159591-0e7e0b7e0d4d?auto=format&fit=crop&w=1000&q=80';
      @endphp
      <article class="rounded-3xl border bg-white/80 p-5">
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
  <div class="mt-8">{{ $products->links() }}</div>
</section>
@endsection
