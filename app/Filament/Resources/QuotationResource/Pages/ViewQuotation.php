<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('print_quote')
                ->label('Print Quote')
                ->url(fn (): string => url('/invoice/preview?' . http_build_query([
                    'quotation_id' => $this->record->getKey(),
                    'print' => 'quote',
                ])))
                ->openUrlInNewTab()
                ->extraAttributes([
                    'style' => 'background-color: #1b2b4b; border-color: #1b2b4b; color: #ffffff;',
                ]),
            Actions\Action::make('print_invoice')
                ->label('Print Invoice')
                ->url(fn (): string => url('/invoice/preview?' . http_build_query([
                    'quotation_id' => $this->record->getKey(),
                    'print' => 'invoice',
                ])))
                ->openUrlInNewTab()
                ->extraAttributes([
                    'style' => 'background-color: #c8202f; border-color: #c8202f; color: #ffffff;',
                ]),
            Actions\EditAction::make(),
        ];
    }
}
