@extends('layouts.shop')
@section('title', 'Admin Orders — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-6xl px-4 py-12">
  <h1 class="font-display text-4xl">Orders</h1>
  <p class="mt-2 text-sm text-stone-600">Client phone numbers are visible for quick callback.</p>
  <div class="mt-6 overflow-x-auto rounded-2xl border bg-white/80">
    <table class="min-w-full text-sm"><thead><tr class="border-b"><th class="px-3 py-2 text-left">#</th><th class="px-3 py-2 text-left">Client</th><th class="px-3 py-2 text-left">Phone</th><th class="px-3 py-2 text-left">Total</th><th class="px-3 py-2 text-left">Status</th></tr></thead>
    <tbody>@foreach($orders as $o)<tr class="border-b"><td class="px-3 py-2"><a class="underline" href="{{ route('admin.orders.show',$o) }}">{{ $o->id }}</a></td><td class="px-3 py-2">{{ $o->client_name }}</td><td class="px-3 py-2 font-semibold text-stone-800">{{ $o->phone }}</td><td class="px-3 py-2">{{ number_format($o->total,2,',',' ') }}</td><td class="px-3 py-2">{{ $o->status }}</td></tr>@endforeach</tbody></table>
  </div>
  <div class="mt-4">{{ $orders->links() }}</div>
</section>
@endsection
