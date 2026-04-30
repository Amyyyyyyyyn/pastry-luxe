<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = is_file($manifestPath) ? json_decode((string) file_get_contents($manifestPath), true) : [];
        $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
        $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        $cssVersion = $cssFile && is_file(public_path('build/'.$cssFile)) ? filemtime(public_path('build/'.$cssFile)) : time();
        $jsVersion = $jsFile && is_file(public_path('build/'.$jsFile)) ? filemtime(public_path('build/'.$jsFile)) : time();
    @endphp
    @if ($cssFile)
      <link rel="stylesheet" href="{{ asset('build/'.$cssFile).'?v='.$cssVersion }}">
    @endif
    @if ($jsFile)
      <script type="module" src="{{ asset('build/'.$jsFile).'?v='.$jsVersion }}"></script>
    @endif
</head>
<body class="luxe-ambient min-h-screen text-stone-900">
    @include('partials.nav')
    @if(session('toast'))
      <div class="fixed right-4 top-20 z-50 rounded-2xl glass px-4 py-3 text-sm">{{ session('toast') }}</div>
    @endif
    <main class="pb-24 md:pb-0">@yield('content')</main>
    @include('partials.footer')
    @php
      $wa = preg_replace('/\D+/', '', (string) config('pastry.whatsapp_number'));
    @endphp
    <a class="fixed bottom-24 right-4 md:bottom-6 rounded-2xl bg-green-500 px-4 py-3 text-sm font-semibold text-white shadow-lg" href="https://wa.me/{{ $wa }}" target="_blank">WhatsApp</a>
    <a class="fixed bottom-0 left-0 right-0 bg-stone-900 px-4 py-3 text-center text-sm font-semibold text-amber-50 md:hidden" href="{{ route('shop.products') }}">Order Now</a>
</body>
</html>
