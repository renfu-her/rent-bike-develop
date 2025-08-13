<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderDetails';
    protected static ?string $title = '訂單明細';
    protected static ?string $pluralModelLabel = '訂單明細';
    protected static ?string $pluralLabel = '訂單明細';
    protected static ?string $modelLabel = '訂單明細';
    protected static ?string $label = '訂單明細';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // 移除新增操作
            ])
            ->actions([
                // 移除編輯和刪除操作
            ])
            ->bulkActions([
                // 移除批量操作
            ]);
    }
}
