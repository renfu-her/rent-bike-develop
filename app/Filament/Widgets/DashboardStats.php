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
        
        // 待出租車詳細資訊 - 優化查詢
        $availableMotorcycles = Motorcycle::select(['id', 'name', 'model', 'license_plate'])
            ->where('status', '可出租')
            ->get();
        $availableMotorcyclesList = $availableMotorcycles->map(function($motorcycle) {
            return $motorcycle->name . ' (' . $motorcycle->model . ') - ' . $motorcycle->license_plate;
        })->join(', ');
        
        // 今日待還車詳細資訊 - 優化查詢
        $rentedMotorcycles = Motorcycle::select(['id', 'name', 'model', 'license_plate'])
            ->where('status', '已出租')
            ->get();
        $rentedMotorcyclesList = $rentedMotorcycles->map(function($motorcycle) {
            return $motorcycle->name . ' (' . $motorcycle->model . ') - ' . $motorcycle->license_plate;
        })->join(', ');
        
        // 預約車子和使用者資訊 - 優化查詢
        $reservedOrders = Order::select(['id', 'member_id', 'is_completed'])
            ->where('rent_date', '>', $today)
            ->with([
                'member:id,name',
                'orderDetails:id,order_id,motorcycle_id',
                'orderDetails.motorcycle:id,name,model,license_plate'
            ])
            ->get();
        
        $reservedMotorcyclesList = $reservedOrders->map(function($order) {
            $motorcycleInfo = $order->orderDetails->map(function($detail) {
                return $detail->motorcycle->name . ' (' . $detail->motorcycle->model . ') - ' . $detail->motorcycle->license_plate;
            })->join(', ');
            $status = $order->is_completed ? '已成交' : '未成交';
            return $motorcycleInfo . ' - 使用者: ' . $order->member->name . ' (' . $status . ')';
        })->join('; ');

        return [
            Stat::make('待出租車', $availableMotorcycles->count())
                ->description($availableMotorcyclesList ?: '目前沒有可出租的機車')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),
            
            Stat::make('今天待還車', $rentedMotorcycles->count())
                ->description($rentedMotorcyclesList ?: '目前沒有待還的機車')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('預約車子', $reservedOrders->count())
                ->description($reservedMotorcyclesList ?: '目前沒有預約的機車')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
