@extends('layouts.admin')

@section('title', 'ম্যানুয়াল অর্ডার তৈরি করুন - অ্যাডমিন')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">ফোন বা হোয়াটসঅ্যাপ থেকে সরাসরি নতুন অর্ডার তৈরি</h1>
            <p class="text-xs text-slate-500 mt-1">অর্ডার তৈরির সাথে সাথেই স্টক সমন্বয় হয়ে যাবে</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-primary-800 border px-3 py-1.5 rounded-xl bg-white">
            &larr; অর্ডারে ফিরুন
        </a>
    </div>

    <form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <!-- Customer Name -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">গ্রাহকের নাম <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" required placeholder="গ্রাহকের সম্পূর্ণ নাম" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <!-- Customer Phone -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">মোবাইল নম্বর <span class="text-red-500">*</span></label>
                <input type="tel" name="customer_phone" required placeholder="017XXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <!-- Customer Address -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">ডেলিভারি ঠিকানা <span class="text-red-500">*</span></label>
                <textarea name="customer_address" rows="2" required placeholder="বাসা/হোল্ডিং, রোড, থানা, জেলা..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm"></textarea>
            </div>

            <!-- Delivery Zone -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">ডেলিভারি এরিয়া <span class="text-red-500">*</span></label>
                <select name="delivery_zone" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
                    <option value="inside_dhaka">ঢাকার ভেতরে (চার্জ ৳৭০)</option>
                    <option value="outside_dhaka">ঢাকার বাইরে (চার্জ ৳১৩০)</option>
                </select>
            </div>

            <!-- Payment Method -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">পেমেন্ট মেথড <span class="text-red-500">*</span></label>
                <select name="payment_method" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
                    <option value="cod">ক্যাশ অন ডেলিভারি (COD)</option>
                    <option value="bkash">বিকাশ (bKash)</option>
                    <option value="nagad">নগদ (Nagad)</option>
                </select>
            </div>

            <!-- Product Selection (Checkbox + Quantity) -->
            <div class="sm:col-span-2 pt-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">অর্ডারকৃত পণ্য নির্বাচন করুন <span class="text-red-500">*</span></label>
                
                <div class="border border-slate-200 rounded-2xl p-4 max-h-72 overflow-y-auto space-y-3 bg-slate-50">
                    @foreach($products as $prod)
                        <div class="flex items-center justify-between gap-4 p-2.5 bg-white rounded-xl border border-slate-200">
                            <label class="flex items-center gap-3 cursor-pointer flex-1">
                                <input type="checkbox" name="products[]" value="{{ $prod->id }}" class="rounded text-primary-800 focus:ring-primary-800 h-4 w-4">
                                <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-10 h-10 object-cover rounded-lg border">
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $prod->name }}</div>
                                    <div class="text-[11px] text-slate-500">মজুদ স্টক: <strong class="text-primary-800">{{ $prod->stock }}টি</strong> | মূল্য: ৳{{ number_format($prod->effective_price) }}</div>
                                </div>
                            </label>
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs text-slate-400">সংখ্যা:</span>
                                <input type="number" name="quantities[{{ $prod->id }}]" value="1" min="1" max="{{ $prod->stock }}" class="w-16 text-center py-1 px-2 border rounded-lg text-xs font-bold">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Notes -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">অর্ডার সংক্রান্ত বিশেষ নোট (ঐচ্ছিক)</label>
                <input type="text" name="notes" placeholder="যেমন: কাস্টমার বিকেলে ডেলিভারি চেয়েছে" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm">
            </div>

        </div>

        <div class="pt-4 border-t flex justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl border text-sm font-bold text-slate-600 hover:bg-slate-50">বাতিল</a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-sm font-bold shadow-lg">
                অর্ডার নিশ্চিত করুন (কনফার্মড)
            </button>
        </div>

    </form>

</div>
@endsection
