<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $qr->content->name }} - Contact</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .gradient-bg {
            background: linear-gradient(135deg, {{ $qr->content->color_l ?? '#232421' }} 0%, {{ $qr->content->color_d ?? '#f78e31' }} 100%);
        }

        .contact-btn {
            background-color: {{ $qr->content->color_l ?? '#232421' }};
        }

        .contact-btn:hover {
            background-color: {{ $qr->content->color_d ?? '#f78e31' }};
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Background Gradient -->
    <div class="gradient-bg relative h-64 sm:h-80 overflow-hidden">
        <!-- Decorative SVG for desktop -->
        <svg class="hidden sm:block absolute inset-0 w-full h-full" viewBox="0 0 2080 340" fill="none"
            preserveAspectRatio="none">
            <path d="M0 0H2080V340L0 290V0Z" fill="url(#gradient)"></path>
            <defs>
                <linearGradient id="gradient" x1="323.5" y1="0" x2="323.5" y2="364">
                    <stop stop-color="{{ $qr->content->color_l ?? '#232421' }}"></stop>
                    <stop offset="1" stop-color="{{ $qr->content->color_d ?? '#f78e31' }}"></stop>
                </linearGradient>
            </defs>
        </svg>

        <!-- Mobile gradient overlay -->
        <div class="sm:hidden absolute inset-0 bg-gradient-to-br from-transparent to-black/10"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-sm sm:max-w-md mx-auto px-4 -mt-32 sm:-mt-40 relative z-10 pb-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 text-center">
            <!-- Avatar -->
            <div class="mb-4 sm:mb-6">
                <img src="{{ $qr->content->profile_photo_url }}" alt="{{ $qr->content->name }}"
                    class="w-28 h-28 sm:w-24 sm:h-24 rounded-full mx-auto border-4 border-white shadow-lg object-cover">
            </div>

            <!-- Name -->
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 px-2">{{ $qr->content->name }}</h1>

            <!-- Contact Info -->
            <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                <!-- Phone -->
                @if ($qr->content->phone)
                    <a href="tel:{{ $qr->content->phone }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-left min-w-0 flex-1">
                            <p class="text-xs text-gray-500">Phone</p>
                            <p class="font-medium text-gray-900 truncate">{{ $qr->content->phone }}</p>
                        </div>
                    </a>
                @endif

                <!-- Email -->
                @if ($qr->content->email)
                    <a href="mailto:{{ $qr->content->email }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div
                            class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-left min-w-0 flex-1">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-medium text-gray-900 truncate">{{ $qr->content->email }}</p>
                        </div>
                    </a>
                @endif

                <!-- Company -->
                @if ($qr->content->company)
                    <div class="flex items-center p-3 rounded-lg">
                        <div
                            class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="text-left min-w-0 flex-1">
                            <p class="text-xs text-gray-500">Company</p>
                            <p class="font-medium text-gray-900 truncate">{{ $qr->content->company }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Social Media -->
            @if (
                $qr->content->facebook ||
                    $qr->content->x ||
                    $qr->content->instagram ||
                    $qr->content->linkedin ||
                    $qr->content->youtube)
                <div class="mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Find me on</h3>
                    <div class="space-y-2 sm:space-y-3">
                        @if ($qr->content->facebook)
                            <a href="{{ $qr->content->facebook }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div
                                        class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 truncate">Facebook</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif

                        @if ($qr->content->x)
                            <a href="{{ $qr->content->x }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div
                                        class="w-8 h-8 bg-black rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 truncate">X (Twitter)</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif

                        @if ($qr->content->instagram)
                            <a href="{{ $qr->content->instagram }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.281c-.49 0-.928-.175-1.297-.49-.368-.315-.49-.753-.49-1.243 0-.49.122-.928.49-1.243.369-.315.807-.49 1.297-.49s.928.175 1.297.49c.368.315.49.753.49 1.243 0 .49-.122.928-.49 1.243-.369.315-.807.49-1.297.49z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 truncate">Instagram</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif

                        @if ($qr->content->linkedin)
                            <a href="{{ $qr->content->linkedin }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div
                                        class="w-8 h-8 bg-blue-700 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 truncate">LinkedIn</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif

                        @if ($qr->content->youtube)
                            <a href="{{ $qr->content->youtube }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div
                                        class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 truncate">YouTube</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Add Contact Button -->
            <a href="{{ route('qr.vcard', $qr) }}"
                class="contact-btn w-full text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Contact
            </a>
        </div>
    </div>
</body>

</html>
