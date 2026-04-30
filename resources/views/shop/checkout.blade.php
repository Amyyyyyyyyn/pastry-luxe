@extends('layouts.shop')
@section('title', 'Checkout — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-2xl px-4 py-12">
  <h1 class="font-display text-4xl">Checkout</h1>
  @if($errors->any())<div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form class="mt-6 space-y-3" method="post" action="{{ route('checkout.place') }}">@csrf
    <input class="w-full rounded-xl border px-3 py-2" name="client_name" placeholder="Name" value="{{ old('client_name') }}">
    <input class="w-full rounded-xl border px-3 py-2" name="phone" placeholder="+216..." value="{{ old('phone') }}">
    <textarea class="w-full rounded-xl border px-3 py-2" name="notes" placeholder="Notes">{{ old('notes') }}</textarea>
    <div class="rounded-xl border bg-white/70 p-3">Total: <strong>{{ number_format($subtotal,2,',',' ') }} TND</strong></div>
    <button class="w-full rounded-xl bg-stone-900 px-4 py-3 text-sm font-semibold text-amber-50">Place Order</button>
  </form>
</section>
@endsection
