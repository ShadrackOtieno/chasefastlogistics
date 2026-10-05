@extends('layouts.site')
@section('title', 'Contact Us')
@section('description', 'Contact Chase Fast Logistics: head office on Mombasa Road, JKIA office and hotline.')
@section('content')
@include('partials.page-header', ['title' => 'Contact Us', 'subtitle' => 'We would be pleased to get into a business agreement with you.'])
<section class="mx-auto grid max-w-7xl gap-10 px-4 pt-16 lg:grid-cols-5">
    <div class="space-y-5 lg:col-span-2">
        <div class="rounded-2xl bg-navy p-6 text-white">
            <h2 class="text-lg font-bold">Head office</h2>
            <p class="mt-2 text-sm text-white/85">{{ $site['address_head_office'] ?? '' }}</p>
            <p class="mt-1 text-sm">{{ $site['phone_head_office'] ?? '' }}</p>
            <h2 class="mt-6 text-lg font-bold">JKIA office</h2>
            <p class="mt-2 text-sm text-white/85">{{ $site['address_jkia'] ?? '' }}</p>
            <p class="mt-1 text-sm">{{ $site['phone_jkia'] ?? '' }}</p>
        </div>
        <div class="rounded-2xl border p-6 text-sm">
            <p><strong class="text-navy">Hotline:</strong> <a class="hover:underline" href="tel:{{ preg_replace('/\s+/', '', $site['hotline'] ?? '') }}">{{ $site['hotline'] ?? '' }}</a></p>
            <p class="mt-2"><strong class="text-navy">Email:</strong> <a class="hover:underline" href="mailto:{{ $site['email'] ?? '' }}">{{ $site['email'] ?? '' }}</a></p>
            <p class="mt-2"><strong class="text-navy">Postal:</strong> {{ $site['po_box'] ?? '' }}</p>
            <p class="mt-2"><strong class="text-navy">Hours:</strong> {{ $site['hours'] ?? '' }}</p>
            <a target="_blank" rel="noopener" class="mt-4 inline-block font-semibold text-brand hover:underline" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($site['address_head_office'] ?? 'Vision Plaza Mombasa Road Nairobi') }}">Open head office in Google Maps &rarr;</a>
        </div>
    </div>

    <form method="POST" action="{{ route('contact.store') }}" class="grid gap-5 rounded-2xl border bg-white p-6 shadow-sm sm:grid-cols-2 sm:p-8 lg:col-span-3">
        @csrf
        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div><label class="label">Name *</label><input class="input" name="name" value="{{ old('name') }}" required>@error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
        <div><label class="label">Email *</label><input type="email" class="input" name="email" value="{{ old('email') }}" required>@error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
        <div><label class="label">Phone</label><input class="input" name="phone" value="{{ old('phone') }}"></div>
        <div><label class="label">Subject *</label><input class="input" name="subject" value="{{ old('subject') }}" required>@error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
        <div class="sm:col-span-2"><label class="label">Message *</label><textarea class="input" name="message" rows="6" required>{{ old('message') }}</textarea>@error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
        <div class="sm:col-span-2"><button class="btn w-full sm:w-auto">Send message</button></div>
    </form>
</section>
@endsection
