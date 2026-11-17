@extends('layouts.admin')

@section('title', 'অর্ডার এডিট: ' . $order->order_number . ' - অ্যাডমিন')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">
                অর্ডার তথ্য এডিট: <span class="text-primary-800 font-mono">{{ $order->order_number }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">ঠিকানা, ফোন নম্বর বা ডেলিভারি চার্জ পরিবর্তন করুন</p>
        </div>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs font-bold text-slate-600 hover:text-primary-800 border px-3 py-1.5 rounded-xl bg-white">
            &larr; বিস্তারিত পেজে ফিরুন
        </a>
    </div>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <!-- Customer Name -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">গ্রাহকের নাম <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <!-- Customer Phone -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">মোবাইল নম্বর <span class="text-red-500">*</span></label>
                <input type="tel" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
            </div>

            <!-- Full Address -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">সম্পূর্ণ ডেলিভারি ঠিকানা <span class="text-red-500">*</span></label>
                <textarea name="customer_address" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">{{ old('customer_address', $order->customer_address) }}</textarea>
            </div>

            <!-- Delivery Zone -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">ডেলিভারি এরিয়া <span class="text-red-500">*</span></label>
                <select name="delivery_zone" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:border-primary-800">
                    <option value="inside_dhaka" {{ $order->delivery_zone === 'inside_dhaka' ? 'selected' : '' }}>ঢাকার ভেতরে</option>
                    <option value="outside_dhaka" {{ $order->delivery_zone === 'outside_dhaka' ? 'selected' : '' }}>ঢাকার বাইরে (সারা দেশ)</option>
                </select>
            </div>

            <!-- Delivery Charge -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">ডেলিভারি চার্জ (৳) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="delivery_charge" value="{{ old('delivery_charge', $order->delivery_charge) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm font-bold text-primary-800">
            </div>

            <!-- Notes -->
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">বিশেষ নোট / নির্দেশনা</label>
                <input type="text" name="notes" value="{{ old('notes', $order->notes) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm">
            </div>

        </div>

        <div class="pt-4 border-t flex justify-end gap-3">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="px-5 py-2.5 rounded-xl border text-sm font-bold text-slate-600 hover:bg-slate-50">বাতিল</a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-primary-800 hover:bg-primary-900 text-white text-sm font-bold shadow-lg">
                পরিবর্তন সংরক্ষণ করুন
            </button>
        </div>

    </form>

</div>
@endsection
