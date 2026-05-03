<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Root-relative hrefs (same origin as the page). Same chain as GET /favicon.ico in routes/web.php. Skip 0-byte favicon.ico (breaks tab icon). --}}
    @php
        $usable = static fn (string $path): bool => is_file($path) && filesize($path) > 0;
        $faviconPng = public_path('favicon.png');
        $brandPng = public_path('brand-logo.png');
        $faviconIco = public_path('favicon.ico');
        $faviconSvg = public_path('favicon.svg');
        $q = static fn (string $path): string => $usable($path) ? '?v='.filemtime($path) : '';
        if ($usable($faviconPng)) {
            $tabIcon = '/favicon.png'.$q($faviconPng);
            $tabMime = 'image/png';
            $appleIcon = $tabIcon;
        } elseif ($usable($brandPng)) {
            $tabIcon = '/brand-logo.png'.$q($brandPng);
            $tabMime = 'image/png';
            $appleIcon = $tabIcon;
        } elseif ($usable($faviconIco)) {
            $tabIcon = '/favicon.ico'.$q($faviconIco);
            $tabMime = 'image/x-icon';
            $appleIcon = $tabIcon;
        } elseif ($usable($faviconSvg)) {
            $tabIcon = '/favicon.svg'.$q($faviconSvg);
            $tabMime = 'image/svg+xml';
            $appleIcon = $tabIcon;
        } else {
            $tabIcon = '/favicon.svg';
            $tabMime = 'image/svg+xml';
            $appleIcon = $tabIcon;
        }
    @endphp
    <link rel="icon" type="{{ $tabMime }}" href="{{ $tabIcon }}" sizes="any">
    <link rel="shortcut icon" href="{{ $tabIcon }}">
    <link rel="apple-touch-icon" href="{{ $appleIcon }}">
    @php
        $viteHot = public_path('hot');
        $manifestPath = public_path('build/manifest.json');
        $manifest = is_file($manifestPath)
            ? json_decode((string) file_get_contents($manifestPath), true)
            : [];
        $builtCss = $manifest['resources/css/app.css']['file'] ?? null;
        $builtJs = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp
    @if (is_file($viteHot))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @elseif ($builtCss && $builtJs && is_file(public_path('build/'.$builtCss)) && is_file(public_path('build/'.$builtJs)))
        {{-- Built assets only: avoids loading port 5173 when `npm run dev` is not running --}}
        <link rel="stylesheet" href="/build/{{ $builtCss }}">
        <script type="module" src="/build/{{ $builtJs }}"></script>
    @else
        <style>body { font-family: system-ui, sans-serif; background: #f7ecd2; color: #103e3f; }</style>
    @endif
    <style>
        /* Fallback layout when Tailwind fails to load (missing build, wrong ASSET_URL, etc.) */
        .shop-nav-shell { max-width: 80rem; margin: 0 auto; padding: 12px 16px; display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: center; }
        .shop-logo { color: #edd6a7; font-weight: 600; font-size: 1.375rem; text-decoration: none; grid-column: 1; grid-row: 1; }
        .shop-nav-mobile-btns { grid-column: 2; grid-row: 1; display: flex; flex-wrap: wrap; gap: 8px; justify-self: end; }
        .shop-nav-links {
            grid-column: 1 / -1;
            grid-row: 2;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 12px 22px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .shop-nav-links a { color: #edd6a7; padding: 8px 12px; text-decoration: none; white-space: nowrap; }
        .shop-nav-desktop-btns { display: none; flex-wrap: wrap; gap: 8px; align-items: center; }
        .shop-nav-btn { border: 1px solid rgba(237,214,167,0.75); color: #edd6a7; border-radius: 0.75rem; padding: 8px 12px; font-size: 0.75rem; text-decoration: none; background: transparent; cursor: pointer; font-family: inherit; }
        @media (min-width: 768px) {
            .shop-nav-shell { display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center; justify-content: space-between; gap: 16px 24px; }
            .shop-logo { grid-column: unset; grid-row: unset; flex-shrink: 0; }
            .shop-nav-mobile-btns { display: none !important; }
            .shop-nav-links { grid-column: unset; grid-row: unset; flex: 1; justify-content: center; margin: 0; min-width: 0; }
            .shop-nav-desktop-btns { display: flex !important; flex-shrink: 0; }
        }
        .shop-hero { max-width: 80rem; margin: 0 auto; padding: 3rem 1rem 0; display: grid; gap: 2rem; align-items: center; }
        @media (min-width: 1024px) { .shop-hero { grid-template-columns: 1fr 1fr; } }
        .shop-card-grid { margin-top: 1.5rem; display: grid; gap: 1rem; grid-template-columns: 1fr; }
        @media (min-width: 640px) { .shop-card-grid--3 { grid-template-columns: repeat(3, 1fr); } }
        .shop-cat-grid { margin-top: 1.5rem; display: grid; gap: 1rem; grid-template-columns: 1fr; }
        @media (min-width: 640px) { .shop-cat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .shop-cat-grid { grid-template-columns: repeat(4, 1fr); } }
        .shop-prod-grid { margin-top: 1.5rem; display: grid; gap: 1rem; grid-template-columns: 1fr; }
        @media (min-width: 640px) { .shop-prod-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .shop-prod-grid { grid-template-columns: repeat(3, 1fr); } }
        .shop-section { margin-top: 4rem; max-width: 80rem; margin-left: auto; margin-right: auto; padding: 0 1rem; }
    </style>
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
    <a class="fixed bottom-0 left-0 right-0 px-4 py-3 text-center text-sm font-semibold md:hidden" style="background:#103e3f;color:#edd6a7;" href="{{ route('shop.products') }}">Order Now</a>
</body>
</html>
