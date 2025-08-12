<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ReservationTable extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '預約車子資訊';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::select([
                    'id',
                    'member_id',
                    'store_id',
                    'total_price',
                    'rent_date',
                    'is_completed'
                ])
                ->where('rent_date', '>', now()->toDateString())
                ->with([
                    'member:id,name,phone,email',
                    'store:id,name,phone,address',
                    'orderDetails:id,order_id,motorcycle_id,quantity,total',
                    'orderDetails.motorcycle:id,name,model,license_plate,price'
                ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->label('使用者姓名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_completed')
                    ->label('成交狀態')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn (bool $state): string => $state ? '已成交' : '未成交'),
                Tables\Columns\TextColumn::make('orderDetails')
                    ->label('機車資訊')
                    ->formatStateUsing(function ($state) {
                        if (!$state || !is_object($state) || !method_exists($state, 'map')) {
                            return '無機車資訊';
                        }
                        
                        $motorcycleInfo = $state->map(function ($detail) {
                            if ($detail && $detail->motorcycle) {
                                return $detail->motorcycle->name . ' (' . $detail->motorcycle->model . ') - ' . $detail->motorcycle->license_plate;
                            }
                            return '未知機車';
                        })->toArray();
                        
                        return implode(', ', $motorcycleInfo);
                    }),
                Tables\Columns\TextColumn::make('rent_date')
                    ->label('租車日期')
                    ->date(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('總價')
                    ->money('TWD'),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('商店'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    protected function getTableQuery(): Builder
    {
        return Order::select([
            'id',
            'member_id',
            'store_id',
            'total_price',
            'rent_date',
            'is_completed'
        ])
        ->where('rent_date', '>', now()->toDateString())
        ->with([
            'member:id,name,phone,email',
            'store:id,name,phone,address',
            'orderDetails:id,order_id,motorcycle_id,quantity,total',
            'orderDetails.motorcycle:id,name,model,license_plate,price'
        ]);
    }
}
