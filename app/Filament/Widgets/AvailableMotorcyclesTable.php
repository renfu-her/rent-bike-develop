<?php

namespace App\Filament\Widgets;

use App\Models\Motorcycle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class AvailableMotorcyclesTable extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = '待出租車';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Motorcycle::select([
                    'id',
                    'name',
                    'model',
                    'license_plate',
                    'price',
                    'status',
                    'store_id'
                ])
                ->where('status', '可出租')
                ->with(['store:id,name,phone,address'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('廠牌名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('型號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('車牌號碼')
                    ->searchable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('所屬商店'),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    protected function getTableQuery(): Builder
    {
        return Motorcycle::select([
            'id',
            'name',
            'model',
            'license_plate',
            'price',
            'status',
            'store_id'
        ])
        ->where('status', '可出租')
        ->with(['store:id,name,phone,address']);
    }
}
