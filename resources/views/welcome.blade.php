<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ \App\Http\Middleware\SetLocale::getDirection() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('landing.meta_title') }}</title>
    <meta name="description" content="{{ __('landing.meta_description') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=almarai:300,400,700,800" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @import "tailwindcss";
        </style>
    @endif

    <style>
        :root {
            --brand-ink: #0f172a;
            --brand-text: #334155;
            --brand-accent: #0ea5e9;
            --brand-accent-2: #1d4ed8;
            --brand-soft: #f8fafc;
        }

        html,
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Almarai', sans-serif" : "'Manrope', sans-serif" }};
            color: var(--brand-text);
            background: radial-gradient(circle at 0% 0%, #ecfeff 0%, #ffffff 40%), radial-gradient(circle at 100% 10%, #e0e7ff 0%, #ffffff 48%);
        }

        .mesh-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .logo-strip {
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 220ms ease;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
        }
    </style>
</head>

<body class="min-h-screen antialiased">
    <header class="relative mesh-bg overflow-hidden border-b border-slate-200/70">
        <div class="relative max-w-7xl mx-auto px-6 py-6">
            <nav class="flex items-center justify-between">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <span class="size-10 rounded-xl bg-slate-950 grid place-items-center shadow-lg shadow-slate-900/20">
                        <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="size-6">
                    </span>
                    <span class="text-lg md:text-xl font-extrabold text-slate-950">QR Generator</span>
                </a>

                <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#features" class="hover:text-slate-950 transition">{{ __('landing.nav_features') }}</a>
                    <a href="#pricing" class="hover:text-slate-950 transition">{{ __('landing.nav_pricing') }}</a>
                    <a href="#contact" class="hover:text-slate-950 transition">{{ __('landing.nav_contact') }}</a>
                    <a href="#faq" class="hover:text-slate-950 transition">{{ __('landing.nav_faq') }}</a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center rounded-lg border border-slate-200 bg-white p-1">
                        <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
                            class="px-2.5 py-1.5 rounded-md text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:text-slate-900' }}">{{ __('landing.language_en') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'ar']) }}"
                            class="px-2.5 py-1.5 rounded-md text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:text-slate-900' }}">{{ __('landing.language_ar') }}</a>
                    </div>
                    @auth
                        <a href="{{ route('dashboard.home') }}"
                            class="px-5 py-2.5 rounded-xl bg-slate-950 text-white text-sm font-bold hover:bg-slate-800 transition">{{ __('landing.nav_dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-slate-950 transition">{{ __('landing.nav_login') }}</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 rounded-xl bg-slate-950 text-white text-sm font-bold hover:bg-slate-800 transition">{{ __('landing.nav_get_started') }}</a>
                    @endauth
                </div>
            </nav>

            <div class="pt-16 pb-20 lg:pt-20 lg:pb-24 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p
                        class="inline-flex items-center px-4 py-1.5 rounded-full bg-cyan-50 border border-cyan-200 text-cyan-800 text-xs font-extrabold tracking-wide uppercase">
                        {{ __('landing.hero_badge') }}
                    </p>
                    <h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-950 leading-tight">
                        {{ __('landing.hero_title_line1') }}
                        <span class="block text-sky-600">{{ __('landing.hero_title_line2') }}</span>
                    </h1>
                    <p class="mt-6 text-lg text-slate-600 max-w-xl">
                        {{ __('landing.hero_description') }}
                    </p>

                    <div class="mt-9 flex flex-wrap gap-3">
                        <a href="{{ auth()->check() ? route('dashboard.qrcodes.create') : route('register') }}"
                            class="px-6 py-3 rounded-xl bg-slate-950 text-white font-bold hover:bg-slate-800 transition">{{ __('landing.hero_cta_start') }}</a>
                        <a href="#features"
                            class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold hover:border-slate-500 transition">{{ __('landing.hero_cta_explore') }}</a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -top-10 -left-8 size-44 bg-cyan-200/55 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -right-8 size-44 bg-blue-200/55 rounded-full blur-3xl"></div>

                    <div
                        class="relative bg-white/90 backdrop-blur border border-slate-200 rounded-3xl p-4 shadow-2xl shadow-slate-900/10">
                        <img src="{{ asset('images/hero1.png') }}" alt="QR Generator Dashboard"
                            class="w-full rounded-2xl object-cover">
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-xs uppercase tracking-wide font-bold text-slate-500">
                                    {{ __('landing.hero_dynamic_qr') }}</p>
                                <p class="mt-1 text-xl font-extrabold text-slate-900">100%</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-xs uppercase tracking-wide font-bold text-slate-500">
                                    {{ __('landing.hero_live_analytics') }}</p>
                                <p class="mt-1 text-xl font-extrabold text-slate-900">{{ __('landing.hero_realtime') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-12 border-b border-slate-200/70 bg-white/80">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-sm font-bold uppercase tracking-wide text-slate-500">
                {{ __('landing.partners_title') }}</p>
            <div
                class="logo-strip mt-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-6 items-center">
                @foreach ($partners as $partner)
                    <a href="{{ $partner->url }}" target="_blank"
                        class="group rounded-xl border border-slate-200 p-4 bg-white hover:border-slate-300 transition">
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                            class="h-10 w-full object-contain grayscale group-hover:grayscale-0 transition">
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <main>
        <section id="features" class="py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-2xl">
                    <p class="text-sm font-extrabold uppercase tracking-wide text-sky-700">
                        {{ __('landing.features_badge') }}</p>
                    <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-slate-950">
                        {{ __('landing.features_title') }}</h2>
                </div>

                <div class="mt-12 grid lg:grid-cols-2 gap-6">
                    <article class="bg-white border border-slate-200 rounded-2xl p-7 shadow-sm">
                        <h3 class="text-2xl font-extrabold text-slate-950">{{ __('landing.feature_1_title') }}</h3>
                        <p class="mt-3 text-slate-600">{{ __('landing.feature_1_desc') }}</p>
                        <ul class="mt-5 space-y-2 text-slate-700 font600">
                            <li>{{ __('landing.feature_1_item_1') }}</li>
                            <li>{{ __('landing.feature_1_item_2') }}</li>
                            <li>{{ __('landing.feature_1_item_3') }}</li>
                        </ul>
                    </article>

                    <article class="bg-white border border-slate-200 rounded-2xl p-7 shadow-sm">
                        <h3 class="text-2xl font-extrabold text-slate-950">{{ __('landing.feature_2_title') }}</h3>
                        <p class="mt-3 text-slate-600">{{ __('landing.feature_2_desc') }}</p>
                        <ul class="mt-5 space-y-2 text-slate-700 font600">
                            <li>{{ __('landing.feature_2_item_1') }}</li>
                            <li>{{ __('landing.feature_2_item_2') }}</li>
                            <li>{{ __('landing.feature_2_item_3') }}</li>
                        </ul>
                    </article>

                    <article class="bg-white border border-slate-200 rounded-2xl p-7 shadow-sm">
                        <h3 class="text-2xl font-extrabold text-slate-950">{{ __('landing.feature_3_title') }}</h3>
                        <p class="mt-3 text-slate-600">{{ __('landing.feature_3_desc') }}</p>
                        <ul class="mt-5 space-y-2 text-slate-700 font600">
                            <li>{{ __('landing.feature_3_item_1') }}</li>
                            <li>{{ __('landing.feature_3_item_2') }}</li>
                            <li>{{ __('landing.feature_3_item_3') }}</li>
                        </ul>
                    </article>

                    <article class="bg-white border border-slate-200 rounded-2xl p-7 shadow-sm">
                        <h3 class="text-2xl font-extrabold text-slate-950">{{ __('landing.feature_4_title') }}</h3>
                        <p class="mt-3 text-slate-600">{{ __('landing.feature_4_desc') }}</p>
                        <ul class="mt-5 space-y-2 text-slate-700 font600">
                            <li>{{ __('landing.feature_4_item_1') }}</li>
                            <li>{{ __('landing.feature_4_item_2') }}</li>
                            <li>{{ __('landing.feature_4_item_3') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="py-20 bg-slate-950 text-white">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <p class="text-sm uppercase tracking-wide font-extrabold text-cyan-300">
                        {{ __('landing.dashboard_block_badge') }}</p>
                    <h2 class="mt-3 text-3xl md:text-4xl font-extrabold">{{ __('landing.dashboard_block_title') }}
                    </h2>
                    <p class="mt-4 text-slate-300 text-lg">{{ __('landing.dashboard_block_desc') }}</p>
                    <a href="{{ auth()->check() ? route('dashboard.home') : route('register') }}"
                        class="mt-8 inline-flex px-6 py-3 rounded-xl bg-white text-slate-950 font-extrabold hover:bg-slate-200 transition">{{ __('landing.dashboard_block_cta') }}</a>
                </div>
                <div class="rounded-3xl border border-slate-700 bg-slate-900 p-4">
                    <img src="{{ asset('images/dashboard-ligth2.png') }}" alt="Analytics dashboard"
                        class="rounded-2xl w-full object-cover">
                </div>
            </div>
        </section>

        <section id="pricing" class="py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto">
                    <p class="text-sm font-extrabold uppercase tracking-wide text-sky-700">
                        {{ __('landing.pricing_badge') }}</p>
                    <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-slate-950">
                        {{ __('landing.pricing_title') }}</h2>
                </div>

                <div
                    class="mt-12 grid md:grid-cols-2 lg:grid-cols-{{ count($plans) > 2 ? '3' : count($plans) }} gap-6">
                    @foreach ($plans as $index => $plan)
                        <article
                            class="relative rounded-2xl border {{ $index === 0 ? 'border-slate-950' : 'border-slate-200' }} bg-white p-7 shadow-sm">
                            @if ($index === 0)
                                <span
                                    class="absolute -top-3 left-6 px-3 py-1 text-xs font-extrabold uppercase rounded-full bg-slate-950 text-white">{{ __('landing.pricing_most_popular') }}</span>
                            @endif
                            <h3 class="text-2xl font-extrabold text-slate-950">{{ $plan->name }}</h3>
                            <p class="mt-2 text-slate-600">{{ $plan->description }}</p>
                            <p class="mt-6 text-4xl font-extrabold text-slate-950">
                                {{ number_format($plan->price / 100, 2) }} <span
                                    class="text-base font-bold text-slate-500">{{ __('landing.pricing_currency') }}</span>
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ __('landing.pricing_interval', ['months' => $plan->interval / 30]) }}</p>

                            <ul class="space-y-3 text-sm mt-6">
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.unlimited_qr_codes') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.advanced_analytics') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.custom_branding') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.priority_support') }}
                                </li>
                            </ul>

                            <a href="/app/subscription"
                                class="mt-7 block text-center px-5 py-3 rounded-xl {{ $index === 0 ? 'bg-slate-950 text-white hover:bg-slate-800' : 'bg-slate-100 text-slate-900 hover:bg-slate-200' }} font-extrabold transition">{{ __('landing.nav_get_started') }}</a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="py-20 bg-slate-100/70 border-y border-slate-200">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center">
                    <p class="text-sm font-extrabold uppercase tracking-wide text-sky-700">
                        {{ __('landing.contact_badge') }}</p>
                    <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-slate-950">
                        {{ __('landing.contact_title') }}</h2>
                    <p class="mt-3 text-slate-600">{{ __('landing.contact_desc') }}</p>
                </div>

                <form method="POST" action="{{ route('contact.store') }}"
                    class="mt-10 rounded-2xl bg-white border border-slate-200 p-6 md:p-8 space-y-5">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-xl border border-red-200 bg-red-50 text-red-700 p-4 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="{{ __('landing.contact_name') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="{{ __('landing.contact_email') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <input type="text" name="subject" value="{{ old('subject') }}" required
                        placeholder="{{ __('landing.contact_subject') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500">

                    <textarea name="message" rows="5" required placeholder="{{ __('landing.contact_message') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('message') }}</textarea>

                    <button type="submit"
                        class="w-full md:w-auto px-7 py-3 rounded-xl bg-slate-950 text-white font-extrabold hover:bg-slate-800 transition">{{ __('landing.contact_send') }}</button>
                </form>
            </div>
        </section>

        <section id="faq" class="py-20">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center">
                    <p class="text-sm font-extrabold uppercase tracking-wide text-sky-700">
                        {{ __('landing.faq_badge') }}</p>
                    <h2 class="mt-2 text-3xl md:text-4xl font-extrabold text-slate-950">{{ __('landing.faq_title') }}
                    </h2>
                </div>

                <div class="mt-10 space-y-3">
                    @foreach ($faqs as $faq)
                        <article class="faq-item border border-slate-200 bg-white rounded-xl p-5">
                            <button type="button"
                                class="faq-toggle w-full {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} flex items-center justify-between gap-4 font-bold text-slate-900">
                                <span>{{ $faq->question }}</span>
                                <span class="text-slate-400 text-xl leading-none">+</span>
                            </button>
                            <div class="faq-answer text-slate-600 mt-3 pr-8">{{ $faq->answer }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="py-10 bg-slate-950 text-slate-300">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row gap-6 items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="size-8">
                <p class="font-bold text-white">QR Generator</p>
            </div>
            <p class="text-sm">&copy; {{ date('Y') }} QR Generator. {{ __('landing.footer_rights') }}</p>
            <div class="flex items-center gap-4 text-sm">
                <a href="#features" class="hover:text-white">{{ __('landing.nav_features') }}</a>
                <a href="#pricing" class="hover:text-white">{{ __('landing.nav_pricing') }}</a>
                <a href="#contact" class="hover:text-white">{{ __('landing.nav_contact') }}</a>
            </div>
        </div>
    </footer>

    @if (session('success'))
        <div
            class="fixed top-6 {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }} z-50 max-w-sm rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 p-4 shadow-lg">
            <p class="font-bold">{{ __('landing.toast_success_title') }}</p>
            <p class="text-sm mt-1">{{ session('success') }}</p>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.faq-item');

            items.forEach((item) => {
                const button = item.querySelector('.faq-toggle');
                const icon = button.querySelector('span:last-child');

                button.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    items.forEach((other) => {
                        other.classList.remove('active');
                        const otherIcon = other.querySelector(
                            '.faq-toggle span:last-child');
                        if (otherIcon) otherIcon.textContent = '+';
                    });

                    if (!isActive) {
                        item.classList.add('active');
                        if (icon) icon.textContent = '-';
                    }
                });
            });
        });
    </script>
</body>

</html>
