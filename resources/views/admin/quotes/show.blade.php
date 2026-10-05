@extends('layouts.admin')
@section('title', 'Quote '.$quote->reference)
@section('content')
<div class="grid gap-6 xl:grid-cols-3">
    <div class="rounded-xl bg-white p-6 shadow-sm xl:col-span-2">
        <dl class="grid gap-4 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-500">Name</dt><dd class="font-semibold">{{ $quote->name }}</dd></div>
            <div><dt class="text-slate-500">Company</dt><dd class="font-semibold">{{ $quote->company ?: '-' }}</dd></div>
            <div><dt class="text-slate-500">Email</dt><dd><a class="font-semibold text-brand" href="mailto:{{ $quote->email }}?subject=Re: Quote {{ $quote->reference }}">{{ $quote->email }}</a></dd></div>
            <div><dt class="text-slate-500">Phone</dt><dd><a class="font-semibold text-brand" href="tel:{{ preg_replace('/\s+/', '', $quote->phone) }}">{{ $quote->phone }}</a></dd></div>
            <div><dt class="text-slate-500">Service</dt><dd class="font-semibold">{{ $quote->service_type }}</dd></div>
            <div><dt class="text-slate-500">Route</dt><dd class="font-semibold">{{ $quote->origin }} → {{ $quote->destination }}</dd></div>
            <div><dt class="text-slate-500">Weight / volume</dt><dd class="font-semibold">{{ $quote->weight ?: '-' }}</dd></div>
            <div><dt class="text-slate-500">Container</dt><dd class="font-semibold">{{ $quote->container_type ?: '-' }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-slate-500">Cargo</dt><dd class="whitespace-pre-line font-semibold">{{ $quote->cargo_description }}</dd></div>
            @if ($quote->message)<div class="sm:col-span-2"><dt class="text-slate-500">Message</dt><dd class="whitespace-pre-line">{{ $quote->message }}</dd></div>@endif
            <div><dt class="text-slate-500">Received</dt><dd>{{ $quote->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>
    <div class="space-y-4">
        <form method="POST" action="{{ route('admin.quotes.update', $quote) }}" class="space-y-4 rounded-xl bg-white p-6 shadow-sm">
            @csrf @method('PUT')
            <div><label class="label">Status</label>
                <select name="status" class="input">@foreach (\App\Models\QuoteRequest::STATUSES as $k => $l)<option value="{{ $k }}" @selected($quote->status === $k)>{{ $l }}</option>@endforeach</select></div>
            <div><label class="label">Internal notes</label><textarea name="admin_notes" rows="6" class="input">{{ old('admin_notes', $quote->admin_notes) }}</textarea></div>
            <button class="btn-red w-full justify-center">Save</button>
        </form>
        <form method="POST" action="{{ route('admin.quotes.destroy', $quote) }}" onsubmit="return confirm('Delete this quote request?')">@csrf @method('DELETE')
            <button class="w-full rounded-lg border border-red-200 bg-white px-4 py-2 text-sm text-red-700 hover:bg-red-50">Delete request</button></form>
        <a href="{{ route('admin.quotes.index') }}" class="block text-center text-sm text-slate-500 hover:underline">← Back to all requests</a>
    </div>
</div>
@endsection
