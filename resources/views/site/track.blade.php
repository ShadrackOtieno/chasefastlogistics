@extends('layouts.site')
@section('title', 'Track Your Shipment')
@section('description', 'Track your air, sea or land shipment with Chase Fast Logistics.')
@section('content')
@include('partials.page-header', ['title' => 'Track Your Shipment', 'subtitle' => 'Enter the tracking number we gave you to see the latest status.'])
<section class="mx-auto max-w-3xl px-4 pt-16">
    <form method="GET" action="{{ route('track') }}" class="flex gap-2">
        <input name="number" value="{{ $number }}" required placeholder="Tracking number" class="input !py-3">
        <button class="btn">Track</button>
    </form>

    @if ($number !== '' && ! $shipment)
        <div class="mt-8 rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            We could not find a shipment with the number <strong>{{ $number }}</strong>. Please check it and try again, or call our hotline <strong>{{ $site['hotline'] ?? '' }}</strong>.
        </div>
    @endif

    @if ($shipment)
        <div class="mt-8 overflow-hidden rounded-2xl border shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 bg-navy px-6 py-5 text-white">
                <div><div class="text-xs uppercase tracking-widest text-white/60">Tracking number</div><div class="text-xl font-bold">{{ $shipment->tracking_number }}</div></div>
                <span class="rounded-full bg-brand px-4 py-1 text-sm font-semibold">{{ $shipment->statusLabel() }}</span>
            </div>
            <dl class="grid gap-4 p-6 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-500">Mode</dt><dd class="font-semibold">{{ \App\Models\Shipment::MODES[$shipment->mode] ?? $shipment->mode }} freight</dd></div>
                <div><dt class="text-slate-500">Route</dt><dd class="font-semibold">{{ $shipment->origin }} &rarr; {{ $shipment->destination }}</dd></div>
                <div><dt class="text-slate-500">Current location</dt><dd class="font-semibold">{{ $shipment->current_location ?: 'Not available' }}</dd></div>
                <div><dt class="text-slate-500">Estimated arrival</dt><dd class="font-semibold">{{ $shipment->eta?->format('d M Y') ?? 'To be confirmed' }}</dd></div>
                @if ($shipment->description)<div class="sm:col-span-2"><dt class="text-slate-500">Cargo</dt><dd class="font-semibold">{{ $shipment->description }}</dd></div>@endif
            </dl>
            <div class="border-t p-6">
                <h2 class="mb-4 font-bold text-navy">Shipment history</h2>
                <ol class="relative space-y-6 border-l-2 border-slate-200 pl-6">
                    @foreach ($shipment->events as $e)
                        <li class="relative">
                            <span class="absolute -left-[31px] top-1 h-3 w-3 rounded-full {{ $loop->first ? 'bg-brand ring-4 ring-brand/20' : 'bg-slate-400' }}"></span>
                            <div class="text-sm font-semibold text-slate-800">{{ \App\Models\Shipment::STATUSES[$e->status] ?? $e->status }}@if ($e->location) <span class="font-normal text-slate-500">&middot; {{ $e->location }}</span>@endif</div>
                            @if ($e->note)<div class="text-sm">{{ $e->note }}</div>@endif
                            <div class="text-xs text-slate-500">{{ $e->occurred_at->format('d M Y, H:i') }}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endif
</section>
@endsection
