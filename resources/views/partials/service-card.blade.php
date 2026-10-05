<a href="{{ route('services.show', $service) }}" class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-navy/5 text-navy"><x-icon :name="$service->icon ?: 'package'" class="h-7 w-7" /></div>
    <h3 class="text-lg font-bold text-navy">{{ $service->title }}</h3>
    <p class="mt-2 flex-1 text-sm leading-relaxed">{{ $service->summary }}</p>
    <span class="mt-4 text-sm font-semibold text-brand group-hover:underline">Learn more &rarr;</span>
</a>
