<section class="bg-navy text-white">
    <div class="mx-auto max-w-7xl px-4 py-14">
        <h1 class="flex items-center gap-3 text-3xl font-extrabold sm:text-4xl">@isset($icon)<x-icon :name="$icon" class="h-9 w-9 text-white/80" />@endisset{{ $title }}</h1>
        @isset($subtitle)<p class="mt-3 max-w-2xl text-white/80">{{ $subtitle }}</p>@endisset
    </div>
</section>
