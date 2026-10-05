<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Sign in | Back Office</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { navy: '#0b2a5b', brand: '#d62839' } } } }</script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-navy to-slate-800 p-4">
    <form method="POST" action="{{ route('admin.login.submit') }}" class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
        @csrf
        <img src="{{ asset('images/logo.png') }}" alt="" class="mx-auto h-16">
        <h1 class="mt-3 text-center text-xl font-extrabold text-navy">Back Office</h1>
        <p class="mb-6 text-center text-sm text-slate-500">{{ $site['company_name'] ?? 'Chase Fast Logistics Limited' }}</p>
        @error('email')<div class="mb-4 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700">{{ $message }}</div>@enderror
        <label class="mb-1 block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mb-4 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
        <label class="mb-1 block text-sm font-medium">Password</label>
        <input type="password" name="password" required class="mb-4 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/20">
        <label class="mb-6 flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Remember me</label>
        <button class="w-full rounded-lg bg-brand py-2.5 text-sm font-semibold text-white hover:bg-red-700">Sign in</button>
    </form>
</body>
</html>
