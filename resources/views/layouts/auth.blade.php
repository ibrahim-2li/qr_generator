<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Authentication' }} - {{ config('app.name', 'QR Generator') }}</title>

    <!-- Fonts -->
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
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <style>
            * {
                font-family: 'Inter', sans-serif !important;
            }
        </style>
    @endif

    <!-- Tailwind CSS via CDN for form styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Custom input styles */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #1f2937;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="password"] {
            color: #fff;
            background-color: #374151;
            border-color: #4b5563;
        }

        .dark input[type="text"]:focus,
        .dark input[type="email"]:focus,
        .dark input[type="password"]:focus {
            border-color: #3b82f6;
        }

        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            accent-color: #3b82f6;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center p-4">
        <!-- Logo -->
        <a href="/" class="mb-2 flex items-center gap-2 text-2xl font-bold text-gray-900 dark:text-white">
            <!-- <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg> -->
                                <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="h-10 w-10 text-blue-600">

            <span>{{ config('app.name', 'QR Generator') }}</span>
        </a>

        <!-- Main Content -->
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>

        <!-- Language Switcher -->
        <div class="mt-8">
            @livewire('language-switcher')
        </div>
    </div>

    @livewireScripts
</body>

</html>
