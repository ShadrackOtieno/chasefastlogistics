@extends('layouts.site')
@section('title', 'About Us')
@section('description', 'Chase Fast Logistics is a licensed clearing and forwarding firm backed by former KRA, KPA and Kenya Railways customs officers.')
@section('content')
@include('partials.page-header', ['title' => 'About Us', 'subtitle' => $site['tagline'] ?? ''])

<section class="mx-auto max-w-4xl px-4 pt-16">
    <h2 class="section-title">Who we are</h2>
    @foreach (preg_split('/\n\s*\n/', $site['about_intro'] ?? '') as $p)
        <p class="mt-4 leading-relaxed">{{ $p }}</p>
    @endforeach
</section>

<section class="mx-auto mt-16 grid max-w-7xl gap-6 px-4 md:grid-cols-2">
    <div class="rounded-2xl  bg-slate-50 p-8"><h3 class="text-xl font-bold text-navy">Our Vision</h3><p class="mt-3">{{ $site['vision'] ?? '' }}</p></div>
    <div class="rounded-2xl  bg-slate-50 p-8"><h3 class="text-xl font-bold text-navy">Our Mission</h3><p class="mt-3">{{ $site['mission'] ?? '' }}</p></div>
</section>

<section class="mx-auto mt-16 grid max-w-7xl gap-10 px-4 md:grid-cols-2">
    <div>
        <h3 class="text-2xl font-bold text-navy">Our Values</h3>
        <ul class="mt-4 space-y-3">
            @foreach (array_filter(array_map('trim', explode("\n", $site['values'] ?? ''))) as $v)
                <li class="flex gap-3"><span class="mt-1 text-brand">&#9679;</span><span>{{ $v }}</span></li>
            @endforeach
        </ul>
    </div>
    <div>
        <h3 class="text-2xl font-bold text-navy">Quality Objectives</h3>
        <ul class="mt-4 space-y-3">
            @foreach (array_filter(array_map('trim', explode("\n", $site['objectives'] ?? ''))) as $v)
                <li class="flex gap-3"><span class="mt-1 text-brand">&#9679;</span><span>{{ $v }}</span></li>
            @endforeach
        </ul>
    </div>
</section>

@if ($team->isNotEmpty())
<section class="mx-auto mt-20 max-w-7xl px-4">
    <h2 class="section-title text-center">Our Team</h2>
    <p class="mx-auto mt-3 max-w-3xl text-center">{{ $site['team_intro'] ?? '' }}</p>
    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($team as $m)
            <div class="rounded-2xl border bg-white p-6 text-center shadow-sm">
                @if ($m->photo)
                    <img src="{{ asset('storage/'.$m->photo) }}" alt="{{ $m->name }}" class="mx-auto h-28 w-28 rounded-full object-cover">
                @else
                    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-navy text-3xl font-bold text-white">{{ mb_substr($m->name, 0, 1) }}</div>
                @endif
                <h3 class="mt-4 text-lg font-bold text-navy">{{ $m->name }}</h3>
                <p class="text-sm font-semibold text-brand">{{ $m->title }}</p>
                @if ($m->bio)<p class="mt-2 text-sm">{{ $m->bio }}</p>@endif
                @if ($m->phone)<a href="tel:{{ preg_replace('/\s+/', '', $m->phone) }}" class="mt-2 block text-sm hover:underline">{{ $m->phone }}</a>@endif
            </div>
        @endforeach
    </div>
</section>
@endif

<div class="mt-20">@include('partials.clients')</div>
@endsection
