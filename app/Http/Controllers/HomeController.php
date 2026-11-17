<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('sort_order')
            ->get();

        $topSelling = Product::where('is_top_selling', true)
            ->where('is_available', true)
            ->take(8)
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_available', true)
            ->take(8)
            ->get();

        // Category sections with their products
        $honeyProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'pure-honey');
        })->take(4)->get();

        $oilGheeProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'oil-and-ghee');
        })->take(4)->get();

        $datesProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'premium-dates');
        })->take(4)->get();

        $nutsProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'nuts-and-seeds');
        })->take(4)->get();

        return view('home', compact(
            'categories',
            'topSelling',
            'featuredProducts',
            'honeyProducts',
            'oilGheeProducts',
            'datesProducts',
            'nutsProducts'
        ));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('is_available', true)
            ->paginate(12);

        $categories = Category::orderBy('sort_order')->get();

        return view('category', compact('category', 'products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $products = Product::where('is_available', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('subtitle', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%");
            })
            ->paginate(12);

        $categories = Category::orderBy('sort_order')->get();

        return view('search', compact('products', 'query', 'categories'));
    }

    public function trackOrder(Request $request)
    {
        $order = null;
        $search = trim($request->input('order_id', ''));

        if (!empty($search)) {
            $clean = str_replace(['#', ' '], '', $search);
            $order = Order::with('items')
                ->where(function ($q) use ($search, $clean) {
                    $q->where('order_number', $search)
                      ->orWhere('order_number', $clean)
                      ->orWhere('order_number', 'like', "%{$clean}%")
                      ->orWhere('customer_phone', $clean);
                })
                ->latest()
                ->first();
        }

        return view('track-order', compact('order', 'search'));
    }
}
