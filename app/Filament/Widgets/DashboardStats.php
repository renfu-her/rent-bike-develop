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
        
        // 待出租車數量
        $availableMotorcyclesCount = Motorcycle::where('status', '可出租')->count();
        
        // 今日待還車數量
        $rentedMotorcyclesCount = Motorcycle::where('status', '已出租')->count();
        
        // 預約車子數量
        $reservedOrdersCount = Order::where('rent_date', '>', $today)->count();

        return [
            Stat::make('待出租車', $availableMotorcyclesCount)
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),
            
            Stat::make('今天待還車', $rentedMotorcyclesCount)
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('預約車子', $reservedOrdersCount)
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
