@extends('layouts.app')

@section('title', 'Your Order is Confirmed! - Amar Bazar | আমার বাজার')

@section('content')
<!-- Canvas Confetti CDN for celebration animation -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<style>
    @keyframes checkmarkRipple {
        0% { transform: scale(0.8); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 0.2; }
        100% { transform: scale(1.4); opacity: 0; }
    }
    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up {
        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .ripple-effect {
        animation: checkmarkRipple 2s infinite ease-out;
    }
</style>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 animate-slide-up">
    
    <!-- Celebratory Success Banner -->
    <div class="bg-white rounded-3xl border border-emerald-200 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden mb-8">
        
        <!-- Glowing background gradient -->
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-emerald-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-amber-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <!-- Animated Pulsing Green Checkmark Icon -->
        <div class="relative w-24 h-24 mx-auto mb-5 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full bg-emerald-400 opacity-25 ripple-effect"></div>
            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-emerald-600 to-green-500 text-white flex items-center justify-center text-4xl shadow-lg shadow-emerald-500/30 transform hover:scale-105 transition">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>

        <!-- Super Prominent Green Heading -->
        <span class="text-xs font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 px-4 py-1.5 rounded-full inline-block mb-3 border border-emerald-200 shadow-sm">
            ✓ ORDER PLACED SUCCESSFULLY
        </span>

        <h1 class="text-3xl sm:text-5xl font-black text-emerald-800 tracking-tight leading-tight mb-2">
            Your Order is Confirmed!
        </h1>
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-3">
            আপনার অর্ডারটি সফলভাবে কনফার্ম হয়েছে!
        </h2>
        
        <p class="text-slate-600 text-sm sm:text-base max-w-lg mx-auto mb-6">
            ধন্যবাদ <strong>{{ $order->customer_name }}</strong>! আমাদের প্রতিনিধি খুব শীঘ্রই আপনার সাথে যোগাযোগ করবেন।
        </p>

        <!-- Order Number Badge -->
        <div class="inline-flex items-center gap-2.5 bg-slate-50 border border-slate-200 px-6 py-3 rounded-2xl shadow-inner">
            <span class="text-xs text-slate-500 font-semibold uppercase">অর্ডার ট্র্যাকিং নম্বর:</span>
            <span class="text-base sm:text-lg font-black text-emerald-800 font-mono tracking-wider">{{ $order->order_number }}</span>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="https://wa.me/8801938860291?text={{ urlencode('আসসালামু আলাইকুম, আমি আমার বাজার থেকে অর্ডার করেছি। আমার অর্ডার নম্বর: ' . $order->order_number . ' | সর্বমোট বিল: ৳' . number_format($order->total)) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3.5 rounded-2xl text-sm transition shadow-lg flex items-center gap-2 animate-pulse">
                <i class="fa-brands fa-whatsapp text-xl"></i>
                <span>হোয়াটসঅ্যাপে সরাসরি নিশ্চিত করুন</span>
            </a>
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-6 py-3.5 rounded-2xl text-sm transition">
                আরও কেনাকাটা করুন
            </a>
        </div>
    </div>

    <!-- What Was Ordered & Price Card (User specifically asked for this) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden mb-8">
        
        <div class="p-6 bg-emerald-50/60 border-b border-emerald-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-basket-shopping text-emerald-700 text-xl"></i>
                <h3 class="font-extrabold text-slate-900 text-base sm:text-lg">আপনি যা যা অর্ডার করেছেন</h3>
            </div>
            <span class="text-xs font-bold bg-white text-emerald-800 border border-emerald-200 px-3 py-1 rounded-full">
                {{ $order->items->count() }}টি আইটেম
            </span>
        </div>

        <div class="p-6 sm:p-8">
            
            <!-- Ordered Products List with Images & Highlighted Prices -->
            <div class="divide-y divide-slate-100 mb-6">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-2xl border border-slate-200 shadow-sm flex-shrink-0">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold flex-shrink-0">
                                    <i class="fa-solid fa-box"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">{{ $item->product_name }}</h4>
                                <div class="text-xs text-slate-500 mt-0.5">পরিমাণ: <strong class="text-slate-800">{{ $item->quantity }} পিস</strong> (প্রতি পিস ৳{{ number_format($item->price) }})</div>
                            </div>
                        </div>

                        <!-- Item Total Price (Highlighted Green) -->
                        <div class="text-right">
                            <span class="text-base sm:text-lg font-black text-emerald-800">৳{{ number_format($item->total) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Grand Total Price Highlight Box -->
            <div class="p-6 bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-100 rounded-2xl border-2 border-emerald-300 space-y-2.5">
                <div class="flex justify-between text-xs sm:text-sm text-slate-600">
                    <span>পণ্যের মোট দাম:</span>
                    <span class="font-bold text-slate-900">৳{{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-xs sm:text-sm text-slate-600">
                    <span>ডেলিভারি চার্জ ({{ $order->delivery_zone === 'inside_dhaka' ? 'ঢাকার ভেতরে' : 'ঢাকার বাইরে' }}):</span>
                    <span class="font-bold text-slate-900">৳{{ number_format($order->delivery_charge) }}</span>
                </div>
                <div class="pt-3 border-t border-emerald-200 flex justify-between items-center text-base sm:text-xl font-black text-slate-900">
                    <span class="text-emerald-900">সর্বমোট প্রদেয় বিল:</span>
                    <span class="text-2xl sm:text-3xl font-black text-emerald-800 tracking-tight">৳{{ number_format($order->total) }}</span>
                </div>
                <div class="text-[11px] text-emerald-700 font-semibold text-right">
                    * ক্যাশ অন ডেলিভারি: পণ্য হাতে পেয়ে টাকা পরিশোধ করবেন
                </div>
            </div>

            <!-- Customer & Delivery Address Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-100 text-xs text-slate-600">
                <div>
                    <strong class="text-slate-800 text-sm block mb-1">গ্রাহকের তথ্য:</strong>
                    <div>নাম: <span class="font-bold text-slate-800">{{ $order->customer_name }}</span></div>
                    <div>মোবাইল: <span class="font-mono font-bold text-slate-800">{{ $order->customer_phone }}</span></div>
                </div>
                <div>
                    <strong class="text-slate-800 text-sm block mb-1">ডেলিভারি ঠিকানা:</strong>
                    <div class="leading-relaxed">{{ $order->customer_address }}</div>
                    @if($order->notes)
                        <div class="mt-1 text-amber-800"><strong>নোট:</strong> {{ $order->notes }}</div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    // Trigger colorful celebration confetti automatically on page load!
    window.addEventListener('DOMContentLoaded', () => {
        if (typeof confetti === 'function') {
            // First burst
            confetti({
                particleCount: 80,
                spread: 70,
                origin: { y: 0.6 }
            });
            // Second celebratory burst after 300ms
            setTimeout(() => {
                confetti({
                    particleCount: 60,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 }
                });
                confetti({
                    particleCount: 60,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 }
                });
            }, 300);
        }
    });
</script>
@endsection
