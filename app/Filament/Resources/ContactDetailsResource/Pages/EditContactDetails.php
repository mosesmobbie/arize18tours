<?php

namespace App\Filament\Resources\ContactDetailsResource\Pages;

use App\Filament\Resources\ContactDetailsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactDetails extends EditRecord
{
    protected static string $resource = ContactDetailsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
