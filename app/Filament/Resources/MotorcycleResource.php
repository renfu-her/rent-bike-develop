<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorcycleResource\Pages;
use App\Filament\Resources\MotorcycleResource\RelationManagers;
use App\Models\Motorcycle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MotorcycleResource extends Resource
{
    protected static ?string $model = Motorcycle::class;

    protected static ?string $navigationGroup = '網站管理';
    protected static ?string $navigationLabel = '機車管理';
    protected static ?string $modelLabel = '機車';
    protected static ?string $pluralModelLabel = '機車';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                    ->label('商店')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('機車名稱')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->label('型號')
                    ->required()
                    ->maxLength(255),
                Forms\Components\CheckboxList::make('accessories')
                    ->label('機車配件')
                    ->options(\App\Models\MotorcycleAccessory::pluck('model', 'id'))
                    ->columns(2),
                Forms\Components\TextInput::make('license_plate')
                    ->label('車牌')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('price')
                    ->label('價格')
                    ->required()
                    ->numeric()
                    ->prefix('NT$')
                    ->minValue(0),
                Forms\Components\Select::make('status')
                    ->label('狀態')
                    ->options([
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store.name')
                    ->label('商店')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('機車名稱')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('型號')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('車牌')
                    ->searchable()
                    ->sortable(),
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
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
                    })
                    ->searchable(),
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('狀態篩選')
                    ->options([
                        'available' => '可出租',
                        'rented' => '已出租',
                        'maintenance' => '維修中',
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMotorcycles::route('/'),
            'create' => Pages\CreateMotorcycle::route('/create'),
            'edit' => Pages\EditMotorcycle::route('/{record}/edit'),
        ];
    }
}
