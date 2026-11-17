@extends('layouts.app')

@section('title', 'Amar Bazar | আমার বাজার - ১০০% খাঁটি ও নিরাপদ অর্গানিক খাদ্যপণ্য')

@section('styles')
<style>
    /* GB-style category slider */
    .gb-cat-track {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        scroll-behavior: smooth;
    }
    .gb-cat-track::-webkit-scrollbar { display: none; }
    .gb-cat-item {
        flex: 0 0 auto;
        width: 110px;
        text-align: center;
        cursor: pointer;
    }
    .gb-cat-img {
        width: 100px;
        height: 100px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        overflow: hidden;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .gb-cat-img:hover {
        border-color: #F48721;
        box-shadow: 0 2px 10px rgba(244,135,33,0.15);
    }
    .gb-cat-img img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }
    .gb-cat-label {
        font-size: 12px;
        color: #374151;
        font-weight: 500;
    }

    /* Product horizontal list (Top Selling style) */
    .gb-product-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .gb-product-h {
        display: flex;
        gap: 12px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        align-items: center;
        transition: box-shadow 0.2s;
    }
    .gb-product-h:hover { box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
    .gb-product-h-img {
        width: 110px;
        height: 110px;
        flex-shrink: 0;
        object-fit: contain;
        border-radius: 6px;
        background: #f9fafb;
    }
    .gb-product-h-info { flex: 1; min-width: 0; }
    .gb-product-h-name { font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 4px; }
    .gb-product-h-price { font-size: 15px; font-weight: 700; color: #F48721; }
    .gb-product-h-old { font-size: 12px; color: #9ca3af; text-decoration: line-through; margin-left: 6px; }
    .gb-product-h-save { display: inline-block; background: #dcfce7; color: #16a34a; font-size: 11px; font-weight: 600; padding: 1px 7px; border-radius: 4px; margin-top: 4px; }

    /* Section header GB style */
    .gb-section-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }
    .gb-section-link {
        font-size: 13px;
        color: #F48721;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .gb-section-link:hover { text-decoration: underline; }

    /* Hero banner GB style */
    .gb-hero {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 0;
        border-radius: 0;
        overflow: hidden;
    }
    @media (max-width: 767px) {
        .gb-hero { grid-template-columns: 1fr; }
        .gb-hero-side { display: none; }
        .gb-product-row { grid-template-columns: 1fr; }
        .gb-cat-item { width: 90px; }
    }

    /* Orange underline accent */
    .gb-underline {
        width: 40px; height: 3px;
        background: #F48721;
        border-radius: 2px;
        margin-top: 6px;
        margin-bottom: 16px;
    }

    /* Scroll arrow buttons */
    .gb-scroll-btn {
        width: 32px; height: 32px;
        background: #F48721;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: background 0.2s;
    }
    .gb-scroll-btn:hover { background: #e07518; }

    /* Swiper custom */
    .swiper-button-next, .swiper-button-prev {
        color: #F48721 !important;
        background: rgba(255,255,255,0.9);
        width: 36px !important;
        height: 36px !important;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 14px !important;
        font-weight: 900;
    }
    .swiper-pagination-bullet-active { background: #F48721 !important; }
</style>
@endsection

@section('content')

<!-- =================== HERO BANNER SLIDER =================== -->
<div class="w-full bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="swiper heroSwiper" style="height: 320px; max-height: 40vw; min-height: 200px;">
            <div class="swiper-wrapper">

                <!-- Slide 1 -->
                <div class="swiper-slide relative overflow-hidden" style="background: linear-gradient(135deg, #fff8f0 0%, #fff3e0 100%);">
                    <div class="flex items-center h-full px-6 sm:px-16 gap-8">
                        <div class="flex-1 py-8">
                            <span class="inline-block bg-[#F48721] text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded mb-3">
                                ১০০% খাঁটি ও প্রাকৃতিক
                            </span>
                            <h1 class="text-2xl sm:text-4xl font-black text-gray-900 leading-tight mb-3">
                                সুন্দরবনের খাঁটি<br>
                                <span class="text-[#F48721]">চাকের কাঁচা মধু</span>
                            </h1>
                            <p class="text-sm text-gray-500 mb-5 max-w-sm">গভীর অরণ্য থেকে সরাসরি সংগৃহীত, কোনো কেমিক্যাল ছাড়া।</p>
                            <div class="flex gap-3">
                                <a href="{{ route('category.show', 'pure-honey') }}" 
                                   class="bg-[#F48721] hover:bg-[#e07518] text-white font-bold px-5 py-2.5 rounded text-sm transition">
                                    অর্ডার করুন
                                </a>
                                <a href="{{ route('category.show', 'pure-honey') }}" 
                                   class="border border-[#F48721] text-[#F48721] hover:bg-orange-50 font-bold px-5 py-2.5 rounded text-sm transition">
                                    সব মধু দেখুন
                                </a>
                            </div>
                        </div>
                        <div class="hidden sm:block w-56 h-56 flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=400&auto=format&fit=crop&q=80" 
                                 alt="মধু" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide relative overflow-hidden" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                    <div class="flex items-center h-full px-6 sm:px-16 gap-8">
                        <div class="flex-1 py-8">
                            <span class="inline-block bg-green-600 text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded mb-3">
                                ঐতিহ্যবাহী স্বাদ
                            </span>
                            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 leading-tight mb-3">
                                দেশি গরুর খাঁটি<br>
                                <span class="text-[#F48721]">গাওয়া ঘি ও সরিষার তেল</span>
                            </h2>
                            <p class="text-sm text-gray-500 mb-5 max-w-sm">কাঠের ঘানিতে ভাঙা খাঁটি সরিষার তেল এবং স্বাস্থ্যসম্মত গাওয়া ঘি।</p>
                            <a href="{{ route('category.show', 'oil-and-ghee') }}" 
                               class="inline-block bg-[#F48721] hover:bg-[#e07518] text-white font-bold px-5 py-2.5 rounded text-sm transition">
                                কিনুন এখনই
                            </a>
                        </div>
                        <div class="hidden sm:block w-56 h-56 flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400&auto=format&fit=crop&q=80" 
                                 alt="তেল ও ঘি" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide relative overflow-hidden" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    <div class="flex items-center h-full px-6 sm:px-16 gap-8">
                        <div class="flex-1 py-8">
                            <span class="inline-block bg-amber-700 text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded mb-3">
                                মদিনার আসল স্বাদ
                            </span>
                            <h2 class="text-2xl sm:text-4xl font-black text-gray-900 leading-tight mb-3">
                                প্রিমিয়াম আজওয়া ও<br>
                                <span class="text-[#F48721]">মেদজুল খেজুর</span>
                            </h2>
                            <p class="text-sm text-gray-500 mb-5 max-w-sm">পুষ্টি ও শক্তির ভরপুর উৎস। পরিবারের জন্য বাছাইকৃত প্রিমিয়াম ড্রাই ফ্রুটস।</p>
                            <a href="{{ route('category.show', 'premium-dates') }}" 
                               class="inline-block bg-[#F48721] hover:bg-[#e07518] text-white font-bold px-5 py-2.5 rounded text-sm transition">
                                অর্ডার করুন
                            </a>
                        </div>
                        <div class="hidden sm:block w-56 h-56 flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1596704017254-9b121068fb31?w=400&auto=format&fit=crop&q=80" 
                                 alt="খেজুর" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>

<!-- =================== TRUST BADGES =================== -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 divide-x divide-gray-100">
            <div class="flex items-center gap-2.5 px-3">
                <i class="fa-solid fa-certificate text-[#F48721] text-xl flex-shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-gray-800">১০০% খাঁটি পণ্য</div>
                    <div class="text-[11px] text-gray-400">সম্পূর্ণ প্রাকৃতিক</div>
                </div>
            </div>
            <div class="flex items-center gap-2.5 px-3">
                <i class="fa-solid fa-truck-fast text-[#F48721] text-xl flex-shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-gray-800">দ্রুত ডেলিভারি</div>
                    <div class="text-[11px] text-gray-400">সারা বাংলাদেশে</div>
                </div>
            </div>
            <div class="flex items-center gap-2.5 px-3">
                <i class="fa-solid fa-hand-holding-dollar text-[#F48721] text-xl flex-shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-gray-800">ক্যাশ অন ডেলিভারি</div>
                    <div class="text-[11px] text-gray-400">পণ্য পেয়ে মূল্য পরিশোধ</div>
                </div>
            </div>
            <div class="flex items-center gap-2.5 px-3">
                <i class="fa-solid fa-rotate-left text-[#F48721] text-xl flex-shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-gray-800">রিটার্ন গ্যারান্টি</div>
                    <div class="text-[11px] text-gray-400">সহজে রিটার্ন করুন</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================== FEATURED CATEGORIES =================== -->
<section class="bg-white py-6 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-1">
            <h2 class="gb-section-title">Featured Categories</h2>
            <div class="flex gap-2">
                <button onclick="scrollCat(-1)" class="gb-scroll-btn"><i class="fa-solid fa-chevron-left"></i></button>
                <button onclick="scrollCat(1)" class="gb-scroll-btn"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="gb-underline"></div>

        <!-- Scrollable category row -->
        <div class="gb-cat-track" id="catTrack">
            @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->slug) }}" class="gb-cat-item group">
                <div class="gb-cat-img">
                    <img src="{{ $cat->image }}" alt="{{ $cat->name }}" 
                         onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                </div>
                <div class="gb-cat-label group-hover:text-[#F48721] transition">{{ $cat->name }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- =================== TOP SELLING PRODUCTS =================== -->
<section class="bg-[#f8f8f8] py-7">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-1">
            <h2 class="gb-section-title">Top Selling Products</h2>
            <a href="{{ route('search') }}" class="gb-section-link">
                VIEW ALL ITEMS <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>
        <div class="gb-underline"></div>

        <!-- Horizontal product list (GB style: 2 columns, image + info) -->
        <div class="relative">
            <div class="swiper topSellingSwiper">
                <div class="swiper-wrapper">
                    @foreach($topSelling as $product)
                    <div class="swiper-slide">
                        <div class="gb-product-h">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="gb-product-h-img">
                            </a>
                            <div class="gb-product-h-info">
                                @if($product->is_top_selling)
                                    <span class="inline-block border border-[#F48721] text-[#F48721] text-[10px] font-bold px-2 py-0.5 rounded mb-1">★ Best Selling</span>
                                @endif
                                <a href="{{ route('product.show', $product->slug) }}" class="gb-product-h-name hover:text-[#F48721] transition block mb-1">
                                    {{ $product->name }}
                                </a>
                                <div class="flex items-baseline">
                                    <span class="gb-product-h-price">৳{{ number_format($product->effective_price) }}.00</span>
                                    @if($product->sale_price && $product->regular_price > $product->sale_price)
                                        <span class="gb-product-h-old">৳{{ number_format($product->regular_price) }}.00</span>
                                    @endif
                                </div>
                                @if($product->discount_percent > 0)
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="bg-[#10b981] text-white text-[10px] font-black px-2 py-0.5 rounded">Save {{ $product->discount_percent }}%</span>
                                        <span class="gb-product-h-save">Save ৳{{ number_format($product->saved_amount) }}</span>
                                    </div>
                                @endif
                                <div class="flex gap-2 mt-3">
                                    <button onclick="addToCartAjax({{ $product->id }})"
                                            class="border border-[#F48721] text-[#F48721] hover:bg-[#F48721] hover:text-white text-xs font-semibold px-3 py-1.5 rounded transition flex items-center gap-1">
                                        <i class="fa-solid fa-cart-shopping text-[10px]"></i> Add To Cart
                                    </button>
                                    <a href="{{ route('checkout') }}?buy_now={{ $product->id }}"
                                       class="bg-[#F48721] hover:bg-[#e07518] text-white text-xs font-semibold px-3 py-1.5 rounded transition flex items-center gap-1">
                                        <i class="fa-solid fa-bolt text-[10px]"></i> Buy now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next top-selling-next"></div>
                <div class="swiper-button-prev top-selling-prev"></div>
            </div>
        </div>
    </div>
</section>

<!-- =================== ALL NATURAL HONEY =================== -->
<section class="bg-white py-7 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-1">
            <h2 class="gb-section-title">খাঁটি মধু সম্ভার</h2>
            <a href="{{ route('category.show', 'pure-honey') }}" class="gb-section-link">
                VIEW ALL ITEMS <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>
        <div class="gb-underline"></div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($honeyProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- =================== OIL & GHEE =================== -->
<section class="bg-[#f8f8f8] py-7 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-1">
            <h2 class="gb-section-title">ঘানি ভাঙা তেল ও গাওয়া ঘি</h2>
            <a href="{{ route('category.show', 'oil-and-ghee') }}" class="gb-section-link">
                VIEW ALL ITEMS <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>
        <div class="gb-underline"></div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($oilGheeProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- =================== PROMO BANNER =================== -->
<section class="bg-white py-7 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="rounded-xl overflow-hidden" style="background: linear-gradient(135deg, #1a3a28 0%, #0e5436 100%);">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-8 md:p-12">
                <div class="text-white max-w-lg">
                    <span class="inline-block bg-[#F48721] text-white text-xs font-black uppercase tracking-wider px-3 py-1 rounded mb-4">
                        স্পেশাল কম্বো অফার
                    </span>
                    <h3 class="text-2xl md:text-3xl font-extrabold mb-3 leading-tight">
                        সুন্দরবনের খাঁটি মধু<br>+ স্পেশাল হানি নাট
                    </h3>
                    <p class="text-green-200 text-sm mb-6">রোগ প্রতিরোধ ক্ষমতা ও এনার্জি বৃদ্ধির জন্য সেরা স্বাস্থ্যকর কম্বো।</p>
                    <a href="{{ route('checkout') }}" 
                       class="inline-flex items-center gap-2 bg-[#F48721] hover:bg-[#e07518] text-white font-bold px-6 py-3 rounded transition">
                        <i class="fa-solid fa-bolt text-sm"></i>
                        সরাসরি অর্ডার করুন
                    </a>
                </div>
                <div class="w-52 h-52 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1508061253366-f7da158b6d46?w=400&auto=format&fit=crop&q=80" 
                         alt="Combo" class="w-full h-full object-cover rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =================== PREMIUM DATES =================== -->
<section class="bg-[#f8f8f8] py-7 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-1">
            <h2 class="gb-section-title">প্রিমিয়াম খেজুর কালেকশন</h2>
            <a href="{{ route('category.show', 'premium-dates') }}" class="gb-section-link">
                VIEW ALL ITEMS <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>
        <div class="gb-underline"></div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($datesProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- =================== WHY CHOOSE US =================== -->
<section class="bg-white py-10 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-xl font-bold text-gray-900 mb-1">কেন 'আমার বাজার' বেছে নেবেন?</h2>
        <div class="gb-underline mx-auto"></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
            <div class="p-6 rounded-xl border border-gray-100 hover:border-[#F48721]/30 hover:shadow-sm transition">
                <div class="w-14 h-14 rounded-full bg-orange-50 text-[#F48721] flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-2">১০০% বিশুদ্ধতার অঙ্গীকার</h3>
                <p class="text-sm text-gray-400">কোনো কেমিক্যাল, কৃত্রিম রং বা প্রিজারভেটিভ ছাড়া সম্পূর্ণ প্রাকৃতিক খাদ্যপণ্য।</p>
            </div>
            <div class="p-6 rounded-xl border border-gray-100 hover:border-[#F48721]/30 hover:shadow-sm transition">
                <div class="w-14 h-14 rounded-full bg-orange-50 text-[#F48721] flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-2">নিরাপদ প্রিমিয়াম প্যাকেজিং</h3>
                <p class="text-sm text-gray-400">ফুড-গ্রেড ও এয়ারটাইট প্যাকেজিংয়ে পণ্যের সতেজতা ও পুষ্টিগুণ নিশ্চিত।</p>
            </div>
            <div class="p-6 rounded-xl border border-gray-100 hover:border-[#F48721]/30 hover:shadow-sm transition">
                <div class="w-14 h-14 rounded-full bg-orange-50 text-[#F48721] flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-2">২৪/৭ কাস্টমার সাপোর্ট</h3>
                <p class="text-sm text-gray-400">যেকোনো জিজ্ঞাসায় হটলাইন ও হোয়াটসঅ্যাপে সবসময় সহায়তা পাবেন।</p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Hero Swiper
    new Swiper('.heroSwiper', {
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    });

    // Top Selling Swiper (2 per view)
    new Swiper('.topSellingSwiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: false,
        navigation: { nextEl: '.top-selling-next', prevEl: '.top-selling-prev' },
        breakpoints: {
            640: { slidesPerView: 2 },
        }
    });

    // Category scroll
    function scrollCat(dir) {
        const track = document.getElementById('catTrack');
        track.scrollLeft += dir * 300;
    }
</script>
@endsection
