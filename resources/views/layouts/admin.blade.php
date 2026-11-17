<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'অ্যাডমিন প্যানেল - Amar Bazar | আমার বাজার')</title>
    
    <!-- Google Fonts: Hind Siliguri & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            700: '#15803d',
                            800: '#1a3a28',
                            900: '#0e2a1c',
                        },
                        gbOrange: {
                            500: '#F48721',
                            600: '#e07518',
                        }
                    },
                    fontFamily: {
                        sans: ['"Hind Siliguri"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Hind Siliguri', Inter, sans-serif;
            background-color: #f1f5f9;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
    @yield('styles')
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- ================= DEDICATED ADMIN TOP NAVIGATION ================= -->
    <header class="bg-primary-900 text-white sticky top-0 z-50 shadow-md border-b border-emerald-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                
                <!-- Left: Admin Brand -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-[#F48721] text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition transform">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <div class="text-lg font-black text-white tracking-tight leading-none">আমার বাজার</div>
                            <div class="text-[10px] text-amber-300 font-bold uppercase tracking-wider mt-0.5">Admin Control Panel</div>
                        </div>
                    </a>
                    <span class="hidden sm:inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-800/80 text-emerald-200 border border-emerald-700/60 ml-2">
                        <i class="fa-solid fa-shield-halved mr-1 text-amber-400"></i> অ্যাডমিন
                    </span>
                </div>

                <!-- Center: Navigation Tabs (Desktop) -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ request()->routeIs('admin.dashboard*') || request()->routeIs('admin.orders.show') || request()->routeIs('admin.orders.edit') ? 'bg-[#F48721] text-white shadow-sm' : 'text-slate-200 hover:bg-emerald-800/60 hover:text-white' }}">
                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                        <span>অর্ডারসমূহ</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ request()->routeIs('admin.products.*') ? 'bg-[#F48721] text-white shadow-sm' : 'text-slate-200 hover:bg-emerald-800/60 hover:text-white' }}">
                        <i class="fa-solid fa-boxes-stacked text-xs"></i>
                        <span>প্রোডাক্ট ও স্টক</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ request()->routeIs('admin.categories.*') ? 'bg-[#F48721] text-white shadow-sm' : 'text-slate-200 hover:bg-emerald-800/60 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group text-xs"></i>
                        <span>ক্যাটাগরি সমূহ</span>
                    </a>

                    <a href="{{ route('admin.customers.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ request()->routeIs('admin.customers.*') ? 'bg-[#F48721] text-white shadow-sm' : 'text-slate-200 hover:bg-emerald-800/60 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield text-xs"></i>
                        <span>কাস্টমার ও ফ্রড</span>
                    </a>

                    <a href="{{ route('admin.orders.create') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ request()->routeIs('admin.orders.create') ? 'bg-amber-400 text-slate-950 font-black' : 'text-amber-300 hover:bg-emerald-800/60' }}">
                        <i class="fa-solid fa-circle-plus text-xs"></i>
                        <span>নতুন অর্ডার</span>
                    </a>
                </nav>

                <!-- Right: Website Link & Logout -->
                <div class="flex items-center gap-2 sm:gap-3">
                    
                    <!-- Language Switcher Toggle (Like Dark/Light Mode Switch) -->
                    <div class="lang-toggle-container dark-theme inline-flex items-center bg-emerald-950/90 p-0.5 rounded-full border border-emerald-700/60 shadow-xs">
                        <button type="button" onclick="switchLanguage('bn')" class="btn-lang-bn px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs" title="বাংলা">
                            <span>🇧🇩 বাংলা</span>
                        </button>
                        <button type="button" onclick="switchLanguage('en')" class="btn-lang-en px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-semibold transition flex items-center gap-1 text-slate-300 hover:text-white" title="English">
                            <span>🇬🇧 EN</span>
                        </button>
                    </div>

                    <!-- View Storefront Website -->
                    <a href="{{ route('home') }}" target="_blank" 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-800/60 text-emerald-200 hover:bg-emerald-800 hover:text-white border border-emerald-700/60 transition" 
                       title="পাবলিক ওয়েবসাইট নতুন ট্যাবে দেখুন">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span class="hidden sm:inline">ওয়েবসাইট</span>
                    </a>

                    <!-- User Identity Badge -->
                    <div class="hidden md:flex items-center gap-2 px-2.5 py-1 rounded-lg bg-emerald-950/60 border border-emerald-800/40 text-xs">
                        <div class="w-6 h-6 rounded-full bg-emerald-700 text-amber-300 flex items-center justify-center font-bold text-[10px]">
                            A
                        </div>
                        <span class="text-emerald-100 font-bold truncate max-w-[120px]">Jaman</span>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-600/90 hover:bg-red-600 text-white transition shadow-xs" 
                                title="অ্যাডমিন প্যানেল থেকে লগআউট">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span class="hidden sm:inline">লগআউট</span>
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- Mobile Quick Tabs Bar -->
        <div class="lg:hidden bg-primary-800 px-3 py-2 border-t border-emerald-900/60 overflow-x-auto flex items-center gap-2 text-xs">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-3 py-1.5 rounded-lg font-bold whitespace-nowrap {{ request()->routeIs('admin.dashboard*') ? 'bg-[#F48721] text-white' : 'text-slate-200 hover:bg-emerald-900' }}">
                <i class="fa-solid fa-cart-shopping mr-1"></i> অর্ডার (Orders)
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="px-3 py-1.5 rounded-lg font-bold whitespace-nowrap {{ request()->routeIs('admin.products.*') ? 'bg-[#F48721] text-white' : 'text-slate-200 hover:bg-emerald-900' }}">
                <i class="fa-solid fa-boxes-stacked mr-1"></i> প্রোডাক্ট ও স্টক
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-3 py-1.5 rounded-lg font-bold whitespace-nowrap {{ request()->routeIs('admin.categories.*') ? 'bg-[#F48721] text-white' : 'text-slate-200 hover:bg-emerald-900' }}">
                <i class="fa-solid fa-layer-group mr-1"></i> ক্যাটাগরি
            </a>
            <a href="{{ route('admin.customers.index') }}" 
               class="px-3 py-1.5 rounded-lg font-bold whitespace-nowrap {{ request()->routeIs('admin.customers.*') ? 'bg-[#F48721] text-white' : 'text-slate-200 hover:bg-emerald-900' }}">
                <i class="fa-solid fa-user-shield mr-1"></i> কাস্টমার (Customers)
            </a>
            <a href="{{ route('admin.orders.create') }}" 
               class="px-3 py-1.5 rounded-lg font-bold whitespace-nowrap bg-amber-400 text-slate-950 ml-auto">
                <i class="fa-solid fa-plus mr-1"></i> নতুন অর্ডার (New)
            </a>
        </div>
    </header>

    <!-- ================= FLASH MESSAGES ================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3.5 rounded-xl text-emerald-800 text-sm flex items-center justify-between mb-3 shadow-xs">
                <div class="flex items-center gap-2.5 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold px-1">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-3.5 rounded-xl text-red-800 text-sm flex items-center justify-between mb-3 shadow-xs">
                <div class="flex items-center gap-2.5 font-medium">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold px-1">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-3.5 rounded-xl text-red-800 text-sm mb-3 shadow-xs">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation text-red-600"></i>
                    <span>অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 ml-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- ================= MAIN WORK AREA ================= -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- ================= MINIMAL ADMIN FOOTER ================= -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>অ্যাডমিন ম্যানেজমেন্ট পোর্টাল — <strong>আমার বাজার (Amar Bazar)</strong></span>
            </div>
            <div>
                লগইন ইউজার: <span class="text-emerald-400 font-bold">amdarbazar@gmail.com</span>
            </div>
        </div>
    </footer>

    <script src="/js/lang-switcher.js"></script>
    @yield('scripts')
</body>
</html>
