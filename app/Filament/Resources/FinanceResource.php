<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class FinanceResource extends Resource
{
    protected static ?string $model = Finance::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Admin Management';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes()
            ->where('user_id', auth()->id())
            ->where('status', 'SUCCESS');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id'),
                TextColumn::make('description'),
                TextColumn::make('type'),
                TextColumn::make('amount')
                    ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                TextColumn::make('balance')
                    ->formatStateUsing(fn (int $state): string => currencyFormat($state)),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn (Carbon $state): string => $state->format('l, ' . config('app.date_format'))),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinances::route('/'),
        ];
    }
}