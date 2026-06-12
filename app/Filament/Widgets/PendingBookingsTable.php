<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\QuotationResource;
use App\Models\Booking;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingBookingsTable extends BaseWidget
{
    protected static ?string $heading = 'Pending Bookings';

    protected static ?int $sort = 11;

    protected int | string | array $columnSpan = 1;

    protected function getTableQuery(): Builder
    {
        return Booking::query()
            ->where('status', 'pending')
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->url(fn (Booking $record): string => QuotationResource::getUrl('create', [
                    'booking_id' => $record->getKey(),
                ]))
                ->openUrlInNewTab(false),
            Tables\Columns\TextColumn::make('service_type')
                ->label('Service Type'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Days Ago')
                ->formatStateUsing(function ($state): ?string {
                    if (blank($state)) {
                        return null;
                    }

                    $days = now()->diffInDays($state);

                    return $days . ' day' . ($days === 1 ? '' : 's') . ' ago';
                }),
        ];
    }

    protected function getTableRecordsPerPage(): int
    {
        return 5;
    }
}
