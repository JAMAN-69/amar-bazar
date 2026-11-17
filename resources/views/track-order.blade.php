@extends('layouts.app')

@section('title', 'অর্ডার ট্র্যাক করুন - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 sm:py-12">
    
    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 sm:p-8">
        
        <div class="text-center max-w-md mx-auto mb-8">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-[#F48721] flex items-center justify-center text-2xl mx-auto mb-3 shadow-xs">
                <i class="fa-solid fa-route"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">অর্ডার ট্র্যাকিং</h1>
            <p class="text-xs text-gray-500 mt-1">আপনার অর্ডার নম্বর (যেমন: AB-20261117-XXXX) অথবা ফোন নম্বর দিয়ে বর্তমান অবস্থান জানুন</p>
        </div>

        <form action="{{ route('track.order') }}" method="GET" class="max-w-md mx-auto mb-8">
            <div class="flex gap-2">
                <input type="text" 
                       name="order_id" 
                       value="{{ $search ?? '' }}" 
                       placeholder="অর্ডার নম্বর বা ফোন নম্বর দিন..." 
                       required
                       class="flex-1 px-4 py-3 text-sm bg-gray-50 border border-gray-300 rounded-xl focus:bg-white focus:outline-none focus:border-[#F48721] focus:ring-2 focus:ring-[#F48721]/20 transition">
                <button type="submit" class="bg-[#F48721] hover:bg-[#e07518] text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>সার্চ</span>
                </button>
            </div>
        </form>

        @if(!empty($search))
            @if($order)
                <!-- Order Status Card -->
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-200 mb-5">
                        <div>
                            <span class="text-xs text-gray-400 font-semibold uppercase">অর্ডার নম্বর</span>
                            <div class="text-lg font-black text-gray-900">{{ $order->order_number }}</div>
                            <div class="text-xs text-gray-500">{{ $order->created_at->format('d M, Y - h:i A') }}</div>
                        </div>
                        <div>
                            @php
                                $statusMap = [
                                    'pending' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-300', 'label' => 'পেন্ডিং (যাচাই চলছে)', 'icon' => 'fa-clock'],
                                    'confirmed' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'label' => 'কনফার্মড (প্রস্তুত হচ্ছে)', 'icon' => 'fa-check'],
                                    'shipped' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => 'ডেলিভারিতে আছে', 'icon' => 'fa-truck-fast'],
                                    'delivered' => ['bg' => 'bg-green-100 text-green-800 border-green-300', 'label' => 'ডেলিভার্ড সফল', 'icon' => 'fa-box-open'],
                                    'cancelled' => ['bg' => 'bg-red-100 text-red-800 border-red-300', 'label' => 'অর্ডার বাতিল', 'icon' => 'fa-xmark'],
                                ];
                                $st = $statusMap[$order->status] ?? ['bg' => 'bg-gray-100 text-gray-800 border-gray-300', 'label' => ucfirst($order->status), 'icon' => 'fa-circle-info'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $st['bg'] }}">
                                <i class="fa-solid {{ $st['icon'] }}"></i> {{ $st['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Steps Timeline -->
                    <div class="grid grid-cols-4 gap-2 mb-6 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold mb-1 shadow">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <span class="text-[11px] font-bold text-gray-800">অর্ডার গ্রহণ</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['confirmed', 'shipped', 'delivered']) ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold mb-1 shadow-xs">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span class="text-[11px] font-bold {{ in_array($order->status, ['confirmed', 'shipped', 'delivered']) ? 'text-gray-800' : 'text-gray-400' }}">কনফার্মেশন</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold mb-1 shadow-xs">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <span class="text-[11px] font-bold {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-gray-800' : 'text-gray-400' }}">ডেলিভারিতে</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full {{ $order->status == 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold mb-1 shadow-xs">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <span class="text-[11px] font-bold {{ $order->status == 'delivered' ? 'text-gray-800' : 'text-gray-400' }}">হস্তান্তর</span>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 mb-4">
                        <div class="text-xs font-bold text-gray-700 uppercase mb-2">অর্ডারের পণ্যসমূহ:</div>
                        <div class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <div class="py-2 flex items-center justify-between text-xs sm:text-sm">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $item->product_image ?? 'https://via.placeholder.com/40' }}" class="w-8 h-8 rounded object-contain border border-gray-100" alt="">
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $item->product_name }}</div>
                                            <div class="text-[10px] text-gray-400">পরিমাণ: {{ $item->quantity }} টি</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-gray-900">৳{{ number_format($item->total) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-3 border-t border-gray-200 flex justify-between items-center text-sm font-bold text-gray-900 mt-2">
                            <span>সর্বমোট প্রদেয় বিল:</span>
                            <span class="text-[#F48721] text-base">৳{{ number_format($order->total) }}</span>
                        </div>
                    </div>

                    <!-- Delivery Address Details -->
                    <div class="text-xs text-gray-600">
                        <span class="font-bold">ডেলিভারি ঠিকানা:</span> {{ $order->customer_address }}, {{ $order->customer_city }} (ফোন: {{ substr($order->customer_phone, 0, 3) . '****' . substr($order->customer_phone, -4) }})
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-2xl border border-gray-200">
                    <i class="fa-solid fa-magnifying-glass text-3xl mb-2 text-gray-300"></i>
                    <p class="text-sm font-semibold text-gray-600">কোনো অর্ডার পাওয়া যায়নি!</p>
                    <p class="text-xs text-gray-400 mt-1">অনুগ্রহ করে সঠিক অর্ডার নম্বর বা ফোন নম্বর লিখে পুনরায় সার্চ করুন।</p>
                </div>
            @endif
        @endif

    </div>

</div>
@endsection
