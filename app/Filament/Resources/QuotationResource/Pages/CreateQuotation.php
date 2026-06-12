<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Booking;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected static bool $canCreateAnother = false;

    protected ?Booking $booking = null;

    public function mount(): void
    {
        parent::mount();

        $bookingId = (int) (request()->query('booking_id') ?? request()->query('bokking_id'));

        $this->booking = $bookingId ? Booking::query()->find($bookingId) : null;

        $this->form->fill([
            'booking_id' => $this->booking?->id,
            'status' => 'pending',
            'deposit_amount' => 0,
            'amount_paid' => 0,
            'notes' => filled($this->booking?->notes) ? $this->booking?->notes : null,
            'name' => filled($this->booking?->name) ? $this->booking?->name : null,
            'phone' => filled($this->booking?->phone) ? $this->booking?->phone : null,
        ]);
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->disabled(function (): bool {
                $items = data_get($this->data, 'items');

                if (! is_array($items)) {
                    $items = [];
                }

                return count($items) === 0;
            });
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['booking_id'] = $this->booking?->id ?? data_get($data, 'booking_id');
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

    protected function afterCreate(): void
    {
        $itemsTotal = $this->record->items
            ->sum(fn ($item): float => ((float) $item->unit) * ((float) $item->amount));

        $this->record->updateQuietly([
            'total_amount' => $itemsTotal + ((float) $this->record->deposit_amount),
        ]);

        $bookingId = $this->record->booking_id;

        if ($bookingId) {
            Booking::query()->find($bookingId)?->update(['status' => 'quoted']);
        }
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
