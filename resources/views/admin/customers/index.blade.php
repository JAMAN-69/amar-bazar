@extends('layouts.admin')

@section('title', 'কাস্টমার ডেটাবেস ও ফেইক অর্ডার ফিল্টার - অ্যাডমিন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">অ্যাডমিন ড্যাশবোর্ড</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">কাস্টমার ফ্রড ফিল্টার</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-users-viewfinder text-purple-600"></i>
                <span>কাস্টমার ডেটাবেস ও ফেইক অর্ডার ফিল্টার</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">ফোন নম্বর ভিত্তিক রিটার্ন রেট ও ফেক অর্ডার প্রতিরোধ ইন্টেলিজেন্স</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold border border-slate-300 hover:bg-slate-50 transition">
                &larr; অর্ডারে ফিরুন
            </a>
            <a href="{{ route('admin.orders.create') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-amber-500 text-slate-950 hover:bg-amber-400 transition shadow flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> নতুন অর্ডার (+ New Order)
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl text-sm font-bold bg-red-600 hover:bg-red-700 text-white transition shadow flex items-center gap-1.5" title="লগআউট">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Fraud & Return Protection Rules Banner -->
    <div class="bg-gradient-to-r from-purple-900 to-indigo-900 text-white p-6 rounded-3xl shadow-md mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="bg-amber-400 text-slate-950 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">
                স্মার্ট অ্যালার্ট সিস্টেম
            </span>
            <h3 class="text-xl font-bold mt-2 mb-1">ফেইক ও রিটার্ন অর্ডার প্রতিরোধে কীভাবে কাজ করে?</h3>
            <p class="text-purple-200 text-xs sm:text-sm leading-relaxed max-w-2xl">
                কোনো কাস্টমার আগে অর্ডার দিয়ে যদি পার্সেল রিটার্ন বা বাতিল করে থাকে, সিস্টেম তাকে স্বয়ংক্রিয়ভাবে <strong class="text-red-300">"লাল ব্যাজ (ঝুঁকিপূর্ণ)"</strong> দিয়ে চিহ্নিত করবে। এতে করে কুরিয়ারে পাঠানোর আগেই অগ্রিম ডেলিভারি চার্জ চেয়ে নেওয়া যায়!
            </p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0 text-xs">
            <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-center">
                <div class="text-emerald-400 font-black text-lg">🟢 বিশ্বস্ত</div>
                <div class="text-[11px] text-purple-200">নিরাপদ ডেলিভারি</div>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-center">
                <div class="text-red-400 font-black text-lg">🔴 ঝুঁকিপূর্ণ</div>
                <div class="text-[11px] text-purple-200">অগ্রিম চার্জ প্রযোজ্য</div>
            </div>
        </div>
    </div>

    <!-- Customer Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">নিবন্ধিত ও সক্রিয় গ্রাহক তালিকা ({{ count($customerList) }} জন)</h2>
            <span class="text-xs text-slate-500">ফোন নম্বর দ্বারা ফিল্টারকৃত</span>
        </div>

        @if(empty($customerList))
            <div class="text-center py-12 text-slate-400">
                <i class="fa-solid fa-users text-5xl mb-3 text-slate-300"></i>
                <p class="text-base font-medium">এখনও কোনো কাস্টমার ডেটা নেই!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">গ্রাহকের নাম ও ফোন</th>
                            <th class="py-3.5 px-6">ঠিকানা</th>
                            <th class="py-3.5 px-6 text-center">মোট অর্ডার</th>
                            <th class="py-3.5 px-6 text-center">সফল ডেলিভারি</th>
                            <th class="py-3.5 px-6 text-center">বাতিল/রিটার্ন</th>
                            <th class="py-3.5 px-6 text-center">রিটার্ন রেট</th>
                            <th class="py-3.5 px-6 text-right">মোট কেনাকাটা</th>
                            <th class="py-3.5 px-6 text-center">ফ্রড/রিস্ক স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($customerList as $cust)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">{{ $cust->name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <a href="tel:{{ $cust->phone }}" class="text-xs font-mono font-bold text-primary-800 hover:underline">
                                            {{ $cust->phone }}
                                        </a>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cust->phone) }}" target="_blank" class="text-emerald-600 hover:underline text-xs" title="WhatsApp Chat">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-xs text-slate-600 max-w-xs truncate">
                                    {{ $cust->address }}
                                </td>

                                <td class="py-4 px-6 text-center font-bold text-slate-800">
                                    {{ $cust->total_orders }}
                                </td>

                                <td class="py-4 px-6 text-center font-bold text-emerald-600">
                                    {{ $cust->delivered_orders }}
                                </td>

                                <td class="py-4 px-6 text-center font-black {{ $cust->cancelled_orders > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                    {{ $cust->cancelled_orders }}
                                </td>

                                <td class="py-4 px-6 text-center font-mono text-xs font-bold {{ $cust->cancel_rate > 30 ? 'text-red-600' : 'text-slate-600' }}">
                                    {{ $cust->cancel_rate }}%
                                </td>

                                <td class="py-4 px-6 text-right font-black text-slate-900">
                                    ৳{{ number_format($cust->total_spent) }}
                                </td>

                                <!-- Risk Score Badge -->
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block text-xs font-bold px-3 py-1 rounded-full border {{ $cust->badgeClass }}">
                                        {{ $cust->badgeText }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
