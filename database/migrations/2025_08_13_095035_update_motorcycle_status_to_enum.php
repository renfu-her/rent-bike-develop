<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            // 先將現有的 status 值轉換為新的 enum 值
            DB::statement("UPDATE motorcycles SET status = 'available' WHERE status = 'available'");
            DB::statement("UPDATE motorcycles SET status = 'rented' WHERE status = 'rented'");
            DB::statement("UPDATE motorcycles SET status = 'maintenance' WHERE status = 'maintenance'");
            
            // 修改欄位為 enum
            $table->enum('status', ['available', 'rented', 'maintenance', 'pending_checkout'])
                ->default('available')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->string('status', 20)->default('available')->change();
        });
    }
};
