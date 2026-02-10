<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Generator - Create & Track QR Codes</title>
    <meta name="description"
        content="Generate professional QR codes with advanced analytics and tracking. Perfect for businesses, events, and personal use.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @import "tailwindcss";
        </style>
    @endif
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
    <!-- Navigation -->
    <nav class="relative z-10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="w-5 h-5">
                </div>
                <span class="hidden sm:inline md:inline lg:inline xl:inline text-xl font-bold text-gray-900">QR
                    Generator</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Features</a>
                <a href="#pricing" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Pricing</a>
                <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard.home') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="/login" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Log in
                    </a>
                    <a href="/register"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Register
                    </a>
                @endauth
            </div>
        </div>

        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 py-16 lg:py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6">
                    Create
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        QR Codes
                    </span>
                    <br>That Show Your Work
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Generate professional QR codes with advanced analytics, custom branding, and real-time tracking.
                    Perfect for businesses,or personal use.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors shadow-lg hover:shadow-xl">
                            Start Creating QR Codes
                        </a>
                    @endif
                    <a href="/dashboard"
                        class="border-2 border-gray-300 text-gray-700 hover:border-blue-600 px-8 py-4 rounded-lg font-semibold text-lg transition-colors ">
                        Get Started
                    </a>
                </div>

            </div>
        </div>

        <!-- QR Code Preview -->
        <div class="absolute top-20 right-10 hidden lg:block">
            <div class="bg-white p-4 rounded-2xl shadow-2xl">
                <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        fill="#000000" stroke="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M896 960H128c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64h768c35.3 0 64 28.7 64 64v768c0 35.3-28.7 64-64 64z"
                                fill="#ffffff"></path>
                            <path
                                d="M426.3 426.3H128V189.7c0-34 27.7-61.7 61.7-61.7h236.6v298.3z m-236.6-61.7h174.9V189.7H189.7v174.9zM395.4 896H266.9c-17.1 0-30.9-13.8-30.9-30.9 0-17.1 13.8-30.9 30.9-30.9h128.6c17.1 0 30.9 13.8 30.9 30.9-0.1 17.1-13.9 30.9-31 30.9zM158.9 779.4c-17.1 0-30.9-13.8-30.9-30.9v-120c0-17.1 13.8-30.9 30.9-30.9s30.9 13.8 30.9 30.9v120c-0.1 17.1-13.9 30.9-30.9 30.9z"
                                fill="#43423d"></path>
                            <path
                                d="M896 426.3H597.7V128h236.6c34 0 61.7 27.7 61.7 61.7v236.6z m-236.6-61.7h174.9V189.7H659.4v174.9z"
                                fill="#f9521a"></path>
                            <path
                                d="M834.3 896H597.7V597.7H896v236.6c0 34-27.7 61.7-61.7 61.7z m-174.9-61.7h174.9V659.4H659.4v174.9z"
                                fill="#43423d"></path>
                            <path
                                d="M365.4 762.3h-72.9c-17.1 0-30.9-13.8-30.9-30.9v-72.9c0-17.1 13.8-30.9 30.9-30.9h103.7v103.7c0.1 17.2-13.7 31-30.8 31z"
                                fill="#f9521a"></path>
                            <path
                                d="M512 896c-17.1 0-30.9-13.8-30.9-30.9V614.4c0-17.1 13.8-30.9 30.9-30.9 17.1 0 30.9 13.8 30.9 30.9v250.7c0 17.1-13.8 30.9-30.9 30.9z m0-465c-17.1 0-30.9-13.8-30.9-30.9V158.9c0-17.1 13.8-30.9 30.9-30.9 17.1 0 30.9 13.8 30.9 30.9v241.3c0 17-13.8 30.8-30.9 30.8z m353.1 111.9H158.9c-17.1 0-30.9-13.8-30.9-30.9 0-17.1 13.8-30.9 30.9-30.9h706.3c17.1 0 30.9 13.8 30.9 30.9-0.1 17.1-13.9 30.9-31 30.9z"
                                fill="#3856ff"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Showcase Section -->
    <div id="features" class="py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
                    ✨ Showcase
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    See What You Can
                    <span
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Create</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    From analytics dashboards to digital business cards — discover the power of QR codes
                </p>
            </div>

            <!-- Dashboard Card - Full Width Row -->
            {{-- <div class="mb-8">
                <!-- Card 1: Dashboard -->
                <div class="group relative">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-500">
                    </div>
                    <div
                        class="relative bg-white rounded-2xl overflow-hidden shadow-xl transform group-hover:-translate-y-2 transition-all duration-300">
                        <!-- Image Container -->
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('images/hero1.png') }}"
                                class="w-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                                alt="QR Generator Dashboard">
                            <!-- Overlay Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Dashboard
                                </span>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Analytics Dashboard</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Track scans, monitor performance, and get detailed insights about your QR codes.
                            </p>
                            <div class="flex items-center text-blue-600 font-semibold text-sm">
                                <span>Learn more</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="text-center mb-16 ">
                <div class="bg-white p-4 rounded-2xl shadow-2xl">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Premium QR Codes Dashboard</h2>
                    <img src="{{ asset('images/hero1.png') }}" class="w-50% h-50% mx-auto" alt="QR Generator">
                </div>
            </div>

            <div class="text-center mb-16 ">
                <div class="bg-white p-4 rounded-2xl shadow-2xl">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Dynamic QR Codes</h2>
                    <img src="{{ asset('images/iphones.jpg') }}" class="w-50% h-50% mx-auto" alt="QR Generator">
                </div>
            </div>


            <!-- Bottom CTA -->
            <div class="text-center mt-16">
                <a href="{{ auth()->check() ? url('/dashboard') : url('/dashboard/register') }}"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <span>Start Creating Now</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <!-- Partners Section -->
    <br /><br /><br />
    <div id="partners" class="py-20 bg-gray-50 mb-20 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-16">
                Partners
            </h2>

            <div class=" flex flex-wrap gap-12 justify-center items-center mt-16">
                @foreach ($partners as $partner)
                    <a href="{{ $partner->url }}" target="_blank">
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                            width="100" height="100" class=" mx-auto  grayscale hover:grayscale-0 transition">
                    </a>
                @endforeach

            </div>
        </div>
    </div>
    <br /><br /><br /><br />
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 mt-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Powerful Features
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Everything you need to create, manage, and track QR codes effectively
            </p>
        </div>

        <!-- Resume & vCard Showcase Cards -->
        {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Card: Resume -->
            <div class="group relative">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-500">
                </div>
                <div
                    class="relative bg-white rounded-2xl overflow-hidden shadow-xl transform group-hover:-translate-y-2 transition-all duration-300">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/hero2.png') }}"
                            class="w-full h-80 object-cover object-top group-hover:scale-105 transition-transform duration-500"
                            alt="Resume QR Code">
                        <!-- Overlay Badge -->
                        <div class="absolute top-4 left-4">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Resume
                            </span>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Smart Resume QR</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Create scannable resume codes that link to your digital CV with download options.
                        </p>
                        <div class="flex items-center text-purple-600 font-semibold text-sm">
                            <span>Learn more</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: vCard -->
            <div class="group relative">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-500">
                </div>
                <div
                    class="relative bg-white rounded-2xl overflow-hidden shadow-xl transform group-hover:-translate-y-2 transition-all duration-300">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/hero3.png') }}"
                            class="w-full h-80 object-cover object-top group-hover:scale-105 transition-transform duration-500"
                            alt="vCard QR Code">
                        <!-- Overlay Badge -->
                        <div class="absolute top-4 left-4">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 text-white text-xs font-bold rounded-full shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                vCard
                            </span>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Digital Business Card</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Share your contact info instantly with beautiful, scannable digital cards.
                        </p>
                        <div class="flex items-center text-emerald-600 font-semibold text-sm">
                            <span>Learn more</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="text-center mb-16 ">
            <div class="bg-white p-4 rounded-2xl shadow-2xl">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Premium QR Codes Dashboard</h2>
                <img src="{{ asset('images/iphones.jpg') }}" class="w-50% h-50% mx-auto" alt="QR Generator">
            </div>
        </div> --}}

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Instant Generation</h3>
                <p class="text-gray-600">Create QR codes in seconds with our fast and reliable
                    generator</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Advanced Analytics</h3>
                <p class="text-gray-600">Track scans, locations, devices, and get detailed
                    insights</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Custom Branding</h3>
                <p class="text-gray-600">Add your logo, colors, and customize QR code appearance
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure & Private</h3>
                <p class="text-gray-600">Your data is protected with enterprise-grade security
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Easy Management</h3>
                <p class="text-gray-600">Organize and manage all your QR codes in one dashboard
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-gray-50 p-8 rounded-2xl">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Real-time Tracking</h3>
                <p class="text-gray-600">Monitor scan activity and performance in real-time</p>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="py-20 bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Simple, Transparent Pricing
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Choose the plan that's right for you and start creating professional QR codes today
                </p>
            </div>

            <div
                class="grid md:grid-cols-2 lg:grid-cols-{{ count($plans) > 2 ? '3' : count($plans) }} gap-8 max-w-5xl mx-auto">
                @foreach ($plans as $index => $plan)
                    <div
                        class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 {{ $index === 0 ? 'ring-2 ring-blue-600' : '' }}">
                        @if ($index === 0)
                            <div
                                class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center py-2 text-sm font-semibold">
                                Most Popular
                            </div>
                        @endif

                        <div class="p-8 {{ $index === 0 ? 'pt-14' : '' }}">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $plan->description }}</p>

                            <div class="mb-6">
                                <span
                                    class="text-4xl font-bold text-gray-900">{{ number_format($plan->price / 100, 2) }}</span>
                                <span class="text-gray-600 ml-1">SAR</span>
                                <span class="text-gray-500 text-sm">/ {{ $plan->interval }}</span>
                            </div>

                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Unlimited QR Codes
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Advanced Analytics
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Custom Branding
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Priority Support
                                </li>
                            </ul>

                            {{-- @auth
                                <a href="{{ route('payment.pay', ['plan_id' => $plan->id]) }}"
                                    class="block w-full text-center py-3 px-6 rounded-lg font-semibold transition-all duration-300 {{ $index === 0 ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                                    Subscribe Now
                                </a>
                            @else --}}
                            <a href="/dashboard/subscribe-page"
                                class="block w-full text-center py-3 px-6 rounded-lg font-semibold transition-all duration-300 {{ $index === 0 ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                                Get Started
                            </a>
                            {{-- @endauth --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Get in Touch
                </h2>
                <p class="text-xl text-gray-600">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('message') }}</textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg hover:shadow-xl">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center px-6">
            <div class="max-w-3xl mx-auto p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Frequently Asked
                    Questions</h1>

                <div class="space-y-4">

                    <!-- FAQ Item -->

                    @foreach ($faqs as $faq)
                        <div class="bg-white text-gray-900 rounded-lg shadow-md p-4 mb-3">
                            <button class="faq-toggle w-full text-left font-semibold text-lg focus:outline-none">
                                {{ $faq->question }}
                            </button>
                            <div class="faq-answer mt-2 hidden text-gray-900">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ Toggle functionality
            const faqButtons = document.querySelectorAll('.faq-toggle');

            faqButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const answer = button.nextElementSibling;
                    if (answer) {
                        answer.classList.toggle('hidden');
                    }
                });
            });
        });
    </script>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="w-5 h-5">
                        </div>
                        <span class="text-xl font-bold">QR Generator</span>
                    </div>
                    <p class="text-gray-400">Create professional QR codes with advanced analytics and tracking.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#contact" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} QR Generator. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
