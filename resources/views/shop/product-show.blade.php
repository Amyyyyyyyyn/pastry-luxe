@extends('layouts.shop')

@section('title', $product->name.' — '.config('app.name'))

@section('content')
    @php
        $img = $product->image;
        $src = $img
            ? (str_starts_with($img, 'http') ? $img : asset('storage/' . ltrim($img, '/')))
            : 'https://images.unsplash.com/photo-1509440159591-0e7e0b7e0d4d?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <style>
        .product-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: start;
        }
        .product-media {
            min-height: 22rem;
            overflow: hidden;
            border-radius: 2rem;
            border: 1px solid rgba(214, 211, 209, 0.7);
            background: #fff;
            box-shadow: 0 2px 10px rgba(28, 25, 23, 0.06);
        }
        .product-media img {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 22rem;
            object-fit: cover;
        }
        .product-image-fallback {
            display: none;
            width: 100%;
            min-height: 22rem;
            align-items: center;
            justify-content: center;
            color: #78716c;
            background: #f5f5f4;
            font-size: 0.95rem;
        }
        @media (min-width: 1024px) {
            .product-layout {
                grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
                gap: 2.5rem;
            }
            .product-media,
            .product-media img,
            .product-image-fallback {
                min-height: 34rem;
            }
        }
    </style>

    <section class="mx-auto max-w-6xl px-4 py-8 sm:py-10">
        <a class="text-sm font-medium text-stone-600 underline hover:text-stone-900" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('shop.products') }}">← Back</a>

        <div class="product-layout mt-6">
            <div class="product-media min-w-0">
                <img
                    src="{{ $src }}"
                    class="w-full"
                    alt="{{ $product->name }}"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                />
                <div class="product-image-fallback">Image unavailable</div>
            </div>

            <div class="min-w-0 space-y-5">
                <div class="p-0">
                    <h1 class="font-display mt-1 text-5xl font-semibold leading-tight text-stone-950">{{ $product->name }}</h1>
                    <p class="mt-2 text-4xl font-semibold text-stone-900">{{ number_format((float) $product->price, 2, ',', ' ') }} TND</p>
                    @if (filled($product->description))
                        <p class="mt-3 whitespace-pre-line text-lg leading-relaxed text-stone-700">{{ $product->description }}</p>
                    @endif
                </div>

                <form class="space-y-4 rounded-3xl border border-stone-200/80 bg-white p-5 shadow-sm sm:p-6" method="post" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />

                    <div>
                        <label class="text-sm font-semibold text-stone-800" for="qty">Quantity</label>
                        <input
                            class="mt-2 w-28 rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm"
                            id="qty"
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="99"
                        />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-800" for="allergie">Allergies / restrictions</label>
                        <textarea
                            class="mt-2 w-full min-h-24 rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm"
                            id="allergie"
                            name="allergie"
                            placeholder="Optional"
                        ></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-800" for="personalization">Personalization</label>
                        <textarea
                            class="mt-2 w-full min-h-24 rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm"
                            id="personalization"
                            name="personalization"
                            placeholder="Message on cake, packaging note, etc."
                        ></textarea>
                    </div>

                    <button
                        class="w-full rounded-2xl bg-stone-900 px-4 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-800"
                        type="submit"
                    >Add to cart</button>
                </form>
            </div>
        </div>
    </section>
@endsection
