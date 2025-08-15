<?php

namespace App\Filament\Resources\StoreResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MotorcyclesRelationManager extends RelationManager
{
    protected static string $relationship = 'motorcycles';

    protected static ?string $title = '機車列表';
    protected static ?string $pluralModelLabel = '機車列表';
    protected static ?string $pluralLabel = '機車列表';
    protected static ?string $modelLabel = '機車';
    protected static ?string $label = '機車';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('機車名稱')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->label('型號')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('license_plate')
                    ->label('車牌號碼')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('price')
                    ->label('價格')
                    ->numeric()
                    ->prefix('NT$')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('狀態')
                    ->options([
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
                        'pending_checkout' => '待結帳',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('機車名稱')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('型號')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('車牌號碼')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('狀態')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'rented' => 'warning',
                        'maintenance' => 'danger',
                        'pending_checkout' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
                        'pending_checkout' => '待結帳',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('狀態篩選')
                    ->options([
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
                        'pending_checkout' => '待結帳',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
