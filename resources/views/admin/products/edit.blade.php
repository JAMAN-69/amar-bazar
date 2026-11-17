@extends('layouts.admin')

@section('title', 'প্রোডাক্ট এডিট: ' . $product->name . ' - অ্যাডমিন')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">প্রোডাক্ট তথ্য, ছবি ও স্টক এডিট</h1>
            <p class="text-xs text-slate-500 mt-1">প্রোডাক্ট আইডি: #{{ $product->id }} | বিক্রি হয়েছে: {{ $product->total_sales }}টি</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-600 hover:text-primary-800 border px-3 py-1.5 rounded-xl bg-white">
            &larr; তালিকায় ফিরুন
        </a>
    </div>

    <!-- enctype="multipart/form-data" for file upload -->
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <!-- Name -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">প্রোডাক্টের নাম <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <!-- Category Selection & Quick Add -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">ক্যাটাগরি <span class="text-red-500">*</span></label>
                    <a href="{{ route('admin.categories.index') }}" target="_blank" class="text-[11px] font-bold text-[#F48721] hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus-circle"></i> নতুন ক্যাটাগরি তৈরি করুন
                    </a>
                </div>
                <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">ক্যাটাগরি পরিবর্তন করলে ওয়েবসাইটে সেই ক্যাটাগরিতে পণ্যটি চলে যাবে।</p>
            </div>

            <!-- Subtitle / Unit -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">পরিমাণ / ওজন (প্যাক সাইজ)</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">
            </div>

            <!-- Pricing & Discount Intelligence Box -->
            <div class="sm:col-span-2 p-5 bg-gradient-to-br from-amber-50/60 via-orange-50/40 to-emerald-50/30 rounded-2xl border-2 border-orange-200 shadow-xs">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-3 pb-2 border-b border-orange-200/80">
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-tags text-[#F48721] text-base"></i>
                        <span>মার্কেট প্রাইজ ও ডিসকাউন্ট অফার (Pricing & Discount)</span>
                    </label>
                    <span class="text-[11px] font-semibold text-[#F48721] bg-white px-2.5 py-0.5 rounded-full border border-orange-200">
                        স্বয়ংক্রিয় হিসাব ও লাইভ প্রিভিউ
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- 1. Market Price (মার্কেট বা রেগুলার মূল্য) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            মার্কেট / রেগুলার প্রাইজ (৳) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 font-bold">৳</span>
                            <input type="number" step="0.01" id="regular_price" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" required placeholder="যেমন: 1250" oninput="calcDiscountFromPrice()" class="w-full pl-8 pr-3 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-900 focus:border-[#F48721] focus:ring-2 focus:ring-[#F48721]/20 transition">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">পণ্যটির আসল বা মার্কেট মূল্য</p>
                    </div>

                    <!-- 2. Discount Percentage (% ছাড়) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            ডিসকাউন্ট (% ছাড়)
                        </label>
                        <div class="relative">
                            <input type="number" step="0.1" min="0" max="99" id="discount_percent" name="discount_percent" value="{{ $product->discount_percent > 0 ? $product->discount_percent : '' }}" placeholder="যেমন: 16" oninput="calcPriceFromDiscount()" class="w-full pl-3 pr-8 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-emerald-700 focus:border-[#F48721] focus:ring-2 focus:ring-[#F48721]/20 transition">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 font-bold">%</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">কতো পার্সেন্ট ছাড় দিচ্ছেন (যেমন ১৬%)</p>
                    </div>

                    <!-- 3. Final Sale / Discount Price (অফার বিক্রয় মূল্য) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            ডিসকাউন্ট অফার মূল্য (৳)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 font-bold">৳</span>
                            <input type="number" step="0.01" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="যেমন: 1050" oninput="calcDiscountFromPrice()" class="w-full pl-8 pr-3 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-[#F48721] focus:border-[#F48721] focus:ring-2 focus:ring-[#F48721]/20 transition">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">ছাড়ের পর কাস্টমার যে মূল্যে কিনবে</p>
                    </div>
                </div>

                <!-- Live Calculated Summary Banner matching public view -->
                <div id="discountSummaryBox" class="mt-4 p-3 bg-white rounded-xl border border-orange-200/90 flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <span id="previewDiscountBadge" class="bg-green-500 text-white text-[11px] font-bold px-2.5 py-0.5 rounded shadow-xs">
                            Save {{ $product->discount_percent }}%
                        </span>
                        <div class="font-medium text-slate-700">
                            মার্কেট: <span class="line-through text-slate-400">৳<span id="previewRegularPrice">{{ number_format($product->regular_price) }}</span></span> &rarr;
                            বিক্রয় মূল্য: <strong class="text-[#F48721] text-sm font-black">৳<span id="previewSalePrice">{{ number_format($product->effective_price) }}</span>.00</strong>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="previewSaveAmount" class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-0.5 rounded">
                            Save ৳{{ number_format($product->saved_amount) }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">কাস্টমার সেভ করবে</span>
                    </div>
                </div>
            </div>

            <!-- Stock -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">মজুদ স্টক সংখ্যা (পিস) <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm font-black text-emerald-800 bg-emerald-50/50">
                <p class="text-[11px] text-slate-400 mt-1">সরাসরি এখান থেকে স্টক আপডেট করতে পারবেন।</p>
            </div>

            <!-- Product Image Upload / Update -->
            <div class="sm:col-span-2 p-5 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300">
                <label class="block text-xs font-bold text-slate-800 uppercase mb-2">
                    <i class="fa-solid fa-cloud-arrow-up text-primary-800 text-base mr-1"></i>
                    প্রোডাক্টের নতুন ছবি পরিবর্তন করুন (কম্পিউটার থেকে)
                </label>
                
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="w-28 h-28 rounded-2xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center flex-shrink-0 relative shadow-sm">
                        <img id="imagePreview" src="{{ $product->image }}" alt="Current Image" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1 w-full space-y-2">
                        <input type="file" name="image_file" accept="image/*" onchange="previewImage(event)" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-800 file:text-white hover:file:bg-primary-900 cursor-pointer">
                        <p class="text-[11px] text-slate-500">নতুন ছবি সিলেক্ট না করলে আগের ছবিটিই বহাল থাকবে।</p>
                        
                        <div class="pt-2 text-[11px] text-slate-400">
                            অনলাইন ছবির লিংক আপডেট করতে চাইলে:
                            <input type="url" name="image_url" value="{{ $product->image }}" class="mt-1 w-full px-3 py-1.5 rounded-lg border text-xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Short description -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">সংক্ষিপ্ত বিবরণ</label>
                <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">
            </div>

            <!-- Long Description -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">বিস্তারিত বিবরণ ও উপকারিতা</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Flags -->
            <div class="sm:col-span-2 flex flex-wrap items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_available" value="1" {{ $product->is_available ? 'checked' : '' }} class="rounded text-primary-800 focus:ring-primary-800 h-4 w-4">
                    <span>সাইটে লাইভ থাকবে (Available)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_top_selling" value="1" {{ $product->is_top_selling ? 'checked' : '' }} class="rounded text-primary-800 focus:ring-primary-800 h-4 w-4">
                    <span>টপ সেলিং (বেস্টসেলার)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-primary-800 focus:ring-primary-800 h-4 w-4">
                    <span>ফিচার্ড প্রোডাক্ট</span>
                </label>
            </div>

        </div>

        <div class="pt-4 border-t flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border text-sm font-bold text-slate-600 hover:bg-slate-50">বাতিল</a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-primary-800 hover:bg-primary-900 text-white text-sm font-bold shadow-lg flex items-center gap-1.5">
                <i class="fa-solid fa-check"></i>
                <span>আপডেট সংরক্ষণ করুন</span>
            </button>
        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function calcDiscountFromPrice() {
        const reg = parseFloat(document.getElementById('regular_price').value) || 0;
        const saleVal = document.getElementById('sale_price').value.trim();
        const sale = parseFloat(saleVal);

        const percentInput = document.getElementById('discount_percent');
        const badge = document.getElementById('previewDiscountBadge');
        const saveBadge = document.getElementById('previewSaveAmount');
        const regPreview = document.getElementById('previewRegularPrice');
        const salePreview = document.getElementById('previewSalePrice');

        regPreview.innerText = reg ? Number(reg).toLocaleString() : '0';

        if (reg > 0 && !isNaN(sale) && sale > 0 && sale < reg) {
            const saved = Math.round(reg - sale);
            const percent = Math.round((saved / reg) * 100);
            percentInput.value = percent;
            salePreview.innerText = Number(sale).toLocaleString();
            badge.innerText = `Save ${percent}%`;
            saveBadge.innerText = `Save ৳${Number(saved).toLocaleString()}`;
        } else {
            percentInput.value = '';
            salePreview.innerText = reg ? Number(reg).toLocaleString() : '0';
            badge.innerText = 'Save 0%';
            saveBadge.innerText = 'Save ৳0';
        }
    }

    function calcPriceFromDiscount() {
        const reg = parseFloat(document.getElementById('regular_price').value) || 0;
        const percentVal = document.getElementById('discount_percent').value.trim();
        const percent = parseFloat(percentVal);

        const saleInput = document.getElementById('sale_price');
        const badge = document.getElementById('previewDiscountBadge');
        const saveBadge = document.getElementById('previewSaveAmount');
        const regPreview = document.getElementById('previewRegularPrice');
        const salePreview = document.getElementById('previewSalePrice');

        regPreview.innerText = reg ? Number(reg).toLocaleString() : '0';

        if (reg > 0 && !isNaN(percent) && percent > 0 && percent < 100) {
            const saved = Math.round((reg * percent) / 100);
            const sale = Math.round(reg - saved);
            saleInput.value = sale;
            salePreview.innerText = Number(sale).toLocaleString();
            badge.innerText = `Save ${Math.round(percent)}%`;
            saveBadge.innerText = `Save ৳${Number(saved).toLocaleString()}`;
        } else if (percentVal === '' || percent === 0) {
            saleInput.value = '';
            calcDiscountFromPrice();
        }
    }
</script>
@endsection
