@extends('layouts.shop')
@section('title', 'Admin Products — '.config('app.name'))
@section('content')
<section class="mx-auto max-w-6xl px-4 py-12">
  <h1 class="font-display text-4xl">Products</h1>
  @if(session('status'))<div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm">{{ session('status') }}</div>@endif
  @if($errors->any())
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-800">
      {{ $errors->first() }}
    </div>
  @endif
  <form class="mt-6 grid gap-3 rounded-2xl border bg-white/80 p-4 md:grid-cols-3" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@csrf
    <select class="rounded-xl border px-3 py-2" name="category_id">@foreach(\App\Models\Category::orderBy('name')->get() as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
    <input class="rounded-xl border px-3 py-2" name="name" placeholder="Product name (ex: Fraisiee gateaux)">
    <input class="rounded-xl border px-3 py-2" name="price" placeholder="Price">
    <p class="text-xs text-stone-600 md:col-span-3">Slug is generated automatically from the product name.</p>
    <textarea class="rounded-xl border px-3 py-2 md:col-span-3" name="subtitle" placeholder="Short line under the product name (shop only)" rows="2"></textarea>
    <textarea class="rounded-xl border px-3 py-2 md:col-span-2" name="description" placeholder="Description shown under price on product page"></textarea>
    <input class="rounded-xl border px-3 py-2" type="file" name="image">
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked> Active</label>
    <button class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50">Create</button>
  </form>
  <div class="mt-6 space-y-4">
    @foreach($products as $p)
      <div class="rounded-2xl border bg-white/80 p-4">
        <form class="grid gap-3 md:grid-cols-6" method="post" action="{{ route('admin.products.update',$p) }}" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="md:col-span-1">
            @if($p->image)
              <img class="h-16 w-16 rounded-lg object-cover" src="{{ str_starts_with($p->image,'http') ? $p->image : asset('storage/'.ltrim($p->image,'/')) }}" alt="{{ $p->name }}">
            @endif
          </div>
          <input class="rounded-xl border px-3 py-2 md:col-span-1" name="name" value="{{ $p->name }}">
          <select class="rounded-xl border px-3 py-2 md:col-span-1" name="category_id">@foreach(\App\Models\Category::orderBy('name')->get() as $c)<option value="{{ $c->id }}" @selected($p->category_id===$c->id)>{{ $c->name }}</option>@endforeach</select>
          <input class="rounded-xl border px-3 py-2 md:col-span-1" name="price" value="{{ $p->price }}">
          <input class="rounded-xl border px-3 py-2 md:col-span-1" type="file" name="image">
          <textarea class="rounded-xl border px-3 py-2 md:col-span-6" name="subtitle" placeholder="Short line under title (shop)" rows="2">{{ $p->subtitle }}</textarea>
          <textarea class="rounded-xl border px-3 py-2 md:col-span-5" name="description" placeholder="Description shown under price on product page">{{ $p->description }}</textarea>
          <label class="flex items-center gap-2 text-sm md:col-span-1"><input type="checkbox" name="is_active" value="1" @checked($p->is_active)> Active</label>
          <div class="flex gap-2 md:col-span-6">
            <button class="rounded-xl bg-stone-900 px-4 py-2 text-sm font-semibold text-amber-50" type="submit">Edit</button>
          </div>
        </form>
        <form class="mt-2" method="post" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirm('Delete this product?')">
          @csrf
          @method('delete')
          <button class="rounded-xl border border-red-300 px-4 py-2 text-sm font-semibold text-red-700" type="submit">Delete</button>
        </form>
      </div>
    @endforeach
  </div>
  <div class="mt-4">{{ $products->links() }}</div>
</section>
@endsection
