<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // 1. Dashboard: Overview & Orders with Search Engine & Fraud Risk Detection
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Search Engine: Search by Order ID, Customer Phone, or Name
        if ($request->filled('search')) {
            $rawSearch = trim($request->input('search'));
            $cleanSearch = trim(str_replace(['#', ' '], '', $rawSearch));
            $query->where(function ($q) use ($rawSearch, $cleanSearch) {
                $q->where('order_number', 'like', "%{$cleanSearch}%")
                  ->orWhere('order_number', 'like', "%{$rawSearch}%")
                  ->orWhere('customer_phone', 'like', "%{$cleanSearch}%")
                  ->orWhere('customer_phone', 'like', "%{$rawSearch}%")
                  ->orWhere('customer_name', 'like', "%{$rawSearch}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();

        // Customer Risk Intelligence calculation for all displayed orders
        foreach ($orders as $order) {
            $phoneOrders = Order::where('customer_phone', $order->customer_phone)->get();
            $totalCount = $phoneOrders->count();
            $cancelledCount = $phoneOrders->where('status', 'cancelled')->count();
            $deliveredCount = $phoneOrders->whereIn('status', ['delivered', 'confirmed', 'shipped'])->count();

            if ($cancelledCount > 0) {
                $order->risk_badge = [
                    'color' => 'bg-red-100 text-red-800 border-red-300',
                    'icon' => 'fa-triangle-exclamation',
                    'label' => 'সতর্ক! রিটার্ন/ক্যান্সেল হিস্টোরি (' . $cancelledCount . 'টি বাতিল)',
                    'level' => 'high'
                ];
            } elseif ($deliveredCount >= 1 && $totalCount > 1) {
                $order->risk_badge = [
                    'color' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    'icon' => 'fa-circle-check',
                    'label' => 'বিশ্বস্ত নিয়মিত গ্রাহক (' . $deliveredCount . 'টি সফল)',
                    'level' => 'trusted'
                ];
            } else {
                $order->risk_badge = [
                    'color' => 'bg-amber-100 text-amber-800 border-amber-300',
                    'icon' => 'fa-clock',
                    'label' => 'নতুন কাস্টমার (১ম অর্ডার)',
                    'level' => 'new'
                ];
            }
            $order->customer_history_count = $totalCount;
        }

        return view('admin.dashboard', compact('orders', 'totalOrders', 'totalRevenue', 'pendingOrders', 'totalProducts'));
    }

    // 2. Order Details
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Previous history for this customer phone
        $customerOrders = Order::where('customer_phone', $order->customer_phone)
            ->where('id', '!=', $order->id)
            ->latest()
            ->get();

        return view('admin.order-details', compact('order', 'customerOrders'));
    }

    // 3. Update Order Status with Automatic Stock Deduction / Restoration
    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->input('status');

        $order->status = $newStatus;
        if ($request->has('payment_status')) {
            $order->payment_status = $request->input('payment_status');
        }

        // AUTO-STOCK LOGIC:
        // 1. When status moves to Confirmed/Shipped/Delivered and stock wasn't deducted yet:
        if (in_array($newStatus, ['confirmed', 'shipped', 'delivered']) && !$order->is_stock_deducted) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock = max(0, $product->stock - $item->quantity);
                        $product->total_sales = $product->total_sales + $item->quantity;
                        $product->save();
                    }
                }
            }
            $order->is_stock_deducted = true;
        }

        // 2. When order is Cancelled, Returned, or moved back to Pending and stock was previously deducted -> Restore Stock!
        if (in_array($newStatus, ['cancelled', 'returned', 'pending']) && $order->is_stock_deducted) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock = $product->stock + $item->quantity;
                        $product->total_sales = max(0, $product->total_sales - $item->quantity);
                        $product->save();
                    }
                }
            }
            $order->is_stock_deducted = false;
        }

        $order->save();

        return redirect()->back()->with('success', 'অর্ডার স্ট্যাটাস এবং প্রোডাক্ট স্টক সফলভাবে সমন্বয় করা হয়েছে!');
    }

    // 4. Create Order Manually from Admin
    public function orderCreate()
    {
        $products = Product::where('is_available', true)->get();
        return view('admin.orders.create', compact('products'));
    }

    public function orderStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'delivery_zone' => 'required|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'required|in:cod,bkash,nagad',
            'products' => 'required|array|min:1',
            'quantities' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        $subtotal = 0;
        $itemsData = [];

        foreach ($validated['products'] as $pId) {
            $product = Product::findOrFail($pId);
            $qty = max(1, (int)($validated['quantities'][$pId] ?? 1));
            $price = $product->sale_price ?? $product->regular_price;
            $lineTotal = $price * $qty;
            $subtotal += $lineTotal;

            $itemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $price,
                'quantity' => $qty,
                'total' => $lineTotal,
            ];
        }

        $deliveryCharge = ($validated['delivery_zone'] === 'inside_dhaka') ? 70.00 : 130.00;
        $total = $subtotal + $deliveryCharge;
        $orderNumber = 'AB-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'delivery_zone' => $validated['delivery_zone'],
            'delivery_charge' => $deliveryCharge,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'status' => 'confirmed', // Admin created orders start as confirmed
            'is_stock_deducted' => true,
            'notes' => $validated['notes'] ?? 'অ্যাডমিন কর্তৃক ম্যানুয়ালি তৈরি করা অর্ডার',
        ]);

        foreach ($itemsData as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);

            // Deduct stock immediately
            $prod = Product::find($item['product_id']);
            if ($prod) {
                $prod->stock = max(0, $prod->stock - $item['quantity']);
                $prod->total_sales += $item['quantity'];
                $prod->save();
            }
        }

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'নতুন অর্ডার সফলভাবে তৈরি হয়েছে এবং স্টক আপডেট করা হয়েছে!');
    }

    // 5. Edit Order Details
    public function orderEdit($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'delivery_zone' => 'required|in:inside_dhaka,outside_dhaka',
            'delivery_charge' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $order->customer_name = $validated['customer_name'];
        $order->customer_phone = $validated['customer_phone'];
        $order->customer_address = $validated['customer_address'];
        $order->delivery_zone = $validated['delivery_zone'];
        $order->delivery_charge = $validated['delivery_charge'];
        $order->total = $order->subtotal + $order->delivery_charge;
        $order->notes = $validated['notes'];
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'অর্ডারের তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    // 6. Product Management: List Products with Stock & Sales Stats
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(15);
        $totalStock = Product::sum('stock');
        $totalSold = Product::sum('total_sales');
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        return view('admin.products.index', compact('products', 'totalStock', 'totalSold', 'lowStockCount'));
    }

    public function productCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subtitle' => 'nullable|string|max:100',
            'regular_price' => 'required|numeric|min:1',
            'sale_price' => 'nullable|numeric|lt:regular_price',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_top_selling' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle Image: Upload from PC takes priority, otherwise URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $imageUrl = $request->input('image_url');
        } else {
            $imageUrl = 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&auto=format&fit=crop&q=80';
        }

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $regularPrice = (float) $validated['regular_price'];
        $salePrice = !empty($validated['sale_price']) ? (float)$validated['sale_price'] : null;
        if (!$salePrice && $request->filled('discount_percent') && (float)$request->input('discount_percent') > 0) {
            $pct = min(99, max(1, (float)$request->input('discount_percent')));
            $salePrice = round($regularPrice - ($regularPrice * $pct / 100));
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'subtitle' => $validated['subtitle'] ?? null,
            'regular_price' => $regularPrice,
            'sale_price' => $salePrice,
            'stock' => $validated['stock'],
            'image' => $imageUrl,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_top_selling' => $request->has('is_top_selling'),
            'is_featured' => $request->has('is_featured'),
            'is_available' => true,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'নতুন প্রোডাক্ট সফলভাবে তালিকায় যোগ করা হয়েছে!');
    }

    public function productEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subtitle' => 'nullable|string|max:100',
            'regular_price' => 'required|numeric|min:1',
            'sale_price' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_available' => 'nullable|boolean',
            'is_top_selling' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $imageUrl = $request->input('image_url');
        } else {
            $imageUrl = $product->image;
        }

        $regularPrice = (float) $validated['regular_price'];
        $salePrice = !empty($validated['sale_price']) ? (float)$validated['sale_price'] : null;
        if (!$salePrice && $request->filled('discount_percent') && (float)$request->input('discount_percent') > 0) {
            $pct = min(99, max(1, (float)$request->input('discount_percent')));
            $salePrice = round($regularPrice - ($regularPrice * $pct / 100));
        }

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'subtitle' => $validated['subtitle'] ?? null,
            'regular_price' => $regularPrice,
            'sale_price' => $salePrice,
            'stock' => $validated['stock'],
            'image' => $imageUrl,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_available' => $request->has('is_available'),
            'is_top_selling' => $request->has('is_top_selling'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'প্রোডাক্টের তথ্য ও স্টক সফলভাবে আপডেট হয়েছে!');
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'প্রোডাক্টটি তালিকা থেকে মুছে ফেলা হয়েছে!');
    }

    // 7. Customer Data Management & Fraud/Return Rate Tracking
    public function customers()
    {
        // Group all orders by phone number
        $allOrders = Order::all();
        $customersGrouped = $allOrders->groupBy('customer_phone');

        $customerList = [];
        foreach ($customersGrouped as $phone => $orders) {
            $totalOrders = $orders->count();
            $cancelled = $orders->where('status', 'cancelled')->count();
            $delivered = $orders->whereIn('status', ['delivered', 'confirmed', 'shipped'])->count();
            $totalSpent = $orders->where('status', '!=', 'cancelled')->sum('total');
            $latestOrder = $orders->sortByDesc('created_at')->first();

            // Calculate return/cancel rate
            $cancelRate = round(($cancelled / $totalOrders) * 100);

            if ($cancelled > 0) {
                $statusType = 'high_risk';
                $badgeText = '🔴 ঝুঁকিপূর্ণ (ফেইক/রিটার্ন)';
                $badgeClass = 'bg-red-100 text-red-800 border-red-300';
            } elseif ($delivered >= 2) {
                $statusType = 'vip';
                $badgeText = '🟢 বিশ্বস্ত নিয়মিত ভিআইপি';
                $badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-300';
            } else {
                $statusType = 'new';
                $badgeText = '🟡 নতুন গ্রাহক';
                $badgeClass = 'bg-amber-100 text-amber-800 border-amber-300';
            }

            $customerList[] = (object)[
                'name' => $latestOrder->customer_name,
                'phone' => $phone,
                'address' => $latestOrder->customer_address,
                'total_orders' => $totalOrders,
                'delivered_orders' => $delivered,
                'cancelled_orders' => $cancelled,
                'cancel_rate' => $cancelRate,
                'total_spent' => $totalSpent,
                'badgeText' => $badgeText,
                'badgeClass' => $badgeClass,
                'statusType' => $statusType,
                'last_order_date' => $latestOrder->created_at,
            ];
        }

        // Sort by total orders descending
        usort($customerList, function ($a, $b) {
            return $b->total_orders <=> $a->total_orders;
        });

        return view('admin.customers.index', compact('customerList'));
    }

    // ================= CATEGORIES MANAGEMENT =================
    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ], [
            'name.required' => 'ক্যাটাগরির নাম দিন।',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $imagePath = 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=200&auto=format&fit=crop&q=80';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $imagePath = '/uploads/categories/' . $filename;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Category::create([
            'name' => trim($request->name),
            'slug' => $slug,
            'image' => $imagePath,
            'description' => $request->description,
            'is_featured' => $request->boolean('is_featured', true),
            'sort_order' => (int) $request->input('sort_order', 0),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'নতুন ক্যাটাগরি তৈরি হয়েছে!',
                'category' => Category::where('slug', $slug)->first()
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'নতুন ক্যাটাগরি সফলভাবে তৈরি হয়েছে!');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $category->image = '/uploads/categories/' . $filename;
        } elseif ($request->filled('image_url')) {
            $category->image = $request->image_url;
        }

        $category->name = trim($request->name);
        $category->description = $request->description;
        $category->sort_order = (int) $request->input('sort_order', $category->sort_order);
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি সফলভাবে আপডেট হয়েছে!');
    }

    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return back()->with('error', 'এই ক্যাটাগরিতে প্রোডাক্ট রয়েছে! আগে প্রোডাক্টগুলো অন্য ক্যাটাগরিতে স্থানান্তর করুন বা ডিলিট করুন।');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
