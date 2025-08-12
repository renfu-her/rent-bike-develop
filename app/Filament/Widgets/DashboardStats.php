<?php

namespace App\Filament\Widgets;

use App\Models\Motorcycle;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $today = now()->toDateString();
        
        // 今日待租車數量
        $todayAvailableMotorcycles = Motorcycle::where('status', 'available')->count();
        
        // 今日待還車數量 (已出租的機車)
        $todayRentedMotorcycles = Motorcycle::where('status', 'rented')->count();
        
        // 預約車子數量 (扣除今日待租車)
        $reservedMotorcycles = Order::where('rent_date', '>', $today)
            ->where('is_completed', true)
            ->count();

        return [
            Stat::make('今日待租車', $todayAvailableMotorcycles)
                ->description('可出租的機車數量')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),
            
            Stat::make('今日待還車', $todayRentedMotorcycles)
                ->description('已出租的機車數量')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('預約車子', $reservedMotorcycles)
                ->description('未來預約的機車數量')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
