<?php

namespace App\Filament\Resources\MotorcycleAccessoryResource\Pages;

use App\Filament\Resources\MotorcycleAccessoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMotorcycleAccessory extends EditRecord
{
    protected static string $resource = MotorcycleAccessoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
