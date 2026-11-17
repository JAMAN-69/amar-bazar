<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('total_sales')->default(0)->after('stock');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_stock_deducted')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('total_sales');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_stock_deducted');
        });
    }
};
