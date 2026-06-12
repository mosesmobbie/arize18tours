<?php

namespace App\Filament\Widgets;

use App\Models\Quotation;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingQuotationsTable extends BaseWidget
{
    protected static ?string $heading = 'Pending Quotations';

    protected static ?int $sort = 21;

    protected int | string | array $columnSpan = 1;

    protected function getTableQuery(): Builder
    {
        return Quotation::query()
            ->where('status', 'pending')
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Name'),
            Tables\Columns\TextColumn::make('total_amount')
                ->label('Total Amount')
                ->formatStateUsing(fn ($state): ?string => blank($state) ? null : 'R ' . number_format((float) $state, 2)),
            Tables\Columns\TextColumn::make('status')
                ->formatStateUsing(fn ($state): string => ucfirst((string) $state)),
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
