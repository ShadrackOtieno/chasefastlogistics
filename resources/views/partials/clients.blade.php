@if ($clients->isNotEmpty())
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-4">
        <h2 class="section-title text-center">Trusted by reputable clients</h2>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($clients as $c)
                <div class="flex items-center gap-4 rounded-xl border bg-white p-5">
                    @if ($c->logo)
                        <img src="{{ asset('storage/'.$c->logo) }}" alt="{{ $c->name }}" class="h-12 w-16 object-contain">
                    @else
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-navy text-lg font-bold text-white">{{ mb_substr($c->name, 0, 1) }}</span>
                    @endif
                    <span class="font-semibold text-navy">{{ $c->name }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
