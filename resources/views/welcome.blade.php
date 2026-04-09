<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Generator - Create & Track QR Codes</title>
    <meta name="description"
        content="Generate branded QR codes, manage campaigns, and track scans with a polished analytics dashboard.">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import "tailwindcss";
        </style>
    @endif

    <style>
        @font-face {
            font-family: 'Geomanist';
            src: url('{{ asset('fonts/Geomanist.woff') }}') format('woff');
            font-style: normal;
            font-weight: normal;
        }

        @font-face {
            font-family: 'Inter';
            src: url('{{ asset('fonts/Inter-Variable.ttf') }}') format('truetype');
            font-weight: 100 900;
            font-style: normal;
        }

        @font-face {
            font-family: 'Fira Code';
            src: url('{{ asset('fonts/FiraCode-Variable.ttf') }}') format('truetype');
            font-weight: 200 700;
            font-style: normal;
        }

        :root {
            --landing-bg: #f6f6f4;
            --landing-panel: rgba(255, 255, 255, 0.74);
            --landing-border: rgba(15, 23, 42, 0.08);
            --landing-text: #171c2e;
            --landing-accent: #2563eb;
            --landing-accent-dark: #1d4ed8;
            --landing-shadow: 0 30px 80px rgba(15, 23, 42, 0.08);
        }

        html {
            scroll-behavior: smooth;
        }

        body,
        .font-sans {
            font-family: 'Inter', sans-serif !important;
            background:
                radial-gradient(circle at 20% 0%, rgba(37, 99, 235, 0.12), transparent 28%),
                radial-gradient(circle at 80% 15%, rgba(23, 28, 46, 0.06), transparent 24%),
                linear-gradient(180deg, #fafaf9 0%, var(--landing-bg) 100%);
            color: var(--landing-text);
        }

        .landing-headline,
        .font-headline {
            font-family: 'Geomanist', sans-serif !important;
            font-weight: 500 !important;
            letter-spacing: -0.03em;
        }

        .text-xs {
            font-size: 0.70rem !important;
        }

        .text-sm {
            font-size: 0.85rem !important;
        }

        p {
            font-size: 0.95rem !important;
        }

        code,
        pre {
            font-family: 'Fira Code', monospace !important;
        }

        .glass-panel {
            background: var(--landing-panel);
            border: 1px solid var(--landing-border);
            box-shadow: var(--landing-shadow);
            backdrop-filter: blur(18px);
        }

        .landing-highlight {
            background: rgba(37, 99, 235, 0.12);
        }

        .landing-button-primary {
            background: var(--landing-accent);
            border: 1px solid var(--landing-accent-dark);
            color: white;
        }

        .landing-button-primary:hover {
            background: #1d4ed8;
        }

        .landing-button-secondary {
            background: white;
            border: 1px solid rgba(39, 39, 42, 0.14);
            color: #52525b;
        }

        .landing-button-secondary:hover {
            border-color: rgba(39, 39, 42, 0.24);
            background: #fafafa;
        }

        .faq-answer[hidden] {
            display: none;
        }

        .hero-grid {
            background-image:
                linear-gradient(rgba(23, 28, 46, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(23, 28, 46, 0.06) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black 28%, transparent 78%);
            opacity: .75;
        }
    </style>
</head>

<body class="min-h-screen antialiased">
    @php($orderedPlans = $plans->sortBy('price')->values())

    <header id="landing-header"
        class="fixed inset-x-0 top-0 z-50 bg-[rgba(246,246,244,0.84)] transition-all duration-300">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-10">
            {{-- <a href="#landing-header" class="flex items-center gap-4">
                <img src="{{ asset('images/logo22.png') }}" alt="QR Generator" class="h-10 w-10 rounded-lg">

                <div class="flex flex-col ml-4">
                    <span class="landing-headline text-2xl text-[var(--landing-text)]">QR Generator</span>

                    <span class="text-xs text-gray-500 hover:underline">By Ibrahim Ali</span>
                </div>
            </a> --}}
            <div href="#landing-header" class="flex items-center">
                <span class="sr-only">QR Generator</span>
                <a href="{{ route('landing') }}">
                    <img class="h-8 w-auto sm:h-10" src="{{ asset('images/logo22.png') }}">
                </a>
                <div class="flex flex-col ml-4">
                    <a href="{{ route('landing') }}" class="font-headline text-2xl text-steel-900">QR Generator</a>
                    <a href="https://github.com/ibrahim-2li" target="_blank"
                        class="text-xs text-steel-700 hover:underline">by
                        ibrahim-2li Code</a>
                </div>
            </div>
            <nav class="hidden items-center gap-8 text-sm text-gray-500 md:flex">
                <a href="#features" class="transition hover:text-gray-900">Features</a>
                <a href="#partners" class="transition hover:text-gray-900">Partners</a>
                <a href="#pricing" class="transition hover:text-gray-900">Pricing</a>
                <a href="#faq" class="transition hover:text-gray-900">FAQ</a>
                <a href="#contact" class="transition hover:text-gray-900">Contact</a>
            </nav>

            <div class="hidden items-center gap-4 md:flex">
                @auth
                    <a href="{{ route('dashboard.home') }}"
                        class="landing-button-primary inline-flex h-10 items-center rounded-lg px-4 text-sm font-medium transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 transition hover:text-gray-900">Sign in</a>
                    <a href="{{ route('register') }}"
                        class="landing-button-secondary inline-flex h-10 items-center rounded-lg px-4 text-sm font-medium transition">Sign
                        up</a>
                @endauth
            </div>

            <button id="menu-toggle" type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-black/5 bg-white/80 md:hidden">
                <span class="sr-only">Toggle menu</span>
                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-black/5 bg-[rgba(246,246,244,0.96)] px-6 py-6 md:hidden">
            <div class="flex flex-col gap-4 text-sm text-gray-600">
                <a href="#features">Features</a>
                <a href="#partners">Partners</a>
                <a href="#pricing">Pricing</a>
                <a href="#faq">FAQ</a>
                <a href="#contact">Contact</a>
                @auth
                    <a href="{{ route('dashboard.home') }}"
                        class="landing-button-primary mt-2 rounded-lg px-4 py-3 text-center font-medium">Dashboard</a>
                @else
                    <div class="mt-2 flex gap-3">
                        <a href="{{ route('register') }}"
                            class="landing-button-primary flex-1 rounded-lg px-4 py-3 text-center font-medium">Sign up</a>
                        <a href="{{ route('login') }}"
                            class="landing-button-secondary flex-1 rounded-lg px-4 py-3 text-center font-medium">Sign in</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="relative overflow-hidden px-6 pb-16 pt-32 lg:px-10 lg:pt-44">
        <div class="hero-grid pointer-events-none absolute inset-x-0 top-0 h-[38rem]"></div>

        <section class="relative mx-auto flex max-w-7xl flex-col items-center gap-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl text-center">
                <div class="relative mt-6">
                    <h2 class="landing-headline absolute inset-0 text-4xl leading-tight md:text-6xl">
                        Share <span class="px-3 text-[var(--landing-accent)]">QR experiences</span><br>
                        Show Your Work
                    </h2>
                    <mark
                        class="landing-headline landing-highlight inline-block -rotate-1 bg-transparent px-1 text-4xl leading-tight text-transparent md:text-6xl">
                        Share <span class="rounded-xl px-3">QR experiences</span><br>
                        Show Your Work
                    </mark>
                </div>

                <p class="mt-8 flex justify-items-center relative mx-auto grid items-center max-w-2xl text-lg leading-8 text-black/55 md:text-xl">
                    Create branded QR codes, share digital profiles, and track every scan from one polished dashboard.
                    The new landing page keeps your live plans, partners, and FAQ content.
                </p>

                <div class="mt-8 flex justify-items-center relative mx-auto grid items-center">
                    <a href="{{ auth()->check() ? route('dashboard.home') : route('register') }}" class="landing-button-primary inline-flex h-12 items-center justify-center rounded-lg px-6 text-sm font-semibold transition">
                        {{ auth()->check() ? 'Open dashboard' : 'Try for free' }}
                    </a>
                </div>
            </div>

            <div class="flex justify-center" style="width:1040px; height:711px;">
                <div class="glass-panel rounded-[28px] p-3">
                    <div class="overflow-hidden rounded-[22px] border border-black/5 bg-white">
                        <div class="flex items-center border-b border-black/5 px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo2.png') }}" alt="QR Generator" class="h-8 w-8 rounded-lg">
                                <div>
                                    <p class="text-xs font-semibold text-[var(--landing-text)] sm:text-sm">QR Generator</p>
                                    <p class="hidden text-xs text-gray-500 sm:block">Performance overview</p>
                                </div>
                            </div>
                            <span class="rounded-full bg-[rgba(222,78,121,0.08)] px-3 py-1 text-xs font-medium text-[var(--landing-accent)]">Live dashboard</span>
                        </div>
                        <img src="{{ asset('images/dashboard.png') }}"
                 class="w-full h-[calc(100%-64px)] object-cover object-top">
                    </div>
                </div>
                <div class="absolute -bottom-5 left-0 glass-panel rounded-2xl px-4 py-4 text-sm text-gray-600 shadow-xl md:left-8"><span class="font-semibold text-[var(--landing-text)]">+48%</span> scan growth from active campaigns</div>

            </div>
        </section>


        <section id="features" class="mx-auto mt-24 max-w-7xl">
            <div class="flex flex-col items-start gap-4 md:items-center md:text-center">
                <div
                    class="rounded-full border border-black/5 bg-white px-4 py-2 text-sm text-[var(--landing-accent)] shadow-sm">
                    Features</div>
                <div class="relative">
                    <h2 class="landing-headline absolute inset-0 text-4xl md:text-6xl">Built for creators,<br><span
                            class="text-[var(--landing-accent)]">ready for growing teams</span></h2>
                    <mark
                        class="landing-headline landing-highlight inline-block -rotate-1 bg-transparent text-4xl text-transparent md:text-6xl">Built
                        for creators,<br><span class="rounded-xl px-3">ready for growing teams</span></mark>
                </div>
                <div class="mt-10 grid gap-4 text-sm text-gray-500 sm:grid-cols-3">
                    <div class="glass-panel rounded-2xl p-4">
                        <p class="text-2xl font-semibold text-[var(--landing-text)]">Dynamic</p>
                        <p class="mt-1">Edit destinations without reprinting codes.</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-4">
                        <p class="text-2xl font-semibold text-[var(--landing-text)]">Analytics</p>
                        <p class="mt-1">Track scans, devices, and campaign performance.</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-4">
                        <p class="text-2xl font-semibold text-[var(--landing-text)]">Branding</p>
                        <p class="mt-1">Keep every QR destination polished and on-brand.</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                <article class="glass-panel overflow-hidden rounded-[28px] p-3">
                    <div class="rounded-[22px] border border-black/5 bg-white p-6"><img
                            src="{{ asset('images/iphones.jpg') }}" alt="Dynamic QR preview"
                            class="h-64 w-full rounded-2xl object-cover">
                        <h3 class="mt-6 text-2xl font-semibold text-[var(--landing-text)]">Dynamic QR campaigns</h3>
                        <p class="mt-3 text-sm leading-7 text-gray-500">Swap destinations, rotate offers, and keep old
                            prints working while your content keeps moving.</p>
                    </div>
                </article>
                <article class="glass-panel overflow-hidden rounded-[28px] p-3">
                    <div class="rounded-[22px] border border-black/5 bg-white p-6"><img
                            src="{{ asset('images/hero2.png') }}" alt="Resume QR preview"
                            class="h-64 w-full rounded-2xl object-cover object-top">
                        <h3 class="mt-6 text-2xl font-semibold text-[var(--landing-text)]">Portfolio and profile pages
                        </h3>
                        <p class="mt-3 text-sm leading-7 text-gray-500">Turn a single scan into a complete profile,
                            resume, or contact card without adding friction.</p>
                    </div>
                </article>
                <article class="glass-panel overflow-hidden rounded-[28px] p-3">
                    <div class="rounded-[22px] border border-black/5 bg-white p-6"><img
                            src="{{ asset('images/hero3.png') }}" alt="Business card QR preview"
                            class="h-64 w-full rounded-2xl object-cover object-top">
                        <h3 class="mt-6 text-2xl font-semibold text-[var(--landing-text)]">Instant analytics snapshots
                        </h3>
                        <p class="mt-3 text-sm leading-7 text-gray-500">Give teams a clean view into scans, devices,
                            and campaign lift without digging through clutter.</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="pricing" class="mx-auto mt-24 max-w-7xl">
            <div class="flex flex-col items-start gap-4 md:items-center md:text-center">
                <div
                    class="rounded-full border border-black/5 bg-white px-4 py-2 text-sm text-[var(--landing-accent)] shadow-sm">
                    Pricing</div>
                <div class="relative">
                    <h2 class="landing-headline absolute inset-0 text-4xl md:text-6xl">Flexible for solo
                        makers,<br><span class="text-[var(--landing-accent)]">strong enough for teams</span></h2>
                    <mark
                        class="landing-headline landing-highlight inline-block -rotate-1 bg-transparent text-4xl text-transparent md:text-6xl">Flexible
                        for solo makers,<br><span class="rounded-xl px-3">strong enough for teams</span></mark>
                </div>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach ($orderedPlans as $plan)
                    @php($isFeatured = strcasecmp($plan->name, 'Pro') === 0)
                    <article
                        class="rounded-[28px] border border-black/5 p-3 shadow-lg {{ $isFeatured ? 'bg-[rgba(15,23,42,0.9)]' : 'bg-white/70' }}">
                        <div
                            class="h-full rounded-[22px] border border-black/10 p-8 {{ $isFeatured ? 'bg-gray-900 text-white' : 'bg-white text-[var(--landing-text)]' }}">
                            <p class="text-base">{{ $plan->name }}</p>
                            <p class="mt-3 text-sm {{ $isFeatured ? 'text-white/60' : 'text-gray-500' }}">
                                {{ $plan->description }}</p>
                            <div class="mt-5 flex items-baseline gap-3">
                                @if ((int) $plan->price === 0)
                                    <span class="landing-headline text-4xl">Free</span>
                                @else
                                    <span class="landing-headline text-4xl">{{ number_format($plan->price / 100, 2) }}
                                        SAR</span>
                                    <span class="text-sm {{ $isFeatured ? 'text-white/60' : 'text-gray-500' }}">/
                                        {{ max((int) ($plan->interval / 30), 1) }} month</span>
                                @endif
                            </div>
                            <a href="{{ auth()->check() ? url('/app/subscription') : route('register') }}"
                                class="{{ $isFeatured ? 'landing-button-primary' : 'landing-button-secondary' }} mt-6 inline-flex h-11 w-full items-center justify-center rounded-lg px-4 text-sm font-semibold transition">{{ $plan->price !== 0 ? 'Register now' : 'Try for free' }}</a>
                            <p
                                class="mt-6 text-sm {{ $isFeatured ? 'text-[#ff80a6]' : 'text-[var(--landing-accent)]' }}">
                                What's included</p>
                            <ul class="mt-3 space-y-3 text-sm">
                                @foreach ($plan->features ?? [] as $feature)
                                    <li
                                        class="flex items-start gap-3 {{ $isFeatured ? 'text-white/70' : 'text-gray-500' }}">
                                        <span
                                            class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full {{ $feature['check'] ? 'bg-[rgba(222,78,121,0.12)] text-[var(--landing-accent)]' : 'bg-gray-100 text-gray-400' }}">
                                            @if ($feature['check'])
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            @endif
                                        </span>
                                        <span>{{ $feature['text'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>


        <section id="partners" class="mx-auto mt-24 mb-24 max-w-7xl">
            <div class="flex flex-col items-start gap-4 md:items-center md:text-center">
                <div
                    class="rounded-full border border-black/5 bg-white px-4 py-2 text-sm text-[var(--landing-accent)] shadow-sm">
                    Partners</div>
                {{-- <div class="relative">
                    <h2 class="landing-headline absolute inset-0 text-4xl md:text-6xl">Built for creators,<br><span class="text-[var(--landing-accent)]">ready for growing teams</span></h2>
                    <mark class="landing-headline landing-highlight inline-block -rotate-1 bg-transparent text-4xl text-transparent md:text-6xl">Built for creators,<br><span class="rounded-xl px-3">ready for growing teams</span></mark>
                </div> --}}
                <div class="relative text-center mt-6">
                    <h2 class="landing-headline absolute inset-0 text-4xl md:text-5xl">
                        Partners<span class="px-3 text-[var(--landing-accent)]">with mejor companes</span><br>
                    </h2>
                    <mark
                        class="landing-headline landing-highlight inline-block -rotate-1 bg-transparent px-1 text-4xl text-transparent md:text-5xl">
                        Partners<span class="rounded-xl px-3">with mejor companes</span><br>
                    </mark>
                </div>
                <div class="mt-10 flex justify-center">
                    @forelse ($partners as $partner)
                        <a href="{{ $partner->url }}" target="_blank" rel="noreferrer"
                            class="flex min-h-28 items-center justify-center rounded-full p-6 transition hover:-translate-y-1 hover:shadow-lg">
                            <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                                class="h-16 grayscale transition hover:grayscale-0">
                        </a>
                    @empty
                        <div
                            class="col-span-full rounded-2xl border border-dashed border-black/10 px-6 py-10 text-center text-sm text-gray-500">
                            Add partners from the dashboard to show them here.</div>
                    @endforelse
                </div>
            </div>
            </div>
        </section>


        <section id="faq" class="mx-auto mt-24 grid max-w-7xl gap-8 lg:grid-cols">
            <div class="glass-panel rounded-[32px] p-4">
                <div class="rounded-[26px] border border-black/5 bg-white p-8">
                    <p class="text-sm font-medium uppercase tracking-[0.24em] text-[var(--landing-accent)]">FAQ</p>
                    <h2 class="landing-headline mt-4 text-4xl">Questions teams ask before they launch</h2>
                    <p class="mt-4 text-sm leading-7 text-gray-500">These answers are still powered by your existing
                        FAQ records, so updates from the admin side keep showing up here automatically.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($faqs as $faq)
                    <article class="glass-panel rounded-[26px] p-3">
                        <div class="rounded-[20px] border border-black/5 bg-white p-6">
                            <button type="button"
                                class="faq-toggle flex w-full items-center justify-between gap-4 text-left text-lg font-semibold text-[var(--landing-text)]"
                                aria-expanded="false">
                                <span>{{ $faq->question }}</span>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#faf5f7] text-[var(--landing-accent)]">+</span>
                            </button>
                            <div class="faq-answer mt-4 text-sm leading-7 text-gray-500" hidden>{{ $faq->answer }}
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="glass-panel rounded-[26px] p-6 text-sm text-gray-500">No FAQs Yet.</div>
                @endforelse
            </div>
        </section>

        <section id="contact" class="mx-auto mt-24 max-w-5xl">
            <div class="glass-panel rounded-[32px] p-4">
                <div class="rounded-[26px] border border-black/5 bg-white p-8 md:p-10">
                    <div class="max-w-2xl">
                        <p class="text-sm font-medium uppercase tracking-[0.24em] text-[var(--landing-accent)]">Contact
                        </p>
                        <h2 class="landing-headline mt-4 text-4xl">Bring your next QR campaign to life</h2>
                        <p class="mt-4 text-sm leading-7 text-gray-500">Ask about branded codes, dashboards, partner
                            packages, or rollout support and well get back to you.</p>
                    </div>

                    @if (session('success'))
                        <div
                            class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}"
                        class="mt-8 grid gap-5 md:grid-cols-2">
                        @csrf
                        <label class="block"><span
                                class="mb-2 block text-sm font-medium text-gray-700">Name</span><input type="text"
                                name="name" value="{{ old('name') }}" required
                                class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[var(--landing-accent)] focus:ring-2 focus:ring-[rgba(222,78,121,0.16)]"></label>
                        <label class="block"><span
                                class="mb-2 block text-sm font-medium text-gray-700">Email</span><input type="email"
                                name="email" value="{{ old('email') }}" required
                                class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[var(--landing-accent)] focus:ring-2 focus:ring-[rgba(222,78,121,0.16)]"></label>
                        <label class="block md:col-span-2"><span
                                class="mb-2 block text-sm font-medium text-gray-700">Subject</span><input
                                type="text" name="subject" value="{{ old('subject') }}" required
                                class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[var(--landing-accent)] focus:ring-2 focus:ring-[rgba(222,78,121,0.16)]"></label>
                        <label class="block md:col-span-2"><span
                                class="mb-2 block text-sm font-medium text-gray-700">Message</span>
                            <textarea name="message" rows="6" required
                                class="w-full rounded-2xl border border-black/10 bg-[#fafaf9] px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[var(--landing-accent)] focus:ring-2 focus:ring-[rgba(222,78,121,0.16)]">{{ old('message') }}</textarea>
                        </label>
                        <div class="md:col-span-2"><button type="submit"
                                class="landing-button-primary inline-flex h-12 items-center justify-center rounded-lg px-6 text-sm font-semibold transition">Send
                                message</button></div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="px-6 pb-10 pt-6 lg:px-10">
        <div class="mx-auto max-w-7xl rounded-[28px] border border-black/5 bg-[#171c2e] px-8 py-8 text-white/70">
            <div class="flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/white-logo.png') }}" alt="QR Generator"
                        class="h-10 w-auto brightness-0 invert">
                    <div>
                        <p class="landing-headline text-2xl text-white">QR Generator</p>
                        <p class="text-sm text-white/50">Create, share, and measure every scan.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-6 text-sm">
                    <a href="#features" class="transition hover:text-white">Features</a>
                    <a href="#pricing" class="transition hover:text-white">Pricing</a>
                    <a href="#faq" class="transition hover:text-white">FAQ</a>
                    <a href="#contact" class="transition hover:text-white">Contact</a>
                </div>
            </div>
            <div class="mt-8 border-t border-white/10 pt-6 text-sm text-white/40">&copy; {{ date('Y') }} QR
                Generator. All rights reserved.</div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('landing-header');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuToggle = document.getElementById('menu-toggle');
            const faqButtons = document.querySelectorAll('.faq-toggle');

            const syncHeader = () => {
                if (window.scrollY > 24) {
                    header.classList.add('border-b', 'border-black/5', 'backdrop-blur-xl');
                } else {
                    header.classList.remove('border-b', 'border-black/5', 'backdrop-blur-xl');
                }
            };

            menuToggle?.addEventListener('click', () => mobileMenu?.classList.toggle('hidden'));

            faqButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const answer = button.parentElement.querySelector('.faq-answer');
                    const icon = button.querySelector('span:last-child');
                    const isOpen = button.getAttribute('aria-expanded') === 'true';
                    button.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                    answer.hidden = isOpen;
                    icon.textContent = isOpen ? '+' : '-';
                });
            });

            syncHeader();
            window.addEventListener('scroll', syncHeader, {
                passive: true
            });
        });
    </script>
</body>

</html>
