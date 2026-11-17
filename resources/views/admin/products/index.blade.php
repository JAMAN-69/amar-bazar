@extends('layouts.admin')

@section('title', 'প্রোডাক্ট ও স্টক ম্যানেজমেন্ট - অ্যাডমিন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">অ্যাডমিন ড্যাশবোর্ড</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">প্রোডাক্ট ও স্টক</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-primary-800"></i>
                <span>প্রোডাক্ট ও ইনভেন্টরি স্টক কন্ট্রোল</span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold border border-slate-300 hover:bg-slate-50 transition">
                &larr; অর্ডারে ফিরুন
            </a>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-primary-800 text-white hover:bg-primary-900 transition shadow flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> নতুন প্রোডাক্ট যোগ করুন
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl text-sm font-bold bg-red-600 hover:bg-red-700 text-white transition shadow flex items-center gap-1.5" title="লগআউট">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Notice Banner for Orders & Stock Action -->
    <div class="mb-6 p-4 bg-amber-50 rounded-2xl border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-circle-info text-amber-600 text-lg"></i>
            <span class="text-amber-950 font-medium">
                <strong>অর্ডার কনফার্মেশন ও স্টক কাটছাঁট:</strong> কাস্টমারের অর্ডার আসলে তা <strong>কনফার্ম</strong> (স্টক কমবে), <strong>বাতিল</strong> (স্টক ফেরত) কিংবা <strong>রিটার্ন</strong> করতে অর্ডার তালিকায় যান।
            </span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-primary-800 hover:bg-primary-900 text-white font-bold rounded-xl whitespace-nowrap shadow-sm">
            &rarr; অর্ডার ম্যানেজমেন্টে যান
        </a>
    </div>

    <!-- Inventory Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-boxes-packing"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold uppercase">মোট মজুদ স্টক</div>
                <div class="text-2xl font-black text-slate-900 mt-0.5">{{ number_format($totalStock) }} <span class="text-xs font-normal text-slate-500">পিস</span></div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold uppercase">মোট বিক্রিত পরিমাণ</div>
                <div class="text-2xl font-black text-primary-800 mt-0.5">{{ number_format($totalSold) }} <span class="text-xs font-normal text-slate-500">পিস বিক্রি</span></div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-semibold uppercase">কম স্টক সতর্কতা (Low Stock Alert)</div>
                <div class="text-2xl font-black text-amber-600 mt-0.5">{{ $lowStockCount }} <span class="text-xs font-normal text-slate-500">টি প্রোডাক্ট</span></div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">সকল প্রোডাক্ট তালিকা</h2>
            <span class="text-xs text-slate-500">লাইভ স্টক আপডেট সংযুক্ত</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-6">প্রোডাক্ট</th>
                        <th class="py-3.5 px-6">ক্যাটাগরি</th>
                        <th class="py-3.5 px-6">মূল্য ও ডিসকাউন্ট</th>
                        <th class="py-3.5 px-6 text-center">বর্তমান স্টক</th>
                        <th class="py-3.5 px-6 text-center">মোট বিক্রি</th>
                        <th class="py-3.5 px-6 text-center">স্ট্যাটাস</th>
                        <th class="py-3.5 px-6 text-center">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl border border-slate-100 flex-shrink-0">
                                <div>
                                    <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-primary-800 text-sm line-clamp-1">
                                        {{ $product->name }}
                                    </a>
                                    <div class="text-xs text-slate-500">{{ $product->subtitle }}</div>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-xs font-semibold text-slate-600">
                                {{ $product->category->name ?? 'N/A' }}
                            </td>

                            <td class="py-4 px-6 text-sm">
                                <div class="font-black text-[#F48721] text-base">৳{{ number_format($product->effective_price) }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-[11px] text-slate-400 line-through">মার্কেট: ৳{{ number_format($product->regular_price) }}</span>
                                    @if($product->discount_percent > 0)
                                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.5 rounded">
                                            -{{ $product->discount_percent }}% (সেভ ৳{{ number_format($product->saved_amount) }})
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Stock Counter with Alert Badge -->
                            <td class="py-4 px-6 text-center">
                                @if($product->stock <= 5)
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-black border border-red-200 animate-pulse">
                                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $product->stock }} (ক্রিটিক্যাল!)
                                    </span>
                                @elseif($product->stock <= 15)
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full text-xs font-bold border border-amber-200">
                                        {{ $product->stock }} (কম আছে)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-200">
                                        {{ $product->stock }} পিস
                                    </span>
                                @endif
                            </td>

                            <!-- Total Sales Counter -->
                            <td class="py-4 px-6 text-center font-bold text-primary-800">
                                {{ $product->total_sales }} পিস
                            </td>

                            <td class="py-4 px-6 text-center text-xs">
                                <span class="px-2 py-1 rounded-md font-bold {{ $product->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $product->is_available ? 'চালু আছে' : 'হাইড করা' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 px-3 py-1.5 rounded-lg transition" title="এডিট করুন">
                                        <i class="fa-solid fa-pen"></i> এডিট
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই প্রোডাক্টটি মুছে ফেলতে চান?')">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold bg-slate-100 hover:bg-red-600 hover:text-white text-red-600 px-3 py-1.5 rounded-lg transition" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
