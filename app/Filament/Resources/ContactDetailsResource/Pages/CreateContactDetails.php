<?php

namespace App\Filament\Resources\ContactDetailsResource\Pages;

use App\Filament\Resources\ContactDetailsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactDetails extends CreateRecord
{
    protected static string $resource = ContactDetailsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
