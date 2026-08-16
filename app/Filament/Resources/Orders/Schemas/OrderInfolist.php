<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class OrderInfolist
{
    public static function createInfolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del pedido')
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('N.º de pedido'),
                        TextEntry::make('email')
                            ->label('Correo electrónico'),
                        TextEntry::make('created_at')
                            ->label('Creado')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('estado_orden')
                            ->label('Estado')
                            ->badge()
                            ->placeholder('Sin definir')
                            ->color(function (?string $state): string {
                                if ($state === 'pendiente') {
                                    return 'warning';
                                }

                                if ($state === 'confirmado' || $state === 'entregado') {
                                    return 'success';
                                }

                                if ($state === 'preparando') {
                                    return 'info';
                                }

                                if ($state === 'cancelado') {
                                    return 'danger';
                                }

                                return 'gray';
                            }),
                    ])
                    ->columns(2),
                Section::make('Solicitud de mesa')
                    ->schema([
                        TextEntry::make('eventQuote.id')
                            ->hiddenLabel()
                            ->placeholder('Sin vincular')
                            ->formatStateUsing(function (?int $state): string {
                                if ($state) {
                                    return 'Solicitud vinculada';
                                }

                                return 'No vinculado';
                            }),
                    ]),
                Section::make('Entrega y observaciones')
                    ->schema([
                        TextEntry::make('metodo_entrega')
                            ->label('Entrega')
                            ->formatStateUsing(function (?string $state): string {
                                if ($state === 'delivery') {
                                    return 'Envío a domicilio';
                                }

                                if ($state === 'pickup') {
                                    return 'Retiro en el local';
                                }

                                return 'Sin definir';
                            }),
                        TextEntry::make('fecha_estimada')
                            ->label('Fecha estimada')
                            ->date('d/m/Y')
                            ->placeholder('Sin fecha'),
                        TextEntry::make('direccion_envio')
                            ->label('Dirección de envío')
                            ->placeholder('No corresponde'),
                        TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->placeholder('Sin observaciones')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Productos del pedido')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('productVariant.product.nombre')
                                    ->label('Producto'),
                                TextEntry::make('productVariant.nombre')
                                    ->label('Variante'),
                                TextEntry::make('cantidad')
                                    ->label('Cantidad'),
                                TextEntry::make('precio_unitario_snapshot')
                                    ->label('Precio unitario')
                                    ->money('ARS'),
                            ])
                            ->columns(4),
                    ]),
                Section::make('Totales')
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('Subtotal')
                            ->money('ARS'),
                        TextEntry::make('costo_envio')
                            ->label('Costo de envío')
                            ->money('ARS')
                            ->placeholder('$0,00'),
                        TextEntry::make('descuento')
                            ->label('Descuento')
                            ->money('ARS')
                            ->placeholder('$0,00'),
                        TextEntry::make('total')
                            ->label('Total')
                            ->money('ARS'),
                    ])
                    ->columns(4),
            ]);
    }
}
