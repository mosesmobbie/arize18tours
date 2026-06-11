<?php

namespace App\Filament\Resources\FleetResource\Pages;

use App\Filament\Resources\FleetResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFleet extends EditRecord
{
    protected static string $resource = FleetResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
