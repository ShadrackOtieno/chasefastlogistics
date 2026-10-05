@extends('layouts.admin')
@section('title', 'My account')
@section('content')
<form method="POST" action="{{ route('admin.account.update') }}" class="grid max-w-2xl gap-5 rounded-xl bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <div><label class="label">Name</label><input class="input" name="name" value="{{ old('name', auth()->user()->name) }}" required></div>
    <div><label class="label">Email</label><input type="email" class="input" name="email" value="{{ old('email', auth()->user()->email) }}" required></div>
    <hr>
    <p class="text-sm text-slate-500">Leave the password fields blank to keep your current password.</p>
    <div><label class="label">Current password</label><input type="password" class="input" name="current_password" autocomplete="current-password"></div>
    <div><label class="label">New password (min. 10 characters)</label><input type="password" class="input" name="password" autocomplete="new-password"></div>
    <div><label class="label">Confirm new password</label><input type="password" class="input" name="password_confirmation" autocomplete="new-password"></div>
    <div><button class="btn-red">Save</button></div>
</form>
@endsection
