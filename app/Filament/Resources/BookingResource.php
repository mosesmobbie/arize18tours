<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function canCreate(): bool
    {
        return false;
    }

    protected static function hideIfBlankOnEdit(string $field): Closure
    {
        return fn (?Booking $record): bool => filled($record) && blank(data_get($record, $field));
    }

    protected static function requiredIfVisible(string $field): Closure
    {
        return fn (?Booking $record): bool => blank($record) || filled(data_get($record, $field));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('service_type')
                    ->required(self::requiredIfVisible('service_type'))
                    ->hidden(self::hideIfBlankOnEdit('service_type'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required(self::requiredIfVisible('name'))
                    ->hidden(self::hideIfBlankOnEdit('name'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(self::requiredIfVisible('email'))
                    ->hidden(self::hideIfBlankOnEdit('email'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required(self::requiredIfVisible('phone'))
                    ->hidden(self::hideIfBlankOnEdit('phone'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('pickup_address')
                    ->required(self::requiredIfVisible('pickup_address'))
                    ->hidden(self::hideIfBlankOnEdit('pickup_address'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('dropoff_address')
                    ->hidden(self::hideIfBlankOnEdit('dropoff_address'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('pickup_time')
                    ->required(self::requiredIfVisible('pickup_time'))
                    ->hidden(self::hideIfBlankOnEdit('pickup_time'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('dropoff_time')
                    ->hidden(self::hideIfBlankOnEdit('dropoff_time'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('passengers')
                    ->required(self::requiredIfVisible('passengers'))
                    ->hidden(self::hideIfBlankOnEdit('passengers')),
                Forms\Components\TextInput::make('transmission')
                    ->hidden(self::hideIfBlankOnEdit('transmission'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('flight_number')
                    ->hidden(self::hideIfBlankOnEdit('flight_number'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_number')
                    ->hidden(self::hideIfBlankOnEdit('id_number'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('reservation_number')
                    ->hidden(self::hideIfBlankOnEdit('reservation_number'))
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'quoated' => 'Quoated',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ])
                    ->required(self::requiredIfVisible('status'))
                    ->hidden(self::hideIfBlankOnEdit('status')),
                Forms\Components\Textarea::make('notes')
                    ->hidden(self::hideIfBlankOnEdit('notes'))
                    ->maxLength(65535),
                Forms\Components\TextInput::make('user_id')
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_type'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('pickup_address'),
                Tables\Columns\TextColumn::make('pickup_time'),
                Tables\Columns\TextColumn::make('passengers'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_type')
                    ->options([
                        'shuttle' => 'Shuttle',
                        'airport-transfers' => 'Airport Transfer',
                        'car-hire' => 'Self-Drive',
                        'hotel-transfers' => 'Hotel Transfer',
                        'tours-safaris' => 'Tours & Safaris',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'quoated' => 'Quoated',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBookings::route('/'),
        ];
    }
}
