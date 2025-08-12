<?php

namespace App\Filament\Widgets;

use App\Models\Motorcycle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RentedMotorcyclesTable extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '今日待還車';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Motorcycle::select([
                    'motorcycles.id',
                    'motorcycles.name',
                    'motorcycles.model',
                    'motorcycles.license_plate',
                    'motorcycles.price',
                    'motorcycles.status',
                    'motorcycles.store_id',
                    'stores.name as store_name',
                    'members.name as member_name',
                    'orders.rent_date',
                    'orders.is_completed'
                ])
                    ->leftJoin('stores', 'motorcycles.store_id', '=', 'stores.id')
                    ->leftJoin('order_details', 'motorcycles.id', '=', 'order_details.motorcycle_id')
                    ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
                    ->leftJoin('members', 'orders.member_id', '=', 'members.id')
                    ->where('motorcycles.status', '已出租')
            )
            ->columns([
                Tables\Columns\TextColumn::make('member_name')
                    ->label('使用者姓名'),
                Tables\Columns\TextColumn::make('name')
                    ->label('廠牌名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('型號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('車牌號碼')
                    ->searchable(),
                Tables\Columns\TextColumn::make('store_name')
                    ->label('所屬商店'),
                Tables\Columns\TextColumn::make('rent_date')
                    ->label('租車日期')
                    ->date(),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD'),

                Tables\Columns\TextColumn::make('is_completed')
                    ->label('成交狀態')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn(bool $state): string => $state ? '已成交' : '未成交'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    protected function getTableQuery(): Builder
    {
        return Motorcycle::select([
            'motorcycles.id',
            'motorcycles.name',
            'motorcycles.model',
            'motorcycles.license_plate',
            'motorcycles.price',
            'motorcycles.status',
            'motorcycles.store_id',
            'stores.name as store_name',
            'members.name as member_name',
            'orders.rent_date',
            'orders.is_completed'
        ])
            ->leftJoin('stores', 'motorcycles.store_id', '=', 'stores.id')
            ->leftJoin('order_details', 'motorcycles.id', '=', 'order_details.motorcycle_id')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('members', 'orders.member_id', '=', 'members.id')
            ->where('motorcycles.status', '已出租');
    }
}
