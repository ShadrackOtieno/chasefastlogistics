@extends('layouts.site')
@section('title', 'Our Services')
@section('description', 'Air freight, sea freight, overland transport, customs clearance, warehousing and project forwarding in Kenya and East Africa.')
@section('content')
@include('partials.page-header', ['title' => 'Our Services', 'subtitle' => 'Traffic by sea, air and overland, domestically and internationally, plus warehousing, distribution and customs brokerage.'])
<section class="mx-auto max-w-7xl px-4 pt-16">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service) @include('partials.service-card') @endforeach
    </div>
</section>
@endsection
