<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorcycleAccessoryResource\Pages;
use App\Filament\Resources\MotorcycleAccessoryResource\RelationManagers;
use App\Models\MotorcycleAccessory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MotorcycleAccessoryResource extends Resource
{
    protected static ?string $model = MotorcycleAccessory::class;

    protected static ?string $navigationGroup = '網站管理';
    protected static ?string $navigationLabel = '機車配件管理';
    protected static ?string $modelLabel = '機車配件';
    protected static ?string $pluralModelLabel = '機車配件';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model')
                    ->label('型號')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->label('數量')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Forms\Components\Select::make('status')
                    ->label('狀態')
                    ->options([
                        '待出租' => '待出租',
                        '出租中' => '出租中',
                        '停用' => '停用',
                    ])
                    ->default('待出租')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->label('型號')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('數量')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('狀態')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '待出租' => 'success',
                        '出租中' => 'warning',
                        '停用' => 'danger',
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('狀態篩選')
                    ->options([
                        '待出租' => '待出租',
                        '出租中' => '出租中',
                        '停用' => '停用',
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
            'index' => Pages\ListMotorcycleAccessories::route('/'),
            'create' => Pages\CreateMotorcycleAccessory::route('/create'),
            'edit' => Pages\EditMotorcycleAccessory::route('/{record}/edit'),
        ];
    }
}
