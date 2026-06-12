<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Booking;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function updateQuotationTotal(callable $set, callable $get): void
    {
        $items = $get('items');
        $deposit = (float) ($get('deposit_amount') ?? 0);

        if (! is_array($items)) {
            $items = [];
        }

        $total = 0;
        foreach ($items as $item) {
            if (is_array($item) && isset($item['unit']) && isset($item['amount'])) {
                $unit = (float) ($item['unit'] ?? 0);
                $amount = (float) ($item['amount'] ?? 0);
                $total += $unit * $amount;
            }
        }

        $set('total_amount', $total + $deposit);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Quote Fields')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('notes')
                                    ->rows(1),
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make('Booking Details')
                            ->schema([
                                Forms\Components\Hidden::make('booking_id'),
                                Forms\Components\Placeholder::make('booking_summary')
                                    ->label('Loaded Booking')
                                    ->content(function (callable $get) {
                                        $bookingId = (int) $get('booking_id');

                                        if (! $bookingId) {
                                            return 'No booking loaded.';
                                        }

                                        $booking = Booking::query()->find($bookingId);

                                        if (! $booking) {
                                            return 'Booking not found.';
                                        }

                                        $excludeFields = ['id', 'updated_at', 'created_at', 'user_id'];

                                        $rows = collect($booking->toArray())
                                            ->reject(fn ($value, $key) => in_array($key, $excludeFields, true) || blank($value))
                                            ->map(function ($value, $key) {
                                                $label = Str::headline((string) $key);

                                                return '<div style="margin-bottom: 6px;"><strong>' . e($label) . ':</strong> ' . e((string) $value) . '</div>';
                                            })
                                            ->implode('');

                                        if ($rows === '') {
                                            return 'No non-empty booking fields available.';
                                        }

                                        return new HtmlString($rows);
                                    }),
                            ])
                            ->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([

                                Forms\Components\TextInput::make('deposit_amount')
                                    ->label('Refundable Dep.')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step('0.01')
                                    ->default(0)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        self::updateQuotationTotal($set, $get);
                                    }),
                                Forms\Components\TextInput::make('amount_paid')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step('0.01')
                                    ->default(0),
                                Forms\Components\TextInput::make('total_amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step('0.01')
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->default('pending')
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Repeater::make('items')
                    ->relationship('items')
                    ->label('Quote Items')
                    ->defaultItems(1)
                    ->default([
                        [
                            'name' => null,
                            'unit' => null,
                            'amount' => null,
                            'description' => null,
                        ],
                    ])
                    ->minItems(1)
                    ->createItemButtonLabel('Add Item')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        self::updateQuotationTotal($set, $get);
                    })
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Vehicle')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('unit')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->maxLength(3)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        self::updateQuotationTotal($set, $get);
                                    })
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step('0.01')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        self::updateQuotationTotal($set, $get);
                                    })
                                    ->columnSpan(1),
                                Forms\Components\Textarea::make('description')
                                    ->rows(1)
                                    ->columnSpan(4),
                            ]),
                    ])
                        ->columnSpanFull()
                        ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_id')
                    ->label('Booking')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($state): ?string => blank($state) ? null : 'R ' . number_format((float) $state, 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposit_amount')
                    ->formatStateUsing(fn ($state): ?string => blank($state) ? null : 'R ' . number_format((float) $state, 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->formatStateUsing(fn ($state): ?string => blank($state) ? null : 'R ' . number_format((float) $state, 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')

                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Items'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
