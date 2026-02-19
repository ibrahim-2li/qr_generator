<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Authentication' }} - {{ config('app.name', 'QR Generator') }}</title>

    @if (app()->getLocale() === 'ar')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap"
            rel="stylesheet">
        <style>
            * {
                font-family: 'Almarai', sans-serif !important;
            }
        </style>
    @else
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            * {
                font-family: 'Manrope', sans-serif !important;
            }
        </style>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        .hero-glow::before {
            content: '';
            position: absolute;
            inset: -180px -80px auto;
            height: 420px;
            background: radial-gradient(ellipse at top, rgba(25, 115, 255, .16), rgba(255, 255, 255, 0));
            pointer-events: none;
        }
    </style>
</head>

<body class="min-h-screen bg-white antialiased text-slate-700">
    <div class="relative hero-glow min-h-screen">
        <div class="relative max-w-7xl mx-auto px-6 py-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 text-slate-950">
                <span class="size-10 rounded-xl bg-slate-950 grid place-items-center shadow-lg shadow-slate-900/20">
                    <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="size-6">
                </span>
                <span class="text-xl font-extrabold">{{ config('app.name', 'QR Generator') }}</span>
            </a>

            <div class="mt-8 grid lg:grid-cols-2 gap-8 items-stretch">
                <section class="hidden lg:flex rounded-2xl border border-slate-200 bg-slate-50 p-10 flex-col justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] font-extrabold text-blue-700">Secure Access</p>
                        <h1 class="mt-4 text-4xl font-extrabold text-slate-950 leading-tight">Welcome back to your QR workspace.</h1>
                        <p class="mt-4 text-slate-600 text-lg">Manage dynamic QR campaigns, analytics, and subscriptions from one place.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs uppercase tracking-wide font-bold text-slate-500">Dynamic Links</p>
                            <p class="mt-1 text-lg font-extrabold text-slate-950">Always editable</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs uppercase tracking-wide font-bold text-slate-500">Analytics</p>
                            <p class="mt-1 text-lg font-extrabold text-slate-950">Real-time</p>
                        </div>
                    </div>
                </section>

                <section class="w-full max-w-xl lg:max-w-none mx-auto">
                    {{ $slot }}
                </section>
            </div>

            <div class="mt-8 flex justify-center">
                @livewire('language-switcher')
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
