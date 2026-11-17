<div class="gb-card bg-white rounded-2xl border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg flex flex-col group p-2.5">
    
    <!-- Product Image & Badges -->
    <div class="relative overflow-hidden bg-gray-50 rounded-xl" style="aspect-ratio: 1/1;">
        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                 class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300">
        </a>

        <!-- Discount Percentage Badge (Top-Left) -->
        @if($product->discount_percent > 0)
            <span class="absolute top-2 left-2 bg-[#10b981] text-white text-[11px] font-black px-2.5 py-0.5 rounded-md shadow-xs">
                Save {{ $product->discount_percent }}%
            </span>
        @endif

        <!-- Best Selling Badge (Top-Right) -->
        @if($product->is_top_selling)
            <span class="absolute top-2 right-2 bg-[#F48721] text-white text-[11px] font-black px-2.5 py-0.5 rounded-md shadow-xs">
                Best Selling
            </span>
        @endif

        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-white/80 backdrop-blur-xs flex items-center justify-center">
                <span class="text-red-600 font-black text-xs border-2 border-red-600 px-3 py-1 rounded-lg bg-white shadow-xs">স্টক আউট</span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="pt-3 px-1 flex flex-col flex-grow">
        
        <!-- Name -->
        <a href="{{ route('product.show', $product->slug) }}" 
           class="font-black text-gray-900 hover:text-[#F48721] transition line-clamp-2 text-sm leading-snug mb-1.5"
           title="{{ $product->name }}">
            {{ $product->name }}
        </a>

        <!-- Subtitle / Unit Pack -->
        @if($product->subtitle)
            <div class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                <span>🍃</span>
                <span>{{ $product->subtitle }}</span>
            </div>
        @else
            <div class="text-xs text-gray-400 mb-2">স্ট্যান্ডার্ড প্যাক</div>
        @endif

        <!-- Price: Effective Price (Orange) + Regular Price (Crossed-out) -->
        <div class="flex items-baseline gap-2 mb-2">
            <span class="text-base sm:text-lg font-black text-[#F48721]">
                ৳{{ number_format($product->effective_price) }}.00
            </span>
            @if($product->sale_price && $product->regular_price > $product->sale_price)
                <span class="text-xs text-gray-400 line-through font-semibold">
                    ৳{{ number_format($product->regular_price) }}.00
                </span>
            @endif
        </div>

        <!-- Save Amount Badge (Light Green) -->
        @if($product->discount_percent > 0)
            <div class="mb-3">
                <span class="inline-block bg-[#dcfce7] text-[#16a34a] text-xs font-black px-2.5 py-0.5 rounded-md">
                    Save ৳{{ number_format($product->saved_amount) }}
                </span>
            </div>
        @endif

        <!-- Action Buttons (Add To Cart & Buy now) -->
        <div class="mt-auto grid grid-cols-2 gap-2 pt-1">
            <!-- Add To Cart -->
            <button type="button" 
                    onclick="addToCartAjax({{ $product->id }})" 
                    class="border-2 border-[#F48721] bg-white text-[#F48721] hover:bg-[#F48721] hover:text-white text-xs font-bold py-2 px-1 rounded-xl transition duration-200 flex items-center justify-center gap-1 active:scale-95 shadow-2xs">
                <i class="fa-solid fa-cart-shopping text-[11px]"></i>
                <span>Add To Cart</span>
            </button>

            <!-- Buy Now -->
            <a href="{{ route('checkout') }}?buy_now={{ $product->id }}" 
               class="bg-[#F48721] hover:bg-[#e07518] text-white text-xs font-bold py-2 px-1 rounded-xl transition duration-200 flex items-center justify-center gap-1 active:scale-95 shadow-xs">
                <i class="fa-solid fa-bolt text-[11px]"></i>
                <span>Buy now</span>
            </a>
        </div>

    </div>

</div>
