<footer class="mt-20 border-t border-stone-200/70 bg-stone-950 text-stone-300">
  <div class="mx-auto max-w-7xl px-4 py-10">
    <div class="grid gap-8 md:grid-cols-3">
      <div><div class="font-display text-2xl text-amber-50">{{ config('app.name') }}</div><p class="mt-2 text-sm">Handcrafted sweets and pastries, made with care.</p></div>
      <div><div class="text-sm font-semibold text-amber-50">Contact</div><p class="mt-2 text-sm">{{ config('pastry.shop_phone') }}<br>{{ config('pastry.shop_address') }}</p></div>
      <div>
        <div class="text-sm font-semibold text-amber-50">Social</div>
        <div class="mt-2 flex flex-wrap gap-2 text-xs">
          <a class="rounded-xl border border-white/20 px-3 py-1" href="{{ config('pastry.instagram_url') }}" target="_blank" rel="noreferrer">Instagram</a>
          <a class="rounded-xl border border-white/20 px-3 py-1" href="{{ config('pastry.facebook_url') }}" target="_blank" rel="noreferrer">Facebook</a>
          <a class="rounded-xl border border-white/20 px-3 py-1" href="{{ config('pastry.tiktok_url') }}" target="_blank" rel="noreferrer">TikTok</a>
        </div>
      </div>
    </div>
  </div>
</footer>
