@extends('layouts.app')

@section('title', 'Checkout - Ghorer Bazar Style | Amar Bazar')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    
    <!-- Top Back to Home Navigation -->
    <div class="mb-6 flex items-center justify-between text-xs text-slate-500 pb-3 border-b border-slate-200">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 font-bold text-[#e86b24] hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Shop / হোম পেজে যান</span>
        </a>
        <div class="flex items-center gap-1.5 font-medium">
            <a href="{{ route('home') }}" class="hover:text-slate-800">Home</a>
            <span>/</span>
            <a href="{{ route('cart') }}" class="hover:text-slate-800">Cart</a>
            <span>/</span>
            <span class="text-slate-900 font-bold">Checkout</span>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="delivery_zone" id="deliveryZoneInput" value="inside_dhaka">
        <input type="hidden" name="payment_method" value="cod">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- ================= LEFT COLUMN: Shipping & Billing Address (7 Cols) ================= -->
            <div class="lg:col-span-7 space-y-5">
                
                <!-- Shipping Address Card (Exact Ghorer Bazar Design) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-6 sm:p-7 shadow-xs">
                    
                    <!-- Header with Orange Bar Indicator -->
                    <div class="flex items-center gap-2 mb-6">
                        <span class="w-1.5 h-5 bg-[#e86b24] rounded-full"></span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">Shipping Address</h2>
                    </div>

                    <div class="space-y-4">
                        
                        <!-- Row 1: Name and Phone (Split Input) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            <!-- Full Name -->
                            <div>
                                <input 
                                    type="text" 
                                    name="customer_name" 
                                    value="{{ old('customer_name') }}" 
                                    required 
                                    placeholder="Your Full Name *" 
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white placeholder:text-slate-400 font-medium"
                                >
                                @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone with '88' Prefix Box (Exact Ghorer Bazar Design) -->
                            <div>
                                <div class="flex rounded-xl border border-slate-300 focus-within:border-[#e86b24] focus-within:ring-1 focus-within:ring-[#e86b24] overflow-hidden bg-white">
                                    <span class="bg-slate-100/90 text-slate-700 px-3.5 py-3.5 border-r border-slate-200 text-sm font-bold flex items-center justify-center select-none">
                                        88
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="customer_phone" 
                                        value="{{ old('customer_phone') }}" 
                                        required 
                                        placeholder="017********" 
                                        class="w-full px-4 py-3.5 border-0 focus:outline-none text-sm bg-transparent placeholder:text-slate-400 font-medium"
                                    >
                                </div>
                                @error('customer_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <!-- Row 2: Email (Optional) -->
                        <div>
                            <input 
                                type="email" 
                                name="customer_email" 
                                value="{{ old('customer_email') }}" 
                                placeholder="example@gmail.com (Optional)" 
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white placeholder:text-slate-400 font-medium"
                            >
                        </div>

                        <!-- Row 3: Street Address -->
                        <div>
                            <input 
                                type="text" 
                                name="customer_address" 
                                value="{{ old('customer_address') }}" 
                                required 
                                placeholder="ex: House no. / building / street / area" 
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white placeholder:text-slate-400 font-medium"
                            >
                            @error('customer_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Row 4: District & Thana (2 Cols) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            <!-- District Dropdown -->
                            <div>
                                <select 
                                    name="district" 
                                    id="districtSelect" 
                                    onchange="handleDistrictChange(this.value)" 
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white text-slate-700 cursor-pointer font-medium"
                                >
                                    <option value="Dhaka" selected>Dhaka (ঢাকার ভেতরে - ৳৭০)</option>
                                    <option value="Gazipur">Gazipur (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Narayanganj">Narayanganj (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Chattogram">Chattogram (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Sylhet">Sylhet (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Rajshahi">Rajshahi (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Khulna">Khulna (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Barishal">Barishal (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Rangpur">Rangpur (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Mymensingh">Mymensingh (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Bogura">Bogura (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Cumilla">Cumilla (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Cox's Bazar">Cox's Bazar (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Feni">Feni (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Tangail">Tangail (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Faridpur">Faridpur (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Jessore">Jessore (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Kushtia">Kushtia (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Pabna">Pabna (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Dinajpur">Dinajpur (ঢাকার বাইরে - ৳১৩০)</option>
                                    <option value="Other">অন্যান্য জেলা / Other District (৳১৩০)</option>
                                </select>
                            </div>

                            <!-- Thana / Area -->
                            <div>
                                <input 
                                    type="text" 
                                    name="thana" 
                                    value="{{ old('thana') }}" 
                                    placeholder="Select Thana (Optional)" 
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white placeholder:text-slate-400 font-medium"
                                >
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Billing Address Card (Matches Ghorer Bazar Screenshot) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-[#e86b24] rounded-full"></span>
                        <span class="text-sm sm:text-base font-bold text-slate-900">Billing Address</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span>Same as shipping address</span>
                        <div class="w-5 h-5 rounded-full border-2 border-[#e86b24] flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#e86b24]"></div>
                        </div>
                    </div>
                </div>

                <!-- Cash On Delivery Notice -->
                <div class="bg-amber-50/70 rounded-2xl border border-amber-200/80 p-4 flex items-center gap-3 text-xs text-amber-950">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base flex-shrink-0">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">ক্যাশ অন ডেলিভারি (Cash on Delivery)</div>
                        <div class="text-[11px] text-slate-600 mt-0.5">পণ্য হাতে পেয়ে দেখে ডেলিভারি ম্যানের কাছে সম্পূর্ণ মূল্য পরিশোধ করতে পারবেন।</div>
                    </div>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN: Summary, Notes & Place Order (5 Cols) ================= -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- Selected Products Card (With Live Delete & Qty Stepper) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-[#e86b24] rounded-full"></span>
                            <h3 class="text-sm font-bold text-slate-900">Selected Products (<span id="checkoutItemCount">{{ count($cart) }}</span>)</h3>
                        </div>
                        <a href="{{ route('home') }}" class="text-xs text-[#e86b24] font-bold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-plus-circle text-[11px]"></i> Add more
                        </a>
                    </div>

                    <!-- Items List -->
                    <div id="checkoutItemsContainer">
                        <div id="checkoutItemsList" class="divide-y divide-slate-100 max-h-60 overflow-y-auto pr-1">
                            @foreach($cart as $id => $item)
                                <div class="py-3 flex items-center gap-3 transition-all" id="checkout-item-row-{{ $id }}">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-xl border border-slate-100 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-bold text-slate-900 truncate">{{ $item['name'] }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $item['subtitle'] ?? '' }}</div>
                                        
                                        <!-- Controls: Qty Stepper & Keep only -->
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <div class="inline-flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                                                <button type="button" onclick="updateCheckoutQty({{ $id }}, {{ $item['quantity'] - 1 }})" class="px-2 py-0.5 text-xs text-slate-600 hover:bg-slate-200 font-bold transition" title="Decrease">-</button>
                                                <span class="px-2 py-0.5 text-xs font-bold bg-white min-w-[20px] text-center" id="item-qty-{{ $id }}">{{ $item['quantity'] }}</span>
                                                <button type="button" onclick="updateCheckoutQty({{ $id }}, {{ $item['quantity'] + 1 }})" class="px-2 py-0.5 text-xs text-slate-600 hover:bg-slate-200 font-bold transition" title="Increase">+</button>
                                            </div>

                                            @if(count($cart) > 1)
                                                <button type="button" onclick="keepOnlyCheckoutItem({{ $id }})" class="keep-only-btn text-[10px] text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 font-bold hover:bg-emerald-100 transition" title="বাকি সব বাদ দিয়ে শুধু এটি রাখুন">
                                                    শুধু এটি
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end justify-between self-stretch">
                                        <button type="button" onclick="removeCheckoutItem({{ $id }})" class="text-slate-300 hover:text-red-600 p-1 rounded-lg transition" title="Remove">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                        <div class="text-xs font-black text-slate-800" id="item-total-{{ $id }}">
                                            ৳{{ number_format($item['price'] * $item['quantity']) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Empty Cart Message -->
                    <div id="checkoutEmptyMessage" class="hidden text-center py-6">
                        <i class="fa-solid fa-basket-shopping text-3xl text-slate-300 mb-2"></i>
                        <p class="text-xs font-bold text-slate-700">Your cart is empty!</p>
                        <a href="{{ route('home') }}" class="mt-2 inline-block bg-[#e86b24] text-white text-xs font-bold px-4 py-2 rounded-xl">Go to Shop</a>
                    </div>

                </div>

                <!-- Cost Summary Card (Exact Ghorer Bazar Design) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-3" id="priceCalcTable">
                    
                    <div class="flex justify-between text-sm text-slate-600 font-medium">
                        <span>Sub total</span>
                        <span class="text-slate-900 font-semibold"><span id="subtotalDisplay">{{ number_format($subtotal, 2) }}</span> BDT</span>
                    </div>

                    <div class="flex justify-between text-sm text-slate-600 font-medium">
                        <span>Delivery cost</span>
                        <span class="text-slate-900 font-semibold"><span id="deliveryDisplay">70.00</span> BDT</span>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex justify-between text-base font-black text-slate-900">
                        <span>Total</span>
                        <span class="text-slate-900 font-black text-lg"><span id="totalDisplay">{{ number_format($subtotal + 70, 2) }}</span>BDT</span>
                    </div>

                </div>

                <!-- Special Notes Card (Exact Ghorer Bazar Design with 0/90 Char Counter) -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-1.5 h-4 bg-[#e86b24] rounded-full"></span>
                        <label for="specialNotesInput" class="text-xs sm:text-sm font-bold text-slate-800 cursor-pointer">
                            Special notes <span class="text-[11px] text-slate-400 font-normal">(Optional)</span>
                        </label>
                    </div>

                    <textarea 
                        name="notes" 
                        id="specialNotesInput" 
                        rows="3" 
                        maxlength="90" 
                        oninput="updateCharCount(this)" 
                        placeholder="" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#e86b24] focus:ring-1 focus:ring-[#e86b24] text-sm bg-white placeholder:text-slate-400 resize-none font-medium"
                    >{{ old('notes') }}</textarea>
                    
                    <div class="text-[11px] text-slate-400 mt-1.5 font-medium">
                        <span id="noteCharCount">0</span> / 90 characters
                    </div>
                </div>

                <!-- Terms and Policy Agreement Checkbox (Exact Ghorer Bazar Checkbox) -->
                <div class="px-1">
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600 select-none leading-relaxed">
                        <input type="checkbox" checked required class="mt-0.5 rounded text-[#e86b24] focus:ring-[#e86b24] h-4 w-4 border-slate-300 accent-[#e86b24]">
                        <span>I have read and agree to the <a href="#" class="text-[#e86b24] font-semibold hover:underline">Terms and Conditions</a>, <a href="#" class="text-[#e86b24] font-semibold hover:underline">Privacy Policy</a> & <a href="#" class="text-[#e86b24] font-semibold hover:underline">Refund and Return Policy</a>.</span>
                    </label>
                </div>

                <!-- Big Vibrant Orange PLACE ORDER Button (Exact Ghorer Bazar Button) -->
                <button 
                    type="submit" 
                    id="submitOrderBtn" 
                    class="w-full bg-[#e86b24] hover:bg-[#d45d1a] active:scale-[0.99] text-white font-black py-4 px-6 rounded-2xl shadow-xl shadow-orange-500/20 transition-all text-base tracking-wider uppercase flex items-center justify-center gap-2 group cursor-pointer"
                >
                    <span>PLACE ORDER</span>
                </button>

            </div>

        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
    let currentSubtotal = {{ $subtotal }};

    function updateCharCount(el) {
        document.getElementById('noteCharCount').innerText = el.value.length;
    }

    function handleDistrictChange(district) {
        const isDhaka = district.toLowerCase() === 'dhaka';
        const charge = isDhaka ? 70 : 130;
        document.getElementById('deliveryZoneInput').value = isDhaka ? 'inside_dhaka' : 'outside_dhaka';
        document.getElementById('deliveryDisplay').innerText = Number(charge).toFixed(2);
        
        const total = currentSubtotal + charge;
        document.getElementById('totalDisplay').innerText = Number(total).toFixed(2);
    }

    function getSelectedDeliveryCharge() {
        const dist = document.getElementById('districtSelect')?.value || 'dhaka';
        return dist.toLowerCase() === 'dhaka' ? 70 : 130;
    }

    function updatePriceDisplays(newSubtotal) {
        currentSubtotal = newSubtotal;
        const charge = getSelectedDeliveryCharge();
        const grandTotal = currentSubtotal + charge;

        const subDisplay = document.getElementById('subtotalDisplay');
        const totDisplay = document.getElementById('totalDisplay');

        if (subDisplay) subDisplay.innerText = Number(currentSubtotal).toFixed(2);
        if (totDisplay) totDisplay.innerText = Number(grandTotal).toFixed(2);
    }

    // Handle cart updates dynamically
    function handleCartUpdated(data) {
        const cart = data.cart || {};
        const itemKeys = Object.keys(cart);

        // Update global header badge and side cart & mobile bottom badge
        const headerBadge = document.getElementById('headerCartCount');
        if (headerBadge) headerBadge.innerText = data.cartCount;

        const mobileBadge = document.getElementById('mobileBottomCartBadge');
        if (mobileBadge) mobileBadge.innerText = data.cartCount;

        const fCount = document.getElementById('floatingCartCount');
        const fTotal = document.getElementById('floatingCartTotal');
        if (fCount) fCount.innerText = data.cartCount;
        if (fTotal) fTotal.innerText = Number(data.subtotal).toLocaleString();

        if (typeof renderDrawerCart === 'function') {
            renderDrawerCart(cart, data.subtotal);
        }

        const countBadge = document.getElementById('checkoutItemCount');
        if (countBadge) countBadge.innerText = itemKeys.length;

        if (itemKeys.length === 0) {
            const container = document.getElementById('checkoutItemsContainer');
            if (container) container.classList.add('hidden');
            const emptyMsg = document.getElementById('checkoutEmptyMessage');
            if (emptyMsg) emptyMsg.classList.remove('hidden');
            const calcTable = document.getElementById('priceCalcTable');
            if (calcTable) calcTable.classList.add('hidden');
            const submitBtn = document.getElementById('submitOrderBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return;
        }

        // Re-render items in checkout summary
        const list = document.getElementById('checkoutItemsList');
        if (list) {
            let html = '';
            itemKeys.forEach(id => {
                const item = cart[id];
                const itemTotal = Number(item.price * item.quantity).toLocaleString();
                html += `
                    <div class="py-3 flex items-center gap-3 transition-all" id="checkout-item-row-${id}">
                        <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded-xl border border-slate-100 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold text-slate-900 truncate">${item.name}</div>
                            <div class="text-[11px] text-slate-400">${item.subtitle || ''}</div>
                            
                            <div class="flex items-center gap-2 mt-1.5">
                                <div class="inline-flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                                    <button type="button" onclick="updateCheckoutQty(${id}, ${item.quantity - 1})" class="px-2 py-0.5 text-xs text-slate-600 hover:bg-slate-200 font-bold transition">-</button>
                                    <span class="px-2 py-0.5 text-xs font-bold bg-white min-w-[20px] text-center" id="item-qty-${id}">${item.quantity}</span>
                                    <button type="button" onclick="updateCheckoutQty(${id}, ${item.quantity + 1})" class="px-2 py-0.5 text-xs text-slate-600 hover:bg-slate-200 font-bold transition">+</button>
                                </div>

                                ${itemKeys.length > 1 ? `
                                    <button type="button" onclick="keepOnlyCheckoutItem(${id})" class="keep-only-btn text-[10px] text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 font-bold hover:bg-emerald-100 transition" title="বাকি সব বাদ দিয়ে শুধু এটি রাখুন">
                                        শুধু এটি
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-between self-stretch">
                            <button type="button" onclick="removeCheckoutItem(${id})" class="text-slate-300 hover:text-red-600 p-1 rounded-lg transition" title="Remove">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                            <div class="text-xs font-black text-slate-800" id="item-total-${id}">
                                ৳${itemTotal}
                            </div>
                        </div>
                    </div>
                `;
            });
            list.innerHTML = html;
        }

        updatePriceDisplays(data.subtotal);
    }

    // Remove single item on checkout
    function removeCheckoutItem(productId) {
        if (!confirm('Are you sure you want to remove this item?')) return;

        fetch(`/cart/remove/${productId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                handleCartUpdated(data);
                showToast('Item removed from cart!');
            }
        })
        .catch(err => console.error(err));
    }

    // Update quantity on checkout
    function updateCheckoutQty(productId, newQty) {
        if (newQty < 1) {
            removeCheckoutItem(productId);
            return;
        }

        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json"
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQty
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                handleCartUpdated(data);
            }
        })
        .catch(err => console.error(err));
    }

    // Keep only this item on checkout
    function keepOnlyCheckoutItem(productId) {
        fetch(`/cart/keep-only/${productId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                handleCartUpdated(data);
                showToast('Kept only selected product!');
            }
        })
        .catch(err => console.error(err));
    }

    // Prevent submission if cart is empty
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        if (currentSubtotal <= 0) {
            e.preventDefault();
            alert('Your cart is empty! Please add products to order.');
        }
    });
</script>
@endsection
