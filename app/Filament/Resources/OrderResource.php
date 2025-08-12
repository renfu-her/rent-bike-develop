<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = '訂單管理';
    protected static ?string $navigationLabel = '訂單管理';
    protected static ?string $modelLabel = '訂單';
    protected static ?string $pluralModelLabel = '訂單';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_no')
                    ->label('訂單編號')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                Forms\Components\Select::make('store_id')
                    ->label('商店')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('member_id')
                    ->label('會員')
                    ->relationship('member', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->label('總價')
                    ->required()
                    ->numeric()
                    ->prefix('NT$')
                    ->minValue(0),
                Forms\Components\DatePicker::make('rent_date')
                    ->label('租車日期')
                    ->required()
                    ->displayFormat('Y-m-d'),
                Forms\Components\DatePicker::make('return_date')
                    ->label('還車日期')
                    ->required()
                    ->displayFormat('Y-m-d'),
                Forms\Components\Toggle::make('is_completed')
                    ->label('是否成交')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_no')
                    ->label('訂單編號')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('訂單編號已複製'),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('商店')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('member.name')
                    ->label('會員')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('總價')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rent_date')
                    ->label('租車日期')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_date')
                    ->label('還車日期')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('是否成交')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('store_id')
                    ->label('商店篩選')
                    ->relationship('store', 'name'),
                Tables\Filters\SelectFilter::make('is_completed')
                    ->label('成交狀態')
                    ->options([
                        '1' => '已成交',
                        '0' => '未成交',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
