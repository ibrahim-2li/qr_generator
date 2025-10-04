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

<body
    class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
    <!-- Navigation -->
    <nav class="relative z-10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="w-5 h-5">
                </div>
                <span
                    class="hidden sm:inline md:inline lg:inline xl:inline text-xl font-bold text-gray-900 dark:text-white">QR
                    Generator</span>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Dark/Light Mode Toggle -->
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors">
                    <!-- Sun icon (visible in dark mode) -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                    <!-- Moon icon (visible in light mode) -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="/dashboard/login"
                        class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                        Log in
                    </a>
                    <a href="/dashboard/register"
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
        <div class="max-w-7xl mx-auto px-6 py-20 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6">
                    Create
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        QR Codes
                    </span>
                    <br>That Work
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    Generate professional QR codes with advanced analytics, custom branding, and real-time tracking.
                    Perfect for businesses, events, and personal use.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors shadow-lg hover:shadow-xl">
                            Start Creating QR Codes
                        </a>
                    @endif
                    <a href="/dashboard"
                        class="border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-600 dark:hover:border-blue-400 px-8 py-4 rounded-lg font-semibold text-lg transition-colors">
                        Get Started
                    </a>
                </div>
            </div>
        </div>

        <!-- QR Code Preview -->
        <div class="absolute top-20 right-10 hidden lg:block">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-2xl">
                <div class="w-32 h-32 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
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

    <!-- Features Section -->
    <div id="features" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Powerful Features
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Everything you need to create, manage, and track QR codes effectively
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Instant Generation</h3>
                    <p class="text-gray-600 dark:text-gray-300">Create QR codes in seconds with our fast and reliable
                        generator</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Advanced Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-300">Track scans, locations, devices, and get detailed
                        insights</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Custom Branding</h3>
                    <p class="text-gray-600 dark:text-gray-300">Add your logo, colors, and customize QR code appearance
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div
                        class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Secure & Private</h3>
                    <p class="text-gray-600 dark:text-gray-300">Your data is protected with enterprise-grade security
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Easy Management</h3>
                    <p class="text-gray-600 dark:text-gray-300">Organize and manage all your QR codes in one dashboard
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-2xl">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Real-time Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-300">Monitor scan activity and performance in real-time</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Get in Touch
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-700 rounded-2xl shadow-xl p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
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
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-600 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message
                        </label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-600 dark:text-white">{{ old('message') }}</textarea>
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
                <h1 class="text-3xl md:text-4xl font-bold text-white dark:gray-900 mb-4">Frequently Asked
                    Questions</h1>

                <div class="space-y-4">

                    <!-- FAQ Item -->

                    @foreach ($faqs as $faq)
                        <div
                            class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg shadow-md p-4 mb-3">
                            <button class="faq-toggle w-full text-left font-semibold text-lg focus:outline-none">
                                {{ $faq->question }}
                            </button>
                            <div class="faq-answer mt-2 hidden text-gray-900 dark:text-white">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>



    <script>
        // FAQ Toggle functionality
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                answer.classList.toggle('hidden');
            });
        });

        // Dark/Light Mode Toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleBtn = document.getElementById('theme-toggle');

            // Check if elements exist before proceeding
            if (!themeToggleDarkIcon || !themeToggleLightIcon || !themeToggleBtn) {
                console.log('Theme toggle elements not found');
                return;
            }

            // Initialize theme on page load
            function initTheme() {
                const savedTheme = localStorage.getItem('color-theme');

                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                    themeToggleLightIcon.classList.remove('hidden');
                    themeToggleDarkIcon.classList.add('hidden');
                } else {
                    // Default to light mode
                    document.documentElement.classList.remove('dark');
                    themeToggleDarkIcon.classList.remove('hidden');
                    themeToggleLightIcon.classList.add('hidden');
                }
            }

            // Initialize theme when page loads
            initTheme();

            // Handle theme toggle click
            themeToggleBtn.addEventListener('click', function() {
                const isDark = document.documentElement.classList.contains('dark');

                if (isDark) {
                    // Switch to light mode
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                    themeToggleDarkIcon.classList.remove('hidden');
                    themeToggleLightIcon.classList.add('hidden');
                } else {
                    // Switch to dark mode
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                    themeToggleLightIcon.classList.remove('hidden');
                    themeToggleDarkIcon.classList.add('hidden');
                }
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
