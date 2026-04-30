@extends('layouts.shop')
@section('title', 'Dashboard — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-5xl px-4 py-12">
  <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div>
      <h1 class="font-display text-4xl">Admin Dashboard</h1>
      <p class="mt-2 text-sm text-stone-600">Overview of products and latest customer activity.</p>
    </div>
    <div class="flex gap-3">
      <a class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50" href="{{ route('admin.products') }}">Manage products</a>
      <a class="rounded-xl border bg-white/70 px-4 py-2 text-sm font-semibold" href="{{ route('admin.orders') }}">View orders</a>
    </div>
  </div>

  @if(($newOrdersCount ?? 0) > 0)
    <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
      🔔 You have <strong>{{ $newOrdersCount }}</strong> new pending order(s) in the last 24h.
    </div>
  @endif

  <div class="mt-8 rounded-2xl border bg-white/80 p-4">
    <h2 class="font-display text-2xl">Latest Orders</h2>
    <div class="mt-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="border-b">
            <th class="px-3 py-2 text-left">#</th>
            <th class="px-3 py-2 text-left">Client</th>
            <th class="px-3 py-2 text-left">Phone</th>
            <th class="px-3 py-2 text-left">Total</th>
            <th class="px-3 py-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse(($recentOrders ?? []) as $o)
            <tr class="border-b">
              <td class="px-3 py-2"><a class="underline" href="{{ route('admin.orders.show', $o) }}">#{{ $o->id }}</a></td>
              <td class="px-3 py-2">{{ $o->client_name }}</td>
              <td class="px-3 py-2">{{ $o->phone }}</td>
              <td class="px-3 py-2">{{ number_format((float)$o->total,2,',',' ') }} TND</td>
              <td class="px-3 py-2">{{ $o->status }}</td>
            </tr>
          @empty
            <tr><td class="px-3 py-4 text-stone-500" colspan="5">No orders yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
