<x-filament::widget class="filament-account-widget">
    <x-filament::card>
        @php
            $user = \Filament\Facades\Filament::auth()->user();
        @endphp

        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <x-filament::user-avatar :user="$user" />

                <h2 class="text-lg font-bold tracking-tight sm:text-xl">
                    {{ __('filament::widgets/account-widget.welcome', ['user' => \Filament\Facades\Filament::getUserName($user)]) }}
                </h2>
            </div>

            <form
                action="{{ route('filament.auth.logout') }}"
                method="post"
                class="text-sm"
            >
                @csrf

                <button
                    type="submit"
                    @class([
                        'text-gray-600 outline-none hover:text-primary-500 focus:underline',
                        'dark:text-gray-300 dark:hover:text-primary-500' => config('filament.dark_mode'),
                    ])
                >
                    {{ __('filament::widgets/account-widget.buttons.logout.label') }}
                </button>
            </form>
        </div>
    </x-filament::card>
</x-filament::widget>
