<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ $site['company_name'] ?? 'Chase Fast Logistics Limited' }}</title>
    <meta name="description" content="@yield('description', 'Licensed clearing and forwarding firm in Kenya: air, sea and land freight, customs clearance, warehousing and project forwarding.')">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Tailwind via CDN keeps setup to zero. For production, switch to the Vite build that ships with Laravel. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: {
            colors: { navy: '#0b2a5b', brand: '#d62839', teal: '#2fa4b5' },
            fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] }
        } } }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .input { @apply w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20; }
            .label { @apply mb-1 block text-sm font-medium text-slate-700; }
            .btn { @apply inline-flex items-center justify-center rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white shadow hover:bg-red-700 transition; }
            .btn-outline { @apply inline-flex items-center justify-center rounded-lg border border-white/70 px-5 py-3 text-sm font-semibold text-white hover:bg-white hover:text-navy transition; }
            .section-title { @apply text-3xl font-extrabold tracking-tight text-navy sm:text-4xl; }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white font-sans text-slate-700 antialiased">

<div class="hidden bg-navy text-xs text-white/90 md:block">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
        <span>{{ $site['hours'] ?? '' }}</span>
        <span class="space-x-5">
            <a href="tel:{{ preg_replace('/\s+/', '', $site['hotline'] ?? '') }}" class="hover:underline">Hotline: {{ $site['hotline'] ?? '' }}</a>
            <a href="mailto:{{ $site['email'] ?? '' }}" class="hover:underline">{{ $site['email'] ?? '' }}</a>
        </span>
    </div>
</div>

<header x-data="{ open: false }" class="sticky top-0 z-40 border-b bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Chase Fast Logistics logo" class="h-12 w-auto">
            <span class="leading-tight">
                <span class="block text-lg font-extrabold text-navy">CHASE FAST</span>
                <span class="block text-[11px] font-semibold uppercase tracking-widest text-brand">Logistics Limited</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            @foreach ([['home','Home'],['about','About'],['services.index','Services'],['rates','Rates'],['track','Track Shipment'],['contact','Contact']] as [$r,$label])
                <a href="{{ route($r) }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs($r === 'services.index' ? 'services.*' : $r) ? 'text-brand' : 'text-slate-700 hover:text-navy' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('quote.create') }}" class="btn ml-2 !py-2">Get a Quote</a>
        </nav>

        <button @click="open = !open" class="rounded-md p-2 lg:hidden" aria-label="Menu">
            <x-icon name="menu" class="h-6 w-6" />
        </button>
    </div>
    <nav x-show="open" x-cloak class="border-t px-4 pb-4 lg:hidden">
        @foreach ([['home','Home'],['about','About'],['services.index','Services'],['rates','Rates'],['track','Track Shipment'],['contact','Contact'],['quote.create','Get a Quote']] as [$r,$label])
            <a href="{{ route($r) }}" class="block border-b py-3 text-sm font-medium">{{ $label }}</a>
        @endforeach
    </nav>
</header>

@if (session('success'))
    <div class="bg-green-50 px-4 py-3 text-center text-sm text-green-800">{{ session('success') }}</div>
@endif

<main>@yield('content')</main>

<footer class="mt-24 bg-navy text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-4">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="" class="mb-4 h-14 rounded bg-white p-1">
            <p class="text-sm font-semibold">{{ $site['company_name'] ?? '' }}</p>
            <p class="mt-1 text-sm italic text-white/70">{{ $site['tagline'] ?? '' }}</p>
        </div>
        <div>
            <h3 class="mb-3 text-sm font-bold uppercase tracking-wider text-white/60">Services</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($footerServices as $s)
                    <li><a class="hover:underline" href="{{ route('services.show', $s) }}">{{ $s->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h3 class="mb-3 text-sm font-bold uppercase tracking-wider text-white/60">Company</h3>
            <ul class="space-y-2 text-sm">
                <li><a class="hover:underline" href="{{ route('about') }}">About us</a></li>
                <li><a class="hover:underline" href="{{ route('rates') }}">Our rates</a></li>
                <li><a class="hover:underline" href="{{ route('track') }}">Track a shipment</a></li>
                <li><a class="hover:underline" href="{{ route('quote.create') }}">Request a quote</a></li>
                <li><a class="hover:underline" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
        <div class="text-sm">
            <h3 class="mb-3 text-sm font-bold uppercase tracking-wider text-white/60">Reach us</h3>
            <p><span class="font-semibold">Head office:</span> {{ $site['address_head_office'] ?? '' }}</p>
            <p class="mt-2"><span class="font-semibold">JKIA office:</span> {{ $site['address_jkia'] ?? '' }}</p>
            <p class="mt-2">{{ $site['po_box'] ?? '' }}</p>
            <p class="mt-2">Hotline: <a class="hover:underline" href="tel:{{ preg_replace('/\s+/', '', $site['hotline'] ?? '') }}">{{ $site['hotline'] ?? '' }}</a></p>
            <p><a class="hover:underline" href="mailto:{{ $site['email'] ?? '' }}">{{ $site['email'] ?? '' }}</a></p>
            <div class="mt-3 flex gap-4 text-white/80">
                @foreach (['facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'twitter' => 'X'] as $k => $n)
                    @if (!empty($site[$k]))<a href="{{ $site[$k] }}" target="_blank" rel="noopener" class="hover:text-white">{{ $n }}</a>@endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="border-t border-white/10 py-5 text-center text-xs text-white/60">
        &copy; {{ date('Y') }} {{ $site['company_name'] ?? '' }}. All rights reserved.
    </div>
</footer>

@if (!empty($site['whatsapp']))
    <a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"
       class="fixed bottom-5 right-5 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-white shadow-lg hover:bg-green-600"><x-icon name="chat" class="h-7 w-7" /></a>
@endif
<style>[x-cloak]{display:none!important}</style>
</body>
</html>
