<?php

namespace App\Filament\Resources\EventQuotes\Pages;

use App\Filament\Resources\EventQuotes\EventQuoteResource;
use Filament\Resources\Pages\ListRecords;

class ListEventQuotes extends ListRecords
{
    protected static string $resource = EventQuoteResource::class;

}
