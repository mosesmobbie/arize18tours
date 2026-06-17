<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FleetResource\Pages;
use App\Models\Fleet;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FleetResource extends Resource
{
    protected static ?string $model = Fleet::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required(),
                Forms\Components\TextInput::make('transmission')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('short_description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->disk('public')
                    ->directory('fleet')
                    ->imagePreviewHeight('180')
                    ->visibility('public'),
                Forms\Components\TextInput::make('passengers')
                    ->required(),
                Forms\Components\TextInput::make('meta_description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('meta_keywords')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('model'),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('transmission')
                    ->label('T')
                    ->formatStateUsing(function (?string $state): string {
                        $value = strtolower(trim((string) $state));

                        return match ($value) {
                            'manual', 'm' => 'M',
                            'automatic', 'auto', 'a' => 'A',
                            default => strtoupper(substr($value, 0, 1)) ?: '-',
                        };
                    }),
                Tables\Columns\TextColumn::make('passengers'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('name')
                    ->label('Name')
                    ->options(fn (): array => Fleet::query()
                        ->whereNotNull('name')
                        ->distinct()
                        ->orderBy('name')
                        ->pluck('name', 'name')
                        ->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('model')
                    ->label('Model')
                    ->options(fn (): array => Fleet::query()
                        ->whereNotNull('model')
                        ->distinct()
                        ->orderBy('model')
                        ->pluck('model', 'model')
                        ->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('year')
                    ->label('Year')
                    ->options(fn (): array => Fleet::query()
                        ->whereNotNull('year')
                        ->distinct()
                        ->orderByDesc('year')
                        ->pluck('year', 'year')
                        ->toArray()),
                Tables\Filters\SelectFilter::make('transmission')
                    ->label('Transmission')
                    ->options(fn (): array => Fleet::query()
                        ->whereNotNull('transmission')
                        ->distinct()
                        ->orderBy('transmission')
                        ->pluck('transmission', 'transmission')
                        ->toArray())
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFleets::route('/'),
            'create' => Pages\CreateFleet::route('/create'),
            'edit' => Pages\EditFleet::route('/{record}/edit'),
        ];
    }
}
