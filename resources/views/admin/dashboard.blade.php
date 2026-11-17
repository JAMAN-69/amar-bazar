@extends('layouts.admin')

@section('title', 'অর্ডার কন্ট্রোল ড্যাশবোর্ড - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    
    <!-- Admin Navigation Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <span class="font-bold text-primary-800">অ্যাডমিন কন্ট্রোল</span>
                <span>/</span>
                <span>অর্ডার ড্যাশবোর্ড</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                অর্ডার ও ডেলিভারি ড্যাশবোর্ড
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">কাস্টমারের সাথে কথা বলে অর্ডার কনফার্ম, বাতিল বা রিটার্ন পরিচালনা করুন</p>
        </div>


    </div>

    <!-- Quick Stats Cards Grid (Optimized & Compact on Mobile) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-5 mb-5 sm:mb-6">
        <div class="bg-white p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-xs sm:shadow-sm flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-[11px] text-slate-500 font-bold uppercase truncate">মোট অর্ডার</div>
                <div class="text-base sm:text-2xl font-black text-slate-900 leading-tight">{{ $totalOrders }}</div>
            </div>
        </div>

        <div class="bg-white p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-xs sm:shadow-sm flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-emerald-50 text-primary-800 flex items-center justify-center text-sm sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-[11px] text-slate-500 font-bold uppercase truncate">মোট বিক্রয়</div>
                <div class="text-base sm:text-2xl font-black text-primary-800 leading-tight">৳{{ number_format($totalRevenue) }}</div>
            </div>
        </div>

        <div class="bg-white p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-xs sm:shadow-sm flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-[11px] text-slate-500 font-bold uppercase truncate">পেন্ডিং অর্ডার</div>
                <div class="text-base sm:text-2xl font-black text-amber-600 leading-tight">{{ $pendingOrders }}</div>
            </div>
        </div>

        <a href="{{ route('admin.products.index') }}" class="bg-white p-3 sm:p-5 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-xs sm:shadow-sm flex items-center gap-2.5 sm:gap-3.5 hover:border-primary-500 transition">
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-[11px] text-slate-500 font-bold uppercase truncate">মোট প্রোডাক্ট (Total Products) (Total Products)</div>
                <div class="text-base sm:text-2xl font-black text-slate-900 leading-tight">{{ $totalProducts }}</div>
            </div>
        </a>
    </div>

    <!-- Filter Buttons & Controls -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        
        <!-- Search Engine Box (Specially Designed for Pasting Order ID / Phone / Name) -->
        <div class="p-4 sm:p-6 bg-gradient-to-r from-slate-50 via-emerald-50/20 to-amber-50/20 border-b border-slate-200">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-primary-800">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        id="adminSearchInput"
                        value="{{ request('search') }}" 
                        placeholder="অর্ডার আইডি পেস্ট করুন (যেমন: AB-20261117-XIY2), ফোন নম্বর বা গ্রাহকের নাম..." 
                        class="w-full pl-10 pr-24 py-3 rounded-2xl border border-slate-300 focus:border-primary-800 focus:ring-2 focus:ring-primary-800/20 text-xs sm:text-sm bg-white shadow-sm font-semibold placeholder:text-slate-400 placeholder:font-normal"
                    >
                    <button 
                        type="button" 
                        onclick="pasteToSearch()" 
                        class="absolute inset-y-1.5 right-1.5 px-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold flex items-center gap-1.5 transition border border-slate-200 shadow-xs"
                        title="ক্লিপবোর্ড থেকে অর্ডার আইডি পেস্ট করুন"
                    >
                        <i class="fa-regular fa-paste text-primary-800"></i> পেস্ট
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-primary-800 hover:bg-primary-900 text-white rounded-2xl text-xs sm:text-sm font-black shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>সার্চ করুন (Search)</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.dashboard', request('status') ? ['status' => request('status')] : []) }}" class="px-4 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-center gap-1.5" title="সার্চ রিসেট">
                            <i class="fa-solid fa-xmark"></i> রিসেট
                        </a>
                    @endif
                </div>
            </form>
            @if(request('search'))
                <div class="mt-3 flex items-center justify-between text-xs text-slate-600 bg-white/80 p-2.5 rounded-xl border border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>সার্চ রেজাল্ট: <strong class="text-primary-800">"{{ request('search') }}"</strong> এর জন্য <strong class="text-slate-900">{{ $orders->total() }}</strong>টি অর্ডার পাওয়া গেছে</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="text-primary-800 hover:underline font-bold text-xs flex items-center gap-1">
                        <i class="fa-solid fa-arrow-rotate-left text-[10px]"></i> সব অর্ডার দেখুন
                    </a>
                </div>
            @endif
        </div>

        <div class="p-4 sm:p-5 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-white">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">অর্ডার তালিকা</h2>
                <p class="text-xs text-slate-500">স্ট্যাটাস অপশন থেকে কনফার্ম, বাতিল বা রিটার্ন সিলেক্ট করুন</p>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center gap-1.5 flex-wrap">
                <a href="{{ route('admin.dashboard', request('search') ? ['search' => request('search')] : []) }}" class="text-xs font-bold px-3 py-1.5 rounded-xl border {{ !request('status') ? 'bg-primary-800 text-white border-primary-800' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">সবগুলো</a>
                <a href="{{ route('admin.dashboard', array_merge(['status' => 'pending'], request('search') ? ['search' => request('search')] : [])) }}" class="text-xs font-bold px-3 py-1.5 rounded-xl border {{ request('status') === 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">পেন্ডিং</a>
                <a href="{{ route('admin.dashboard', array_merge(['status' => 'confirmed'], request('search') ? ['search' => request('search')] : [])) }}" class="text-xs font-bold px-3 py-1.5 rounded-xl border {{ request('status') === 'confirmed' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">কনফার্মড</a>
                <a href="{{ route('admin.dashboard', array_merge(['status' => 'cancelled'], request('search') ? ['search' => request('search')] : [])) }}" class="text-xs font-bold px-3 py-1.5 rounded-xl border {{ request('status') === 'cancelled' ? 'bg-red-600 text-white border-red-600' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">বাতিল/রিটার্ন</a>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-16 text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-5xl mb-3 text-slate-300"></i>
                <p class="text-base font-bold text-slate-700">কোনো অর্ডার পাওয়া যায়নি!</p>
                @if(request('search'))
                    <p class="text-xs text-slate-500 mt-1">"{{ request('search') }}" দিয়ে কোনো অর্ডার খুঁজে পাওয়া যায়নি। সঠিক অর্ডার আইডি বা ফোন নম্বর দিন।</p>
                    <a href="{{ route('admin.dashboard') }}" class="mt-4 inline-block px-5 py-2.5 bg-primary-800 text-white text-xs font-bold rounded-xl shadow">সব অর্ডার দেখুন</a>
                @endif
            </div>
        @else

            <!-- ================= DESKTOP TABLE VIEW (Clean, Spacious, No Messy Wrap) ================= -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-5">অর্ডার নং ও সময়</th>
                            <th class="py-3.5 px-5">গ্রাহকের নাম ও এলাকা</th>
                            <th class="py-3.5 px-5">মোবাইল নম্বর</th>
                            <th class="py-3.5 px-5 text-center">রিস্ক ফিল্টার</th>
                            <th class="py-3.5 px-5 text-right">মোট বিল</th>
                            <th class="py-3.5 px-5 text-center">স্টক অবস্থা</th>
                            <th class="py-3.5 px-5 text-center">স্ট্যাটাস পরিবর্তন (১টি অপশন)</th>
                            <th class="py-3.5 px-5 text-center">ইনভয়েস</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-50/70 transition">
                                
                                <!-- Order Number & Date -->
                                <td class="py-4 px-5">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-bold text-primary-800 hover:underline text-xs block">
                                        {{ $order->order_number }}
                                    </a>
                                    <span class="text-[11px] text-slate-400 mt-0.5 block">{{ $order->created_at->format('d M, Y (h:i A)') }}</span>
                                </td>

                                <!-- Customer Name & Zone -->
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</div>
                                    <span class="inline-block text-[11px] font-medium text-slate-500 mt-0.5">
                                        {{ $order->delivery_zone === 'inside_dhaka' ? '📍 ঢাকার ভেতরে' : '📍 ঢাকার বাইরে' }}
                                    </span>
                                </td>

                                <!-- Phone & Direct Links -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-2">
                                        <a href="tel:{{ $order->customer_phone }}" class="font-mono font-bold text-slate-800 hover:text-primary-800 text-xs">
                                            {{ $order->customer_phone }}
                                        </a>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs hover:bg-emerald-200" title="হোয়াটসঅ্যাপ চ্যাট">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>

                                <!-- Clean Single-Line Risk Badge (No vertical pink blocks!) -->
                                <td class="py-4 px-5 text-center">
                                    @if(isset($order->risk_badge))
                                        @if($order->risk_badge['level'] === 'high')
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-800 border border-red-200">
                                                <i class="fa-solid fa-triangle-exclamation"></i> রিটার্ন হিস্টোরি (সতর্ক)
                                            </span>
                                        @elseif($order->risk_badge['level'] === 'trusted')
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <i class="fa-solid fa-circle-check"></i> বিশ্বস্ত গ্রাহক
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                <i class="fa-solid fa-clock"></i> নতুন কাস্টমার
                                            </span>
                                        @endif
                                    @endif
                                </td>

                                <!-- Price -->
                                <td class="py-4 px-5 text-right font-black text-slate-900 text-sm">
                                    ৳{{ number_format($order->total) }}
                                </td>

                                <!-- Stock Status -->
                                <td class="py-4 px-5 text-center text-xs">
                                    @if($order->is_stock_deducted)
                                        <span class="text-emerald-700 font-bold inline-flex items-center gap-1 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                            <i class="fa-solid fa-check text-[10px]"></i> স্টক মাইনাস
                                        </span>
                                    @else
                                        <span class="text-slate-400 inline-flex items-center gap-1 bg-slate-50 px-2.5 py-1 rounded-lg">
                                            <i class="fa-solid fa-minus text-[10px]"></i> স্টক অক্ষুণ্ণ
                                        </span>
                                    @endif
                                </td>

                                <!-- 1 SINGLE ACTION: Clean Status Dropdown with In-Page Animated Modal -->
                                <td class="py-4 px-5 text-center">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" id="status-form-{{ $order->id }}">
                                        @csrf
                                        <select 
                                            name="status" 
                                            data-order-id="{{ $order->id }}"
                                            data-order-number="{{ $order->order_number }}"
                                            data-customer="{{ $order->customer_name }}"
                                            data-total="৳{{ number_format($order->total) }}"
                                            data-current-status="{{ $order->status }}"
                                            onchange="openStatusModal(this, 'status-form-{{ $order->id }}')" 
                                            class="text-xs font-bold rounded-xl px-3 py-2 border shadow-sm cursor-pointer transition focus:outline-none focus:ring-2 focus:ring-primary-800/20
                                            {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-900 border-amber-300' : '' }}
                                            {{ $order->status === 'confirmed' ? 'bg-emerald-100 text-emerald-900 border-emerald-300' : '' }}
                                            {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-900 border-purple-300' : '' }}
                                            {{ $order->status === 'delivered' ? 'bg-blue-100 text-blue-900 border-blue-300' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-900 border-red-300' : '' }}
                                            {{ $order->status === 'returned' ? 'bg-orange-100 text-orange-900 border-orange-300' : '' }}
                                        ">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ পেন্ডিং (কল দিন)</option>
                                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✓ কনফার্ম (স্টক কমবে)</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 ডেলিভারিতে আছে</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>📦 ডেলিভার্ড</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>✕ বাতিল (স্টক ফেরত)</option>
                                            <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>🔄 পার্সেল রিটার্ন (স্টক ফেরত)</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Invoice & Edit -->
                                <td class="py-4 px-5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-primary-800 hover:text-white text-slate-700 px-3 py-1.5 rounded-lg transition" title="ইনভয়েস দেখুন">
                                            <i class="fa-solid fa-eye"></i> ভিউ
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 px-2 py-1.5 rounded-lg transition" title="তথ্য এডিট">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ================= MOBILE CARD VIEW (Completely Redesigned for Phones & Tablets) ================= -->
            <div class="md:hidden p-3 space-y-3 bg-slate-50/70">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs space-y-3 transition hover:border-slate-300">
                        
                        <!-- Row 1: Order ID, Date & Risk Pill -->
                        <div class="flex items-start justify-between gap-2 pb-2.5 border-b border-slate-100">
                            <div>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-extrabold text-primary-800 text-xs hover:underline flex items-center gap-1">
                                    <span>#{{ $order->order_number }}</span>
                                </a>
                                <span class="text-[10px] text-slate-400 block mt-0.5 font-medium">
                                    <i class="fa-regular fa-clock text-[9px] mr-0.5"></i> {{ $order->created_at->format('d M, Y (h:i A)') }}
                                </span>
                            </div>
                            
                            <!-- Risk Badge -->
                            <div class="flex-shrink-0">
                                @if(isset($order->risk_badge))
                                    @if($order->risk_badge['level'] === 'high')
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-800 border border-red-200 flex items-center gap-1 whitespace-nowrap">
                                            <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> রিটার্ন হিস্টোরি
                                        </span>
                                    @elseif($order->risk_badge['level'] === 'trusted')
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1 whitespace-nowrap">
                                            <i class="fa-solid fa-circle-check text-[9px]"></i> বিশ্বস্ত
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1 whitespace-nowrap">
                                            <i class="fa-solid fa-user-clock text-[9px]"></i> নতুন কাস্টমার
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Row 2: Customer Info with Separate Call & WhatsApp Buttons (No overlapping text!) -->
                        <div class="space-y-2">
                            <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-slate-400 text-xs"></i>
                                <span>{{ $order->customer_name }}</span>
                            </div>

                            <!-- Phone and WhatsApp Quick Actions as distinct colored pills -->
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="tel:{{ $order->customer_phone }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-mono font-bold px-3 py-1.5 rounded-xl border border-slate-200/80 transition">
                                    <i class="fa-solid fa-phone text-primary-800 text-[10px]"></i>
                                    <span>{{ $order->customer_phone }}</span>
                                </a>

                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}?text=হ্যালো {{ urlencode($order->customer_name) }}, আপনার আমার বাজার অর্ডার #{{ $order->order_number }} সম্পর্কে..." target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-xl border border-emerald-200 transition">
                                    <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                                    <span>হোয়াটসঅ্যাপ</span>
                                </a>
                            </div>

                            <!-- Address Box -->
                            <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 flex items-start gap-1.5 leading-relaxed">
                                <i class="fa-solid fa-location-dot text-red-500 text-xs mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <span>{{ $order->customer_address }}</span>
                                    <span class="inline-block font-semibold text-primary-800 text-[11px] ml-1">
                                        ({{ $order->delivery_zone === 'inside_dhaka' ? 'ঢাকার ভেতরে' : 'ঢাকার বাইরে' }})
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Total Bill & Stock Status -->
                        <div class="flex items-center justify-between text-xs pt-2 pb-1 border-t border-slate-100">
                            <div>
                                <span class="text-slate-500 text-xs">মোট বিল:</span>
                                <span class="font-black text-slate-900 text-base ml-1">৳{{ number_format($order->total) }}</span>
                            </div>
                            
                            <div>
                                @if($order->is_stock_deducted)
                                    <span class="text-emerald-700 font-bold text-xs bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 flex items-center gap-1">
                                        <i class="fa-solid fa-check text-[10px]"></i> স্টক মাইনাস
                                    </span>
                                @else
                                    <span class="text-slate-500 font-medium text-xs bg-slate-100 px-2.5 py-1 rounded-lg flex items-center gap-1">
                                        <i class="fa-solid fa-clock text-[10px]"></i> স্টক অক্ষুণ্ণ
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Row 4: Status Selector & Action Buttons -->
                        <div class="pt-2 flex items-center gap-2">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" id="status-form-mob-{{ $order->id }}" class="flex-1">
                                @csrf
                                <select 
                                    name="status" 
                                    data-order-id="{{ $order->id }}"
                                    data-order-number="{{ $order->order_number }}"
                                    data-customer="{{ $order->customer_name }}"
                                    data-total="৳{{ number_format($order->total) }}"
                                    data-current-status="{{ $order->status }}"
                                    onchange="openStatusModal(this, 'status-form-mob-{{ $order->id }}')" 
                                    class="w-full text-xs font-bold rounded-xl px-3 py-2.5 border shadow-xs cursor-pointer transition focus:outline-none focus:ring-2 focus:ring-primary-800/20
                                    {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-900 border-amber-300' : '' }}
                                    {{ $order->status === 'confirmed' ? 'bg-emerald-100 text-emerald-900 border-emerald-300' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-900 border-purple-300' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-blue-100 text-blue-900 border-blue-300' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-900 border-red-300' : '' }}
                                    {{ $order->status === 'returned' ? 'bg-orange-100 text-orange-900 border-orange-300' : '' }}
                                ">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ পেন্ডিং (কল দিন)</option>
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✓ কনফার্ম (স্টক কমবে)</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 ডেলিভারিতে আছে</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>📦 ডেলিভার্ড</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>✕ বাতিল (স্টক ফেরত)</option>
                                    <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>🔄 পার্সেল রিটার্ন (স্টক ফেরত)</option>
                                </select>
                            </form>

                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-primary-800 hover:text-white text-slate-700 px-3.5 py-2.5 rounded-xl border border-slate-200/80 transition flex items-center gap-1 shadow-xs" title="ইনভয়েস দেখুন">
                                <i class="fa-solid fa-eye"></i>
                                <span>ভিউ</span>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 px-3 py-2.5 rounded-xl border border-slate-200/80 transition shadow-xs" title="এডিট">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-200">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

<!-- ================= BEAUTIFUL IN-PAGE ANIMATED STATUS CONFIRMATION MODAL (NO OS POPUP!) ================= -->
<div id="statusConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs opacity-0 pointer-events-none transition-all duration-300">
    
    <!-- Backdrop click to dismiss -->
    <div class="fixed inset-0" onclick="closeStatusModal()"></div>

    <!-- Modal Dialog Card with bounce/scale animation -->
    <div id="statusModalCard" class="relative bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100 transform scale-90 opacity-0 transition-all duration-300 text-center z-10">
        
        <!-- Close 'X' button in top-right -->
        <button type="button" onclick="closeStatusModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition" title="বন্ধ করুন">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <!-- Dynamic Icon Container with animation -->
        <div id="modalIconContainer" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 transition-all duration-300 shadow-sm">
            <!-- Injected by JS -->
        </div>

        <!-- Dynamic Title -->
        <h3 id="modalTitle" class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mb-2">
            <!-- Injected by JS -->
        </h3>

        <!-- Dynamic Message / Explanation -->
        <p id="modalMessage" class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 px-2">
            <!-- Injected by JS -->
        </p>

        <!-- Order Snapshot Pill -->
        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200/80 mb-6 text-xs text-slate-700 flex items-center justify-between">
            <div class="font-mono font-bold text-primary-800" id="modalOrderNumber"></div>
            <div class="font-bold text-slate-900 truncate max-w-[120px]" id="modalCustomerName"></div>
            <div class="font-black text-primary-800" id="modalOrderTotal"></div>
        </div>

        <!-- Action Buttons Grid -->
        <div class="grid grid-cols-2 gap-3">
            <button type="button" onclick="closeStatusModal()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-xmark"></i>
                <span>না, ফিরে যান</span>
            </button>
            <button type="button" id="modalConfirmBtn" onclick="submitStatusChange()" class="w-full text-white font-black py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition shadow-lg flex items-center justify-center gap-2">
                <!-- Text and styles injected by JS -->
            </button>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Paste Order ID / Search Term directly from clipboard
    async function pasteToSearch() {
        try {
            const text = await navigator.clipboard.readText();
            if (text) {
                const input = document.getElementById('adminSearchInput');
                input.value = text.trim();
                input.focus();
            }
        } catch (err) {
            const input = document.getElementById('adminSearchInput');
            input.focus();
            input.select();
        }
    }

    // Modal State Management
    let pendingSelectEl = null;
    let pendingFormId = null;
    let previousStatusValue = null;

    const statusConfigs = {
        confirmed: {
            title: 'অর্ডার কনফার্ম করবেন?',
            message: 'কাস্টমারের সাথে ফোনে কথা বলে অর্ডার নিশ্চিত করলে ইনভেন্টরি থেকে পণ্যের স্টক সংখ্যা স্বয়ংক্রিয়ভাবে কমে যাবে।',
            icon: '<i class="fa-solid fa-circle-check"></i>',
            iconBg: 'bg-emerald-100 text-emerald-600 animate-pulse',
            btnText: '✓ হ্যাঁ, কনফার্ম করুন',
            btnClass: 'bg-emerald-600 hover:bg-emerald-700'
        },
        cancelled: {
            title: 'অর্ডার বাতিল করবেন?',
            message: 'আপনি কি এই অর্ডারটি বাতিল করতে চান? পূর্বে স্টক কাটা হয়ে থাকলে তা স্বয়ংক্রিয়ভাবে ইনভেন্টরিতে ফেরত যোগ হবে।',
            icon: '<i class="fa-solid fa-triangle-exclamation"></i>',
            iconBg: 'bg-red-100 text-red-600 animate-bounce',
            btnText: '✕ হ্যাঁ, বাতিল করুন',
            btnClass: 'bg-red-600 hover:bg-red-700'
        },
        returned: {
            title: 'পার্সেল রিটার্ন এসেছে?',
            message: 'কুরিয়ার থেকে পার্সেল ফেরত আসলে রিটার্ন সিলেক্ট করুন। ইনভেন্টরিতে স্টক পুনরায় ফেরত যোগ হবে।',
            icon: '<i class="fa-solid fa-box-open"></i>',
            iconBg: 'bg-orange-100 text-orange-600 animate-pulse',
            btnText: '🔄 হ্যাঁ, রিটার্ন করুন',
            btnClass: 'bg-orange-600 hover:bg-orange-700'
        },
        shipped: {
            title: 'ডেলিভারিতে পাঠাবেন?',
            message: 'পার্সেলটি কুরিয়ারে হস্তান্তর করা হয়েছে এবং ট্র্যাকিং চালু হয়েছে।',
            icon: '<i class="fa-solid fa-truck-fast"></i>',
            iconBg: 'bg-purple-100 text-purple-600 animate-pulse',
            btnText: '🚚 হ্যাঁ, শিপ করুন',
            btnClass: 'bg-purple-600 hover:bg-purple-700'
        },
        delivered: {
            title: 'পণ্য ডেলিভার্ড হয়েছে?',
            message: 'গ্রাহক পার্সেল রিসিভ করেছেন এবং মূল্য সম্পূর্ণ পরিশোধ করেছেন।',
            icon: '<i class="fa-solid fa-box-check"></i>',
            iconBg: 'bg-blue-100 text-blue-600 animate-pulse',
            btnText: '📦 হ্যাঁ, ডেলিভার্ড',
            btnClass: 'bg-blue-600 hover:bg-blue-700'
        },
        pending: {
            title: 'অর্ডার পেন্ডিং রাখবেন?',
            message: 'কাস্টমার রিসিভ না করলে বা কথা না হলে অর্ডার পেন্ডিং রাখতে পারেন। স্টক অক্ষুণ্ণ থাকবে।',
            icon: '<i class="fa-solid fa-clock-rotate-left"></i>',
            iconBg: 'bg-amber-100 text-amber-600 animate-pulse',
            btnText: '⏳ পেন্ডিং রাখুন',
            btnClass: 'bg-amber-600 hover:bg-amber-700'
        }
    };

    // Open In-Page Animated Modal (Zero Browser Popups!)
    function openStatusModal(selectEl, formId) {
        const newStatus = selectEl.value;
        const currentStatus = selectEl.getAttribute('data-current-status');

        if (newStatus === currentStatus) return;

        pendingSelectEl = selectEl;
        pendingFormId = formId;
        previousStatusValue = currentStatus;

        const config = statusConfigs[newStatus] || statusConfigs.pending;

        document.getElementById('modalTitle').innerText = config.title;
        document.getElementById('modalMessage').innerText = config.message;
        
        const iconContainer = document.getElementById('modalIconContainer');
        iconContainer.className = `w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 transition-all duration-300 shadow-sm ${config.iconBg}`;
        iconContainer.innerHTML = config.icon;

        document.getElementById('modalOrderNumber').innerText = '#' + selectEl.getAttribute('data-order-number');
        document.getElementById('modalCustomerName').innerText = selectEl.getAttribute('data-customer');
        document.getElementById('modalOrderTotal').innerText = selectEl.getAttribute('data-total');

        const confirmBtn = document.getElementById('modalConfirmBtn');
        confirmBtn.className = `w-full text-white font-black py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition shadow-lg flex items-center justify-center gap-2 ${config.btnClass}`;
        confirmBtn.innerHTML = `<span>${config.btnText}</span>`;

        // Animate modal in
        const modal = document.getElementById('statusConfirmModal');
        const card = document.getElementById('statusModalCard');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        setTimeout(() => {
            card.classList.remove('scale-90', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Dismiss modal and revert dropdown to original value
    function closeStatusModal() {
        if (pendingSelectEl && previousStatusValue) {
            pendingSelectEl.value = previousStatusValue;
        }
        const modal = document.getElementById('statusConfirmModal');
        const card = document.getElementById('statusModalCard');
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            pendingSelectEl = null;
            pendingFormId = null;
            previousStatusValue = null;
        }, 200);
    }

    // Submit the status change form
    function submitStatusChange() {
        if (pendingFormId) {
            document.getElementById(pendingFormId).submit();
        }
    }
</script>
@endsection
