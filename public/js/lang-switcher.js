/**
 * Amar Bazar - Dual-Language Switcher (বাংলা / English Toggle)
 * Translates all UI controls, navigation, buttons, headings, and badges.
 * PROTECTS: Product titles and product descriptions remain untouched.
 */

(function () {
    'use strict';

    let currentLang = localStorage.getItem('amar_bazar_lang') || 'bn';

    const BN_TO_EN = {
    "আমার বাজার": "Amar Bazar",
    "আমার": "Amar",
    "বাজার": "Bazar",
    "১০০% প্রাকৃতিক ও স্বাস্থ্যকর খাবার — সারা বাংলাদেশে দ্রুত হোম ডেলিভারি": "100% Pure & Organic Food — Fast Delivery Across Bangladesh",
    "১০০% খাঁটি ও নিরাপদ খাদ্য": "100% Pure & Safe Food",
    "১০০% খাঁটি ও নিরাপদ অর্গানিক খাদ্যপণ্য": "100% Pure & Safe Organic Food",
    "১০০% খাঁটি ও প্রাকৃতিক": "100% Pure & Natural",
    "সুন্দরবনের খাঁটি": "Sundarban Pure",
    "চাকের কাঁচা মধু": "Raw Comb Honey",
    "গভীর অরণ্য থেকে সরাসরি সংগৃহীত, কোনো কেমিক্যাল ছাড়া।": "Harvested directly from deep forests, without any chemicals.",
    "অর্ডার করুন": "Order Now",
    "সব মধু দেখুন": "View All Honey",
    "ঐতিহ্যবাহী স্বাদ": "Traditional Taste",
    "দেশি গরুর খাঁটি": "Pure Desi Cow",
    "গাওয়া ঘি ও সরিষার তেল": "Gawa Ghee & Mustard Oil",
    "কাঠের ঘানিতে ভাঙা খাঁটি সরিষার তেল এবং স্বাস্থ্যসম্মত গাওয়া ঘি।": "Cold-pressed pure mustard oil and healthy grass-fed gawa ghee.",
    "কিনুন এখনই": "Buy Now",
    "মদিনার আসল স্বাদ": "Authentic Taste of Madinah",
    "প্রিমিয়াম আজওয়া ও": "Premium Ajwa &",
    "মেদজুল খেজুর": "Medjool Dates",
    "পুষ্টি ও শক্তির ভরপুর উৎস। পরিবারের জন্য বাছাইকৃত প্রিমিয়াম ড্রাই ফ্রুটস।": "Rich source of energy & nutrition. Premium handpicked dry fruits for family.",
    "স্পেশাল কম্বো অফার": "Special Combo Offer",
    "সুন্দরবনের খাঁটি মধু": "Sundarban Pure Honey",
    "+ স্পেশাল হানি নাট": "+ Special Honey Nut",
    "রোগ প্রতিরোধ ক্ষমতা ও এনার্জি বৃদ্ধির জন্য সেরা স্বাস্থ্যকর কম্বো।": "Best healthy combo to boost immunity and sustained energy.",
    "সরাসরি অর্ডার করুন": "Order Directly",
    "১০০% খাঁটি পণ্য": "100% Pure Food",
    "সম্পূর্ণ প্রাকৃতিক": "Completely Natural",
    "দ্রুত ডেলিভারি": "Fast Delivery",
    "সারা বাংলাদেশে": "All Over Bangladesh",
    "ক্যাশ অন ডেলিভারি": "Cash on Delivery",
    "পণ্য পেয়ে মূল্য পরিশোধ": "Pay after receiving product",
    "রিটার্ন গ্যারান্টি": "Return Guarantee",
    "সহজে রিটার্ন করুন": "Easy Hassle-free Returns",
    "খাঁটি মধু সম্ভার": "Pure Honey Collection",
    "ঘানি ভাঙা তেল ও গাওয়া ঘি": "Cold Pressed Oil & Ghee",
    "প্রিমিয়াম খেজুর কালেকশন": "Premium Dates Collection",
    "জনপ্রিয় ক্যাটাগরি": "Featured Categories",
    "সেরা বিক্রিত পণ্য": "Top Selling Products",
    "আমাদের ব্র্যান্ডসমূহ": "Our Brands",
    "সকল প্রাকৃতিক মধু": "All Natural Honey",
    "রান্নার প্রয়োজনীয় পণ্য": "Cooking Essentials",
    "সকল পণ্য দেখুন": "View All Items",
    "সবগুলো দেখুন": "View All Items",
    "VIEW ALL ITEMS": "VIEW ALL ITEMS",
    "কেন 'আমার বাজার' বেছে নেবেন?": "Why Choose Amar Bazar?",
    "১০০% বিশুদ্ধতার অঙ্গীকার": "100% Purity Commitment",
    "কোনো কেমিক্যাল, কৃত্রিম রং বা প্রিজারভেটিভ ছাড়া সম্পূর্ণ প্রাকৃতিক খাদ্যপণ্য।": "Completely natural food products free from chemicals, colors, or preservatives.",
    "নিরাপদ প্রিমিয়াম প্যাকেজিং": "Safe Premium Packaging",
    "ফুড-গ্রেড ও এয়ারটাইট প্যাকেজিংয়ে পণ্যের সতেজতা ও পুষ্টিগুণ নিশ্চিত।": "Freshness & nutrition preserved in food-grade airtight packaging.",
    "২৪/৭ কাস্টমার সাপোর্ট": "24/7 Customer Support",
    "যেকোনো জিজ্ঞাসায় হটলাইন ও হোয়াটসঅ্যাপে সবসময় সহায়তা পাবেন।": "Always get quick support via hotline and WhatsApp for any questions.",
    "অফার জোন": "Offer Zone",
    "তেল ও ঘি": "Oil & Ghee",
    "মধু": "Honey",
    "খাঁটি মধু": "Pure Honey",
    "খেজুর": "Dates",
    "প্রিমিয়াম খেজুর": "Premium Dates",
    "প্রিমিয়াম খেজুর": "Premium Dates",
    "মশলা": "Spices",
    "খাঁটি মশলা": "Pure Spices",
    "বাদাম ও বীজ": "Nuts & Seeds",
    "চাল": "Rice",
    "ডাল ও আটা": "Flours & Lentils",
    "আটা ও ডাল": "Flours & Lentils",
    "সার্টিফাইড": "Certified",
    "আচার": "Pickle",
    "তবায়া": "Tabaya",
    "অর্গানিক ফুড": "Organic Food",
    "ক্যাটাগরি": "Categories",
    "সকল ক্যাটাগরি": "All Categories",
    "ভাষা / Language:": "Language:",
    "সরিষার তেল": "Mustard Oil",
    "খাঁটি গাওয়া ঘি": "Pure Gawa Ghee",
    "নারিকেল তেল": "Coconut Oil",
    "তিলের তেল": "Sesame Oil",
    "কালোজিরা মধু": "Black Seed Honey",
    "লিচু ফুলের মধু": "Lychee Flower Honey",
    "সিদর মধু": "Sidr Honey",
    "চাকের মধু": "Honeycomb Honey",
    "আজওয়া খেজুর": "Ajwa Dates",
    "মেডজুল খেজুর": "Medjool Dates",
    "মাব্রুম খেজুর": "Mabroom Dates",
    "হলুদ গুঁড়া": "Turmeric Powder",
    "মরিচ গুঁড়া": "Chili Powder",
    "ধনিয়া গুঁড়া": "Coriander Powder",
    "কাজু বাদাম": "Cashew Nut",
    "কাঠ বাদাম": "Almond",
    "পেস্তা বাদাম": "Pistachio",
    "কার্টে যোগ করুন": "Add To Cart",
    "অর্ডার সম্পন্ন করুন": "Place Order",
    "সার্চ করুন": "Search",
    "পেস্ট": "Paste",
    "নতুন অর্ডার": "New Order",
    "নতুন অর্ডার তৈরি": "Create New Order",
    "অর্ডারসমূহ": "Orders",
    "প্রোডাক্ট ও স্টক": "Products & Stock",
    "কাস্টমার ও ফ্রড": "Customers & Fraud",
    "সংরক্ষণ করুন": "Save",
    "বাতিল": "Cancel",
    "মুছে ফেলুন": "Delete",
    "এডিট": "Edit",
    "বিস্তারিত": "Details",
    "বন্ধ করুন": "Close",
    "ড্যাশবোর্ড": "Dashboard",
    "লগআউট": "Logout",
    "অ্যাডমিন": "Admin",
    "অ্যাডমিন প্যানেল": "Admin Panel",
    "অ্যাডমিন কন্ট্রোল": "Admin Control",
    "অর্ডার ম্যানেজমেন্ট": "Order Management",
    "অর্ডার ড্যাশবোর্ড": "Orders Dashboard",
    "অর্ডার ও ডেলিভারি ড্যাশবোর্ড": "Orders & Delivery Dashboard",
    "কাস্টমারের সাথে কথা বলে অর্ডার কনফার্ম, বাতিল বা রিটার্ন পরিচালনা করুন": "Manage order confirmation, cancellation, or return after calling the customer.",
    "পাবলিক ওয়েবসাইটে ফিরে যান": "Return to Storefront Website",
    "লগইন করুন": "Login",
    "আমাকে মনে রাখুন": "Remember Me",
    "অ্যাডমিন অ্যাক্সেস অনলি": "Admin Access Only",
    "পাসওয়ার্ড": "Password",
    "ইমেইল অথবা ইউজারনেম": "Username or Email",
    "আপনার ইমেইল অথবা ইউজারনেম দিন": "Enter your username or email",
    "আপনার পাসওয়ার্ড দিন": "Enter your password",
    "সুরক্ষিত অ্যাডমিন কন্ট্রোল প্যানেল": "Secure Admin Control Panel",
    "অর্ডার ও স্টক পরিচালনা করতে আপনার অ্যাডমিন তথ্য দিয়ে প্রবেশ করুন": "Enter your admin credentials to manage orders and stock",
    "শপিং কার্ট": "Shopping Cart",
    "🛒 শপিং কার্ট": "🛒 Shopping Cart",
    "আপনার কার্ট খালি আছে": "Your cart is empty",
    "কেনাকাটা শুরু করুন": "Start Shopping",
    "সর্বমোট:": "Total:",
    "সর্বমোট": "Total",
    "মোট": "Total",
    "কার্ট পেজ দেখুন": "View Cart",
    "চেকআউট": "Checkout",
    "CHECKOUT (অর্ডার করুন)": "CHECKOUT (Place Order)",
    "আপনার আরও পছন্দ হতে পারে": "You May Also Like",
    "সফল হয়েছে": "Success",
    "প্রোডাক্ট কার্টে যুক্ত হয়েছে": "Product added to cart",
    "কার্টে যুক্ত হয়েছে!": "Added to cart!",
    "অর্ডার কনফার্ম করুন": "Confirm Order",
    "আপনার নাম": "Your Name",
    "মোবাইল নম্বর": "Mobile Number",
    "সম্পূর্ণ ঠিকানা": "Full Delivery Address",
    "ডেলিভারি এরিয়া": "Delivery Area",
    "নোট বা বিশেষ নির্দেশনা": "Special Delivery Note",
    "অগ্রিম কোনো টাকা দিতে হবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।": "No advance payment needed, pay cash when product arrives.",
    "Back to Shop / হোম পেজে যান": "Back to Shop / Home",
    "ঢাকার ভেতরে": "Inside Dhaka",
    "ঢাকার বাইরে": "Outside Dhaka",
    "অন্যান্য জেলা": "Other Districts",
    "শুধু এটি": "Only this",
    "স্টক আউট": "Out of Stock",
    "স্ট্যান্ডার্ড প্যাক": "Standard Pack",
    "স্ট্যান্ডার্ড প্যাকেজ": "Standard Package",
    "পণ্যের বিস্তারিত বিবরণ": "Full Description",
    "ডেলিভারি চার্জ:": "Delivery Charge:",
    "পেমেন্ট সুবিধা:": "Payment:",
    "ক্যাশ অন ডেলিভারি (পণ্য হাতে পেয়ে টাকা পরিশোধ)": "Cash on Delivery (Pay upon receiving product)",
    "সরাসরি অর্ডার করতে কল করুন": "Call to order directly",
    "অর্ডারের জন্য সরাসরি মেসেজ দিন": "Direct message for order",
    "মোট অর্ডার": "Total Orders",
    "মোট বিক্রয়": "Total Sales",
    "পেন্ডিং অর্ডার": "Pending Orders",
    "মোট প্রোডাক্টস": "Total Products",
    "মোট প্রোডাক্ট": "Total Products",
    "সবগুলো": "All Orders",
    "পেন্ডিং": "Pending",
    "কনফার্মড": "Confirmed",
    "ডেলিভার্ড": "Delivered",
    "বাতিল/রিটার্ন": "Cancelled/Return",
    "রিটার্ন": "Returned",
    "অর্ডার আইডি": "Order ID",
    "তারিখ": "Date",
    "গ্রাহক": "Customer",
    "গ্রাহকের নাম": "Customer Name",
    "ফোন": "Phone",
    "ঠিকানা": "Address",
    "পরিমাণ": "Qty",
    "মূল্য": "Amount",
    "স্ট্যাটাস": "Status",
    "অ্যাকশন": "Action",
    "মার্কেট / রেগুলার প্রাইজ": "Market / Regular Price",
    "মার্কেট প্রাইজ": "Market Price",
    "ডিসকাউন্ট (% ছাড়)": "Discount (% Off)",
    "ডিসকাউন্ট অফার মূল্য": "Discount Offer Price",
    "ডিসকাউন্ট প্রাইজ": "Discount Price",
    "প্রোডাক্ট সেভ করুন": "Save Product",
    "রামপুরা, ঢাকা, বাংলাদেশ": "Rampura, Dhaka, Bangladesh",
    "তথ্য ও সহায়িকা": "Information",
    "ক্যাটাগরি সমূহ": "Categories",
    "গ্রাহক সহায়তা": "Support",
    "গ্রাহক পলিসি": "Consumer Policy",
    "আমাদের সম্পর্কে": "About Us",
    "যোগাযোগ": "Contact Us",
    "শর্তাবলী": "Terms & Conditions",
    "গোপনীয়তা নীতি": "Privacy Policy",
    "পেমেন্ট মাধ্যম": "Payment Methods",
    "বিকাশ": "bKash",
    "নগদ": "Nagad",
    "Admin Control Panel": "Admin Control Panel",
    "ওয়েবসাইট": "Website",
    "রিসেট": "Reset",
    "অর্ডার তালিকা": "Order List",
    "স্ট্যাটাস অপশন থেকে কনফার্ম, বাতিল বা রিটার্ন সিলেক্ট করুন": "Select confirmed, cancelled, or returned from status options.",
    "অর্ডার নং ও সময়": "Order No & Date",
    "গ্রাহকের নাম ও এলাকা": "Customer Name & Area",
    "রিস্ক ফিল্টার": "Risk Filter",
    "মোট বিল": "Total Bill",
    "স্টক অবস্থা": "Stock Status",
    "স্ট্যাটাস পরিবর্তন (১টি অপশন)": "Change Status",
    "ইনভয়েস": "Invoice",
    "স্টক সঠিক আছে": "Stock In Stock",
    "পেন্ডিং (কল দিন)": "Pending (Call)",
    "কনফার্ম (প্যাক পাঠান)": "Confirmed (Pack & Ship)",
    "বাতিল (অর্ডার বাতিল)": "Cancelled (Cancel Order)",
    "রিটার্ন (ফেরত পণ্য)": "Returned (Return)",
    "রিস্ক কাস্টমার": "High Risk Customer",
    "নতুন কাস্টমার": "New Customer",
    "বিশ্বস্ত Customer": "Trusted Customer",
    "ক্যাটাগরি ও বিভাগ পরিচালনা": "Category & Department Management",
    "নতুন ক্যাটাগরি তৈরি করুন, ছবি দিন এবং ওয়েবসাইটে কোন প্রোডাক্ট কোথায় থাকবে তা নিয়ন্ত্রণ করুন।": "Create new categories, upload images, and control product placement on the website.",
    "নতুন ক্যাটাগরি যোগ করুন": "Add New Category",
    "নতুন ক্যাটাগরি তৈরি করুন": "Create New Category",
    "পাবলিক ভিউ": "Public View",
    "ক্যাটাগরির নাম": "Category Name",
    "ছবি আপলোড করুন (বা ইমেজ লিংক)": "Upload Image (or URL)",
    "ইমেজ না দিলে স্বয়ংক্রিয়ভাবে ডিফল্ট সুন্দর অর্গানিক ছবি সেট হবে।": "If no image is provided, a default organic food image will be set.",
    "সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)": "Short Description (Optional)",
    "ক্যাটাগরি সংরক্ষণ করুন": "Save Category",
    "নতুন প্রোডাক্ট যুক্ত করুন": "Add New Product",
    "কম্পিউটার থেকে ছবি আপলোড করুন এবং পণ্যের বিবরণ দিন": "Upload photo from computer and provide product details.",
    "প্রোডাক্টের নাম": "Product Name",
    "ক্যাটাগরি নির্বাচন করুন": "Select Category",
    "ক্যাটাগরি নির্বাচন করুন (কোন গ্রুপে পণ্যটি দেখাবে)": "Select Category (Where product will be displayed)",
    "পণ্যটি যে ক্যাটাগরি সিলেক্ট করবেন ওয়েবসাইটে সেই ক্যাটাগরির অধীনে প্রদর্শিত হবে।": "The product will appear on the website under the selected category.",
    "পরিমাণ / ওজন (প্যাক সাইজ)": "Quantity / Weight (Pack Size)",
    "মার্কেট প্রাইজ ও ডিসকাউন্ট অফার": "Market Price & Discount Offer",
    "মার্কেট / রেগুলার প্রাইজ (৳)": "Market / Regular Price (৳)",
    "ডিসকাউন্ট অফার মূল্য (৳)": "Discount Offer Price (৳)",
    "স্টক পরিমাণ (পিস)": "Stock Quantity (Pcs)",
    "পণ্যের ছবি (কম্পিউটার থেকে আপলোড)": "Product Image (Upload from Computer)",
    "ছবি পরিবর্তন করুন": "Change Image",
    "ছবি সিলেক্ট করুন": "Select Image",
    "পণ্যের সংক্ষিপ্ত বিবরণ": "Short Description",
    "টপ সেলিং (বেস্টসেলার হিসেবে হোমপেজে দেখাবে)": "Top Selling (Display as bestseller on homepage)",
    "ফিচার্ড প্রোডাক্ট": "Featured Product",
    "তালিকায় ফিরুন": "Back to List"
};
    const EN_TO_BN = {
    "Amar Bazar": "আমার বাজার",
    "Amar": "আমার",
    "Bazar": "বাজার",
    "100% Pure & Organic Food — Fast Delivery Across Bangladesh": "১০০% প্রাকৃতিক ও স্বাস্থ্যকর খাবার — সারা বাংলাদেশে দ্রুত হোম ডেলিভারি",
    "100% Pure & Safe Food": "১০০% খাঁটি ও নিরাপদ খাদ্য",
    "100% Pure & Safe Organic Food": "১০০% খাঁটি ও নিরাপদ অর্গানিক খাদ্যপণ্য",
    "100% Pure & Natural": "১০০% খাঁটি ও প্রাকৃতিক",
    "Sundarban Pure": "সুন্দরবনের খাঁটি",
    "Raw Comb Honey": "চাকের কাঁচা মধু",
    "Harvested directly from deep forests, without any chemicals.": "গভীর অরণ্য থেকে সরাসরি সংগৃহীত, কোনো কেমিক্যাল ছাড়া।",
    "Order Now": "অর্ডার করুন",
    "View All Honey": "সব মধু দেখুন",
    "Traditional Taste": "ঐতিহ্যবাহী স্বাদ",
    "Pure Desi Cow": "দেশি গরুর খাঁটি",
    "Gawa Ghee & Mustard Oil": "গাওয়া ঘি ও সরিষার তেল",
    "Cold-pressed pure mustard oil and healthy grass-fed gawa ghee.": "কাঠের ঘানিতে ভাঙা খাঁটি সরিষার তেল এবং স্বাস্থ্যসম্মত গাওয়া ঘি।",
    "Buy Now": "কিনুন এখনই",
    "Authentic Taste of Madinah": "মদিনার আসল স্বাদ",
    "Premium Ajwa &": "প্রিমিয়াম আজওয়া ও",
    "Medjool Dates": "মেডজুল খেজুর",
    "Rich source of energy & nutrition. Premium handpicked dry fruits for family.": "পুষ্টি ও শক্তির ভরপুর উৎস। পরিবারের জন্য বাছাইকৃত প্রিমিয়াম ড্রাই ফ্রুটস।",
    "Special Combo Offer": "স্পেশাল কম্বো অফার",
    "Sundarban Pure Honey": "সুন্দরবনের খাঁটি মধু",
    "+ Special Honey Nut": "+ স্পেশাল হানি নাট",
    "Best healthy combo to boost immunity and sustained energy.": "রোগ প্রতিরোধ ক্ষমতা ও এনার্জি বৃদ্ধির জন্য সেরা স্বাস্থ্যকর কম্বো।",
    "Order Directly": "সরাসরি অর্ডার করুন",
    "100% Pure Food": "১০০% খাঁটি পণ্য",
    "Completely Natural": "সম্পূর্ণ প্রাকৃতিক",
    "Fast Delivery": "দ্রুত ডেলিভারি",
    "All Over Bangladesh": "সারা বাংলাদেশে",
    "Cash on Delivery": "ক্যাশ অন ডেলিভারি",
    "Pay after receiving product": "পণ্য পেয়ে মূল্য পরিশোধ",
    "Return Guarantee": "রিটার্ন গ্যারান্টি",
    "Easy Hassle-free Returns": "সহজে রিটার্ন করুন",
    "Pure Honey Collection": "খাঁটি মধু সম্ভার",
    "Cold Pressed Oil & Ghee": "ঘানি ভাঙা তেল ও গাওয়া ঘি",
    "Premium Dates Collection": "প্রিমিয়াম খেজুর কালেকশন",
    "Featured Categories": "জনপ্রিয় ক্যাটাগরি",
    "Top Selling Products": "সেরা বিক্রিত পণ্য",
    "Our Brands": "আমাদের ব্র্যান্ডসমূহ",
    "All Natural Honey": "সকল প্রাকৃতিক মধু",
    "Cooking Essentials": "রান্নার প্রয়োজনীয় পণ্য",
    "View All Items": "সবগুলো দেখুন",
    "VIEW ALL ITEMS": "VIEW ALL ITEMS",
    "Why Choose Amar Bazar?": "কেন 'আমার বাজার' বেছে নেবেন?",
    "100% Purity Commitment": "১০০% বিশুদ্ধতার অঙ্গীকার",
    "Completely natural food products free from chemicals, colors, or preservatives.": "কোনো কেমিক্যাল, কৃত্রিম রং বা প্রিজারভেটিভ ছাড়া সম্পূর্ণ প্রাকৃতিক খাদ্যপণ্য।",
    "Safe Premium Packaging": "নিরাপদ প্রিমিয়াম প্যাকেজিং",
    "Freshness & nutrition preserved in food-grade airtight packaging.": "ফুড-গ্রেড ও এয়ারটাইট প্যাকেজিংয়ে পণ্যের সতেজতা ও পুষ্টিগুণ নিশ্চিত।",
    "24/7 Customer Support": "২৪/৭ কাস্টমার সাপোর্ট",
    "Always get quick support via hotline and WhatsApp for any questions.": "যেকোনো জিজ্ঞাসায় হটলাইন ও হোয়াটসঅ্যাপে সবসময় সহায়তা পাবেন।",
    "Offer Zone": "অফার জোন",
    "Oil & Ghee": "তেল ও ঘি",
    "Honey": "মধু",
    "Pure Honey": "খাঁটি মধু",
    "Dates": "খেজুর",
    "Premium Dates": "প্রিমিয়াম খেজুর",
    "Spices": "মশলা",
    "Pure Spices": "খাঁটি মশলা",
    "Nuts & Seeds": "বাদাম ও বীজ",
    "Rice": "চাল",
    "Flours & Lentils": "আটা ও ডাল",
    "Certified": "সার্টিফাইড",
    "Pickle": "আচার",
    "Tabaya": "তবায়া",
    "Organic Food": "অর্গানিক ফুড",
    "Categories": "ক্যাটাগরি সমূহ",
    "All Categories": "সকল ক্যাটাগরি",
    "Language:": "ভাষা / Language:",
    "Mustard Oil": "সরিষার তেল",
    "Pure Gawa Ghee": "খাঁটি গাওয়া ঘি",
    "Coconut Oil": "নারিকেল তেল",
    "Sesame Oil": "তিলের তেল",
    "Black Seed Honey": "কালোজিরা মধু",
    "Lychee Flower Honey": "লিচু ফুলের মধু",
    "Sidr Honey": "সিদর মধু",
    "Honeycomb Honey": "চাকের মধু",
    "Ajwa Dates": "আজওয়া খেজুর",
    "Mabroom Dates": "মাব্রুম খেজুর",
    "Turmeric Powder": "হলুদ গুঁড়া",
    "Chili Powder": "মরিচ গুঁড়া",
    "Coriander Powder": "ধনিয়া গুঁড়া",
    "Cashew Nut": "কাজু বাদাম",
    "Almond": "কাঠ বাদাম",
    "Pistachio": "পেস্তা বাদাম",
    "Add To Cart": "কার্টে যোগ করুন",
    "Place Order": "অর্ডার সম্পন্ন করুন",
    "Search": "সার্চ করুন",
    "Paste": "পেস্ট",
    "New Order": "নতুন অর্ডার",
    "Create New Order": "নতুন অর্ডার তৈরি",
    "Orders": "অর্ডারসমূহ",
    "Products & Stock": "প্রোডাক্ট ও স্টক",
    "Customers & Fraud": "কাস্টমার ও ফ্রড",
    "Save": "সংরক্ষণ করুন",
    "Cancel": "বাতিল",
    "Delete": "মুছে ফেলুন",
    "Edit": "এডিট",
    "Details": "বিস্তারিত",
    "Close": "বন্ধ করুন",
    "Dashboard": "ড্যাশবোর্ড",
    "Logout": "লগআউট",
    "Admin": "অ্যাডমিন",
    "Admin Panel": "অ্যাডমিন প্যানেল",
    "Admin Control": "অ্যাডমিন কন্ট্রোল",
    "Order Management": "অর্ডার ম্যানেজমেন্ট",
    "Orders Dashboard": "অর্ডার ড্যাশবোর্ড",
    "Orders & Delivery Dashboard": "অর্ডার ও ডেলিভারি ড্যাশবোর্ড",
    "Manage order confirmation, cancellation, or return after calling the customer.": "কাস্টমারের সাথে কথা বলে অর্ডার কনফার্ম, বাতিল বা রিটার্ন পরিচালনা করুন",
    "Return to Storefront Website": "পাবলিক ওয়েবসাইটে ফিরে যান",
    "Login": "লগইন করুন",
    "Remember Me": "আমাকে মনে রাখুন",
    "Admin Access Only": "অ্যাডমিন অ্যাক্সেস অনলি",
    "Password": "পাসওয়ার্ড",
    "Username or Email": "ইমেইল অথবা ইউজারনেম",
    "Enter your username or email": "আপনার ইমেইল অথবা ইউজারনেম দিন",
    "Enter your password": "আপনার পাসওয়ার্ড দিন",
    "Secure Admin Control Panel": "সুরক্ষিত অ্যাডমিন কন্ট্রোল প্যানেল",
    "Enter your admin credentials to manage orders and stock": "অর্ডার ও স্টক পরিচালনা করতে আপনার অ্যাডমিন তথ্য দিয়ে প্রবেশ করুন",
    "Shopping Cart": "শপিং কার্ট",
    "🛒 Shopping Cart": "🛒 শপিং কার্ট",
    "Your cart is empty": "আপনার কার্ট খালি আছে",
    "Start Shopping": "কেনাকাটা শুরু করুন",
    "Total:": "সর্বমোট:",
    "Total": "মোট",
    "View Cart": "কার্ট পেজ দেখুন",
    "Checkout": "চেকআউট",
    "CHECKOUT (Place Order)": "CHECKOUT (অর্ডার করুন)",
    "You May Also Like": "আপনার আরও পছন্দ হতে পারে",
    "Success": "সফল হয়েছে",
    "Product added to cart": "প্রোডাক্ট কার্টে যুক্ত হয়েছে",
    "Added to cart!": "কার্টে যুক্ত হয়েছে!",
    "Confirm Order": "অর্ডার কনফার্ম করুন",
    "Your Name": "আপনার নাম",
    "Mobile Number": "মোবাইল নম্বর",
    "Full Delivery Address": "সম্পূর্ণ ঠিকানা",
    "Delivery Area": "ডেলিভারি এরিয়া",
    "Special Delivery Note": "নোট বা বিশেষ নির্দেশনা",
    "No advance payment needed, pay cash when product arrives.": "অগ্রিম কোনো টাকা দিতে হবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।",
    "Back to Shop / Home": "Back to Shop / হোম পেজে যান",
    "Inside Dhaka": "ঢাকার ভেতরে",
    "Outside Dhaka": "ঢাকার বাইরে",
    "Other Districts": "অন্যান্য জেলা",
    "Only this": "শুধু এটি",
    "Out of Stock": "স্টক আউট",
    "Standard Pack": "স্ট্যান্ডার্ড প্যাক",
    "Standard Package": "স্ট্যান্ডার্ড প্যাকেজ",
    "Full Description": "পণ্যের বিস্তারিত বিবরণ",
    "Delivery Charge:": "ডেলিভারি চার্জ:",
    "Payment:": "পেমেন্ট সুবিধা:",
    "Cash on Delivery (Pay upon receiving product)": "ক্যাশ অন ডেলিভারি (পণ্য হাতে পেয়ে টাকা পরিশোধ)",
    "Call to order directly": "সরাসরি অর্ডার করতে কল করুন",
    "Direct message for order": "অর্ডারের জন্য সরাসরি মেসেজ দিন",
    "Total Orders": "মোট অর্ডার",
    "Total Sales": "মোট বিক্রয়",
    "Pending Orders": "পেন্ডিং অর্ডার",
    "Total Products": "মোট প্রোডাক্ট",
    "All Orders": "সবগুলো",
    "Pending": "পেন্ডিং",
    "Confirmed": "কনফার্মড",
    "Delivered": "ডেলিভার্ড",
    "Cancelled/Return": "বাতিল/রিটার্ন",
    "Returned": "রিটার্ন",
    "Order ID": "অর্ডার আইডি",
    "Date": "তারিখ",
    "Customer": "গ্রাহক",
    "Customer Name": "গ্রাহকের নাম",
    "Phone": "ফোন",
    "Address": "ঠিকানা",
    "Qty": "পরিমাণ",
    "Amount": "মূল্য",
    "Status": "স্ট্যাটাস",
    "Action": "অ্যাকশন",
    "Market / Regular Price": "মার্কেট / রেগুলার প্রাইজ",
    "Market Price": "মার্কেট প্রাইজ",
    "Discount (% Off)": "ডিসকাউন্ট (% ছাড়)",
    "Discount Offer Price": "ডিসকাউন্ট অফার মূল্য",
    "Discount Price": "ডিসকাউন্ট প্রাইজ",
    "Save Product": "প্রোডাক্ট সেভ করুন",
    "Rampura, Dhaka, Bangladesh": "রামপুরা, ঢাকা, বাংলাদেশ",
    "Information": "তথ্য ও সহায়িকা",
    "Support": "গ্রাহক সহায়তা",
    "Consumer Policy": "গ্রাহক পলিসি",
    "About Us": "আমাদের সম্পর্কে",
    "Contact Us": "যোগাযোগ",
    "Terms & Conditions": "শর্তাবলী",
    "Privacy Policy": "গোপনীয়তা নীতি",
    "Payment Methods": "পেমেন্ট মাধ্যম",
    "bKash": "বিকাশ",
    "Nagad": "নগদ",
    "Admin Control Panel": "Admin Control Panel",
    "Website": "ওয়েবসাইট",
    "Reset": "রিসেট",
    "Order List": "অর্ডার তালিকা",
    "Select confirmed, cancelled, or returned from status options.": "স্ট্যাটাস অপশন থেকে কনফার্ম, বাতিল বা রিটার্ন সিলেক্ট করুন",
    "Order No & Date": "অর্ডার নং ও সময়",
    "Customer Name & Area": "গ্রাহকের নাম ও এলাকা",
    "Risk Filter": "রিস্ক ফিল্টার",
    "Total Bill": "মোট বিল",
    "Stock Status": "স্টক অবস্থা",
    "Change Status": "স্ট্যাটাস পরিবর্তন (১টি অপশন)",
    "Invoice": "ইনভয়েস",
    "Stock In Stock": "স্টক সঠিক আছে",
    "Pending (Call)": "পেন্ডিং (কল দিন)",
    "Confirmed (Pack & Ship)": "কনফার্ম (প্যাক পাঠান)",
    "Cancelled (Cancel Order)": "বাতিল (অর্ডার বাতিল)",
    "Returned (Return)": "রিটার্ন (ফেরত পণ্য)",
    "High Risk Customer": "রিস্ক কাস্টমার",
    "New Customer": "নতুন কাস্টমার",
    "Trusted Customer": "বিশ্বস্ত Customer",
    "Category & Department Management": "ক্যাটাগরি ও বিভাগ পরিচালনা",
    "Create new categories, upload images, and control product placement on the website.": "নতুন ক্যাটাগরি তৈরি করুন, ছবি দিন এবং ওয়েবসাইটে কোন প্রোডাক্ট কোথায় থাকবে তা নিয়ন্ত্রণ করুন।",
    "Add New Category": "নতুন ক্যাটাগরি যোগ করুন",
    "Create New Category": "নতুন ক্যাটাগরি তৈরি করুন",
    "Public View": "পাবলিক ভিউ",
    "Category Name": "ক্যাটাগরির নাম",
    "Upload Image (or URL)": "ছবি আপলোড করুন (বা ইমেজ লিংক)",
    "If no image is provided, a default organic food image will be set.": "ইমেজ না দিলে স্বয়ংক্রিয়ভাবে ডিফল্ট সুন্দর অর্গানিক ছবি সেট হবে।",
    "Short Description (Optional)": "সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)",
    "Save Category": "ক্যাটাগরি সংরক্ষণ করুন",
    "Add New Product": "নতুন প্রোডাক্ট যুক্ত করুন",
    "Upload photo from computer and provide product details.": "কম্পিউটার থেকে ছবি আপলোড করুন এবং পণ্যের বিবরণ দিন",
    "Product Name": "প্রোডাক্টের নাম",
    "Select Category": "ক্যাটাগরি নির্বাচন করুন",
    "Select Category (Where product will be displayed)": "ক্যাটাগরি নির্বাচন করুন (কোন গ্রুপে পণ্যটি দেখাবে)",
    "The product will appear on the website under the selected category.": "পণ্যটি যে ক্যাটাগরি সিলেক্ট করবেন ওয়েবসাইটে সেই ক্যাটাগরির অধীনে প্রদর্শিত হবে।",
    "Quantity / Weight (Pack Size)": "পরিমাণ / ওজন (প্যাক সাইজ)",
    "Market Price & Discount Offer": "মার্কেট প্রাইজ ও ডিসকাউন্ট অফার",
    "Market / Regular Price (৳)": "মার্কেট / রেগুলার প্রাইজ (৳)",
    "Discount Offer Price (৳)": "ডিসকাউন্ট অফার মূল্য (৳)",
    "Stock Quantity (Pcs)": "স্টক পরিমাণ (পিস)",
    "Product Image (Upload from Computer)": "পণ্যের ছবি (কম্পিউটার থেকে আপলোড)",
    "Change Image": "ছবি পরিবর্তন করুন",
    "Select Image": "ছবি সিলেক্ট করুন",
    "Short Description": "পণ্যের সংক্ষিপ্ত বিবরণ",
    "Top Selling (Display as bestseller on homepage)": "টপ সেলিং (বেস্টসেলার হিসেবে হোমপেজে দেখাবে)",
    "Featured Product": "ফিচার্ড প্রোডাক্ট",
    "Back to List": "তালিকায় ফিরুন"
};

    const BN_KEYS = Object.keys(BN_TO_EN).sort((a, b) => b.length - a.length);
    const EN_KEYS = Object.keys(EN_TO_BN).sort((a, b) => b.length - a.length);

    window.switchLanguage = function (lang) {
        if (lang !== 'bn' && lang !== 'en') lang = 'bn';
        currentLang = lang;
        localStorage.setItem('amar_bazar_lang', lang);

        updateToggleButtons(lang);
        translatePage(lang);

        fetch('/set-locale/' + lang).catch(function () {});
    };

    function updateToggleButtons(lang) {
        document.querySelectorAll('.lang-toggle-container').forEach(function (container) {
            const btnBn = container.querySelector('.btn-lang-bn');
            const btnEn = container.querySelector('.btn-lang-en');
            const isDark = container.classList.contains('dark-theme');

            if (lang === 'bn') {
                if (btnBn) {
                    btnBn.className = 'btn-lang-bn px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs';
                }
                if (btnEn) {
                    const textClass = isDark ? 'text-slate-300 hover:text-white' : 'text-gray-500 hover:text-gray-900';
                    btnEn.className = 'btn-lang-en px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-semibold transition flex items-center gap-1 ' + textClass;
                }
            } else {
                if (btnEn) {
                    btnEn.className = 'btn-lang-en px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-black transition flex items-center gap-1 bg-[#F48721] text-white shadow-xs';
                }
                if (btnBn) {
                    const textClass = isDark ? 'text-slate-300 hover:text-white' : 'text-gray-500 hover:text-gray-900';
                    btnBn.className = 'btn-lang-bn px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-semibold transition flex items-center gap-1 ' + textClass;
                }
            }
        });
    }

    function translateText(text, lang) {
        if (!text || typeof text !== 'string') return text;
        const trimmed = text.trim();
        if (!trimmed) return text;

        if (lang === 'en') {
            if (BN_TO_EN[trimmed]) {
                return text.replace(trimmed, BN_TO_EN[trimmed]);
            }
            let replaced = text;
            for (let i = 0; i < BN_KEYS.length; i++) {
                const k = BN_KEYS[i];
                if (replaced.indexOf(k) !== -1) {
                    replaced = replaced.split(k).join(BN_TO_EN[k]);
                }
            }
            return replaced;
        } else {
            if (EN_TO_BN[trimmed]) {
                return text.replace(trimmed, EN_TO_BN[trimmed]);
            }
            let replaced = text;
            for (let i = 0; i < EN_KEYS.length; i++) {
                const k = EN_KEYS[i];
                if (replaced.indexOf(k) !== -1) {
                    replaced = replaced.split(k).join(EN_TO_BN[k]);
                }
            }
            return replaced;
        }
    }

    function isProductContent(element) {
        if (!element) return false;

        // Skip product titles
        if (element.classList && (
            element.classList.contains('gb-product-h-name') ||
            element.closest('.gb-product-h-name') ||
            element.classList.contains('line-clamp-2') ||
            element.closest('.line-clamp-2')
        )) {
            return true;
        }

        // Skip product description areas
        if (element.classList && (
            element.classList.contains('product-description') ||
            element.closest('.product-description') ||
            element.classList.contains('prose') ||
            element.closest('.prose')
        )) {
            return true;
        }

        // Check if inside detail page product title or descriptions
        const h1 = element.closest('h1');
        if (h1 && h1.parentElement && h1.parentElement.querySelector('input[name="product_id"]')) {
            return true;
        }

        return false;
    }

    function translatePage(lang) {
        // 1. Translate search and form placeholders
        document.querySelectorAll('input, textarea').forEach(function (el) {
            const ph = el.getAttribute('placeholder');
            if (ph) {
                el.setAttribute('placeholder', translateText(ph, lang));
            }
        });

        // 2. Translate text nodes
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function (node) {
                    if (!node.nodeValue || !node.nodeValue.trim()) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    const parent = node.parentElement;
                    if (!parent) return NodeFilter.FILTER_REJECT;

                    const tag = parent.tagName.toLowerCase();
                    if (tag === 'script' || tag === 'style' || tag === 'code' || tag === 'pre' || tag === 'svg') {
                        return NodeFilter.FILTER_REJECT;
                    }

                    // Ignore language switcher pill itself
                    if (parent.closest('.lang-toggle-container')) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    // PROTECT: Product titles and descriptions remain intact
                    if (isProductContent(parent)) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    return NodeFilter.FILTER_ACCEPT;
                }
            },
            false
        );

        const nodes = [];
        while (walker.nextNode()) {
            nodes.push(walker.currentNode);
        }

        nodes.forEach(function (node) {
            const orig = node.nodeValue;
            const translated = translateText(orig, lang);
            if (orig !== translated) {
                node.nodeValue = translated;
            }
        });

        document.documentElement.lang = lang;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const activeLang = localStorage.getItem('amar_bazar_lang') || 'bn';
        updateToggleButtons(activeLang);
        if (activeLang === 'en') {
            translatePage('en');
        }
    });
})();
