@extends('layouts.site')
@section('title', 'Clearing & Forwarding in Kenya')
@section('content')

<section class="relative isolate overflow-hidden bg-navy text-white">
    <img src="{{ asset('images/hero.jpg') }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-40">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy via-navy/80 to-transparent"></div>
    <div class="mx-auto max-w-7xl px-4 py-24 sm:py-32">
        <h1 class="max-w-3xl text-4xl font-extrabold leading-tight sm:text-6xl">{{ $site['tagline'] ?? 'Your Cargo in Good and Safe Hands' }}</h1>
        <p class="mt-5 max-w-2xl text-lg text-white/85">Air, sea and land freight, customs clearance and warehousing, handled by former customs officers at JKIA, Mombasa, ICD Nairobi &amp; Kisumu and the Kenya, Uganda and Southern Sudan borders.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('quote.create') }}" class="btn">Request a Quote</a>
            <a href="{{ route('services.index') }}" class="btn-outline">Our Services</a>
        </div>
        <form action="{{ route('track') }}" method="GET" class="mt-10 flex max-w-xl gap-2 rounded-xl bg-white p-2 shadow-xl">
            <input name="number" required placeholder="Enter tracking number, e.g. CFL-DEMO-001" class="flex-1 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none">
            <button class="rounded-lg bg-navy px-5 py-2 text-sm font-semibold text-white hover:bg-navy/90">Track</button>
        </form>
    </div>
</section>

<section class="mx-auto mt-8 grid max-w-7xl gap-4 px-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([['layers','Air, Sea & Land','One partner for every mode'],['shield-check','Ex-Customs Experts','Former KRA, KPA & KRC officers'],['globe','East Africa Reach','Kenya, Uganda, Rwanda, South Sudan'],['map-pin','Track & Trace','Day-to-day shipment updates']] as [$i,$t,$d])
        <div class="rounded-xl bg-white p-5 text-center shadow-lg ring-1 ring-slate-100">
            <x-icon :name="$i" class="mx-auto h-7 w-7 text-brand" />
            <div class="mt-2 font-bold text-navy">{{ $t }}</div>
            <div class="text-sm">{{ $d }}</div>
        </div>
    @endforeach
</section>

<section class="mx-auto max-w-7xl px-4 pt-24">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="section-title">What we do</h2>
        <p class="mt-3">Complete clearing, forwarding and transport solutions under one roof.</p>
    </div>
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service) @include('partials.service-card') @endforeach
    </div>
</section>

<section class="mx-auto mt-24 max-w-7xl px-4">
    <div class="grid items-center gap-12 lg:grid-cols-2">
        <div>
            <h2 class="section-title">Experience that clears your cargo faster</h2>
            <p class="mt-4 whitespace-pre-line leading-relaxed">
                {{ \Illuminate\Support\Str::before($site['about_intro'] ?? '', "\n\n") }}
            </p>
        </div>

        <div class="rounded-2xl bg-navy p-8 text-white">
            <h3 class="text-xl font-bold">Where we clear</h3>

            <ul class="mt-5 space-y-3 text-sm">
                @foreach ([
                    'Jomo Kenyatta International Airport (JKIA)',
                    'Mombasa Seaport',
                    'Inland Container Depots: Nairobi & Kisumu',
                    'Kenya borders with Uganda and Southern Sudan'
                ] as $loc)
                    <li class="flex gap-3">
                        <x-icon name="check" class="h-4 w-4 shrink-0 text-brand" />
                        {{ $loc }}
                    </li>
                @endforeach
            </ul>

            <div class="mt-6 border-t border-white/20 pt-5 text-sm text-white/80">
                Need it moved? Call our hotline
                <a
                    class="font-semibold text-white underline"
                    href="tel:{{ preg_replace('/\s+/', '', $site['hotline'] ?? '') }}"
                >
                    {{ $site['hotline'] ?? '' }}
                </a>
            </div>
        </div>
    </div>

    <!-- Centered button across both columns -->
    <div class="mt-8 flex justify-center">
        <a href="{{ route('about') }}" class="btn">
            About Chase Fast
        </a>
    </div>
</section>

<div class="mt-24">@include('partials.clients')</div>

<section class="mx-auto mt-0 max-w-7xl px-4 pt-24">
    <div class="rounded-3xl bg-gradient-to-r from-brand to-red-700 px-8 py-12 text-center text-white">
        <h2 class="text-3xl font-extrabold">Ready to ship?</h2>
        <p class="mx-auto mt-2 max-w-xl text-white/90">Tell us what you are moving and where. We will come back with a clear quote.</p>
        <a href="{{ route('quote.create') }}" class="mt-6 inline-block rounded-lg bg-white px-6 py-3 text-sm font-bold text-brand hover:bg-slate-100">Get a free quote</a>
    </div>
</section>
@endsection
