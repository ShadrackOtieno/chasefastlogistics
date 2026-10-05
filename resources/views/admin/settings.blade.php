@extends('layouts.admin')
@section('title', 'Site settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-4xl space-y-8">
    @csrf @method('PUT')
    @foreach ($schema as $group => $fields)
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-navy">{{ $group }}</h2>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($fields as $key => [$label, $type])
                    <div class="{{ $type === 'textarea' ? 'md:col-span-2' : '' }}">
                        <label class="label" for="s_{{ $key }}">{{ $label }}</label>
                        @if ($type === 'textarea')
                            <textarea id="s_{{ $key }}" name="{{ $key }}" rows="4" class="input">{{ old($key, $values[$key] ?? '') }}</textarea>
                        @else
                            <input id="s_{{ $key }}" name="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}" class="input">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <button class="btn-red">Save settings</button>
</form>
@endsection
