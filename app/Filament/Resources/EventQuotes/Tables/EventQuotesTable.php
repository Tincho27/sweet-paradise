<?php

namespace App\Filament\Resources\EventQuotes\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventQuotesTable
{
    public static function createTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->placeholder('Sin usuario'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('telefono')
                    ->label('Teléfono'),
                TextColumn::make('cantidad_personas')
                    ->label('Personas')
                    ->placeholder('Ver detalle'),
                TextColumn::make('fecha_evento')
                    ->label('Fecha del evento')
                    ->date('d/m/Y')
                    ->placeholder('Sin fecha'),
                TextColumn::make('servicio')
                    ->label('Servicio'),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(function (?string $state): string {
                        if ($state === 'pendiente') {
                            return 'warning';
                        }

                        if ($state === 'aceptado') {
                            return 'success';
                        }

                        if ($state === 'rechazado') {
                            return 'danger';
                        }

                        return 'gray';
                    }),
                TextColumn::make('convertedOrder.order_number')
                    ->label('Pedido vinculado')
                    ->placeholder('Sin pedido'),
                TextColumn::make('created_at')
                    ->label('Solicitada el')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
