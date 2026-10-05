@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'Add ').strtolower($singular))
@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $item->exists ? route('admin.'.$route.'.update', $item) : route('admin.'.$route.'.store') }}"
      class="grid max-w-4xl gap-5 rounded-xl bg-white p-6 shadow-sm md:grid-cols-2">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    @foreach ($fields as $name => $f)
        @php
            $type = $f['type'] ?? 'text';
            $val = old($name, $item->exists ? $item->{$name} : ($f['default'] ?? null));
        @endphp
        <div class="{{ !empty($f['wide']) ? 'md:col-span-2' : '' }}">
            @if ($type === 'checkbox')
                <label class="flex items-center gap-2 pt-6 text-sm font-medium">
                    <input type="hidden" name="{{ $name }}" value="0">
                    <input type="checkbox" name="{{ $name }}" value="1" @checked($val)> {{ $f['label'] }}
                </label>
            @else
                <label class="label" for="f_{{ $name }}">{{ $f['label'] }}</label>
                @if ($type === 'textarea')
                    <textarea id="f_{{ $name }}" name="{{ $name }}" rows="{{ $f['rows'] ?? 4 }}" class="input">{{ $val }}</textarea>
                @elseif ($type === 'select')
                    <select id="f_{{ $name }}" name="{{ $name }}" class="input">
                        @foreach ($f['options'] as $k => $label)<option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $label }}</option>@endforeach
                    </select>
                @elseif ($type === 'image')
                    @if ($item->exists && $item->{$name})<img src="{{ asset('storage/'.$item->{$name}) }}" class="mb-2 h-24 rounded border object-cover" alt="">@endif
                    <input id="f_{{ $name }}" type="file" name="{{ $name }}" accept="image/*" class="input">
                @else
                    <input id="f_{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ $val }}" @if (!empty($f['step'])) step="{{ $f['step'] }}" @endif class="input">
                @endif
                @isset($f['help'])<p class="mt-1 text-xs text-slate-500">{{ $f['help'] }}</p>@endisset
            @endif
        </div>
    @endforeach

    <div class="flex gap-3 md:col-span-2">
        <button class="btn-red">Save</button>
        <a href="{{ route('admin.'.$route.'.index') }}" class="btn-light">Cancel</a>
    </div>
</form>
@endsection
