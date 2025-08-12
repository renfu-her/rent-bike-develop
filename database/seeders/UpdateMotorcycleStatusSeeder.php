<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateMotorcycleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 更新 motorcycles 表的 status 欄位
        // 將中文狀態改為英文狀態
        
        DB::table('motorcycles')->where('status', '可出租')->update(['status' => 'available']);
        DB::table('motorcycles')->where('status', '已出租')->update(['status' => 'rented']);
        DB::table('motorcycles')->where('status', '維修中')->update(['status' => 'maintenance']);
        
        $this->command->info('Motorcycle statuses updated successfully!');
        $this->command->info('可出租 -> available');
        $this->command->info('已出租 -> rented');
        $this->command->info('維修中 -> maintenance');
    }
}
