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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->onDelete('cascade')->comment('會員 ID');
            $table->string('session_id')->nullable()->comment('Session ID (未登入用戶)');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('總金額');
            $table->enum('status', ['active', 'checkout', 'completed', 'abandoned'])->default('active')->comment('購物車狀態');
            $table->timestamp('expires_at')->nullable()->comment('過期時間');
            $table->timestamps();
            
            $table->index(['member_id', 'status']);
            $table->index(['session_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
