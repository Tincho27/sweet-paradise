<?php

namespace App\Filament\Resources\EventQuotes;

use App\Filament\Resources\EventQuotes\Pages\ListEventQuotes;
use App\Filament\Resources\EventQuotes\Pages\ViewEventQuote;
use App\Filament\Resources\EventQuotes\Schemas\EventQuoteInfolist;
use App\Filament\Resources\EventQuotes\Tables\EventQuotesTable;
use App\Models\EventQuote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EventQuoteResource extends Resource
{
    protected static ?string $model = EventQuote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Mesa dulce';

    protected static ?string $modelLabel = 'Solicitud de mesa dulce';

    protected static ?string $pluralModelLabel = 'Solicitudes de mesa dulce';

    public static function infolist(Schema $schema): Schema
    {
        return EventQuoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventQuotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventQuotes::route('/'),
            'view' => ViewEventQuote::route('/{record}'),
        ];
    }
}
