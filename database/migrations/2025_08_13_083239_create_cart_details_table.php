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
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade')->comment('購物車 ID');
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade')->comment('機車 ID');
            $table->integer('quantity')->default(1)->comment('數量');
            $table->date('rent_date')->comment('租車日期');
            $table->date('return_date')->comment('還車日期');
            $table->decimal('unit_price', 10, 2)->comment('單價');
            $table->decimal('subtotal', 10, 2)->comment('小計');
            $table->text('notes')->nullable()->comment('備註');
            $table->timestamps();
            
            $table->index(['cart_id', 'motorcycle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_details');
    }
};
