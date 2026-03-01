<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .login-bg{
            background:
                radial-gradient(900px 450px at 10% 10%, rgba(168,85,247,.30), transparent 55%),
                radial-gradient(900px 450px at 90% 30%, rgba(59,130,246,.25), transparent 55%),
                #020617;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-100 login-bg">
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="flex items-center justify-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-blue-500 flex items-center justify-center font-bold">
                F
            </div>
        </div>

        <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-2xl">
            {{ $slot }}
        </div>

        <div class="text-center text-xs text-slate-400 mt-6">
            {{ config('app.name') }} • {{ date('Y') }}
        </div>
    </div>
</div>
</body>
</html>
