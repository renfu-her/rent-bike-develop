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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->comment('訂單 ID');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade')->comment('機車 ID');
            $table->integer('quantity')->default(1)->comment('數量');
            $table->decimal('subtotal', 10, 2)->comment('小計');
            $table->decimal('total', 10, 2)->comment('總計');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
