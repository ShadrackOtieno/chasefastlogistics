@extends('layouts.admin')
@section('title', $message->subject)
@section('content')
<div class="max-w-3xl rounded-xl bg-white p-6 shadow-sm">
    <div class="text-sm text-slate-500">From <strong class="text-slate-800">{{ $message->name }}</strong> &lt;<a class="text-brand" href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}">{{ $message->email }}</a>&gt; @if ($message->phone) · {{ $message->phone }} @endif · {{ $message->created_at->format('d M Y H:i') }}</div>
    <p class="mt-6 whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
    <div class="mt-8 flex gap-3">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn">Reply by email</a>
        <a href="{{ route('admin.messages.index') }}" class="btn-light">Back</a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')
            <button class="rounded-lg border border-red-200 px-4 py-2 text-sm text-red-700 hover:bg-red-50">Delete</button></form>
    </div>
</div>
@endsection
