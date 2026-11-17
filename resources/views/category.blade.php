@extends('layouts.app')

@section('title', $category->name . ' - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-slate-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-primary-800">হোম</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-semibold">{{ $category->name }}</span>
    </nav>

    <!-- Category Header Banner -->
    <div class="relative bg-gradient-to-r from-emerald-900 to-primary-800 text-white rounded-2xl overflow-hidden p-6 sm:p-10 mb-8 shadow-md">
        <div class="relative z-10 max-w-xl">
            <span class="text-xs bg-amber-400 text-slate-950 px-3 py-0.5 rounded-full font-bold uppercase">ক্যাটাগরি</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 mb-2">{{ $category->name }}</h1>
            <p class="text-emerald-100 text-sm leading-relaxed">{{ $category->description }}</p>
        </div>
        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="absolute right-0 top-0 w-1/3 h-full object-cover opacity-30 mix-blend-overlay hidden md:block">
    </div>

    <!-- Layout: Sidebar + Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm sticky top-24">
                <h3 class="font-bold text-slate-900 text-base mb-4 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-primary-800"></i>
                    <span>সকল ক্যাটাগরি</span>
                </h3>
                <ul class="space-y-1.5 text-sm">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat->slug) }}" class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $cat->id === $category->id ? 'bg-primary-50 text-primary-800 font-bold border-l-4 border-primary-800' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>{{ $cat->name }}</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-slate-500 font-medium">মোট পাওয়া গেছে: <strong class="text-slate-900">{{ $products->total() }}টি পণ্য</strong></div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                    <i class="fa-solid fa-box-open text-5xl text-slate-300 mb-3"></i>
                    <h3 class="text-base font-bold text-slate-700">এই ক্যাটাগরিতে বর্তমানে কোনো পণ্য নেই!</h3>
                    <a href="{{ route('home') }}" class="mt-4 inline-block bg-primary-800 text-white px-5 py-2 rounded-full text-sm font-semibold">হোমপেজে ফিরে যান</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
