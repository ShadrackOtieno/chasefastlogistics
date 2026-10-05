@extends('layouts.admin')
@section('title', 'Quote requests')
@section('content')
<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('admin.quotes.index') }}" class="rounded-full px-4 py-1 text-sm {{ request('status') ? 'bg-white' : 'bg-navy text-white' }}">All</a>
    @foreach (\App\Models\QuoteRequest::STATUSES as $k => $l)
        <a href="{{ route('admin.quotes.index', ['status' => $k]) }}" class="rounded-full px-4 py-1 text-sm {{ request('status') === $k ? 'bg-navy text-white' : 'bg-white' }}">{{ $l }}</a>
    @endforeach
</div>
<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full">
        <thead class="border-b bg-slate-50"><tr><th class="th">Ref</th><th class="th">Customer</th><th class="th">Service</th><th class="th">Route</th><th class="th">Status</th><th class="th">Received</th></tr></thead>
        <tbody class="divide-y">
            @forelse ($quotes as $q)
                <tr class="hover:bg-slate-50">
                    <td class="td"><a class="font-semibold text-navy" href="{{ route('admin.quotes.show', $q) }}">{{ $q->reference }}</a></td>
                    <td class="td">{{ $q->name }}<div class="text-xs text-slate-500">{{ $q->company }}</div></td>
                    <td class="td">{{ $q->service_type }}</td>
                    <td class="td">{{ $q->origin }} → {{ $q->destination }}</td>
                    <td class="td"><span class="rounded-full px-2 py-0.5 text-xs {{ $q->status === 'new' ? 'bg-brand text-white' : 'bg-slate-100' }}">{{ \App\Models\QuoteRequest::STATUSES[$q->status] ?? $q->status }}</span></td>
                    <td class="td text-slate-500">{{ $q->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="td py-10 text-center text-slate-500">No quote requests.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $quotes->links() }}</div>
@endsection
