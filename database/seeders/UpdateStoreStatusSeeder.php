<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateStoreStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 更新 stores 表的 status 欄位
        // 將字串狀態改為整數狀態
        
        DB::table('stores')->where('status', '啟用')->update(['status' => 1]);
        DB::table('stores')->where('status', '停用')->update(['status' => 0]);
        
        $this->command->info('Store statuses updated successfully!');
        $this->command->info('啟用 -> 1');
        $this->command->info('停用 -> 0');
    }
}
