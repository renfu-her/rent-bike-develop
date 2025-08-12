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
        Schema::create('motorcycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade')->comment('商店 ID');
            $table->string('name')->comment('名稱');
            $table->string('model')->comment('型號');
            $table->json('accessories')->nullable()->comment('機車配件 (JSON array)');
            $table->string('license_plate')->unique()->comment('車牌');
            $table->decimal('price', 10, 2)->comment('價格');
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available')->comment('狀態');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};
