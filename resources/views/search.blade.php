@extends('layouts.app')

@section('title', 'খোঁজার ফলাফল: ' . $query . ' - Amar Bazar | আমার বাজার')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">
            খোঁজার ফলাফল: <span class="text-primary-800">"{{ $query }}"</span>
        </h1>
        <p class="text-sm text-slate-500 mt-1">মোট {{ $products->total() }}টি পণ্য পাওয়া গেছে</p>
    </div>

    @if($products->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto">
            <i class="fa-solid fa-magnifying-glass text-5xl text-slate-300 mb-3"></i>
            <h2 class="text-xl font-bold text-slate-800 mb-2">কোনো পণ্য পাওয়া যায়নি!</h2>
            <p class="text-sm text-slate-500 mb-6">অন্য কোনো নাম দিয়ে সার্চ করুন অথবা আমাদের ক্যাটাগরিগুলো দেখুন।</p>
            <a href="{{ route('home') }}" class="inline-block bg-primary-800 text-white font-bold px-6 py-2.5 rounded-full text-sm">
                হোমপেজে ফিরে যান
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->appends(['q' => $query])->links() }}
        </div>
    @endif
</div>
@endsection
