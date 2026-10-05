@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-slate-500">{{ $items->total() }} {{ strtolower($title) }}</p>
    <a href="{{ route('admin.'.$route.'.create') }}" class="btn-red">+ Add {{ strtolower($singular) }}</a>
</div>
<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full">
        <thead class="border-b bg-slate-50">
            <tr>
                @foreach ($columns as $c)<th class="th">{{ $c['label'] }}</th>@endforeach
                <th class="th text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($items as $item)
                <tr class="hover:bg-slate-50">
                    @foreach ($columns as $c)
                        @php $v = $item->{$c['key']}; @endphp
                        <td class="td">
                            @switch($c['type'] ?? 'text')
                                @case('icon') <x-icon :name="$v ?: 'package'" class="h-5 w-5 text-navy" /> @break
                                @case('bool') <span class="rounded-full px-2 py-0.5 text-xs {{ $v ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-600' }}">{{ $v ? 'Yes' : 'No' }}</span> @break
                                @case('image') @if ($v)<img src="{{ asset('storage/'.$v) }}" class="h-10 w-10 rounded object-cover" alt="">@endif @break
                                @case('money') {{ is_null($v) ? '' : number_format($v, 2) }} @break
                                @default {{ $v }}
                            @endswitch
                        </td>
                    @endforeach
                    <td class="td whitespace-nowrap text-right">
                        <a href="{{ route('admin.'.$route.'.edit', $item) }}" class="btn-light !py-1">Edit</a>
                        <form method="POST" action="{{ route('admin.'.$route.'.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete this {{ strtolower($singular) }}?')">
                            @csrf @method('DELETE')
                            <button class="rounded-lg border border-red-200 px-3 py-1 text-sm text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) + 1 }}" class="td py-10 text-center text-slate-500">Nothing here yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $items->links() }}</div>
@endsection
