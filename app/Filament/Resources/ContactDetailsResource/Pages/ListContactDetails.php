<?php

namespace App\Filament\Resources\ContactDetailsResource\Pages;

use App\Filament\Resources\ContactDetailsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactDetails extends ListRecords
{
    protected static string $resource = ContactDetailsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
