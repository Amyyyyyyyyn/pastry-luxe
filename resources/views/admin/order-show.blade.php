@extends('layouts.shop')
@section('title', 'Order Details — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-4xl px-4 py-12">
  <h1 class="font-display text-4xl">Order #{{ $order->id }}</h1>
  @if(session('status'))<div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm">{{ session('status') }}</div>@endif
  <div class="mt-4 rounded-2xl border bg-white/80 p-4 text-sm">Client: {{ $order->client_name }} · {{ $order->phone }}</div>
  <form class="mt-4 flex gap-2" method="post" action="{{ route('admin.orders.update',$order) }}">@csrf @method('patch')
    <select class="rounded-xl border px-3 py-2" name="status">@foreach(['pending','preparing','ready','delivered','cancelled'] as $s)<option value="{{ $s }}" @selected($order->status===$s)>{{ $s }}</option>@endforeach</select>
    <button class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50">Update</button>
  </form>
  <div class="mt-6 space-y-3">@foreach($order->items as $i)<div class="rounded-2xl border bg-white/80 p-4 text-sm"><div class="font-semibold">{{ $i->name_snapshot }} x{{ $i->quantity }}</div><div class="mt-1 text-stone-600">Allergie: {{ $i->allergie ?: '—' }}</div><div class="text-stone-600">Personalization: {{ $i->personalization ?: '—' }}</div></div>@endforeach</div>
</section>
@endsection
