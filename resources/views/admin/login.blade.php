<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন - Amar Bazar | আমার বাজার</title>
    
    <!-- Google Fonts: Hind Siliguri -->
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
            background: linear-gradient(135deg, #0e2a1c 0%, #1a3a28 50%, #28543b 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 antialiased text-slate-800 relative">
    <!-- Top Right Language Switcher Pill (Dark/Light mode style) -->
    <div class="fixed top-4 right-4 z-50">
        <div class="lang-toggle-container dark-theme inline-flex items-center bg-emerald-950/90 p-0.5 rounded-full border border-emerald-700/60 shadow-lg backdrop-blur-md">
            <button type="button" onclick="switchLanguage('bn')" class="btn-lang-bn px-2.5 py-1 rounded-full text-xs font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs" title="বাংলা">
                <span>🇧🇩 বাংলা</span>
            </button>
            <button type="button" onclick="switchLanguage('en')" class="btn-lang-en px-2.5 py-1 rounded-full text-xs font-semibold transition flex items-center gap-1 text-slate-300 hover:text-white" title="English">
                <span>🇬🇧 EN</span>
            </button>
        </div>
    </div>


    <div class="w-full max-w-md">
        
        <!-- Brand Header Above Card -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-[#F48721] text-white flex items-center justify-center text-2xl shadow-lg group-hover:scale-105 transition transform">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="text-left">
                    <div class="text-2xl font-black text-white tracking-tight leading-tight">আমার বাজার</div>
                    <div class="text-[10px] text-amber-300 font-bold tracking-wider uppercase">Amar Bazar • Pure Food</div>
                </div>
            </a>
            <div class="mt-3 text-emerald-200/80 text-xs font-medium">
                <i class="fa-solid fa-shield-halved text-amber-400 mr-1"></i> সুরক্ষিত অ্যাডমিন কন্ট্রোল প্যানেল
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-white/20 p-6 sm:p-8 backdrop-blur-sm relative overflow-hidden">
            
            <!-- Top Orange Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-600 via-[#F48721] to-amber-400"></div>

            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-lock text-[#F48721]"></i> অ্যাডমিন লগইন
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    অর্ডার ও স্টক পরিচালনা করতে আপনার অ্যাডমিন তথ্য দিয়ে প্রবেশ করুন
                </p>
            </div>

            <!-- Alerts -->
            @if(session('error'))
                <div class="mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-start gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5 text-base flex-shrink-0"></i>
                    <div class="flex-1 font-medium">{{ session('error') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs sm:text-sm flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-base flex-shrink-0"></i>
                    <div class="flex-1 font-medium">{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username or Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        ইমেইল অথবা ইউজারনেম
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user-shield text-sm"></i>
                        </div>
                        <input type="text" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder="আপনার ইমেইল অথবা ইউজারনেম দিন" 
                               class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#F48721]/30 focus:border-[#F48721] transition font-medium text-slate-800">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            পাসওয়ার্ড
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-sm"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               value=""
                               required 
                               autocomplete="current-password"
                               placeholder="আপনার পাসওয়ার্ড দিন" 
                               class="w-full pl-10 pr-11 py-2.5 sm:py-3 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#F48721]/30 focus:border-[#F48721] transition font-medium text-slate-800">
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                title="পাসওয়ার্ড দেখুন/লুকান">
                            <i id="togglePasswordIcon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" checked class="w-4 h-4 text-[#F48721] rounded border-slate-300 focus:ring-[#F48721] accent-[#F48721]">
                        <span class="text-xs text-slate-600 font-medium">আমাকে মনে রাখুন</span>
                    </label>
                    <span class="text-[11px] text-slate-400">অ্যাডমিন অ্যাক্সেস অনলি</span>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-primary-800 via-primary-800 to-emerald-700 hover:from-primary-900 hover:to-emerald-800 text-white font-bold text-sm sm:text-base rounded-xl shadow-lg shadow-emerald-950/20 hover:shadow-xl transition flex items-center justify-center gap-2 group active:scale-[0.99]">
                        <span>লগইন করুন</span>
                        <i class="fa-solid fa-arrow-right-to-bracket text-amber-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>

            </form>



            <!-- Back to Website -->
            <div class="mt-5 text-center">
                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-[#F48721] transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>পাবলিক ওয়েবসাইটে ফিরে যান</span>
                </a>
            </div>

        </div>

        <!-- Security Note Footer -->
        <div class="mt-6 text-center text-xs text-emerald-100/60 flex items-center justify-center gap-2">
            <i class="fa-solid fa-lock text-[10px]"></i>
            <span>২৫৬-বিট SSL এনক্রিপ্টেড সুরক্ষিত কানেকশন</span>
        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }


    </script>
    <script src="/js/lang-switcher.js"></script>
</body>
</html>
