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
        // 為現有記錄生成訂單編號
        $orders = \App\Models\Order::whereNull('order_no')->get();
        foreach ($orders as $order) {
            $date = $order->created_at->format('Ymd');
            $order->update(['order_no' => "REBT-{$date}-0001"]);
        }

        // 添加唯一約束（如果不存在）
        if (!Schema::hasColumn('orders', 'order_no')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_no', 20)->unique()->comment('訂單編號');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_no');
        });
    }
};
