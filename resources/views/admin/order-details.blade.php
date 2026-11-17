@extends('layouts.admin')

@section('title', 'অর্ডার বিস্তারিত: ' . $order->order_number . ' - অ্যাডমিন')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-primary-800 hover:underline flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> সকল অর্ডারে ফিরে যান
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1">
                <i class="fa-solid fa-pen-to-square"></i> অর্ডার এডিট
            </a>
            <span class="text-xs text-slate-500 font-mono">আইডি: #{{ $order->id }}</span>
        </div>
    </div>

    <!-- Main Order Box -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        
        <!-- Header Bar -->
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <span>অর্ডার নং:</span>
                    <span class="text-primary-800 font-mono">{{ $order->order_number }}</span>
                </h1>
                <div class="text-xs text-slate-500 mt-1">অর্ডারের সময়: {{ $order->created_at->format('d M, Y (h:i A)') }}</div>
            </div>

            <!-- Quick Action Buttons for Status & Stock -->
            <div class="flex flex-wrap items-center gap-2">
                
                @if($order->status !== 'confirmed')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow flex items-center gap-1.5">
                            <i class="fa-solid fa-check"></i> কনফার্ম করুন (স্টক কাটবে)
                        </button>
                    </form>
                @endif

                @if($order->status !== 'cancelled')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('অর্ডারটি বাতিল করবেন? যদি স্টক কাটা হয়ে থাকে তবে তা ফেরত আসবে।')">
                        @csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="bg-red-50 hover:bg-red-600 hover:text-white text-red-600 border border-red-200 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                            <i class="fa-solid fa-xmark"></i> বাতিল (স্টক ফেরত)
                        </button>
                    </form>
                @endif

                @if($order->status !== 'returned' && $order->status !== 'cancelled' && $order->status !== 'pending')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('কুরিয়ার থেকে পার্সেল রিটার্ন এসেছে? স্টক পুনরায় যুক্ত হবে।')">
                        @csrf
                        <input type="hidden" name="status" value="returned">
                        <button type="submit" class="bg-orange-50 hover:bg-orange-600 hover:text-white text-orange-700 border border-orange-200 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                            <i class="fa-solid fa-rotate-left"></i> পার্সেল রিটার্ন (স্টক ফেরত)
                        </button>
                    </form>
                @endif

                @if($order->status !== 'pending')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="bg-amber-50 hover:bg-amber-600 hover:text-white text-amber-800 border border-amber-200 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                            <i class="fa-solid fa-clock"></i> পেন্ডিং রাখুন
                        </button>
                    </form>
                @endif

            </div>
        </div>

        <div class="p-6 sm:p-8">
            
            <!-- Customer Details & Risk Indicator -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100 text-sm mb-6">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">গ্রাহকের বিবরণ:</h3>
                    <div class="font-bold text-slate-900 text-base">{{ $order->customer_name }}</div>
                    <div class="text-slate-600 mt-1 flex items-center gap-3">
                        <a href="tel:{{ $order->customer_phone }}" class="hover:underline font-mono font-bold text-primary-800 flex items-center gap-1">
                            <i class="fa-solid fa-phone text-xs"></i> {{ $order->customer_phone }}
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="text-emerald-600 hover:underline text-xs font-bold flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-sm"></i> হোয়াটসঅ্যাপ
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ডেলিভারি ঠিকানা ও জোন:</h3>
                    <div class="text-slate-700 leading-relaxed">{{ $order->customer_address }}</div>
                    <div class="text-xs font-bold text-emerald-800 mt-1">
                        {{ $order->delivery_zone === 'inside_dhaka' ? 'ঢাকার ভেতরে (চার্জ ৳৭০)' : 'ঢাকার বাইরে (চার্জ ৳১৩০)' }}
                    </div>
                    @if($order->notes)
                        <div class="mt-2 p-2.5 bg-amber-50 rounded-xl text-xs text-amber-900 border border-amber-200">
                            <strong>নোট:</strong> {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ordered Items List -->
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-900 text-sm">অর্ডারকৃত পণ্যসমূহ:</h3>
                <span class="text-xs font-bold {{ $order->is_stock_deducted ? 'text-emerald-700' : 'text-slate-400' }}">
                    <i class="fa-solid {{ $order->is_stock_deducted ? 'fa-check' : 'fa-clock' }}"></i>
                    {{ $order->is_stock_deducted ? 'এই অর্ডারের জন্য স্টক সফলভাবে কাটা হয়েছে' : 'স্টক এখনও কাটা হয়নি (পেন্ডিং)' }}
                </span>
            </div>

            <table class="w-full text-left text-sm mb-6">
                <thead>
                    <tr class="bg-slate-50 text-xs font-bold text-slate-500 uppercase">
                        <th class="py-2.5 px-4 rounded-l-lg">পণ্য</th>
                        <th class="py-2.5 px-4 text-center">মূল্য</th>
                        <th class="py-2.5 px-4 text-center">পরিমাণ</th>
                        <th class="py-2.5 px-4 text-right rounded-r-lg">মোট</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3 px-4 font-semibold text-slate-800 flex items-center gap-2">
                                @if($item->product && $item->product->image)
                                    <img src="{{ $item->product->image }}" class="w-8 h-8 rounded-lg object-cover">
                                @endif
                                <span>{{ $item->product_name }}</span>
                            </td>
                            <td class="py-3 px-4 text-center text-slate-600">৳{{ number_format($item->price) }}</td>
                            <td class="py-3 px-4 text-center font-bold text-slate-900">{{ $item->quantity }}টি</td>
                            <td class="py-3 px-4 text-right font-black text-slate-900">৳{{ number_format($item->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Billing Summary -->
            <div class="max-w-xs ml-auto space-y-2 text-sm border-t pt-4">
                <div class="flex justify-between text-slate-600">
                    <span>পণ্যের দাম:</span>
                    <span class="font-bold text-slate-900">৳{{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>ডেলিভারি চার্জ:</span>
                    <span class="font-bold text-slate-900">৳{{ number_format($order->delivery_charge) }}</span>
                </div>
                <div class="flex justify-between text-base font-black text-slate-900 border-t pt-2">
                    <span>সর্বমোট বিল:</span>
                    <span class="text-primary-800 text-xl font-black">৳{{ number_format($order->total) }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Customer Previous History (Fraud / Return Tracker) -->
    @if(isset($customerOrders) && $customerOrders->isNotEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="font-bold text-slate-900 text-base mb-1 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-primary-800"></i>
                <span>এই কাস্টমারের পূর্বের অর্ডার হিস্টোরি ({{ $order->customer_phone }})</span>
            </h3>
            <p class="text-xs text-slate-500 mb-4">কাস্টমার আগে কোনো অর্ডার রিটার্ন বা ক্যান্সেল করেছে কিনা তা যাচাই করুন</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b text-slate-500 font-bold uppercase">
                            <th class="py-2.5 px-3">অর্ডার নং</th>
                            <th class="py-2.5 px-3">তারিখ</th>
                            <th class="py-2.5 px-3 text-right">বিল</th>
                            <th class="py-2.5 px-3 text-center">স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($customerOrders as $cOrd)
                            <tr>
                                <td class="py-2.5 px-3 font-mono font-bold text-primary-800">
                                    <a href="{{ route('admin.orders.show', $cOrd->id) }}" class="hover:underline">{{ $cOrd->order_number }}</a>
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $cOrd->created_at->format('d M, Y') }}</td>
                                <td class="py-2.5 px-3 text-right font-bold">৳{{ number_format($cOrd->total) }}</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded font-bold uppercase
                                        {{ $cOrd->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800' }}
                                    ">
                                        {{ $cOrd->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
