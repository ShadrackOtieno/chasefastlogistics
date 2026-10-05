@extends('layouts.admin')
@section('title', 'Shipment '.$shipment->tracking_number)
@section('content')
<div class="grid gap-6 xl:grid-cols-3">
    <div class="space-y-6 xl:col-span-2">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <div class="text-xs uppercase tracking-wider text-slate-500">Tracking number</div>
                    <div class="text-2xl font-extrabold text-navy">{{ $shipment->tracking_number }}</div>
                    <a class="text-xs text-brand hover:underline" target="_blank" href="{{ route('track', ['number' => $shipment->tracking_number]) }}">View public tracking page ↗</a>
                </div>
                <span class="rounded-full bg-navy px-4 py-1 text-sm font-semibold text-white">{{ $shipment->statusLabel() }}</span>
            </div>
            <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-500">Customer</dt><dd class="font-semibold">{{ $shipment->customer_name }} @if ($shipment->customer_email)<a class="font-normal text-brand" href="mailto:{{ $shipment->customer_email }}">({{ $shipment->customer_email }})</a>@endif</dd></div>
                <div><dt class="text-slate-500">Mode</dt><dd class="font-semibold">{{ \App\Models\Shipment::MODES[$shipment->mode] ?? $shipment->mode }}</dd></div>
                <div><dt class="text-slate-500">Route</dt><dd class="font-semibold">{{ $shipment->origin }} → {{ $shipment->destination }}</dd></div>
                <div><dt class="text-slate-500">Current location</dt><dd class="font-semibold">{{ $shipment->current_location ?: '-' }}</dd></div>
                <div><dt class="text-slate-500">ETA</dt><dd class="font-semibold">{{ $shipment->eta?->format('d M Y') ?? '-' }}</dd></div>
                <div><dt class="text-slate-500">Cargo</dt><dd class="font-semibold">{{ $shipment->description ?: '-' }}</dd></div>
            </dl>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('admin.shipments.edit', $shipment) }}" class="btn-light">Edit details</a>
                <form method="POST" action="{{ route('admin.shipments.destroy', $shipment) }}" onsubmit="return confirm('Delete this shipment and its history?')">@csrf @method('DELETE')
                    <button class="rounded-lg border border-red-200 px-4 py-2 text-sm text-red-700 hover:bg-red-50">Delete</button></form>
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 font-bold text-navy">History</h2>
            <ol class="space-y-4">
                @foreach ($shipment->events as $e)
                    <li class="flex items-start justify-between gap-4 border-b pb-4 last:border-0">
                        <div>
                            <div class="text-sm font-semibold">{{ \App\Models\Shipment::STATUSES[$e->status] ?? $e->status }} @if ($e->location)<span class="font-normal text-slate-500">· {{ $e->location }}</span>@endif</div>
                            @if ($e->note)<div class="text-sm">{{ $e->note }}</div>@endif
                            <div class="text-xs text-slate-400">{{ $e->occurred_at->format('d M Y H:i') }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.shipments.events.destroy', [$shipment, $e]) }}" onsubmit="return confirm('Remove this update?')">@csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">Remove</button></form>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.shipments.events.store', $shipment) }}" class="h-fit space-y-4 rounded-xl bg-white p-6 shadow-sm">
        @csrf
        <h2 class="font-bold text-navy">Add tracking update</h2>
        <div><label class="label">New status</label>
            <select name="status" class="input">@foreach (\App\Models\Shipment::STATUSES as $k => $l)<option value="{{ $k }}" @selected($shipment->status === $k)>{{ $l }}</option>@endforeach</select></div>
        <div><label class="label">Location</label><input name="location" class="input" value="{{ $shipment->current_location }}"></div>
        <div><label class="label">Note (visible to customer)</label><input name="note" class="input"></div>
        <div><label class="label">Date &amp; time</label><input type="datetime-local" name="occurred_at" class="input" value="{{ now()->format('Y-m-d\TH:i') }}" required></div>
        <button class="btn-red w-full justify-center">Publish update</button>
    </form>
</div>
@endsection
