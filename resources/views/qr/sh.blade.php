<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $qr->content->name ?? $qr->pdf->name }} </title>
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

@if ($qr->content)

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
                        class="w-28 h-28 sm:w-28 sm:h-28 rounded-full mx-auto border-4 border-white shadow-lg object-cover">
                </div>

                <!-- Name -->
                <div class="mb-4 sm:mb-6  px-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 ">{{ $qr->content->name }}</h1>
                    <h3 class="text-base sm:text-base  text-gray-500  ">{{ $qr->content->title }}
                    </h3>
                </div>

                <!-- Contact Info -->
                <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                    <!-- Phone -->
                    @if ($qr->content->phone)
                        <a href="tel:{{ $qr->content->phone }}"
                            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div
                                class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                        $qr->content->snap ||
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
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif

                            @if ($qr->content->snap)
                                <a href="https://www.snapchat.com/{{ $qr->content->snap }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center min-w-0 flex-1">
                                        <div
                                            class="w-8 h-8 text-white rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="45" width="45"
                                                viewBox="-11.82687 -19.71145 102.49954 118.2687">
                                                <path
                                                    d="M66.2827 0c6.9372 0 12.5631 5.6247 12.5631 12.5643v53.7184c0 6.9372-5.6259 12.5631-12.5631 12.5631H12.5643C5.626 78.8458 0 73.22 0 66.2827V12.5643C0 5.6247 5.6259 0 12.5643 0z"
                                                    fill="#fffc00" />
                                                <path
                                                    d="M66.0063 52.9389c-.2324-.769-1.3444-1.3112-1.3444-1.3112-.1051-.0553-.1992-.1051-.2766-.1439-1.8534-.8962-3.4966-1.975-4.8797-3.1978-1.112-.9848-2.0636-2.0691-2.8271-3.2199-.935-1.4053-1.3721-2.5782-1.5602-3.2144-.1051-.415-.0885-.581 0-.7967.072-.1826.2877-.354.3873-.437.6252-.4427 1.632-1.0955 2.2517-1.4938.5367-.3486.9959-.6473 1.267-.8355.8686-.6085 1.466-1.2282 1.8146-1.8976.4537-.863.509-1.8147.155-2.7497-.4759-1.2614-1.6543-2.0138-3.1536-2.0138-.332 0-.675.0387-1.018.1106-.8575.1881-1.6708.4924-2.3513.758a.0707.0707 0 01-.0996-.072c.072-1.6874.155-3.9557-.0332-6.1078-.166-1.9475-.5698-3.5907-1.2227-5.0236-.6583-1.4384-1.5159-2.5007-2.1853-3.2697-.6363-.7303-1.7594-1.8091-3.4523-2.7773-2.379-1.361-5.09-2.0526-8.0554-2.0526-2.9599 0-5.6653.6916-8.0498 2.0526-1.7926 1.0235-2.9378 2.1798-3.4578 2.7773-.6695.769-1.527 1.8313-2.1854 3.2697-.6584 1.433-1.0567 3.0706-1.2227 5.0236-.188 2.1632-.1106 4.249-.0332 6.1079 0 .0553-.0498.094-.1051.0719-.6805-.2656-1.4938-.5699-2.3513-.758-.3375-.0719-.6805-.1106-1.018-.1106-1.4938 0-2.6722.7524-3.1536 2.0138-.354.935-.2987 1.8866.155 2.7497.354.6694.946 1.289 1.8146 1.8976.2656.1882.7303.487 1.267.8355.603.3928 1.5823 1.029 2.213 1.466.0774.0554.343.2546.426.4648.0885.2213.1051.3873-.011.8299-.1937.6418-.6308 1.8036-1.5492 3.1812-.7635 1.1563-1.715 2.2351-2.8271 3.22-1.3831 1.2226-3.0263 2.3015-4.8797 3.1977-.0885.0443-.1936.094-.3043.1605 0 0-1.1065.5643-1.3167 1.2946-.3098 1.0788.5145 2.0913 1.35 2.6335 1.372.8852 3.0428 1.361 4.011 1.621.271.072.5145.1383.7358.2047.1383.0443.4869.177.6363.3707.188.2434.2102.5422.2766.8797.1051.5698.343 1.2724 1.0456 1.7593.7746.5311 1.7539.5698 2.9987.6196 1.3001.0498 2.9156.1107 4.769.7248.8576.2822 1.6376.7635 2.534 1.3167 1.881 1.1563 4.2212 2.5948 8.2157 2.5948 4 0 6.3569-1.444 8.249-2.6058.8963-.5477 1.6653-1.0235 2.5063-1.3002 1.8533-.614 3.4688-.675 4.769-.7247 1.2448-.0498 2.224-.083 2.9986-.6197.7524-.52.9682-1.2946 1.0678-1.8755.0553-.2877.0885-.5477.2545-.758.1438-.1825.4647-.3098.6141-.3596.2268-.0719.4813-.1383.7635-.2157.9682-.26 2.1853-.5644 3.6625-1.3998 1.7815-1.0124 1.9032-2.2517 1.7151-2.8658z"
                                                    fill="#fff" />
                                                <path
                                                    d="M67.5444 52.3414c-.3929-1.0733-1.1453-1.6432-1.9973-2.119-.1604-.094-.3098-.1715-.4315-.2268-.2545-.1328-.5145-.26-.7746-.3928-2.6611-1.4108-4.7414-3.1923-6.1798-5.3002-.4869-.7137-.8244-1.3555-1.0623-1.881-.1217-.3541-.1161-.5533-.0276-.7359.0664-.1383.2434-.2821.343-.354a91.283 91.283 0 011.2503-.8133c.5699-.3707 1.0236-.664 1.3113-.8631 1.0954-.7635 1.8589-1.5768 2.3347-2.4841.675-1.278.758-2.7386.2379-4.1107-.7192-1.9032-2.5228-3.0871-4.7027-3.0871-.4536 0-.9128.0497-1.3665.1493-.1217.0277-.2379.0554-.354.083.022-1.2946-.0111-2.6777-.1273-4.0277-.4094-4.758-2.0747-7.2531-3.812-9.2393-.7247-.8299-1.9861-2.0415-3.8782-3.1259-2.639-1.5159-5.6266-2.2794-8.8853-2.2794-3.2476 0-6.2351.7635-8.8742 2.274-1.9032 1.0843-3.1646 2.3014-3.8838 3.1258-1.7372 1.9862-3.4025 4.4813-3.812 9.2393-.116 1.35-.1438 2.733-.1272 4.0277-.1161-.0277-.2379-.0553-.354-.083a6.4198 6.4198 0 00-1.3666-.1494c-2.1798 0-3.9834 1.184-4.7026 3.0872-.52 1.372-.4371 2.8326.2379 4.1106.4758.9074 1.2448 1.7207 2.3347 2.4842.2932.2047.7414.4979 1.3112.863.3098.1992.758.4924 1.2006.7856.0664.0443.3043.2213.3872.3873.0941.1881.0941.3928-.0442.769-.2324.5146-.5699 1.1453-1.0457 1.8424-1.4108 2.0636-3.4301 3.8119-6.0028 5.206-1.3665.7248-2.7828 1.2062-3.3803 2.8327-.4537 1.2283-.155 2.628.9903 3.8064.3762.4039.852.7635 1.4495 1.0955 1.4053.7745 2.6003 1.1563 3.5408 1.4163.166.0498.5478.1715.7137.3209.4205.3651.3596.9184.9184 1.7261.3375.5035.7248.8465 1.0457 1.0678 1.1673.8078 2.484.8575 3.8783.9129 1.2559.0498 2.6833.105 4.3098.6417.675.2213 1.3776.6529 2.1854 1.1508 1.9474 1.2006 4.6196 2.8382 9.0844 2.8382 4.4703 0 7.1535-1.6487 9.1176-2.8493.8077-.4924 1.5048-.9239 2.1577-1.1397 1.6265-.5366 3.054-.592 4.3098-.6417 1.3942-.0554 2.7054-.1051 3.8783-.9129a4.0756 4.0756 0 001.195-1.3001c.3984-.6805.3929-1.1619.769-1.4883.155-.1328.4925-.249.675-.3043.9461-.26 2.1577-.6418 3.5906-1.433.6363-.3485 1.1287-.7302 1.5215-1.1673l.0166-.0166c1.0678-1.1618 1.3389-2.5173.8963-3.7178zm-3.9669 2.13c-2.4232 1.3389-4.0332 1.195-5.2835 1.9972-1.0623.686-.4371 2.1633-1.2061 2.6944-.9516.6584-3.7566-.0443-7.3804 1.1507-2.9876.9904-4.8963 3.8286-10.2795 3.8286-5.3942 0-7.2476-2.8272-10.2794-3.8286-3.6238-1.195-6.4343-.4923-7.3804-1.1507-.769-.5311-.1438-2.0083-1.206-2.6944-1.2504-.8077-2.8604-.6639-5.2836-1.9972-1.5436-.852-.6695-1.3776-.155-1.6266 8.7746-4.2434 10.1688-10.805 10.2352-11.2974.0775-.5864.1605-1.0512-.4868-1.6542-.6252-.581-3.408-2.3016-4.1771-2.8382-1.278-.8907-1.8368-1.7815-1.4219-2.877.2877-.7579.9959-1.04 1.7428-1.04.2324 0 .4703.0276.697.0774 1.3998.3043 2.7608 1.007 3.5464 1.195.1107.0277.2047.0388.2877.0388.4205 0 .5643-.2103.5367-.6916-.0885-1.5325-.3098-4.52-.0664-7.314.332-3.8396 1.5712-5.7428 3.0429-7.4302.7081-.8077 4.0277-4.3154 10.3735-4.3154 6.3624 0 9.6653 3.5077 10.3735 4.3154 1.4716 1.682 2.711 3.5851 3.0429 7.4302.2434 2.794.0332 5.7815-.0664 7.314-.0332.5035.1217.6916.5366.6916.083 0 .1826-.011.2877-.0388.7856-.188 2.1466-.8907 3.5464-1.195a3.2825 3.2825 0 01.697-.0774c.747 0 1.4551.2877 1.7428 1.04.415 1.0955-.1494 1.9863-1.4218 2.877-.769.5366-3.552 2.2573-4.1771 2.8382-.6473.5975-.5643 1.0622-.4869 1.6542.0609.4924 1.4606 7.054 10.2352 11.2974.498.249 1.3776.7746-.166 1.6266z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-900 truncate">Snapchat</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
@else
    <!-- PDF Viewer Section -->
    <section class="relative py-4 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Card Container -->
            <div
                class="relative bg-white/70 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden border border-white/30">
                <!-- Header -->
                <div class="bg-[{{ $qr->pdf->color_l }}] p-6 sm:p-8 text-center text-white">
                    <h2 class="text-xl sm:text-2xl font-bold mb-2">{{ $qr->pdf->name }}</h2>
                    <p class="text-sm sm:text-base opacity-90">{{ $qr->pdf->description }}</p>
                </div>

                <!-- PDF Embed -->
                <div class="p-4=2 sm:p-3 bg-white rounded-b-3xl">
                    <div class="w-auto h-[100vh] border border-gray-200 rounded-xl overflow-hidden shadow-inner">
                        <iframe src="{{ Storage::disk('public')->url($qr->pdf->file) }}" class="w-full h-full"
                            title="PDF Preview"></iframe>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6">
                        <a href="{{ asset('storage/files/' . $qr->pdf->file) }}" download
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg bg-[{{ $qr->pdf->color_d }}] text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF
                        </a>

                        <a href="{{ Storage::disk('public')->url($qr->pdf->file) }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-100 text-gray-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 9V3h4v6m2 0h4l-8 8-8-8h4m4 8v4" />
                            </svg>
                            Open in New Tab
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif

</html>
