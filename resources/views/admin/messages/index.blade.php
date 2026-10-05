@extends('layouts.admin')
@section('title', 'Messages')
@section('content')
<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full">
        <thead class="border-b bg-slate-50"><tr><th class="th">From</th><th class="th">Subject</th><th class="th">Received</th></tr></thead>
        <tbody class="divide-y">
            @forelse ($messages as $m)
                <tr class="hover:bg-slate-50 {{ $m->is_read ? '' : 'bg-blue-50/40' }}">
                    <td class="td {{ $m->is_read ? '' : 'font-bold' }}">{{ $m->name }}<div class="text-xs font-normal text-slate-500">{{ $m->email }}</div></td>
                    <td class="td"><a class="{{ $m->is_read ? '' : 'font-bold' }} text-navy" href="{{ route('admin.messages.show', $m) }}">{{ $m->subject }}</a></td>
                    <td class="td text-slate-500">{{ $m->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="td py-10 text-center text-slate-500">No messages.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $messages->links() }}</div>
@endsection
