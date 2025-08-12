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
        Schema::create('motorcycle_accessories', function (Blueprint $table) {
            $table->id();
            $table->string('model')->comment('型號');
            $table->integer('quantity')->default(0)->comment('數量');
            $table->enum('status', ['待出租', '出租中', '停用'])->default('待出租')->comment('狀態');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motorcycle_accessories');
    }
};
