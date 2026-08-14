<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'nombre')
                    ->required(),
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Textarea::make('descripcion')
                    ->label('Descripción'),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
                Toggle::make('promo')
                    ->label('En promoción'),
                Toggle::make('destacado_home')
                    ->label('Destacar en inicio'),
            ]);
    }
}
