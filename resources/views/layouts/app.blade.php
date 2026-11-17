<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Amar Bazar | আমার বাজার - ১০০% খাঁটি ও নিরাপদ খাদ্য')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 800: '#1a3a28', 900: '#0e2a1c' },
                        orange: { 500: '#F48721', 600: '#e07518' }
                    },
                    fontFamily: {
                        sans: ['"Hind Siliguri"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Hind Siliguri', Inter, sans-serif; background: #f8f8f8; }

        /* ===== Mobile Nav Drawer ===== */
        #mobileNavDrawer {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #mobileNavDrawer.open { transform: translateX(0); }
        #mobileNavBackdrop {
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #mobileNavBackdrop.open { opacity: 1; pointer-events: auto; }

        /* ===== Desktop Hover Dropdown ===== */
        .cat-dropdown:hover .cat-dropdown-menu { display: block; }
        .cat-dropdown-menu { display: none; }

        /* ===== "More" dropdown in header ===== */
        #moreDropdown { display: none; }
        #moreDropdown.open { display: block; }

        /* GB-style header icon buttons */
        .gb-header-icon { display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer; color: #374151; transition: color 0.2s; }
        .gb-header-icon:hover { color: #F48721; }
        .gb-header-icon i { font-size: 18px; }
        .gb-header-icon span { font-size: 10px; font-weight: 500; white-space: nowrap; }

        /* Cart drawer GB style */
        #cartDrawer { transform: translateX(100%); transition: transform 0.3s ease; }
        #cartDrawer.open { transform: translateX(0); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #F48721; border-radius: 3px; }

        /* Flash alert animation */
        @keyframes slideDown { from { opacity:0; transform: translateY(-10px); } to { opacity:1; transform: translateY(0); } }
        .flash-alert { animation: slideDown 0.3s ease; }
    </style>
    @yield('styles')
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen">
    @php
        $globalCart = session('cart', []);
        $globalCartSubtotal = 0;
        $globalCartCount = 0;
        foreach($globalCart as $cItem) {
            $globalCartSubtotal += $cItem['price'] * $cItem['quantity'];
            $globalCartCount += $cItem['quantity'];
        }
    @endphp

    <!-- ============ FLOATING CART WIDGET (right edge, storefront only) ============ -->
    @if(!request()->is('admin*'))
    <div id="floatingSideCart" onclick="toggleCartDrawer()"
         class="fixed right-0 top-1/2 -translate-y-1/2 z-40 cursor-pointer shadow-xl rounded-l-xl overflow-hidden border-y border-l border-orange-400 hover:-translate-x-0.5 transition-all duration-200 flex flex-col items-center">
        <div class="bg-[#F48721] text-white px-3 py-2.5 text-center flex flex-col items-center w-[68px]">
            <i class="fa-solid fa-bag-shopping text-lg mb-0.5"></i>
            <div class="text-[11px] font-bold leading-none">
                <span id="floatingCartCount">{{ $globalCartCount }}</span> Items
            </div>
        </div>
        <div class="bg-white text-[#F48721] font-black text-[11px] px-2 py-1 text-center w-full border-t border-orange-100">
            ৳<span id="floatingCartTotal">{{ number_format($globalCartSubtotal) }}</span>
        </div>
    </div>
    @endif

    <!-- ============ TOP ANNOUNCEMENT BAR ============ -->
    <div class="bg-[#1a3a28] text-emerald-100 text-xs py-1.5 px-4 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-leaf text-[#F48721]"></i>
                ১০০% প্রাকৃতিক ও স্বাস্থ্যকর খাবার — সারা বাংলাদেশে দ্রুত হোম ডেলিভারি
            </span>
            <div class="flex items-center gap-4 font-medium">
                <a href="tel:+8801938860291" class="hover:text-white flex items-center gap-1 transition">
                    <i class="fa-solid fa-phone text-[#F48721] text-[11px]"></i> +880 1938-860291
                </a>
                <span class="text-emerald-600">|</span>
                <a href="https://wa.me/8801938860291" target="_blank" class="hover:text-white flex items-center gap-1 transition text-green-300">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <!-- Language Switcher Pill (Top Bar) -->
                <div class="lang-toggle-container dark-theme inline-flex items-center bg-[#0e2a1c] p-0.5 rounded-full border border-emerald-700/60 shadow-xs">
                    <button type="button" onclick="switchLanguage('bn')" class="btn-lang-bn px-2 py-0.5 rounded-full text-[11px] font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs" title="বাংলা">
                        <span>🇧🇩 বাংলা</span>
                    </button>
                    <button type="button" onclick="switchLanguage('en')" class="btn-lang-en px-2 py-0.5 rounded-full text-[11px] font-semibold transition flex items-center gap-1 text-slate-300 hover:text-white" title="English">
                        <span>🇬🇧 EN</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- ============ MAIN HEADER (Ghorer Bazar style) ============ -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 py-3">
            <div class="flex items-center gap-3">

                <!-- Mobile: Hamburger -->
                <button onclick="openMobileNavDrawer()"
                        class="md:hidden flex items-center justify-center w-9 h-9 rounded text-gray-600 hover:text-[#F48721] transition flex-shrink-0">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- LOGO (GB orange square style) -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-[#F48721] flex items-center justify-center">
                        <i class="fa-solid fa-leaf text-white text-xl"></i>
                    </div>
                    <div class="leading-none">
                        <div class="text-base sm:text-lg font-black text-gray-900 tracking-tight leading-tight">আমার</div>
                        <div class="text-base sm:text-lg font-black text-gray-900 tracking-tight leading-tight">বাজার</div>
                    </div>
                </a>

                <!-- SEARCH BAR (center, GB style rounded) -->
                <div class="flex-1 mx-2 sm:mx-6">
                    <form action="{{ route('search') }}" method="GET" class="relative flex">
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Search in..."
                               class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:border-[#F48721] transition">
                        <button type="submit"
                                class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 bg-transparent text-gray-500 hover:text-[#F48721] flex items-center justify-center transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <!-- RIGHT ICONS (Track Order, Sign In, Wishlist, Cart, More) -->
                <div class="hidden md:flex items-center gap-4">

                    <!-- Track Order -->
                    <a href="{{ route('track.order') }}" class="gb-header-icon">
                        <i class="fa-solid fa-route"></i>
                        <span>Track Order</span>
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ route('home') }}" class="gb-header-icon">
                        <i class="fa-regular fa-heart"></i>
                        <span>Wishlist</span>
                    </a>

                    <!-- Cart -->
                    <button onclick="toggleCartDrawer()" class="gb-header-icon relative">
                        <div class="relative">
                            <i class="fa-solid fa-cart-shopping text-[#F48721]"></i>
                            <span id="headerCartCount"
                                  class="absolute -top-2 -right-2 bg-[#F48721] text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center">{{ $globalCartCount }}</span>
                        </div>
                        <span>Cart</span>
                    </button>

                    <!-- More dropdown -->
                    <div class="relative">
                        <button onclick="toggleMoreMenu()" class="gb-header-icon">
                            <i class="fa-solid fa-bars-staggered"></i>
                            <span>More</span>
                        </button>
                        <div id="moreDropdown" class="absolute right-0 top-full mt-1 w-44 bg-white border border-gray-200 rounded-lg shadow-xl z-50 py-1">
                            <a href="#" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                                <i class="fa-regular fa-heart w-4"></i> Wishlists
                            </a>
                            <a href="#" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                                <i class="fa-regular fa-circle-question w-4"></i> Faqs
                            </a>
                            <a href="#" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                                <i class="fa-solid fa-store w-4"></i> About Us
                            </a>
                            <a href="tel:+8801938860291" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                                <i class="fa-solid fa-phone w-4"></i> Call Us
                            </a>
                            <a href="https://wa.me/8801938860291" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                                <i class="fa-brands fa-whatsapp w-4 text-green-500"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Language Pill -->
                <div class="md:hidden lang-toggle-container inline-flex items-center bg-gray-100 p-0.5 rounded-full border border-gray-200 shadow-xs">
                    <button type="button" onclick="switchLanguage('bn')" class="btn-lang-bn px-2 py-0.5 rounded-full text-[10px] font-black transition flex items-center gap-0.5 bg-[#F48721] text-white shadow-xs" title="বাংলা">
                        <span>🇧🇩 বাংলা</span>
                    </button>
                    <button type="button" onclick="switchLanguage('en')" class="btn-lang-en px-2 py-0.5 rounded-full text-[10px] font-semibold transition flex items-center gap-0.5 text-gray-500 hover:text-gray-900" title="English">
                        <span>🇬🇧 EN</span>
                    </button>
                </div>

                <!-- Mobile Cart only -->
                <button onclick="toggleCartDrawer()" class="md:hidden relative flex-shrink-0">
                    <i class="fa-solid fa-cart-shopping text-[#F48721] text-xl"></i>
                    <span id="mobileCartBadge"
                          class="absolute -top-1.5 -right-1.5 bg-[#F48721] text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center">{{ $globalCartCount }}</span>
                </button>

            </div>
        </div>

        <!-- DESKTOP CATEGORY NAV (dark green, GB style with hover dropdowns) -->
        <nav class="bg-[#1a3a28] text-white text-sm hidden md:block relative z-30">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center">

                    <!-- Offer Zone -->
                    <a href="{{ route('home') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 text-[#F48721]">
                        Offer Zone
                    </a>

                    <!-- তেল ও ঘি -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'oil-and-ghee') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 {{ request()->is('category/oil-and-ghee*') ? 'text-[#F48721]' : '' }}">
                            Oil & Ghee <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[190px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'oil-and-ghee') }}?sub=mustard" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">সরিষার তেল</a>
                            <a href="{{ route('category.show', 'oil-and-ghee') }}?sub=ghee" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">খাঁটি গাওয়া ঘি</a>
                            <a href="{{ route('category.show', 'oil-and-ghee') }}?sub=coconut" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">নারিকেল তেল</a>
                            <a href="{{ route('category.show', 'oil-and-ghee') }}?sub=sesame" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">তিলের তেল</a>
                        </div>
                    </div>

                    <!-- মধু -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'pure-honey') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 {{ request()->is('category/pure-honey*') ? 'text-[#F48721]' : '' }}">
                            Honey <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[200px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'pure-honey') }}?sub=sundarban" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">সুন্দরবনের মধু</a>
                            <a href="{{ route('category.show', 'pure-honey') }}?sub=black-seed" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">কালোজিরা মধু</a>
                            <a href="{{ route('category.show', 'pure-honey') }}?sub=lychee" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">লিচু ফুলের মধু</a>
                            <a href="{{ route('category.show', 'pure-honey') }}?sub=sidr" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">সিদর মধু</a>
                            <a href="{{ route('category.show', 'pure-honey') }}?sub=honeycomb" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">চাকের মধু</a>
                        </div>
                    </div>

                    <!-- খেজুর -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'premium-dates') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 {{ request()->is('category/premium-dates*') ? 'text-[#F48721]' : '' }}">
                            Dates <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[180px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'premium-dates') }}?sub=ajwa" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">আজওয়া খেজুর</a>
                            <a href="{{ route('category.show', 'premium-dates') }}?sub=medjool" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">মেডজুল খেজুর</a>
                            <a href="{{ route('category.show', 'premium-dates') }}?sub=mabroom" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">মাব্রুম খেজুর</a>
                        </div>
                    </div>

                    <!-- মশলা -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'pure-spices') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 {{ request()->is('category/pure-spices*') ? 'text-[#F48721]' : '' }}">
                            Spices <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[170px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'pure-spices') }}?sub=turmeric" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">হলুদ গুঁড়া</a>
                            <a href="{{ route('category.show', 'pure-spices') }}?sub=chili" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">মরিচ গুঁড়া</a>
                            <a href="{{ route('category.show', 'pure-spices') }}?sub=coriander" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">ধনিয়া গুঁড়া</a>
                        </div>
                    </div>

                    <!-- বাদাম -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'nuts-and-seeds') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1 {{ request()->is('category/nuts-and-seeds*') ? 'text-[#F48721]' : '' }}">
                            Nuts & Seeds <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[180px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'nuts-and-seeds') }}?sub=cashew" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">কাজু বাদাম</a>
                            <a href="{{ route('category.show', 'nuts-and-seeds') }}?sub=almond" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">কাঠ বাদাম</a>
                            <a href="{{ route('category.show', 'nuts-and-seeds') }}?sub=pistachio" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">পেস্তা বাদাম</a>
                        </div>
                    </div>

                    <!-- Rice (no dropdown) -->
                    <a href="{{ route('home') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap">
                        Rice
                    </a>

                    <!-- Flours & Lentils -->
                    <div class="cat-dropdown relative">
                        <a href="{{ route('category.show', 'organic-foods') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap flex items-center gap-1">
                            Flours & Lentils <i class="fa-solid fa-chevron-down text-[9px] opacity-60 ml-0.5"></i>
                        </a>
                        <div class="cat-dropdown-menu absolute top-full left-0 min-w-[180px] bg-white text-gray-700 shadow-xl z-50 py-1 border-t-2 border-[#F48721] rounded-b-lg">
                            <a href="{{ route('category.show', 'organic-foods') }}" class="block px-4 py-2 text-[13px] hover:bg-orange-50 hover:text-[#F48721] transition">অর্গানিক ফুড</a>
                        </div>
                    </div>

                    <!-- Certified, Pickle -->
                    <a href="{{ route('home') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap">Certified</a>
                    <a href="{{ route('home') }}" class="px-3 py-2.5 font-medium hover:bg-[#0e2a1c] transition whitespace-nowrap">Pickle</a>

                </div>
            </div>
        </nav>
    </header>

    <!-- ============ FLASH MESSAGES ============ -->
    @if(session('success') || session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-3 w-full">
        @if(session('success'))
        <div class="flash-alert bg-green-50 border-l-4 border-green-500 p-3 rounded text-green-800 text-sm flex items-center justify-between mb-2">
            <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}</div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold">×</button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash-alert bg-red-50 border-l-4 border-red-500 p-3 rounded text-red-800 text-sm flex items-center justify-between mb-2">
            <div class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation text-red-500"></i> {{ session('error') }}</div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold">×</button>
        </div>
        @endif
    </div>
    @endif

    <!-- ============ MAIN CONTENT ============ -->
    <main class="flex-grow">@yield('content')</main>

    <!-- ============ FOOTER (Ghorer Bazar style 5-column) ============ -->
    <footer class="bg-white border-t border-gray-200 mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8">

                <!-- Col 1: Brand -->
                <div class="sm:col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-[#F48721] flex items-center justify-center">
                            <i class="fa-solid fa-leaf text-white text-lg"></i>
                        </div>
                        <div class="leading-none">
                            <div class="font-black text-gray-900 text-sm">আমার</div>
                            <div class="font-black text-gray-900 text-sm">বাজার</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed mb-3">
                        Amar Bazar is an e-commerce platform dedicated to providing safe and reliable food to every home.
                    </p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-[#F48721] w-4"></i> রামপুরা, ঢাকা, বাংলাদেশ</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-phone text-[#F48721] w-4"></i> <a href="tel:+8801938860291" class="hover:text-[#F48721]">+880 1938-860291</a></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-envelope text-[#F48721] w-4"></i> amdarbazar@gmail.com</div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <a href="#" class="w-7 h-7 bg-gray-100 hover:bg-[#F48721] hover:text-white text-gray-500 rounded-full flex items-center justify-center transition text-xs"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-7 h-7 bg-gray-100 hover:bg-[#F48721] hover:text-white text-gray-500 rounded-full flex items-center justify-center transition text-xs"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/8801938860291" class="w-7 h-7 bg-gray-100 hover:bg-green-500 hover:text-white text-gray-500 rounded-full flex items-center justify-center transition text-xs"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Col 2: Information -->
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Information</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li><a href="#" class="hover:text-[#F48721] transition">About us</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Contact us</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Company Information</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Col 3: Shop By -->
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Shop By</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li><a href="{{ route('category.show', 'oil-and-ghee') }}" class="hover:text-[#F48721] transition">Oil & Ghee</a></li>
                        <li><a href="{{ route('category.show', 'pure-honey') }}" class="hover:text-[#F48721] transition">Honey</a></li>
                        <li><a href="{{ route('category.show', 'premium-dates') }}" class="hover:text-[#F48721] transition">Dates</a></li>
                        <li><a href="{{ route('category.show', 'pure-spices') }}" class="hover:text-[#F48721] transition">Spices</a></li>
                        <li><a href="{{ route('category.show', 'nuts-and-seeds') }}" class="hover:text-[#F48721] transition">Nuts & Seeds</a></li>
                        <li><a href="{{ route('category.show', 'organic-foods') }}" class="hover:text-[#F48721] transition">Organic Foods</a></li>
                    </ul>
                </div>

                <!-- Col 4: Support -->
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Support</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li><a href="#" class="hover:text-[#F48721] transition">Support Center</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">How to Order</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Order Tracking</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Payment</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Shipping</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">FAQ</a></li>
                    </ul>
                </div>

                <!-- Col 5: Consumer Policy -->
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Consumer Policy</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li><a href="#" class="hover:text-[#F48721] transition">Happy Return</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Refund Policy</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Exchange</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Cancellation</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Pre-Order</a></li>
                        <li><a href="#" class="hover:text-[#F48721] transition">Extra Discount</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom: Payment + Copyright -->
        <div class="border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-gray-400">Copyright © {{ date('Y') }} <strong class="text-gray-600">Amar Bazar</strong></div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>Pay With</span>
                    <span class="bg-green-50 border border-green-200 text-green-700 px-2 py-0.5 rounded font-bold text-[10px]">ক্যাশ অন ডেলিভারি</span>
                    <span class="bg-pink-50 border border-pink-200 text-pink-700 px-2 py-0.5 rounded font-bold text-[10px]">বিকাশ</span>
                    <span class="bg-orange-50 border border-orange-200 text-orange-700 px-2 py-0.5 rounded font-bold text-[10px]">নগদ</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============ MOBILE SLIDE-IN CATEGORY DRAWER ============ -->
    <div id="mobileNavBackdrop" onclick="closeMobileNavDrawer()"
         class="fixed inset-0 bg-black/50 z-[60]"></div>
    <div id="mobileNavDrawer"
         class="fixed top-0 left-0 h-full w-[82vw] max-w-[300px] bg-white z-[70] flex flex-col shadow-2xl overflow-y-auto">

        <!-- Drawer Header -->
        <div class="bg-[#1a3a28] text-white px-4 py-3.5 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-lg bg-[#F48721] flex items-center justify-center">
                    <i class="fa-solid fa-leaf text-white"></i>
                </div>
                <div class="font-black text-sm leading-tight">
                    <div>আমার বাজার</div>
                    <div class="text-[10px] text-orange-300 font-normal">PURE FOOD</div>
                </div>
            </div>
            <button onclick="closeMobileNavDrawer()"
                    class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Mobile Drawer Language Switcher -->
        <div class="p-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xs font-semibold text-gray-600">ভাষা / Language:</span>
            <div class="lang-toggle-container inline-flex items-center bg-white p-0.5 rounded-full border border-gray-300 shadow-xs">
                <button type="button" onclick="switchLanguage('bn')" class="btn-lang-bn px-2.5 py-1 rounded-full text-xs font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs" title="বাংলা">
                    <span>🇧🇩 বাংলা</span>
                </button>
                <button type="button" onclick="switchLanguage('en')" class="btn-lang-en px-2.5 py-1 rounded-full text-xs font-semibold transition flex items-center gap-1 text-gray-500 hover:text-gray-900" title="English">
                    <span>🇬🇧 EN</span>
                </button>
            </div>
        </div>

        <!-- Categories -->
        <div class="px-3 pt-3 pb-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ক্যাটাগরি</span>
        </div>
        <ul class="divide-y divide-gray-100">
            <li><a href="{{ route('home') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-[#F48721] hover:bg-orange-50 transition">
                <span>Offer Zone</span>
            </a></li>
            <li><a href="{{ route('category.show', 'oil-and-ghee') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Oil & Ghee</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('category.show', 'pure-honey') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Honey</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('category.show', 'premium-dates') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Dates</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('category.show', 'pure-spices') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Spices</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('category.show', 'nuts-and-seeds') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Nuts & Seeds</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('home') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Rice</span>
            </a></li>
            <li><a href="{{ route('category.show', 'organic-foods') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Flours & Lentils</span><i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
            </a></li>
            <li><a href="{{ route('home') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Certified</span>
            </a></li>
            <li><a href="{{ route('home') }}" onclick="closeMobileNavDrawer()" class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-[#F48721] transition">
                <span>Pickle</span>
            </a></li>
        </ul>

        <!-- Quick Links -->
        <div class="px-3 pt-4 pb-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Quick Links</span>
        </div>
        <ul class="divide-y divide-gray-100 mb-6">
            <li><a href="#" onclick="closeMobileNavDrawer()" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-[#F48721] transition">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center"><i class="fa-regular fa-heart text-sm"></i></div> Wishlists
            </a></li>
            <li><a href="#" onclick="closeMobileNavDrawer()" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-[#F48721] transition">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center"><i class="fa-regular fa-circle-question text-sm"></i></div> Faqs
            </a></li>
            <li><a href="#" onclick="closeMobileNavDrawer()" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-[#F48721] transition">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center"><i class="fa-solid fa-store text-sm"></i></div> About Us
            </a></li>
            <li><a href="{{ route('track.order') }}" onclick="closeMobileNavDrawer()" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-orange-50 hover:text-[#F48721] transition">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center"><i class="fa-solid fa-route text-sm"></i></div> Track Order
            </a></li>

        </ul>
    </div>

    <!-- ============ CART DRAWER (Ghorer Bazar style) ============ -->
    <div id="cartDrawerBackdrop" onclick="toggleCartDrawer()"
         class="fixed inset-0 bg-black/40 z-50 transition-opacity hidden"></div>
    <div id="cartDrawer"
         class="fixed top-0 right-0 h-full w-full max-w-[380px] bg-white shadow-2xl z-50 flex flex-col">

        <!-- Cart Header -->
        <div class="flex items-center justify-between px-4 py-3.5 border-b border-gray-200 bg-white">
            <h3 class="font-black text-sm text-gray-900 uppercase tracking-wider">🛒 শপিং কার্ট</h3>
            <button onclick="toggleCartDrawer()" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 font-semibold transition">
                Close <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div id="drawerCartItems" class="flex-1 overflow-y-auto divide-y divide-gray-100">
            @php $cart = session('cart', []); @endphp
            @if(empty($cart))
                <div id="emptyCartNotice" class="flex flex-col items-center justify-center h-full text-gray-400 py-16">
                    <i class="fa-solid fa-cart-shopping text-5xl mb-4 text-gray-200"></i>
                    <p class="text-sm font-medium mb-4">আপনার কার্ট খালি আছে</p>
                    <a href="{{ route('home') }}" onclick="toggleCartDrawer()"
                       class="bg-[#F48721] hover:bg-[#e07518] text-white px-5 py-2 rounded text-sm font-bold transition">
                        কেনাকাটা শুরু করুন
                    </a>
                </div>
            @else
                @php $drawerSubtotal = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $drawerSubtotal += $item['price'] * $item['quantity']; @endphp
                    <div class="flex items-center gap-3 p-3" id="cart-item-{{ $id }}">
                        <div class="w-16 h-16 rounded border border-gray-100 bg-gray-50 flex-shrink-0 overflow-hidden">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain p-1">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-semibold text-gray-800 leading-snug mb-1 truncate">{{ $item['name'] }}..</div>
                            <div class="flex items-center gap-1 text-xs text-gray-500 mb-1">
                                <button onclick="cartQtyChange({{ $id }}, -1)" class="w-5 h-5 border border-gray-300 rounded text-gray-600 hover:border-[#F48721] hover:text-[#F48721] transition text-xs font-bold flex items-center justify-center">-</button>
                                <span class="cart-qty-{{ $id }} w-6 text-center font-bold text-gray-800">{{ $item['quantity'] }}</span>
                                <button onclick="cartQtyChange({{ $id }}, 1)" class="w-5 h-5 border border-gray-300 rounded text-gray-600 hover:border-[#F48721] hover:text-[#F48721] transition text-xs font-bold flex items-center justify-center">+</button>
                                <span class="ml-1">× ৳{{ number_format($item['price']) }}.00 = <strong class="text-[#F48721]">৳{{ number_format($item['price'] * $item['quantity']) }}.00</strong></span>
                            </div>
                        </div>
                        <button onclick="removeFromCartAjax({{ $id }})" class="text-gray-300 hover:text-red-500 transition p-1 flex-shrink-0">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Cart Footer -->
        @if(!empty($cart))
        <div id="drawerFooter" class="border-t border-gray-200 p-4 space-y-3 bg-white">
            <div class="flex justify-between items-center font-bold text-sm">
                <span class="text-gray-700">Total:</span>
                <span id="drawerSubtotalText" class="text-[#F48721] text-lg">৳{{ number_format(isset($drawerSubtotal) ? $drawerSubtotal : 0) }}.00</span>
            </div>
            <a href="{{ route('checkout') }}"
               class="block w-full bg-[#F48721] hover:bg-[#e07518] text-white font-bold py-3 rounded text-center text-sm uppercase tracking-wide transition shadow-md">
                CHECKOUT
            </a>
            <a href="{{ route('cart') }}"
               class="block w-full border border-gray-300 text-gray-600 hover:border-[#F48721] hover:text-[#F48721] font-semibold py-2.5 rounded text-center text-sm transition">
                কার্ট পেজ দেখুন
            </a>
        </div>
        @else
        <div id="drawerFooter" class="hidden border-t border-gray-200 p-4 space-y-3">
            <div class="flex justify-between font-bold text-sm">
                <span>Total:</span>
                <span id="drawerSubtotalText" class="text-[#F48721] text-lg">৳0.00</span>
            </div>
            <a href="{{ route('checkout') }}" class="block w-full bg-[#F48721] hover:bg-[#e07518] text-white font-bold py-3 rounded text-center text-sm uppercase transition">CHECKOUT</a>
        </div>
        @endif
    </div>

    <!-- ============ TOAST NOTIFICATION ============ -->
    <div id="toastNotification"
         class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 bg-gray-900 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-green-500">
        <i class="fa-solid fa-circle-check text-green-400 text-xl"></i>
        <div>
            <div class="text-xs text-green-300 font-semibold" id="toastTitle">সফল হয়েছে</div>
            <div class="text-sm font-medium" id="toastMessage">প্রোডাক্ট কার্টে যুক্ত হয়েছে</div>
        </div>
    </div>

    <!-- ============ SCRIPTS ============ -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ===== Cart Drawer =====
        function toggleCartDrawer() {
            const drawer = document.getElementById('cartDrawer');
            const backdrop = document.getElementById('cartDrawerBackdrop');
            if (drawer.classList.contains('open')) {
                drawer.classList.remove('open');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                drawer.classList.add('open');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
        function openCartDrawer() {
            document.getElementById('cartDrawer').classList.add('open');
            document.getElementById('cartDrawerBackdrop').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeCartDrawer() {
            document.getElementById('cartDrawer').classList.remove('open');
            document.getElementById('cartDrawerBackdrop').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // ===== Mobile Nav Drawer =====
        function openMobileNavDrawer() {
            document.getElementById('mobileNavDrawer').classList.add('open');
            document.getElementById('mobileNavBackdrop').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileNavDrawer() {
            document.getElementById('mobileNavDrawer').classList.remove('open');
            document.getElementById('mobileNavBackdrop').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ===== More Dropdown =====
        function toggleMoreMenu() {
            const dd = document.getElementById('moreDropdown');
            dd.classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            const dd = document.getElementById('moreDropdown');
            if (dd && !e.target.closest('.relative')) dd.classList.remove('open');
        });

        // ===== Toast =====
        function showToast(message, title = 'সফল হয়েছে') {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastTitle').innerText = title;
            document.getElementById('toastMessage').innerText = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }

        // ===== Render Cart Drawer =====
        function renderDrawerCart(cart, subtotal) {
            const container = document.getElementById('drawerCartItems');
            const footer = document.getElementById('drawerFooter');
            const subtotalText = document.getElementById('drawerSubtotalText');
            const itemKeys = Object.keys(cart);

            const fCount = document.getElementById('floatingCartCount');
            const fTotal = document.getElementById('floatingCartTotal');
            const hCount = document.getElementById('headerCartCount');
            const mBadge = document.getElementById('mobileCartBadge');

            const totalQty = itemKeys.reduce((s, k) => s + (cart[k].quantity || 1), 0);
            if (fCount) fCount.innerText = totalQty;
            if (fTotal) fTotal.innerText = Number(subtotal).toLocaleString();
            if (hCount) hCount.innerText = totalQty;
            if (mBadge) mBadge.innerText = totalQty;

            if (itemKeys.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 py-16">
                        <i class="fa-solid fa-cart-shopping text-5xl mb-4 text-gray-200"></i>
                        <p class="text-sm font-medium mb-4">আপনার কার্ট খালি আছে</p>
                        <a href="{{ route('home') }}" onclick="toggleCartDrawer()" class="bg-[#F48721] hover:bg-[#e07518] text-white px-5 py-2 rounded text-sm font-bold transition">কেনাকাটা শুরু করুন</a>
                    </div>`;
                if (footer) footer.classList.add('hidden');
            } else {
                let html = '';
                itemKeys.forEach(id => {
                    const item = cart[id];
                    const lineTotal = Number(item.price) * Number(item.quantity || 1);
                    html += `
                        <div class="flex items-center gap-3 p-3 border-b border-gray-100" id="cart-item-${id}">
                            <div class="w-16 h-16 rounded border border-gray-100 bg-gray-50 flex-shrink-0 overflow-hidden">
                                <img src="${item.image}" alt="${item.name}" class="w-full h-full object-contain p-1">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-gray-800 leading-snug mb-1 truncate">${item.name}..</div>
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <button onclick="cartQtyChange(${id}, -1)" class="w-5 h-5 border border-gray-300 rounded text-gray-600 hover:border-[#F48721] hover:text-[#F48721] transition font-bold flex items-center justify-center">-</button>
                                    <span class="cart-qty-${id} w-6 text-center font-bold text-gray-800">${item.quantity}</span>
                                    <button onclick="cartQtyChange(${id}, 1)" class="w-5 h-5 border border-gray-300 rounded text-gray-600 hover:border-[#F48721] hover:text-[#F48721] transition font-bold flex items-center justify-center">+</button>
                                    <span class="ml-1">× ৳${Number(item.price).toLocaleString()}.00 = <strong class="text-[#F48721]">৳${lineTotal.toLocaleString()}.00</strong></span>
                                </div>
                            </div>
                            <button onclick="removeFromCartAjax(${id})" class="text-gray-300 hover:text-red-500 transition p-1 flex-shrink-0">
                                <i class="fa-solid fa-xmark text-base"></i>
                            </button>
                        </div>`;
                });
                container.innerHTML = html;
                if (footer) footer.classList.remove('hidden');
                if (subtotalText) subtotalText.innerText = '৳' + Number(subtotal).toLocaleString() + '.00';
            }
        }

        // ===== AJAX Add to Cart =====
        function addToCartAjax(productId, quantity = 1) {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderDrawerCart(data.cart, data.subtotal);
                    openCartDrawer();
                    showToast(data.message || 'কার্টে যুক্ত হয়েছে!');
                }
            })
            .catch(err => console.error(err));
        }

        // ===== AJAX Remove from Cart =====
        function removeFromCartAjax(productId) {
            fetch(`/cart/remove/${productId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderDrawerCart(data.cart, data.subtotal);
                }
            });
        }

        // ===== Cart Quantity Change =====
        function cartQtyChange(productId, delta) {
            const qtyEl = document.querySelector('.cart-qty-' + productId);
            const currentQty = qtyEl ? parseInt(qtyEl.innerText) : 1;
            const newQty = Math.max(1, currentQty + delta);
            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: JSON.stringify({ product_id: productId, quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) renderDrawerCart(data.cart, data.subtotal);
            });
        }
    </script>
    <script src="/js/lang-switcher.js"></script>
    @yield('scripts')
</body>
</html>
