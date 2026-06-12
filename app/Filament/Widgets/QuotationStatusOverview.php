<?php

namespace App\Filament\Widgets;

use App\Models\Quotation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class QuotationStatusOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 20;

    protected static ?string $heading = 'Quotations';

    protected int | string | array $columnSpan = 1;

    public function getWidgetHeading(): ?string
    {
        return static::$heading;
    }

    protected function getCards(): array
    {
        $counts = Quotation::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            Card::make('Pending', (int) ($counts['pending'] ?? 0)),
            Card::make('Paid', (int) ($counts['paid'] ?? 0)),
            Card::make('Rejected', (int) ($counts['rejected'] ?? 0)),
        ];
    }
}
