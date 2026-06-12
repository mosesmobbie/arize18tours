<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['total_amount'] = $this->resolveQuotationTotal($data);

        return $data;
    }

    public function calculateQuotationTotal(): void
    {
        data_set($this->data, 'total_amount', $this->resolveQuotationTotal($this->data));
    }

    protected function resolveQuotationTotal(array $data): float
    {
        $items = data_get($data, 'items');
        $deposit = (float) data_get($data, 'deposit_amount', 0);

        if (! is_array($items) || count($items) === 0) {
            return (float) data_get($data, 'total_amount', 0);
        }

        $itemsTotal = 0;
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $unit = (float) data_get($item, 'unit', 0);
            $amount = (float) data_get($item, 'amount', 0);
            $itemsTotal += $unit * $amount;
        }

        return $itemsTotal + $deposit;
    }

    protected function afterSave(): void
    {
        $itemsTotal = $this->record->items
            ->sum(fn ($item): float => ((float) $item->unit) * ((float) $item->amount));

        $this->record->updateQuietly([
            'total_amount' => $itemsTotal + ((float) $this->record->deposit_amount),
        ]);
    }

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
