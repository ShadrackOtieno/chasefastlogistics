<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Dashboard') | Back Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { navy: '#0b2a5b', brand: '#d62839' } } } }</script>
    <style type="text/tailwindcss">
        @layer components {
            .input { @apply w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20; }
            .label { @apply mb-1 block text-sm font-medium text-slate-700; }
            .btn { @apply inline-flex items-center rounded-lg bg-navy px-4 py-2 text-sm font-semibold text-white hover:bg-navy/90; }
            .btn-red { @apply inline-flex items-center rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-red-700; }
            .btn-light { @apply inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50; }
            .th { @apply px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500; }
            .td { @apply px-4 py-3 text-sm; }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ nav: false }">
@php
    $links = [
        ['admin.dashboard', 'Dashboard', 'dashboard', null, 'admin.dashboard'],
        ['admin.quotes.index', 'Quote requests', 'message', $badges['quotes'] ?? 0, 'admin.quotes.*'],
        ['admin.messages.index', 'Messages', 'mail', $badges['messages'] ?? 0, 'admin.messages.*'],
        ['admin.shipments.index', 'Shipments', 'package', null, 'admin.shipments.*'],
        ['admin.services.index', 'Services', 'wrench', null, 'admin.services.*'],
        ['admin.rates.index', 'Rates', 'banknote', null, 'admin.rates.*'],
        ['admin.clients.index', 'Clients', 'briefcase', null, 'admin.clients.*'],
        ['admin.team.index', 'Team', 'users', null, 'admin.team.*'],
        ['admin.settings.edit', 'Site settings', 'sliders', null, 'admin.settings.*'],
        ['admin.account.edit', 'My account', 'lock', null, 'admin.account.*'],
    ];
@endphp
<div class="flex min-h-screen">
    <aside :class="nav ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 transform bg-navy text-white transition lg:static lg:translate-x-0">
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
            <img src="{{ asset('images/logo.png') }}" class="h-10 rounded bg-white p-0.5" alt="">
            <div class="text-sm font-bold leading-tight">Chase Fast<br><span class="text-xs font-normal text-white/60">Back Office</span></div>
        </div>
        <nav class="space-y-1 p-3">
            @foreach ($links as [$r, $label, $icon, $badge, $pattern])
                <a href="{{ route($r) }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-sm {{ request()->routeIs($pattern) ? 'bg-white/15 font-semibold' : 'text-white/80 hover:bg-white/10' }}">
                    <span class="flex items-center gap-3"><x-icon :name="$icon" class="h-4 w-4" /> {{ $label }}</span>
                    @if ($badge)<span class="rounded-full bg-brand px-2 py-0.5 text-xs font-bold">{{ $badge }}</span>@endif
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-white/80 hover:bg-white/10"><x-icon name="globe" class="h-4 w-4" /> View website</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf
                <button class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-sm text-white/80 hover:bg-white/10"><x-icon name="log-out" class="h-4 w-4" /> Sign out</button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 lg:ml-0">
        <header class="flex items-center justify-between border-b bg-white px-4 py-3 lg:px-8">
            <button @click="nav = !nav" class="rounded p-2 lg:hidden" aria-label="Menu"><x-icon name="menu" class="h-6 w-6" /></button>
            <h1 class="text-lg font-bold text-navy">@yield('title', 'Dashboard')</h1>
            <span class="text-sm text-slate-500">{{ auth()->user()->name }}</span>
        </header>
        <main class="p-4 lg:p-8">
            @if (session('success'))<div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
