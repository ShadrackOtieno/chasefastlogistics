@extends('layouts.site')
@section('title', 'Request a Quote')
@section('description', 'Request a clearing, forwarding or transport quote from Chase Fast Logistics.')
@section('content')
@include('partials.page-header', ['title' => 'Request a Quote', 'subtitle' => 'Tell us about your cargo and we will get back to you quickly.'])
<section class="mx-auto max-w-3xl px-4 pt-16">
    @if (session('quote_ref'))
        <div class="rounded-2xl border border-green-200 bg-green-50 p-8 text-center">
            <x-icon name="check-circle" class="mx-auto h-12 w-12 text-green-600" />
            <h2 class="mt-3 text-2xl font-bold text-green-900">Thank you, we have your request</h2>
            <p class="mt-2 text-green-900">Your reference is <strong>{{ session('quote_ref') }}</strong>. A member of our team will contact you shortly.</p>
            <a href="{{ route('home') }}" class="btn mt-6">Back to home</a>
        </div>
    @else
        <form method="POST" action="{{ route('quote.store') }}" class="grid gap-5 rounded-2xl border bg-white p-6 shadow-sm sm:grid-cols-2 sm:p-8">
            @csrf
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
            @php
                $f = fn ($n) => old($n);
            @endphp
            <div><label class="label">Full name *</label><input class="input" name="name" value="{{ $f('name') }}" required>@error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Company</label><input class="input" name="company" value="{{ $f('company') }}">@error('company')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Email *</label><input type="email" class="input" name="email" value="{{ $f('email') }}" required>@error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Phone *</label><input class="input" name="phone" value="{{ $f('phone') }}" required>@error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2">
                <label class="label">Service needed *</label>
                <select class="input" name="service_type" required>
                    <option value="">Select a service</option>
                    @foreach (\App\Models\QuoteRequest::SERVICE_TYPES as $t)
                        <option value="{{ $t }}" @selected(old('service_type', $selected) === $t)>{{ $t }}</option>
                    @endforeach
                </select>
                @error('service_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div><label class="label">Origin (port / city / country) *</label><input class="input" name="origin" value="{{ $f('origin') }}" required>@error('origin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Destination *</label><input class="input" name="destination" value="{{ $f('destination') }}" required>@error('destination')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Approx. weight / volume</label><input class="input" name="weight" value="{{ $f('weight') }}" placeholder="e.g. 450 kg or 12 CBM">@error('weight')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="label">Container type (if any)</label>
                <select class="input" name="container_type"><option value="">None / not sure</option>
                    @foreach (['20ft', '40ft', '40ft High Cube', 'LCL / Consolidation'] as $c)<option @selected(old('container_type') === $c)>{{ $c }}</option>@endforeach
                </select>
            </div>
            <div class="sm:col-span-2"><label class="label">Cargo description *</label><textarea class="input" name="cargo_description" rows="3" required>{{ $f('cargo_description') }}</textarea>@error('cargo_description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div class="sm:col-span-2"><label class="label">Anything else we should know?</label><textarea class="input" name="message" rows="3">{{ $f('message') }}</textarea></div>
            <div class="sm:col-span-2"><button class="btn w-full">Submit quote request</button></div>
        </form>
    @endif
</section>
@endsection
