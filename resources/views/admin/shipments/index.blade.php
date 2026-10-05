@extends('layouts.admin')
@section('title', 'Shipments')
@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <form method="GET" class="flex flex-wrap gap-2">
        <input name="q" value="{{ request('q') }}" placeholder="Search tracking no. or customer" class="input !w-64">
        <select name="status" class="input !w-48" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach (\App\Models\Shipment::STATUSES as $k => $l)<option value="{{ $k }}" @selected(request('status') === $k)>{{ $l }}</option>@endforeach
        </select>
        <button class="btn-light">Search</button>
    </form>
    <a href="{{ route('admin.shipments.create') }}" class="btn-red">+ New shipment</a>
</div>
<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full">
        <thead class="border-b bg-slate-50"><tr><th class="th">Tracking no.</th><th class="th">Customer</th><th class="th">Route</th><th class="th">Mode</th><th class="th">Status</th><th class="th">ETA</th></tr></thead>
        <tbody class="divide-y">
            @forelse ($shipments as $s)
                <tr class="hover:bg-slate-50">
                    <td class="td"><a class="font-semibold text-navy" href="{{ route('admin.shipments.show', $s) }}">{{ $s->tracking_number }}</a></td>
                    <td class="td">{{ $s->customer_name }}</td>
                    <td class="td">{{ $s->origin }} → {{ $s->destination }}</td>
                    <td class="td">{{ \App\Models\Shipment::MODES[$s->mode] ?? $s->mode }}</td>
                    <td class="td"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs">{{ $s->statusLabel() }}</span></td>
                    <td class="td">{{ $s->eta?->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="td py-10 text-center text-slate-500">No shipments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $shipments->links() }}</div>
@endsection
