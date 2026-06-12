<x-filament::widget class="filament-stats-overview-widget">
    @if (method_exists($this, 'getWidgetHeading') && filled($this->getWidgetHeading()))
        <x-filament::card class="mb-8">
            <x-filament::card.heading>
                {{ $this->getWidgetHeading() }}
            </x-filament::card.heading>
        </x-filament::card>
    @endif

    <div
        class="mt-2"
        {!! ($pollingInterval = $this->getPollingInterval()) ? "wire:poll.{$pollingInterval}" : '' !!}
    >
        <x-filament::stats :columns="$this->getColumns()">
            @foreach ($this->getCachedCards() as $card)
                {{ $card }}
            @endforeach
        </x-filament::stats>
    </div>
</x-filament::widget>
