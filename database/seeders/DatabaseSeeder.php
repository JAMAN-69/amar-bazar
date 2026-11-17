<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $categories = [
            [
                'name' => 'তেল ও ঘি',
                'slug' => 'oil-and-ghee',
                'icon' => 'fa-bottle-droplet',
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&auto=format&fit=crop&q=80',
                'description' => 'কাঠের ঘানিতে ভাঙা খাঁটি সরিষার তেল এবং দেশি গাওয়া ঘি',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'খাঁটি মধু',
                'slug' => 'pure-honey',
                'icon' => 'fa-jar',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=500&auto=format&fit=crop&q=80',
                'description' => 'সুন্দরবন ও কালোজিরা ফুলের ১০০% প্রাকৃতিক মধু',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'প্রিমিয়াম খেজুর',
                'slug' => 'premium-dates',
                'icon' => 'fa-leaf',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?w=500&auto=format&fit=crop&q=80',
                'description' => 'মদিনার আজওয়া, মেদজুল, সুক্কারি ও মরিয়ম খেজুর',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'বাদাম ও বীজ',
                'slug' => 'nuts-and-seeds',
                'icon' => 'fa-bowl-food',
                'image' => 'https://images.unsplash.com/photo-1508061253366-f7da158b6d46?w=500&auto=format&fit=crop&q=80',
                'description' => 'হানি নাট, কাঠবাদাম, কাজুবাদাম এবং চিয়া সিড',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'খাঁটি মশলা',
                'slug' => 'pure-spices',
                'icon' => 'fa-mortar-pestle',
                'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500&auto=format&fit=crop&q=80',
                'description' => 'কালা ভুনা মশলা, খাঁটি হলুদ, মরিচ ও ধনিয়া গুঁড়া',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'অর্গানিক ফুড',
                'slug' => 'organic-foods',
                'icon' => 'fa-seedling',
                'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=500&auto=format&fit=crop&q=80',
                'description' => 'অর্গানিক অ্যাপল সিডার ভিনেগার, ব্রাউন সুগার ও গ্রিন টি',
                'is_featured' => true,
                'sort_order' => 6,
            ],
        ];

        $createdCats = [];
        foreach ($categories as $cat) {
            $createdCats[$cat['slug']] = Category::create($cat);
        }

        // 2. Products
        $products = [
            // Honey
            [
                'category_id' => $createdCats['pure-honey']->id,
                'name' => 'সুন্দরবনের প্রাকৃতিক চাকের মধু (Sundarban Pure Honey)',
                'slug' => 'sundarban-pure-honey',
                'subtitle' => '১ কেজি প্রিমিয়াম জার',
                'short_description' => 'সুন্দরবনের গভীর জঙ্গল থেকে সংগৃহীত ১০০% অপরিশোধিত ও প্রাকৃতিকভাবে সমৃদ্ধ খাঁটি মধু।',
                'description' => 'আমাদের এই মধু সরাসরি সুন্দরবনের মৌয়ালদের মাধ্যমে সংগৃহীত। এতে কোনো ধরনের কৃত্রিম চিনি বা কেমিক্যাল নেই। পুষ্টিগুণে ভরপুর এই মধু সর্দি-কাশি নিরাময়ে এবং রোগ প্রতিরোধ ক্ষমতা বাড়াতে অতুলনীয়।',
                'regular_price' => 1250,
                'sale_price' => 1050,
                'stock' => 85,
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.9,
                'reviews_count' => 128,
                'is_featured' => true,
                'is_top_selling' => true,
            ],
            [
                'category_id' => $createdCats['pure-honey']->id,
                'name' => 'কালোজিরা ফুলের খাঁটি মধু (Black Seed Flower Honey)',
                'slug' => 'black-seed-flower-honey',
                'subtitle' => '৫০০ গ্রাম জার',
                'short_description' => 'কালোজিরা ফুলের সুগন্ধযুক্ত প্রাকৃতিক ও ওষধি গুণসম্পন্ন গাঢ় মধু।',
                'description' => 'কালোজিরা ফুলের মধু এর অনন্য স্বাদ এবং প্রাকৃতিক আরোগ্য শক্তির জন্য সুপরিচিত। নিয়মিত সেবনে দৈনন্দিন এনার্জি বাড়ে এবং হজমশক্তি উন্নত হয়।',
                'regular_price' => 750,
                'sale_price' => 650,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1471943311424-646960669fbc?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.8,
                'reviews_count' => 84,
                'is_featured' => true,
                'is_top_selling' => true,
            ],

            // Oil & Ghee
            [
                'category_id' => $createdCats['oil-and-ghee']->id,
                'name' => 'খাঁটি গাওয়া ঘি (Traditional Cow Ghee)',
                'slug' => 'traditional-pure-cow-ghee',
                'subtitle' => '১ কেজি স্পেশাল প্যাক',
                'short_description' => 'গ্রামের দেশি গরুর খাঁটি দুধের মাখন থেকে তৈরি সুগন্ধযুক্ত দানাদার গাওয়া ঘি।',
                'description' => 'সম্পূর্ণ ঐতিহ্যবাহী উপায়ে জ্বাল দিয়ে তৈরি নির্ভেজাল খাঁটি গাওয়া ঘি। এর চমৎকার ঘ্রাণ ও স্বাদ যেকোনো খাবারের তৃপ্তি বাড়িয়ে দেবে বহুগুণ। কোনো প্রিজারভেটিভ বা রাসায়নিক রং নেই।',
                'regular_price' => 1850,
                'sale_price' => 1650,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1631709497146-a239ef373cf1?w=600&auto=format&fit=crop&q=80',
                'rating' => 5.0,
                'reviews_count' => 210,
                'is_featured' => true,
                'is_top_selling' => true,
            ],
            [
                'category_id' => $createdCats['oil-and-ghee']->id,
                'name' => 'কাঠের ঘানি ভাঙা খাঁটি সরিষার তেল (Cold Pressed Mustard Oil)',
                'slug' => 'wood-pressed-mustard-oil',
                'subtitle' => '৫ লিটার ক্যান',
                'short_description' => 'কাঠের ঘানিতে ধীরে ধীরে পেষণ করা ঝাঁঝালো ও ১০০% খাঁটি দেশি সরিষার তেল।',
                'description' => 'লো-টেম্পারেচার কোল্ড প্রেস পদ্ধতিতে ভাঙানো হওয়ায় সরিষার আসল পুষ্টি উপাদান এবং প্রাকৃতিক ঝাঁঝ অক্ষুণ্ণ থাকে। রান্না ও ত্বকের যত্নে ১০০% নিরাপদ।',
                'regular_price' => 1600,
                'sale_price' => 1420,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.9,
                'reviews_count' => 95,
                'is_featured' => true,
                'is_top_selling' => true,
            ],

            // Dates
            [
                'category_id' => $createdCats['premium-dates']->id,
                'name' => 'মদিনার প্রিমিয়াম আজওয়া খেজুর (Madinah Ajwa Dates VIP)',
                'slug' => 'madinah-ajwa-dates-vip',
                'subtitle' => '১ কেজি স্পেশাল গিফট বক্স',
                'short_description' => 'সরাসরি সৌদি আরবের মদিনা মুনাওয়ারা থেকে আমদানিকৃত সেরা মানের ভিআইপি আজওয়া খেজুর।',
                'description' => 'নরম, সুস্বাদু এবং হাদিস শরিফে বর্ণিত পুণ্যময় ও বরকতময় আজওয়া খেজুর। হার্ট সুস্থ রাখতে এবং রক্তশূন্যতা রোধে প্রতিদিন সকালে খাওয়ার উপযোগী।',
                'regular_price' => 1500,
                'sale_price' => 1280,
                'stock' => 70,
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?w=600&auto=format&fit=crop&q=80',
                'rating' => 5.0,
                'reviews_count' => 140,
                'is_featured' => true,
                'is_top_selling' => true,
            ],
            [
                'category_id' => $createdCats['premium-dates']->id,
                'name' => 'প্রিমিয়াম জাম্বো মেদজুল খেজুর (Premium Jumbo Medjool Dates)',
                'slug' => 'premium-jumbo-medjool-dates',
                'subtitle' => '১ কেজি বক্স',
                'short_description' => 'খেজুরের রাজা খ্যাত বড় আকারের মিষ্টি ও নরম রসালো মেদজুল খেজুর।',
                'description' => 'প্রাকৃতিক ক্যারামেলের মিষ্টি স্বাদযুক্ত মেদজুল খেজুর অত্যন্ত সুস্বাদু। বাচ্চাদের এবং পরিবারের সকলের প্রিয় স্বাস্থ্যকর স্ন্যাক্স।',
                'regular_price' => 1750,
                'sale_price' => 1550,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1628189871790-21a717277e92?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.9,
                'reviews_count' => 67,
                'is_featured' => true,
                'is_top_selling' => false,
            ],

            // Nuts & Seeds
            [
                'category_id' => $createdCats['nuts-and-seeds']->id,
                'name' => 'স্পেশাল প্রিমিয়াম হানি নাট (Special Honey Nuts Energy Mix)',
                'slug' => 'special-honey-nuts-energy-mix',
                'subtitle' => '৭০০ গ্রাম কাচের বয়াম',
                'short_description' => 'সুন্দরবনের খাঁটি মধু ও ১০ রকমের প্রিমিয়াম ড্রাই নাটসের পুষ্টিকর সুপারফুড কম্বো।',
                'description' => 'কাঠবাদাম, কাজুবাদাম, পেস্তাবাদাম, আখরোট, কিশমিশ, কালোজিরা, সূর্যমুখী বীজ ও কুমড়ার বীজের সাথে খাঁটি মধুর অনবদ্য মিশ্রণ। শারীরিক দুর্বলতা দূর করতে ও এনার্জি বাড়াতে অসাধারণ।',
                'regular_price' => 1250,
                'sale_price' => 990,
                'stock' => 110,
                'image' => 'https://images.unsplash.com/photo-1508061253366-f7da158b6d46?w=600&auto=format&fit=crop&q=80',
                'rating' => 5.0,
                'reviews_count' => 312,
                'is_featured' => true,
                'is_top_selling' => true,
            ],
            [
                'category_id' => $createdCats['nuts-and-seeds']->id,
                'name' => 'অর্গানিক মেক্সিকান চিয়া সিড (Organic Black Chia Seeds)',
                'slug' => 'organic-black-chia-seeds',
                'subtitle' => '৫০০ গ্রাম প্যাক',
                'short_description' => 'ওমেগা-৩, ফাইবার ও অ্যান্টিঅক্সিডেন্টে ভরপুর ১০০% বিশুদ্ধ অর্গানিক চিয়া সিড।',
                'description' => 'ওজন নিয়ন্ত্রণ, হজমশক্তি বৃদ্ধি ও হৃদরোগ প্রতিরোধে কার্যকর এই সুপারফুড। পানি, শরবত বা দইয়ের সাথে প্রতিদিন খাওয়ার জন্য আদর্শ।',
                'regular_price' => 600,
                'sale_price' => 480,
                'stock' => 90,
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.8,
                'reviews_count' => 76,
                'is_featured' => false,
                'is_top_selling' => true,
            ],

            // Spices
            [
                'category_id' => $createdCats['pure-spices']->id,
                'name' => 'ঐতিহ্যবাহী চাটগাঁইয়া কালা ভুনা মশলা (Chittagong Kala Bhuna Masala)',
                'slug' => 'chittagong-kala-bhuna-masala',
                'subtitle' => '২০০ গ্রাম স্পেশাল প্যাক',
                'short_description' => 'চট্টগ্রামের আসল স্বাদের ঐতিহ্যবাহী কালা ভুনা রান্নার জন্য বিশেষ স্পাইস ব্লেন্ড।',
                'description' => 'ঘরে বসেই রেস্তোরাঁ ও মেজবানি স্বাদের কাঠকালো ভুনা মাংস রান্নার জন্য এই মশলা অতুলনীয়। এতে বাড়তি কোনো অতিরিক্ত মশলা যোগ করতে হয় না।',
                'regular_price' => 380,
                'sale_price' => 320,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.9,
                'reviews_count' => 154,
                'is_featured' => true,
                'is_top_selling' => true,
            ],
            [
                'category_id' => $createdCats['pure-spices']->id,
                'name' => 'পাহাড়ি খাঁটি হলুদের গুঁড়া (Organic Pahari Turmeric Powder)',
                'slug' => 'organic-pahari-turmeric-powder',
                'subtitle' => '৫০০ গ্রাম ফ্রেশ প্যাক',
                'short_description' => 'বান্দরবানের পাহাড়ি প্রাকৃতিক কাঁচা হলুদ শুকিয়ে গুঁড়া করা উচ্চ কারকিউমিনযুক্ত খাঁটি হলুদ।',
                'description' => 'কোনো ধরনের কৃত্রিম রং, রাসায়নিক বা মিশ্রণ নেই। চমৎকার প্রাকৃতিক উজ্জ্বল হলুদ রং এবং আসল সুঘ্রাণ।',
                'regular_price' => 320,
                'sale_price' => 260,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.9,
                'reviews_count' => 89,
                'is_featured' => false,
                'is_top_selling' => false,
            ],

            // Organic Foods
            [
                'category_id' => $createdCats['organic-foods']->id,
                'name' => 'র অর্গানিক অ্যাপল সিডার ভিনেগার (Raw Apple Cider Vinegar With Mother)',
                'slug' => 'raw-organic-apple-cider-vinegar',
                'subtitle' => '৫০০ মিলি কাচের বোতল',
                'short_description' => 'উইথ দ্য মাদার সমৃদ্ধ আনফিল্টার্ড খাঁটি অর্গানিক আপেল সিডার ভিনেগার।',
                'description' => 'ওজন নিয়ন্ত্রণ, ব্লাড সুগার ব্যালেন্স ও ত্বকের সতেজতার জন্য বিশ্বমানের র অ্যাপল সিডার ভিনেগার।',
                'regular_price' => 850,
                'sale_price' => 720,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1577401239170-897942555fb3?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.7,
                'reviews_count' => 45,
                'is_featured' => true,
                'is_top_selling' => false,
            ],
            [
                'category_id' => $createdCats['organic-foods']->id,
                'name' => 'অর্গানিক কোকোনাট সুগার (Natural Coconut Blossom Sugar)',
                'slug' => 'natural-organic-coconut-sugar',
                'subtitle' => '৫০০ গ্রাম জার',
                'short_description' => 'সাদা চিনির সেরা স্বাস্থ্যকর বিকল্প—লো গ্লাইসেমিক ইনডেক্সযুক্ত প্রাকৃতিক নারিকেল চিনি।',
                'description' => 'ডায়াবেটিক ফ্রেন্ডলি এবং খনিজ উপাদানে সমৃদ্ধ প্রাকৃতিক মিষ্টি স্বাদ। চা, কফি বা রান্নায় সাধারণ চিনির বদলে ব্যবহার করুন।',
                'regular_price' => 650,
                'sale_price' => 550,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1581441363689-1f3c3c414635?w=600&auto=format&fit=crop&q=80',
                'rating' => 4.8,
                'reviews_count' => 32,
                'is_featured' => false,
                'is_top_selling' => false,
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
