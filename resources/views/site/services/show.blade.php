@extends('layouts.site')
@section('title', $service->title)
@section('description', $service->summary)
@section('content')
@include('partials.page-header', ['title' => $service->title, 'subtitle' => $service->summary, 'icon' => $service->icon ?: 'package'])
<section class="mx-auto grid max-w-7xl gap-12 px-4 pt-16 lg:grid-cols-3">
    <article class="lg:col-span-2">
        @if ($service->image)<img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->title }}" class="mb-8 w-full rounded-2xl object-cover">@endif
        @if ($service->body)<p class="text-lg leading-relaxed">{{ $service->body }}</p>@endif
        @if ($service->featureList())
            <h2 class="mt-10 text-2xl font-bold text-navy">What is included</h2>
            <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                @foreach ($service->featureList() as $f)
                    <li class="flex gap-3 rounded-lg bg-slate-50 p-4 text-sm"><x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand" /><span>{{ $f }}</span></li>
                @endforeach
            </ul>
        @endif
        <a href="{{ route('quote.create', ['service' => $service->title]) }}" class="btn mt-10">Request a quote for {{ $service->title }}</a>
    </article>
    <aside class="space-y-6">
        <div class="rounded-2xl bg-navy p-6 text-white">
            <h3 class="font-bold">Talk to us</h3>
            <p class="mt-2 text-sm text-white/80">Hotline</p>
            <a href="tel:{{ preg_replace('/\s+/', '', $site['hotline'] ?? '') }}" class="text-lg font-bold">{{ $site['hotline'] ?? '' }}</a>
            <p class="mt-3 text-sm text-white/80">Email</p>
            <a href="mailto:{{ $site['email'] ?? '' }}" class="text-sm font-semibold">{{ $site['email'] ?? '' }}</a>
        </div>
        <div class="rounded-2xl border p-6">
            <h3 class="font-bold text-navy">Other services</h3>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($others as $o)<li><a class="flex items-center gap-2 hover:text-brand hover:underline" href="{{ route('services.show', $o) }}"><x-icon :name="$o->icon ?: 'package'" class="h-4 w-4 text-navy" /> {{ $o->title }}</a></li>@endforeach
            </ul>
        </div>
    </aside>
</section>
@endsection
