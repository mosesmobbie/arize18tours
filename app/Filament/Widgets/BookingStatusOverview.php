<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class BookingStatusOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 10;

    protected static ?string $heading = 'Bookings';

    protected int | string | array $columnSpan = 1;

    public function getWidgetHeading(): ?string
    {
        return static::$heading;
    }

    protected function getCards(): array
    {
        $counts = Booking::query()
            ->selectRaw('COALESCE(NULLIF(status, ""), "unknown") as status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        if ($counts->isEmpty()) {
            return [
                Card::make('Pending', 0),
            ];
        }

        return $counts
            ->map(fn ($total, $status) => Card::make(ucfirst((string) $status), (int) $total))
            ->values()
            ->all();
    }
}
