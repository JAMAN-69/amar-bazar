@extends('layouts.admin')

@section('title', 'ক্যাটাগরি ম্যানেজমেন্ট - অ্যাডমিন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <span class="font-bold text-primary-800">অ্যাডমিন কন্ট্রোল</span>
                <span>/</span>
                <span>ক্যাটাগরি ম্যানেজমেন্ট</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                ক্যাটাগরি ও বিভাগ পরিচালনা
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                নতুন ক্যাটাগরি তৈরি করুন, ছবি দিন এবং ওয়েবসাইটে কোন প্রোডাক্ট কোথায় থাকবে তা নিয়ন্ত্রণ করুন।
            </p>
        </div>

        <button type="button" onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" 
                class="px-4 py-2.5 rounded-xl bg-[#F48721] hover:bg-[#e07518] text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>নতুন ক্যাটাগরি যোগ করুন</span>
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $cat)
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition">
            
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-200 p-2 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-full h-full object-contain">
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-1">
                        <h3 class="text-base font-bold text-slate-900 truncate" title="{{ $cat->name }}">{{ $cat->name }}</h3>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $cat->products_count }}টি পণ্য
                        </span>
                    </div>
                    <div class="text-xs text-slate-400 font-mono mt-0.5">/category/{{ $cat->slug }}</div>
                    @if($cat->description)
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $cat->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('category.show', $cat->slug) }}" target="_blank" class="text-xs font-semibold text-[#F48721] hover:underline flex items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> পাবলিক ভিউ
                </a>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.products.index') }}?category={{ $cat->id }}" class="text-xs font-bold text-slate-600 hover:text-primary-800 bg-slate-100 px-2.5 py-1 rounded-lg">
                        প্রোডাক্টসমূহ
                    </a>

                    @if($cat->products_count == 0)
                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত এই ক্যাটাগরি মুছে ফেলতে চান?');" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition" title="মুছে ফেলুন">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-[#F48721]"></i> নতুন ক্যাটাগরি তৈরি করুন
            </h3>
            <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ক্যাটাগরির নাম <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="যেমন: অর্গানিক চা ও কফি, ড্রাই ফ্রুটস" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ছবি আপলোড করুন (বা ইমেজ লিংক)</label>
                <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-[#F48721] hover:file:bg-orange-100">
                <div class="text-[11px] text-slate-400 mt-1">ইমেজ না দিলে স্বয়ংক্রিয়ভাবে ডিফল্ট সুন্দর অর্গানিক ছবি সেট হবে।</div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)</label>
                <textarea name="description" rows="2" placeholder="ক্যাটাগরির পণ্যের বিবরণ..." class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm"></textarea>
            </div>

            <div class="pt-3 border-t flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="px-4 py-2 rounded-xl border text-xs font-bold text-slate-600 hover:bg-slate-50">বাতিল</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary-800 hover:bg-primary-900 text-white text-xs font-bold shadow">ক্যাটাগরি সংরক্ষণ করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection
