@extends('layouts.app')

@section('title', $product->name . ' - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary-800">হোম</a>
        <span class="mx-2">/</span>
        <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-primary-800">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-semibold truncate">{{ $product->name }}</span>
    </nav>

    <!-- Product Details Card -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <!-- Left: Product Image -->
            <div>
                <div class="relative bg-slate-100 rounded-2xl overflow-hidden aspect-square border border-slate-200">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @if($product->discount_percent > 0)
                        <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-lg">
                            -{{ $product->discount_percent }}% ছাড়
                        </span>
                    @endif
                </div>

                <!-- Trust Guarantee Icons under image -->
                <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                        <i class="fa-solid fa-leaf text-primary-800 text-lg mb-1 block"></i>
                        <span class="font-medium text-slate-700">১০০% প্রাকৃতিক</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                        <i class="fa-solid fa-truck text-blue-600 text-lg mb-1 block"></i>
                        <span class="font-medium text-slate-700">হোম ডেলিভারি</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                        <i class="fa-solid fa-hand-holding-dollar text-amber-600 text-lg mb-1 block"></i>
                        <span class="font-medium text-slate-700">ক্যাশ অন ডেলিভারি</span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="flex flex-col">
                <span class="text-xs font-bold uppercase tracking-wider text-primary-800 bg-emerald-50 px-3 py-1 rounded-full w-fit mb-2">
                    {{ $product->category->name }}
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-snug mb-2">
                    {{ $product->name }}
                </h1>

                <!-- Ratings & Stock -->
                <div class="flex items-center gap-4 text-sm mb-4">
                    <div class="flex items-center text-amber-500 font-bold">
                        <i class="fa-solid fa-star mr-1"></i>
                        <span>{{ $product->rating }}</span>
                        <span class="text-slate-400 font-normal ml-1">({{ $product->reviews_count }}টি রিভিউ)</span>
                    </div>
                    <span class="text-slate-300">|</span>
                    <span class="text-emerald-700 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-xs"></i> ইন স্টক (স্টকে আছে)
                    </span>
                </div>

                <!-- Price Section -->
                <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100 mb-6 flex items-baseline gap-3">
                    <span class="text-3xl font-black text-primary-800">৳{{ number_format($product->effective_price) }}</span>
                    @if($product->sale_price && $product->regular_price > $product->sale_price)
                        <span class="text-base text-slate-400 line-through">৳{{ number_format($product->regular_price) }}</span>
                        <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">
                            ৳{{ number_format($product->regular_price - $product->sale_price) }} সাশ্রয়
                        </span>
                    @endif
                </div>

                <!-- Weight / Unit -->
                <div class="mb-4 text-sm">
                    <span class="text-slate-500">পরিমাণ:</span>
                    <span class="font-bold text-slate-900 ml-1">{{ $product->subtitle ?? 'স্ট্যান্ডার্ড প্যাকেজ' }}</span>
                </div>

                <!-- Short Description -->
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    {{ $product->short_description }}
                </p>

                <!-- Order Action Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center gap-4">
                        <label class="text-sm font-semibold text-slate-700">পরিমাণ (সংখ্যা):</label>
                        <div class="flex items-center border-2 border-slate-200 rounded-xl overflow-hidden bg-white">
                            <button type="button" onclick="decrementQty()" class="px-3.5 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition">-</button>
                            <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="50" class="w-14 text-center border-x-2 border-slate-200 py-1.5 text-sm font-bold focus:outline-none">
                            <button type="button" onclick="incrementQty()" class="px-3.5 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition">+</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <!-- Add to Cart Button (Instant Drawer Open without Refresh) -->
                        <button type="button" onclick="addToCartAjax({{ $product->id }}, parseInt(document.getElementById('qtyInput').value))" class="w-full bg-emerald-50 hover:bg-emerald-100 text-primary-800 border-2 border-primary-800 font-bold py-3.5 px-6 rounded-2xl transition flex items-center justify-center gap-2 text-sm sm:text-base">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>কার্ট এ যোগ করুন</span>
                        </button>

                        <!-- Direct Buy Now Button -->
                        <button type="submit" name="redirect_to_checkout" value="1" class="w-full bg-primary-800 hover:bg-primary-900 text-white font-bold py-3.5 px-6 rounded-2xl transition shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                            <i class="fa-solid fa-bolt text-amber-400"></i>
                            <span>সরাসরি অর্ডার করুন</span>
                        </button>
                    </div>
                </form>

                <!-- Phone Order Box -->
                <div class="mt-6 p-4 rounded-2xl bg-amber-50/70 border border-amber-200 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center text-lg">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="text-xs text-amber-900 font-semibold">ফোনে সরাসরি অর্ডার করতে কল করুন</div>
                            <a href="tel:+8801938860291" class="text-base font-extrabold text-amber-950 hover:underline">+880 1938-860291</a>
                        </div>
                    </div>
                    <a href="https://wa.me/8801938860291?text=আমি {{ urlencode($product->name) }} কিনতে চাই" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>হোয়াটসঅ্যাপ</span>
                    </a>
                </div>

            </div>

        </div>

        <!-- Long Description Section -->
        <div class="mt-12 pt-8 border-t border-slate-200">
            <h3 class="text-xl font-bold text-slate-900 mb-4 border-l-4 border-primary-800 pl-3">পণ্যের বিস্তারিত বিবরণ</h3>
            <div class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed">
                {{ $product->description }}
            </div>
        </div>

    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 border-b-2 border-slate-200 pb-3">সম্পর্কিত আরও পণ্য</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relProduct)
                    @include('partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function incrementQty() {
        const input = document.getElementById('qtyInput');
        input.value = parseInt(input.value) + 1;
    }
    function decrementQty() {
        const input = document.getElementById('qtyInput');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endsection
