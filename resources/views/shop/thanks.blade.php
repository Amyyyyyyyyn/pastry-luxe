@extends('layouts.shop')
@section('title', 'Thank You — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-2xl px-4 py-12">
  <h1 class="font-display text-4xl">Thank you for your order</h1>
  <p class="mt-3">Order #{{ $order->id }} is now <strong>{{ $order->status }}</strong>.</p>
  <a class="mt-6 inline-block rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50" href="{{ route('home') }}">Back to Home</a>
</section>
@endsection
