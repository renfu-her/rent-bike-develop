<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDetailResource\Pages;
use App\Filament\Resources\OrderDetailResource\RelationManagers;
use App\Models\OrderDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

    protected static ?string $navigationGroup = '訂單管理';
    protected static ?string $navigationLabel = '訂單明細';
    protected static ?string $modelLabel = '訂單明細';
    protected static ?string $pluralModelLabel = '訂單明細';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('訂單')
                    ->relationship('order', 'order_no')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('motorcycle_id')
                    ->label('機車')
                    ->relationship('motorcycle', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('數量')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1),
                Forms\Components\TextInput::make('subtotal')
                    ->label('小計')
                    ->required()
                    ->numeric()
                    ->prefix('NT$')
                    ->minValue(0),
                Forms\Components\TextInput::make('total')
                    ->label('總計')
                    ->required()
                    ->numeric()
                    ->prefix('NT$')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_no')
                    ->label('訂單編號')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('訂單編號已複製'),
                Tables\Columns\TextColumn::make('motorcycle.name')
                    ->label('機車名稱')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('motorcycle.model')
                    ->label('機車型號')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('motorcycle.license_plate')
                    ->label('車牌號碼')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('數量')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('小計')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('總計')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_id')
                    ->label('訂單篩選')
                    ->relationship('order', 'order_no'),
                Tables\Filters\SelectFilter::make('motorcycle_id')
                    ->label('機車篩選')
                    ->relationship('motorcycle', 'name'),
            ])
            ->actions([
                // 移除編輯操作，只允許查看
            ])
            ->bulkActions([
                // 移除批量操作
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderDetails::route('/'),
        ];
    }
}
