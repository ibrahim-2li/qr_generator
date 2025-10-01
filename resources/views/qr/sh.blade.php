<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif !important;
        }
    </style>
</head>

<div class="qr-backdrop" id="color_palette" style="--bg-color: #f6f6da; --height: 329px;"><svg
        class="hidden md:block absolute" width="2080" height="420" viewBox="0 0 2080 420" fill="none"
        xmlns="http://www.w3.org/2000/svg" style="z-index: -1; width: 100%; height: auto;">
        <path d="M0 0H2080V420L0 360V0Z" fill="url(#paint0_linear_8_2)"></path>
        <defs>
            <linearGradient id="paint0_linear_8_2" x1="323.5" y1="0" x2="323.5" y2="364"
                gradientUnits="userSpaceOnUse">
                <stop stop-color="#232421" class="duration-500"></stop>
                <stop offset="1" stop-color="#f78e31" class="duration-500"></stop>
            </linearGradient>
        </defs>
    </svg><svg class="md:hidden absolute" width="570" height="364" viewBox="0 0 570 364" fill="none"
        xmlns="http://www.w3.org/2000/svg" style="z-index: -1; width: 100%; height: auto;">
        <path d="M0 0H570V340L0 360V0Z" fill="url(#paint0_linear_8_4)"></path>
        <defs>
            <linearGradient id="paint0_linear_8_4" x1="323.5" y1="0" x2="323.5" y2="364"
                gradientUnits="userSpaceOnUse">
                <stop class="duration-500" stop-color="#232421"></stop>
                <stop offset="1" stop-color="#f78e31" class="duration-500"></stop>
            </linearGradient>
        </defs>
    </svg></div>
<div class="App">

    <div class="flex flex-col justify-center items-center">

        <div
            class="flex flex-col items-center justify-center mt-[80px] w-full max-w-[700px] px-[16px] pb-[25px] zoom-block">

            <div
                class="MuiAvatar-root MuiAvatar-circular border-[7px] rounded-full border-white shadow-[1px_6px_30px_rgba(0,31,14,0.05)] css-tq0t2d">
                <img alt="{{ $qr->content->name }}" src="{{ $qr->content->profile_photo_url }}" width="120px"
                    height="120px" class="rounded-full MuiAvatar-img css-1hy9t21">

            </div>

            <div class="flex flex-col items-center justify-center mt-3" id="vcardName">

                <h1 class="text-xl xs:text-2xl mb-1 font-bold duration-500 w-full word-break-fix"
                    style="font-family: &quot;GT Walsheim Pro&quot;; color: rgb(0, 0, 0);">{{ $qr->content->name }}</h1>

            </div>
            <div
                class="flex flew-row space-x-[15px] rtl:space-x-0 rtl:gap-5 rtl:columns-3 xs:space-x-[10px] mt-[10px] xs:mt-[25px]">
                <button
                    class="flex items-center justify-center w-[50px] xs:w-[62px] h-[50px] xs:h-[62px] bg-white rounded-full cursor-pointer hover:opacity-95 hover:scale-105 shadow-[1px_6px_30px_rgba(0,31,14,0.05)]"><svg
                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_797_11738" maskUnits="userSpaceOnUse" x="2" y="2" width="21" height="21">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 2.00024H22.4996V22.4997H2V2.00024Z"
                                fill="white"></path>
                        </mask>
                        <g mask="url(#mask0_797_11738)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.35908 5.06079C4.36108 5.06079 4.31108 5.11279 4.24808 5.17479C4.00608 5.40979 3.50508 5.89879 3.50008 6.92179C3.49208 8.35279 4.43308 11.0098 8.96408 15.5398C13.4741 20.0478 16.1271 20.9998 17.5611 20.9998H17.5821C18.6051 20.9948 19.0931 20.4928 19.3291 20.2518C19.4011 20.1778 19.4591 20.1238 19.5001 20.0898C20.4961 19.0878 21.0061 18.3418 21.0011 17.8638C20.9941 17.3758 20.3871 16.7988 19.5481 16.0008C19.2811 15.7468 18.9911 15.4708 18.6851 15.1648C17.8921 14.3738 17.4991 14.5088 16.6351 14.8128C15.4401 15.2318 13.8001 15.8018 11.2521 13.2528C8.70008 10.7028 9.27108 9.06479 9.68908 7.86979C9.99108 7.00579 10.1291 6.61179 9.33508 5.81779C9.02408 5.50779 8.74508 5.21379 8.48808 4.94379C7.69508 4.10979 7.12308 3.50679 6.63808 3.49979H6.63008C6.15108 3.49979 5.40708 4.01179 4.35408 5.06479C4.35708 5.06179 4.35808 5.06079 4.35908 5.06079ZM17.5621 22.4998C15.0701 22.4998 11.8211 20.5158 7.90408 16.6008C3.97208 12.6698 1.98508 9.41079 2.00008 6.91379C2.00908 5.26379 2.87408 4.41879 3.19908 4.10179C3.21608 4.08079 3.27408 4.02379 3.29408 4.00379C4.72808 2.56879 5.69508 1.98879 6.65708 1.99979C7.77408 2.01479 8.56908 2.85079 9.57508 3.90979C9.82408 4.17179 10.0941 4.45679 10.3951 4.75679C11.8551 6.21679 11.4391 7.40779 11.1051 8.36379C10.7411 9.40679 10.4261 10.3068 12.3121 12.1928C14.2001 14.0788 15.1001 13.7638 16.1391 13.3968C17.0961 13.0628 18.2841 12.6448 19.7461 14.1048C20.0421 14.4008 20.3231 14.6678 20.5821 14.9148C21.6461 15.9258 22.4861 16.7248 22.5001 17.8448C22.5121 18.7998 21.9321 19.7728 20.5001 21.2058L19.8661 20.7758L20.4021 21.2998C20.0851 21.6248 19.2411 22.4908 17.5901 22.4998H17.5621Z"
                                fill="#000000" class="duration-500"></path>
                        </g>
                    </svg>
                </button>

                <button
                    class="flex items-center justify-center w-[50px] xs:w-[62px] h-[50px] xs:h-[62px] bg-white rounded-full cursor-pointer hover:opacity-95 hover:scale-105 shadow-[1px_6px_30px_rgba(0,31,14,0.05)]"><svg
                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.7767 13.4647C11.1077 13.4647 10.4407 13.2437 9.88273 12.8017L5.39773 9.18574C5.07473 8.92574 5.02473 8.45274 5.28373 8.13074C5.54473 7.80974 6.01673 7.75874 6.33873 8.01774L10.8197 11.6297C11.3827 12.0757 12.1757 12.0757 12.7427 11.6257L17.1787 8.01974C17.5007 7.75674 17.9727 7.80674 18.2347 8.12874C18.4957 8.44974 18.4467 8.92174 18.1257 9.18374L13.6817 12.7957C13.1197 13.2417 12.4477 13.4647 11.7767 13.4647Z"
                            fill="#000000" class="duration-500"></path>
                        <mask id="mask0_922_2245" maskUnits="userSpaceOnUse" x="1" y="2" width="22" height="20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1 2H22.4999V21.5H1V2Z" fill="white">
                            </path>
                        </mask>
                        <g mask="url(#mask0_922_2245)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.839 20H16.659C16.661 19.998 16.669 20 16.675 20C17.816 20 18.828 19.592 19.604 18.817C20.505 17.92 21 16.631 21 15.188V8.32C21 5.527 19.174 3.5 16.659 3.5H6.841C4.326 3.5 2.5 5.527 2.5 8.32V15.188C2.5 16.631 2.996 17.92 3.896 18.817C4.672 19.592 5.685 20 6.825 20H6.839ZM6.822 21.5C5.279 21.5 3.901 20.94 2.837 19.88C1.652 18.698 1 17.032 1 15.188V8.32C1 4.717 3.511 2 6.841 2H16.659C19.989 2 22.5 4.717 22.5 8.32V15.188C22.5 17.032 21.848 18.698 20.663 19.88C19.6 20.939 18.221 21.5 16.675 21.5H16.659H6.841H6.822Z"
                                fill="#000000" class="duration-500"></path>
                        </g>
                    </svg></button>
            </div>
            <div class="w-full">
                <div class="py-[20px] px-[12px] xs:p-[20px] rounded-[4px] flex flex-col items-start justify-center w-full shadow-[1px_6px_30px_rgba(0,31,14,0.05)] mt-6"
                    style="font-family: &quot;GT Walsheim Pro&quot;;">
                    <div class="w-full" id="vcardPhone">
                        <div class="w-full"><button
                                class="flex flex-row space-x-[10px] xs:space-x-[16px] w-full cursor-pointer hover:opacity-80">
                                <div class="bg-[#F9F9F9] p-[11px] rounded-full w-10 h-10"><svg width="18"
                                        height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_797_11795" maskUnits="userSpaceOnUse" x="1" y="1"
                                            width="16" height="16">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M1.5 1.50024H16.8747V16.8749H1.5V1.50024Z" fill="white"></path>
                                        </mask>
                                        <g mask="url(#mask0_797_11795)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.26931 3.79562C3.27081 3.79562 3.23331 3.83462 3.18606 3.88112C3.00456 4.05737 2.62881 4.42412 2.62506 5.19137C2.61906 6.26462 3.32481 8.25737 6.72306 11.6549C10.1056 15.0359 12.0953 15.7499 13.1708 15.7499H13.1866C13.9538 15.7461 14.3198 15.3696 14.4968 15.1889C14.5508 15.1334 14.5943 15.0929 14.6251 15.0674C15.3721 14.3159 15.7546 13.7564 15.7508 13.3979C15.7456 13.0319 15.2903 12.5991 14.6611 12.0006C14.4608 11.8101 14.2433 11.6031 14.0138 11.3736C13.4191 10.7804 13.1243 10.8816 12.4763 11.1096C11.5801 11.4239 10.3501 11.8514 8.43906 9.93962C6.52506 8.02712 6.95331 6.79862 7.26681 5.90237C7.49331 5.25437 7.59681 4.95887 7.00131 4.36337C6.76806 4.13087 6.55881 3.91037 6.36606 3.70787C5.77131 3.08237 5.34231 2.63012 4.97856 2.62487H4.97256C4.61331 2.62487 4.05531 3.00887 3.26556 3.79862C3.26781 3.79637 3.26856 3.79562 3.26931 3.79562ZM13.1716 16.8749C11.3026 16.8749 8.86581 15.3869 5.92806 12.4506C2.97906 9.50237 1.48881 7.05812 1.50006 5.18537C1.50681 3.94787 2.15556 3.31412 2.39931 3.07637C2.41206 3.06062 2.45556 3.01787 2.47056 3.00287C3.54606 1.92662 4.27131 1.49162 4.99281 1.49987C5.83056 1.51112 6.42681 2.13812 7.18131 2.93237C7.36806 3.12887 7.57056 3.34262 7.79631 3.56762C8.89131 4.66262 8.57931 5.55587 8.32881 6.27287C8.05581 7.05512 7.81956 7.73012 9.23406 9.14462C10.6501 10.5591 11.3251 10.3229 12.1043 10.0476C12.8221 9.79712 13.7131 9.48362 14.8096 10.5786C15.0316 10.8006 15.2423 11.0009 15.4366 11.1861C16.2346 11.9444 16.8646 12.5436 16.8751 13.3836C16.8841 14.0999 16.4491 14.8296 15.3751 15.9044L14.8996 15.5819L15.3016 15.9749C15.0638 16.2186 14.4308 16.8681 13.1926 16.8749H13.1716Z"
                                                fill="#767C83"></path>
                                        </g>
                                    </svg></div>
                                <div class="flex flex-col justify-center text-left w-full truncate rtl:text-right">
                                    <p class="text-[12px] xxs:text-xs text-[#767C83] rtl:mr-2 rtl:text-right not-lang">
                                        Phone Number</p>
                                    <p class="text-sm xs:text-sm xs:text-base text-black font-medium truncate rtl:mr-2 rtl:text-right not-lang"
                                        style="font-family: &quot;GT Walsheim Pro&quot;;">{{ $qr->content->phone }}</p>
                                </div>
                            </button>
                            <div class="w-full h-[1px] my-[15px] bg-[#F2F2F2] rounded-full"></div>
                        </div>
                    </div>
                    <div class="w-full" id="vcardEmail">
                        <div class="w-full"><button
                                class="flex flex-row space-x-[10px] xs:space-x-[16px] w-full cursor-pointer hover:opacity-80">
                                <div class="bg-[#F9F9F9] p-[11px] rounded-full w-10 h-10"><svg width="18"
                                        height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.83279 10.0986C8.33104 10.0986 7.83079 9.93287 7.41229 9.60137L4.04854 6.88937C3.80629 6.69437 3.76879 6.33962 3.96304 6.09812C4.15879 5.85737 4.51279 5.81912 4.75429 6.01337L8.11504 8.72237C8.53729 9.05687 9.13204 9.05687 9.55729 8.71937L12.8843 6.01487C13.1258 5.81762 13.4798 5.85512 13.6763 6.09662C13.872 6.33737 13.8353 6.69137 13.5945 6.88787L10.2615 9.59687C9.84004 9.93137 9.33604 10.0986 8.83279 10.0986Z"
                                            fill="#767C83"></path>
                                        <mask id="mask0_797_11802" maskUnits="userSpaceOnUse" x="0" y="1"
                                            width="17" height="16">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.75 1.5H16.8749V16.125H0.75V1.5Z" fill="white"></path>
                                        </mask>
                                        <g mask="url(#mask0_797_11802)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.12925 15H12.4943C12.4958 14.9985 12.5017 15 12.5063 15C13.362 15 14.121 14.694 14.703 14.1128C15.3787 13.44 15.75 12.4732 15.75 11.391V6.24C15.75 4.14525 14.3805 2.625 12.4943 2.625H5.13075C3.2445 2.625 1.875 4.14525 1.875 6.24V11.391C1.875 12.4732 2.247 13.44 2.922 14.1128C3.504 14.694 4.26375 15 5.11875 15H5.12925ZM5.1165 16.125C3.95925 16.125 2.92575 15.705 2.12775 14.91C1.239 14.0235 0.75 12.774 0.75 11.391V6.24C0.75 3.53775 2.63325 1.5 5.13075 1.5H12.4943C14.9918 1.5 16.875 3.53775 16.875 6.24V11.391C16.875 12.774 16.386 14.0235 15.4972 14.91C14.7 15.7042 13.6658 16.125 12.5063 16.125H12.4943H5.13075H5.1165Z"
                                                fill="#767C83"></path>
                                        </g>
                                    </svg></div>
                                <div
                                    class="flex flex-col justify-center text-left w-full truncate rtl:text-right rtl:mr-2">
                                    <p class="text-[12px] xxs:text-xs text-[#767C83] rtl:text-right rtl:mr-2 not-lang">
                                        Email</p>
                                    <p class="text-sm xs:text-sm xs:text-base text-black font-medium truncate rtl:text-right rtl:mr-2 not-lang"
                                        style="font-family: &quot;GT Walsheim Pro&quot;;">{{ $qr->content->email }}</p>
                                </div>
                            </button>

                        </div>
                    </div>
                    @if ($qr->content->company)
                        <div class="w-full h-[1px] my-[15px] bg-[#F2F2F2] rounded-full"></div>
                        <button
                            class="flex flex-row space-x-[10px] xs:space-x-[16px] w-full cursor-pointer hover:opacity-80 items-center"
                            id="vcardCompany">
                            <div class="bg-[#F9F9F9] p-[11px] rounded-full w-10 h-10"><svg width="18"
                                    height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.99609 13.0702C8.68559 13.0702 8.43359 12.8182 8.43359 12.5077V10.605C8.43359 10.2945 8.68559 10.0425 8.99609 10.0425C9.30659 10.0425 9.55859 10.2945 9.55859 10.605V12.5077C9.55859 12.8182 9.30659 13.0702 8.99609 13.0702Z"
                                        fill="#767C83"></path>
                                    <mask id="mask0_797_11788" maskUnits="userSpaceOnUse" x="1" y="3" width="16"
                                        height="9">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.5 3.43506H16.4924V11.1683H1.5V3.43506Z" fill="white"></path>
                                    </mask>
                                    <g mask="url(#mask0_797_11788)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.625 8.54481C4.407 9.51306 6.654 10.0433 8.9925 10.0433C11.3355 10.0433 13.5848 9.51306 15.3675 8.54481V6.29331C15.3675 5.33706 14.5942 4.56006 13.6425 4.56006H4.3575C3.402 4.56006 2.625 5.33406 2.625 6.28581V8.54481ZM8.9925 11.1683C6.33375 11.1683 3.771 10.5248 1.77825 9.35781C1.60575 9.25731 1.5 9.07281 1.5 8.87256V6.28581C1.5 4.71381 2.78175 3.43506 4.3575 3.43506H13.6425C15.2145 3.43506 16.4925 4.71681 16.4925 6.29331V8.87256C16.4925 9.07281 16.386 9.25731 16.2142 9.35781C14.2215 10.5248 11.6565 11.1683 8.9925 11.1683Z"
                                            fill="#767C83"></path>
                                    </g>
                                    <mask id="mask1_797_11788" maskUnits="userSpaceOnUse" x="5" y="1" width="8"
                                        height="4">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.80859 1.50024H12.1836V4.55717H5.80859V1.50024Z" fill="white">
                                        </path>
                                    </mask>
                                    <g mask="url(#mask1_797_11788)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.6211 4.55724C11.3106 4.55724 11.0586 4.30524 11.0586 3.99474V3.72024C11.0586 3.11649 10.5673 2.62524 9.96359 2.62524H8.02859C7.42484 2.62524 6.93359 3.11649 6.93359 3.72024V3.99474C6.93359 4.30524 6.68159 4.55724 6.37109 4.55724C6.06059 4.55724 5.80859 4.30524 5.80859 3.99474V3.72024C5.80859 2.49624 6.80459 1.50024 8.02859 1.50024H9.96359C11.1876 1.50024 12.1836 2.49624 12.1836 3.72024V3.99474C12.1836 4.30524 11.9316 4.55724 11.6211 4.55724Z"
                                            fill="#767C83"></path>
                                    </g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3459 16.3052H4.64593C3.08968 16.3052 1.77943 15.0895 1.66168 13.537L1.51918 11.6552C1.49593 11.3455 1.72843 11.0747 2.03818 11.0515C2.34943 11.0402 2.61793 11.26 2.64193 11.5705L2.78368 13.4515C2.85718 14.4205 3.67468 15.1802 4.64593 15.1802H13.3459C14.3172 15.1802 15.1354 14.4205 15.2082 13.4515L15.3507 11.5705C15.3747 11.26 15.6499 11.0395 15.9544 11.0515C16.2642 11.0747 16.4959 11.3455 16.4727 11.6552L16.3302 13.537C16.2124 15.0895 14.9022 16.3052 13.3459 16.3052Z"
                                        fill="#767C83"></path>
                                </svg></div>
                            <div class="flex flex-col justify-center text-left text-balance w-full rtl:text-right">
                                <div class="text-balance w-full block">
                                    <p class="text-[12px] xxs:text-xs text-[#767C83] rtl:mr-2 rtl:text-right not-lang">
                                        Company</p>
                                    <p
                                        class="text-[12px] text-sm xs:text-sm xs:text-base text-black font-medium w-full word-break-fix not-lang">
                                        {{ $qr->content->company }}</p>
                                </div>
                            </div>
                        </button>
                    @endif
                </div>
                <div class="mt-[20px] w-full flex flex-col items-start justify-center mb-[20px]"
                    style="font-family: &quot;GT Walsheim Pro&quot;;">
                    <p class="font-medium text-lg xs:text-xl text-[#131D29] xxxs:mb-[0px] xs:mb-[10px] not-lang"
                        style="font-family: &quot;GT Walsheim Pro&quot;;">Find me on</p>
                    <div class="w-full space-y-[8px] xs:space-y-[15px]"><a href="{{ $qr->content->facebook }}"
                            target="_blank"
                            class="my-[5px] flex flex-col w-full cursor-pointer shadow-[1px_6px_30px_rgba(0,31,14,0.05)] hover:opacity-90 break-all"
                            rel="noreferrer" id="socialBlock_0">
                            <div class="flex flex-row justify-between items-center p-[10px] rounded-[4px]">
                                <div
                                    class="space-x-[8px] xs:space-x-[12px] sm:space-x-[20px] flex flex-row items-center">
                                    <img src="https://qr-code.io/themes/altum/assets/images/socialicon/icon2.svg"
                                        class="w-[44px] rtl:ml-2" alt="Facebook">
                                    <div class="flex flex-col justify-center text-left">
                                        <p class="text-sm xs:text-base sm:text-xl text-[#131D29] font-medium break-words rtl:text-base rtl:leading-4 rtl:text-right not-lang"
                                            style="font-family: &quot;GT Walsheim Pro&quot;;">Facebook</p>
                                        <p class="text-[10px] xs:text-xs text-[#767C83] rtl:text-right word-break-fix not-lang"
                                            style="font-family: &quot;GT Walsheim Pro&quot;;"></p>
                                    </div>
                                </div><span style="width: 24px; margin-left: 8px;"><svg class="rtl:rotate-180"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 11.7256C4 11.3459 4.28215 11.0321 4.64823 10.9824L4.75 10.9756H19.75C20.1642 10.9756 20.5 11.3114 20.5 11.7256C20.5 12.1053 20.2178 12.4191 19.8518 12.4687L19.75 12.4756L4.75 12.4756C4.33579 12.4756 4 12.1398 4 11.7256Z"
                                            fill="#767C83"></path>
                                        <path
                                            d="M13.171 6.23271C12.8775 5.94045 12.8765 5.46558 13.1687 5.17206C13.4344 4.90522 13.851 4.88012 14.1451 5.09734L14.2294 5.16977L20.2794 11.1938C20.547 11.4603 20.5714 11.8784 20.3524 12.1724L20.2794 12.2567L14.2294 18.2817C13.9359 18.574 13.4611 18.573 13.1688 18.2795C12.9031 18.0127 12.8797 17.5959 13.0982 17.3028L13.171 17.2188L18.687 11.7249L13.171 6.23271Z"
                                            fill="#767C83"></path>
                                    </svg></span>
                            </div>
                        </a>
                        @if ($qr->content->x)
                            <a href="{{ $qr->content->x }}" target="_blank"
                                class="my-[5px] flex flex-col w-full cursor-pointer shadow-[1px_6px_30px_rgba(0,31,14,0.05)] hover:opacity-90 break-all"
                                rel="noreferrer" id="socialBlock_1">
                                <div class="flex flex-row justify-between items-center p-[10px] rounded-[4px]">
                                    <div
                                        class="space-x-[8px] xs:space-x-[12px] sm:space-x-[20px] flex flex-row items-center">
                                        <img src="https://qr-code.io/themes/altum/assets/images/socialicon/icon5.svg"
                                            class="w-[44px] rtl:ml-2" alt="X (Twitter)">
                                        <div class="flex flex-col justify-center text-left">
                                            <p class="text-sm xs:text-base sm:text-xl text-[#131D29] font-medium break-words rtl:text-base rtl:leading-4 rtl:text-right not-lang"
                                                style="font-family: &quot;GT Walsheim Pro&quot;;">X (Twitter)</p>
                                            <p class="text-[10px] xs:text-xs text-[#767C83] rtl:text-right word-break-fix not-lang"
                                                style="font-family: &quot;GT Walsheim Pro&quot;;"></p>
                                        </div>
                                    </div><span style="width: 24px; margin-left: 8px;"><svg class="rtl:rotate-180"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4 11.7256C4 11.3459 4.28215 11.0321 4.64823 10.9824L4.75 10.9756H19.75C20.1642 10.9756 20.5 11.3114 20.5 11.7256C20.5 12.1053 20.2178 12.4191 19.8518 12.4687L19.75 12.4756L4.75 12.4756C4.33579 12.4756 4 12.1398 4 11.7256Z"
                                                fill="#767C83"></path>
                                            <path
                                                d="M13.171 6.23271C12.8775 5.94045 12.8765 5.46558 13.1687 5.17206C13.4344 4.90522 13.851 4.88012 14.1451 5.09734L14.2294 5.16977L20.2794 11.1938C20.547 11.4603 20.5714 11.8784 20.3524 12.1724L20.2794 12.2567L14.2294 18.2817C13.9359 18.574 13.4611 18.573 13.1688 18.2795C12.9031 18.0127 12.8797 17.5959 13.0982 17.3028L13.171 17.2188L18.687 11.7249L13.171 6.23271Z"
                                                fill="#767C83"></path>
                                        </svg></span>
                                </div>
                            </a>
                            @endif @if ($qr->content->instagram)
                                <a href="{{ $qr->content->instagram }}" target="_blank"
                                    class="my-[5px] flex flex-col w-full cursor-pointer shadow-[1px_6px_30px_rgba(0,31,14,0.05)] hover:opacity-90 break-all"
                                    rel="noreferrer" id="socialBlock_2">
                                    <div class="flex flex-row justify-between items-center p-[10px] rounded-[4px]">
                                        <div
                                            class="space-x-[8px] xs:space-x-[12px] sm:space-x-[20px] flex flex-row items-center">
                                            <img src="https://qr-code.io/themes/altum/assets/images/socialicon/icon24.svg"
                                                class="w-[44px] rtl:ml-2" alt="Instagram">
                                            <div class="flex flex-col justify-center text-left">
                                                <p class="text-sm xs:text-base sm:text-xl text-[#131D29] font-medium break-words rtl:text-base rtl:leading-4 rtl:text-right not-lang"
                                                    style="font-family: &quot;GT Walsheim Pro&quot;;">Instagram</p>
                                                <p class="text-[10px] xs:text-xs text-[#767C83] rtl:text-right word-break-fix not-lang"
                                                    style="font-family: &quot;GT Walsheim Pro&quot;;"></p>
                                            </div>
                                        </div><span style="width: 24px; margin-left: 8px;"><svg class="rtl:rotate-180"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4 11.7256C4 11.3459 4.28215 11.0321 4.64823 10.9824L4.75 10.9756H19.75C20.1642 10.9756 20.5 11.3114 20.5 11.7256C20.5 12.1053 20.2178 12.4191 19.8518 12.4687L19.75 12.4756L4.75 12.4756C4.33579 12.4756 4 12.1398 4 11.7256Z"
                                                    fill="#767C83"></path>
                                                <path
                                                    d="M13.171 6.23271C12.8775 5.94045 12.8765 5.46558 13.1687 5.17206C13.4344 4.90522 13.851 4.88012 14.1451 5.09734L14.2294 5.16977L20.2794 11.1938C20.547 11.4603 20.5714 11.8784 20.3524 12.1724L20.2794 12.2567L14.2294 18.2817C13.9359 18.574 13.4611 18.573 13.1688 18.2795C12.9031 18.0127 12.8797 17.5959 13.0982 17.3028L13.171 17.2188L18.687 11.7249L13.171 6.23271Z"
                                                    fill="#767C83"></path>
                                            </svg></span>
                                    </div>
                                </a>
                                @endif @if ($qr->content->linkedin)
                                    <a href="{{ $qr->content->linkedin }}" target="_blank"
                                        class="my-[5px] flex flex-col w-full cursor-pointer shadow-[1px_6px_30px_rgba(0,31,14,0.05)] hover:opacity-90 break-all"
                                        rel="noreferrer" id="socialBlock_3">
                                        <div class="flex flex-row justify-between items-center p-[10px] rounded-[4px]">
                                            <div
                                                class="space-x-[8px] xs:space-x-[12px] sm:space-x-[20px] flex flex-row items-center">
                                                <img src="https://qr-code.io/themes/altum/assets/images/socialicon/icon7.svg"
                                                    class="w-[44px] rtl:ml-2" alt="LinkedIn">
                                                <div class="flex flex-col justify-center text-left">
                                                    <p class="text-sm xs:text-base sm:text-xl text-[#131D29] font-medium break-words rtl:text-base rtl:leading-4 rtl:text-right not-lang"
                                                        style="font-family: &quot;GT Walsheim Pro&quot;;">LinkedIn</p>
                                                    <p class="text-[10px] xs:text-xs text-[#767C83] rtl:text-right word-break-fix not-lang"
                                                        style="font-family: &quot;GT Walsheim Pro&quot;;"></p>
                                                </div>
                                            </div><span style="width: 24px; margin-left: 8px;"><svg
                                                    class="rtl:rotate-180" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4 11.7256C4 11.3459 4.28215 11.0321 4.64823 10.9824L4.75 10.9756H19.75C20.1642 10.9756 20.5 11.3114 20.5 11.7256C20.5 12.1053 20.2178 12.4191 19.8518 12.4687L19.75 12.4756L4.75 12.4756C4.33579 12.4756 4 12.1398 4 11.7256Z"
                                                        fill="#767C83"></path>
                                                    <path
                                                        d="M13.171 6.23271C12.8775 5.94045 12.8765 5.46558 13.1687 5.17206C13.4344 4.90522 13.851 4.88012 14.1451 5.09734L14.2294 5.16977L20.2794 11.1938C20.547 11.4603 20.5714 11.8784 20.3524 12.1724L20.2794 12.2567L14.2294 18.2817C13.9359 18.574 13.4611 18.573 13.1688 18.2795C12.9031 18.0127 12.8797 17.5959 13.0982 17.3028L13.171 17.2188L18.687 11.7249L13.171 6.23271Z"
                                                        fill="#767C83"></path>
                                                </svg></span>
                                        </div>
                                    </a>
                                @endif
                    </div>
                    <div id="socialBlock"></div>
                </div>
                <a href="{{ route('qr.vcard', $qr) }}"
                    class="w-full flex flex-row justify-center items-center space-x-[10px] rounded-[4px] mt-[20px] py-[14px] cursor-pointer hover:opacity-80 duration-500"
                    id="vcardContact" style="background-color: #f78731"><svg width="20" height="20"
                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="rtl:ml-2">
                        <mask id="mask0_797_11851" maskUnits="userSpaceOnUse" x="3" y="12" width="14"
                            height="7">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.33301 12.0801H16.5329V18.2251H3.33301V12.0801Z" fill="white"></path>
                        </mask>
                        <g mask="url(#mask0_797_11851)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.93384 13.3301C6.38301 13.3301 4.58301 13.9401 4.58301 15.1442C4.58301 16.3592 6.38301 16.9751 9.93384 16.9751C13.4838 16.9751 15.283 16.3651 15.283 15.1609C15.283 13.9459 13.4838 13.3301 9.93384 13.3301ZM9.93384 18.2251C8.30134 18.2251 3.33301 18.2251 3.33301 15.1442C3.33301 12.3976 7.10051 12.0801 9.93384 12.0801C11.5663 12.0801 16.533 12.0801 16.533 15.1609C16.533 17.9076 12.7663 18.2251 9.93384 18.2251Z"
                                fill="black"></path>
                        </g>
                        <mask id="mask1_797_11851" maskUnits="userSpaceOnUse" x="5" y="1" width="10"
                            height="10">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.50781 1.66675H14.3578V10.5156H5.50781V1.66675Z" fill="white"></path>
                        </mask>
                        <g mask="url(#mask1_797_11851)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.93367 2.8565C8.14951 2.8565 6.69784 4.30734 6.69784 6.0915C6.69201 7.86984 8.13284 9.31984 9.90951 9.3265L9.93367 9.9215V9.3265C11.717 9.3265 13.1678 7.87484 13.1678 6.0915C13.1678 4.30734 11.717 2.8565 9.93367 2.8565ZM9.93367 10.5157H9.90701C7.47201 10.5082 5.49951 8.52234 5.50784 6.089C5.50784 3.6515 7.49284 1.6665 9.93367 1.6665C12.3737 1.6665 14.3578 3.6515 14.3578 6.0915C14.3578 8.5315 12.3737 10.5157 9.93367 10.5157Z"
                                fill="black"></path>
                        </g>
                    </svg>
                    <p class="text-lg not-lang"
                        style="font-family: &quot;GT Walsheim Pro&quot;; color: rgb(0, 0, 0);">Add Contact</p>
                </a>
            </div>
        </div>
    </div>
</div>

</html>
