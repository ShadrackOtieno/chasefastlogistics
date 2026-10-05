@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ([['New quote requests', $newQuotes, 'admin.quotes.index', 'text-brand'], ['Unread messages', $unread, 'admin.messages.index', 'text-brand'], ['Active shipments', $active, 'admin.shipments.index', 'text-navy'], ['Total shipments', $totalShipments, 'admin.shipments.index', 'text-navy']] as [$label, $n, $r, $c])
        <a href="{{ route($r) }}" class="rounded-xl bg-white p-5 shadow-sm hover:shadow-md">
            <div class="text-sm text-slate-500">{{ $label }}</div>
            <div class="mt-1 text-3xl font-extrabold {{ $c }}">{{ $n }}</div>
        </a>
    @endforeach
</div>

<div class="mt-8 grid gap-6 xl:grid-cols-2">
    <div class="rounded-xl bg-white shadow-sm">
        <div class="flex items-center justify-between border-b px-5 py-4"><h2 class="font-bold text-navy">Latest quote requests</h2><a href="{{ route('admin.quotes.index') }}" class="text-sm text-brand">View all</a></div>
        <table class="w-full">
            @forelse ($quotes as $q)
                <tr class="border-b last:border-0 hover:bg-slate-50">
                    <td class="td"><a href="{{ route('admin.quotes.show', $q) }}" class="font-semibold text-navy">{{ $q->name }}</a><div class="text-xs text-slate-500">{{ $q->service_type }} · {{ $q->origin }} → {{ $q->destination }}</div></td>
                    <td class="td text-right"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs">{{ \App\Models\QuoteRequest::STATUSES[$q->status] ?? $q->status }}</span><div class="text-xs text-slate-400">{{ $q->created_at->diffForHumans() }}</div></td>
                </tr>
            @empty
                <tr><td class="td text-slate-500">No quote requests yet.</td></tr>
            @endforelse
        </table>
    </div>

    <div class="rounded-xl bg-white shadow-sm">
        <div class="flex items-center justify-between border-b px-5 py-4"><h2 class="font-bold text-navy">Latest messages</h2><a href="{{ route('admin.messages.index') }}" class="text-sm text-brand">View all</a></div>
        <table class="w-full">
            @forelse ($messages as $m)
                <tr class="border-b last:border-0 hover:bg-slate-50">
                    <td class="td"><a href="{{ route('admin.messages.show', $m) }}" class="{{ $m->is_read ? '' : 'font-bold' }} text-navy">{{ $m->subject }}</a><div class="text-xs text-slate-500">{{ $m->name }}</div></td>
                    <td class="td text-right text-xs text-slate-400">{{ $m->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td class="td text-slate-500">No messages yet.</td></tr>
            @endforelse
        </table>
    </div>

    <div class="rounded-xl bg-white shadow-sm xl:col-span-2">
        <div class="flex items-center justify-between border-b px-5 py-4"><h2 class="font-bold text-navy">Recent tracking updates</h2><a href="{{ route('admin.shipments.create') }}" class="btn">+ New shipment</a></div>
        <table class="w-full">
            @forelse ($events as $e)
                <tr class="border-b last:border-0 hover:bg-slate-50">
                    <td class="td"><a href="{{ route('admin.shipments.show', $e->shipment_id) }}" class="font-semibold text-navy">{{ $e->shipment?->tracking_number }}</a></td>
                    <td class="td">{{ \App\Models\Shipment::STATUSES[$e->status] ?? $e->status }}</td>
                    <td class="td text-slate-500">{{ $e->location }}</td>
                    <td class="td text-right text-xs text-slate-400">{{ $e->occurred_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td class="td text-slate-500">No shipments yet.</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
