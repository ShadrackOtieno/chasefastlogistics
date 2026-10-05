@extends('layouts.admin')
@section('title', $shipment->exists ? 'Edit shipment' : 'New shipment')
@section('content')
<form method="POST" action="{{ $shipment->exists ? route('admin.shipments.update', $shipment) : route('admin.shipments.store') }}" class="grid max-w-4xl gap-5 rounded-xl bg-white p-6 shadow-sm md:grid-cols-2">
    @csrf
    @if ($shipment->exists) @method('PUT') @endif
    <div><label class="label">Tracking number</label><input class="input" name="tracking_number" value="{{ old('tracking_number', $shipment->tracking_number) }}" placeholder="Leave blank to auto-generate"></div>
    <div><label class="label">Customer name *</label><input class="input" name="customer_name" value="{{ old('customer_name', $shipment->customer_name) }}" required></div>
    <div><label class="label">Customer email</label><input type="email" class="input" name="customer_email" value="{{ old('customer_email', $shipment->customer_email) }}"></div>
    <div><label class="label">Mode *</label>
        <select class="input" name="mode">@foreach (\App\Models\Shipment::MODES as $k => $l)<option value="{{ $k }}" @selected(old('mode', $shipment->mode) === $k)>{{ $l }}</option>@endforeach</select></div>
    <div><label class="label">Origin *</label><input class="input" name="origin" value="{{ old('origin', $shipment->origin) }}" required></div>
    <div><label class="label">Destination *</label><input class="input" name="destination" value="{{ old('destination', $shipment->destination) }}" required></div>
    <div class="md:col-span-2"><label class="label">Cargo description</label><input class="input" name="description" value="{{ old('description', $shipment->description) }}"></div>
    <div><label class="label">Status *</label>
        <select class="input" name="status">@foreach (\App\Models\Shipment::STATUSES as $k => $l)<option value="{{ $k }}" @selected(old('status', $shipment->status) === $k)>{{ $l }}</option>@endforeach</select></div>
    <div><label class="label">Current location</label><input class="input" name="current_location" value="{{ old('current_location', $shipment->current_location) }}"></div>
    <div><label class="label">Estimated arrival</label><input type="date" class="input" name="eta" value="{{ old('eta', $shipment->eta?->format('Y-m-d')) }}"></div>
    <div class="flex gap-3 md:col-span-2">
        <button class="btn-red">Save</button>
        <a href="{{ $shipment->exists ? route('admin.shipments.show', $shipment) : route('admin.shipments.index') }}" class="btn-light">Cancel</a>
    </div>
</form>
@endsection
