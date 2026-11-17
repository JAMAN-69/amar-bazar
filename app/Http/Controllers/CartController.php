<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        return view('cart', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = max(1, (int)$request->input('quantity', 1));

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        $price = $product->sale_price ?? $product->regular_price;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float)$price,
                'quantity' => $quantity,
                'image' => $product->image,
                'subtitle' => $product->subtitle,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'প্রোডাক্টটি সফলভাবে কার্টে যুক্ত হয়েছে!',
                'cartCount' => count($cart),
                'totalItems' => array_sum(array_column($cart, 'quantity')),
                'subtotal' => $this->calculateSubtotal($cart),
                'cart' => $cart,
            ]);
        }

        if ($request->input('redirect_to_checkout')) {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', 'পণ্যটি কার্টে যোগ করা হয়েছে!');
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int)$request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart),
                'totalItems' => array_sum(array_column($cart, 'quantity')),
                'subtotal' => $this->calculateSubtotal($cart),
                'cart' => $cart,
            ]);
        }

        return redirect()->route('cart')->with('success', 'কার্ট আপডেট করা হয়েছে!');
    }

    public function remove($id, Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart),
                'totalItems' => array_sum(array_column($cart, 'quantity')),
                'subtotal' => $this->calculateSubtotal($cart),
                'cart' => $cart,
            ]);
        }

        return redirect()->route('cart')->with('success', 'পণ্যটি কার্ট থেকে সরানো হয়েছে!');
    }

    public function keepOnly($id, Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart = [$id => $cart[$id]];
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => count($cart),
                'totalItems' => array_sum(array_column($cart, 'quantity')),
                'subtotal' => $this->calculateSubtotal($cart),
                'cart' => $cart,
            ]);
        }

        return redirect()->back()->with('success', 'শুধু নির্বাচিত পণ্যটি কার্টে রাখা হয়েছে!');
    }

    public function clear(Request $request)
    {
        session()->forget('cart');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => 0,
                'totalItems' => 0,
                'subtotal' => 0,
                'cart' => [],
            ]);
        }

        return redirect()->route('cart')->with('success', 'কার্ট খালি করা হয়েছে!');
    }

    private function calculateSubtotal(array $cart): float
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }
}
