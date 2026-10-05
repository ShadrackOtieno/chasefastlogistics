@extends('layouts.site')
@section('title', 'Our Rates')
@section('description', 'Indicative clearing, forwarding and transport rates from Chase Fast Logistics.')
@section('content')
@include('partials.page-header', ['title' => 'Our Rates', 'subtitle' => 'Indicative rates in Kenya Shillings (KES). Request a quote for exact pricing on your shipment.'])
<section class="mx-auto max-w-5xl px-4 pt-16">
    <div class="space-y-10">
        @forelse ($groups as $group => $rates)
            <div class="overflow-hidden rounded-2xl border shadow-sm">
                <h2 class="bg-navy px-6 py-4 text-lg font-bold text-white">{{ $group }}</h2>
                <table class="w-full text-sm">
                    <tbody class="divide-y">
                        @foreach ($rates as $r)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $r->item }}@if ($r->note)<div class="text-xs font-normal text-slate-500">{{ $r->note }}</div>@endif</td>
                                <td class="px-6 py-4 text-right font-bold text-navy">@if (!is_null($r->amount))KES {{ number_format($r->amount, $r->amount == floor($r->amount) ? 0 : 2) }}@endif</td>
                                <td class="w-32 px-6 py-4 text-slate-500">{{ $r->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <p class="text-center">Rates are available on request. Please <a class="text-brand underline" href="{{ route('quote.create') }}">request a quote</a>.</p>
        @endforelse
    </div>

    @if (!empty($site['vat_note']))<p class="mt-8 rounded-lg bg-amber-50 p-4 text-sm text-amber-900">{{ $site['vat_note'] }}</p>@endif

    <div class="mt-10 grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl bg-slate-50 p-6"><h3 class="flex items-center gap-2 font-bold text-navy"><x-icon name="plane" class="h-5 w-5" /> Air freight grace period</h3><p class="mt-2 text-sm">{{ $site['grace_air'] ?? '' }}</p></div>
        <div class="rounded-2xl bg-slate-50 p-6"><h3 class="flex items-center gap-2 font-bold text-navy"><x-icon name="ship" class="h-5 w-5" /> Sea freight grace period</h3><p class="mt-2 text-sm">{{ $site['grace_sea'] ?? '' }}</p></div>
    </div>
    <div class="mt-10 text-center"><a href="{{ route('quote.create') }}" class="btn">Request an exact quote</a></div>
</section>
@endsection
