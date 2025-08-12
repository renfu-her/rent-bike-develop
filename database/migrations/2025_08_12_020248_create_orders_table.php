<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade')->comment('商店 ID');
            $table->foreignId('member_id')->constrained()->onDelete('cascade')->comment('會員 ID');
            $table->decimal('total_price', 10, 2)->comment('全部價格');
            $table->date('rent_date')->comment('租車日期');
            $table->boolean('is_completed')->default(false)->comment('是否成交');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
