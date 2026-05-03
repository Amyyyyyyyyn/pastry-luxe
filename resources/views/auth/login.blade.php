@extends('layouts.shop')
@section('title', 'Login — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-md px-4 py-16">
  <h1 class="font-display text-4xl">Admin Login</h1>
  @if($errors->any())<div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm">{{ $errors->first() }}</div>@endif
  <form class="mt-6 space-y-3" method="post" action="{{ route('login.store') }}">@csrf
    <input class="w-full rounded-xl border px-3 py-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="username">
    <input class="w-full rounded-xl border px-3 py-2" type="password" name="password" placeholder="Password" autocomplete="current-password">
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Remember me</label>
    <button type="submit" class="w-full rounded-xl px-4 py-3 text-sm font-semibold" style="background:#103e3f;color:#edd6a7;border:none;cursor:pointer;">Login</button>
  </form>
</section>
@endsection
