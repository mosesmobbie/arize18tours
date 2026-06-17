<?php

namespace App\Filament\Resources\FleetResource\Pages;

use App\Filament\Resources\FleetResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFleet extends EditRecord
{
    protected static string $resource = FleetResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (blank($data['image'] ?? null)) {
            unset($data['image']);
        }

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
