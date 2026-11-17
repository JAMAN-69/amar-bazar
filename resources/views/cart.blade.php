@extends('layouts.app')

@section('title', 'শপিং কার্ট - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping text-primary-800"></i>
        <span>আপনার শপিং কার্ট</span>
    </h1>

    @if(empty($cart))
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto">
            <div class="w-20 h-20 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-2">আপনার কার্ট বর্তমানে খালি!</h2>
            <p class="text-sm text-slate-500 mb-6">আপনার পছন্দের স্বাস্থ্যকর ও প্রাকৃতিক পণ্য কার্টে যুক্ত করুন।</p>
            <a href="{{ route('home') }}" class="inline-block bg-primary-800 hover:bg-primary-900 text-white font-bold px-8 py-3.5 rounded-full text-sm transition shadow-lg">
                কেনাকাটা শুরু করুন
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Cart Items Table / List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-bold text-slate-800">নির্বাচিত পণ্যসমূহ ({{ count($cart) }}টি)</span>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-trash-can"></i> সব খালি করুন
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                            <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-4">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-2xl flex-shrink-0 border border-slate-100">
                                
                                <div class="flex-1 text-center sm:text-left min-w-0">
                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">
                                        {{ $item['name'] }}
                                    </h3>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $item['subtitle'] ?? '' }}</div>
                                    <div class="text-primary-800 font-bold text-sm mt-1">৳{{ number_format($item['price']) }}</div>
                                </div>

                                <!-- Quantity Form -->
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-1 text-slate-600 hover:bg-slate-200 font-bold transition">-</button>
                                    <span class="px-3 py-1 text-sm font-bold bg-white min-w-[32px] text-center">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1 text-slate-600 hover:bg-slate-200 font-bold transition">+</button>
                                </form>

                                <!-- Total for this item -->
                                <div class="text-sm font-black text-slate-900 min-w-[80px] text-right">
                                    ৳{{ number_format($item['price'] * $item['quantity']) }}
                                </div>

                                <!-- Remove button -->
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-slate-400 hover:text-red-500 p-2 transition">
                                        <i class="fa-solid fa-xmark text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-sm font-bold text-primary-800 hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i> আরও পণ্য যোগ করুন
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm sticky top-24">
                    <h2 class="font-bold text-slate-900 text-lg mb-4 pb-2 border-b">অর্ডার সামারি</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>পণ্যের মোট মূল্য:</span>
                            <span class="font-bold text-slate-900">৳{{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>ডেলিভারি চার্জ:</span>
                            <span class="text-xs text-emerald-700 font-medium">চেকআউট পেজে নির্ধারিত হবে</span>
                        </div>
                        <div class="pt-3 border-t flex justify-between text-base font-extrabold text-slate-900">
                            <span>সাবটোটাল:</span>
                            <span class="text-primary-800 text-xl">৳{{ number_format($subtotal) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="mt-6 w-full block text-center bg-primary-800 hover:bg-primary-900 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg text-base">
                        <span>চেকআউট ও অর্ডার কনফার্ম</span>
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>

                    <div class="mt-4 p-3 bg-emerald-50 rounded-xl text-xs text-emerald-800 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-base text-primary-800 flex-shrink-0"></i>
                        <span>ক্যাশ অন ডেলিভারি সুবিধা—পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন!</span>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection
