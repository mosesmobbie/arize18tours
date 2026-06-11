<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('service_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pickup_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dropoff_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pickup_time')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dropoff_time')
                    ->maxLength(255),
                Forms\Components\TextInput::make('passengers')
                    ->required(),
                Forms\Components\TextInput::make('transmission')
                    ->maxLength(255),
                Forms\Components\TextInput::make('flight_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('reversation_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('user_id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_type'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('pickup_address'),
                Tables\Columns\TextColumn::make('dropoff_address'),
                Tables\Columns\TextColumn::make('pickup_time'),
                Tables\Columns\TextColumn::make('dropoff_time'),
                Tables\Columns\TextColumn::make('passengers'),
                Tables\Columns\TextColumn::make('transmission'),
                Tables\Columns\TextColumn::make('flight_number'),
                Tables\Columns\TextColumn::make('id_number'),
                Tables\Columns\TextColumn::make('reversation_number'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('notes'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
