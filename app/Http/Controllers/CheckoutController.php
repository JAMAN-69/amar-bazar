<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Support direct single product checkout or full cart checkout
        $cart = session()->get('cart', []);

        // If direct "Buy Now" for a single product was requested
        if ($request->has('buy_now')) {
            $product = Product::findOrFail($request->input('buy_now'));
            $price = $product->sale_price ?? $product->regular_price;
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float)$price,
                'quantity' => 1,
                'image' => $product->image,
                'subtitle' => $product->subtitle,
            ];
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'আপনার কার্ট খালি! অনুগ্রহ করে পণ্য যুক্ত করুন।');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'আপনার কার্ট খালি!');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:30',
            'customer_email' => 'nullable|string|max:150',
            'customer_address' => 'required|string|max:500',
            'district' => 'nullable|string|max:100',
            'thana' => 'nullable|string|max:100',
            'delivery_zone' => 'nullable|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'nullable|in:cod,bkash,nagad',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Your Full Name is required',
            'customer_phone.required' => 'Mobile number is required',
            'customer_address.required' => 'House / street address is required',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Determine delivery zone from District or explicit input
        $deliveryZone = $request->input('delivery_zone');
        if (!$deliveryZone) {
            $district = strtolower(trim($request->input('district', '')));
            $deliveryZone = ($district === 'dhaka' || empty($district)) ? 'inside_dhaka' : 'outside_dhaka';
        }

        $fullAddressParts = array_filter([
            $request->input('customer_address'),
            $request->input('thana'),
            $request->input('district')
        ]);
        $fullAddress = implode(', ', $fullAddressParts);
        if ($request->filled('customer_email')) {
            $fullAddress .= ' (' . $request->input('customer_email') . ')';
        }

        $deliveryCharge = ($deliveryZone === 'inside_dhaka') ? 70.00 : 130.00;
        $total = $subtotal + $deliveryCharge;

        $orderNumber = 'AB-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $fullAddress,
            'delivery_zone' => $deliveryZone,
            'delivery_charge' => $deliveryCharge,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $request->input('payment_method', 'cod'),
            'payment_status' => 'pending',
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'] . ($item['subtitle'] ? ' (' . $item['subtitle'] . ')' : ''),
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.success', $order->order_number);
    }

    public function success($order_number)
    {
        $order = Order::with('items')->where('order_number', $order_number)->firstOrFail();
        return view('order-success', compact('order'));
    }
}
