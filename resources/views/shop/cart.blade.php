@extends('layouts.shop')
@section('title', 'Cart — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-4xl px-4 py-12">
  <h1 class="font-display text-4xl">Your Cart</h1>
  <div class="mt-6 space-y-4">
    @forelse($rows as $r)
      <div class="glass rounded-3xl p-5">
        <div class="flex items-center justify-between"><h3 class="font-display text-xl">{{ $r['product']->name ?? 'Unavailable' }}</h3>
          <form method="post" action="{{ route('cart.remove',$r['index']) }}">@csrf @method('delete')<button class="text-sm underline">Remove</button></form>
        </div>
        <form class="mt-3 grid gap-3" method="post" action="{{ route('cart.update',$r['index']) }}">@csrf @method('put')
          <input class="rounded-xl border px-3 py-2" type="number" name="quantity" min="0" max="99" value="{{ $r['line']['quantity'] }}">
          <textarea class="rounded-xl border px-3 py-2" name="allergie" placeholder="Allergies">{{ $r['line']['allergie'] }}</textarea>
          <textarea class="rounded-xl border px-3 py-2" name="personalization" placeholder="Personalization">{{ $r['line']['personalization'] }}</textarea>
          <button class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50">Update</button>
        </form>
      </div>
    @empty
      <div class="rounded-2xl border bg-white/70 p-6">Cart is empty.</div>
    @endforelse
  </div>
  <div class="mt-6 flex items-center justify-between"><p>Subtotal: <strong>{{ number_format($subtotal,2,',',' ') }} TND</strong></p><a class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50" href="{{ route('checkout.index') }}">Checkout</a></div>
</section>
@endsection
