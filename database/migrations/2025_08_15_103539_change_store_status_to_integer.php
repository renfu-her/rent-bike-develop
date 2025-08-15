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
        // First, update existing data to convert string values to integers
        DB::table('stores')->where('status', '啟用')->update(['status' => 1]);
        DB::table('stores')->where('status', '停用')->update(['status' => 0]);
        
        // Then change the column type
        Schema::table('stores', function (Blueprint $table) {
            $table->integer('status')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, change the column type back to string
        Schema::table('stores', function (Blueprint $table) {
            $table->string('status')->default('啟用')->change();
        });
        
        // Then, update existing data to convert integer values back to strings
        DB::table('stores')->where('status', 1)->update(['status' => '啟用']);
        DB::table('stores')->where('status', 0)->update(['status' => '停用']);
    }
};
