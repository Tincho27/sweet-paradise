<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('N.º de pedido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable(),
                TextColumn::make('metodo_entrega')
                    ->label('Entrega')
                    ->badge()
                    ->formatStateUsing(function (?string $state): string {
                        if ($state === 'delivery') {
                            return 'Envío a domicilio';
                        }

                        if ($state === 'pickup') {
                            return 'Retiro en el local';
                        }

                        return 'Sin definir';
                    }),
                TextColumn::make('estado_orden')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(function (?string $state): string {
                        if ($state === 'pendiente') {
                            return 'Pendiente';
                        }

                        if ($state === 'confirmado') {
                            return 'Confirmado';
                        }

                        if ($state === 'preparando') {
                            return 'Preparando';
                        }

                        if ($state === 'entregado') {
                            return 'Entregado';
                        }

                        if ($state === 'cancelado') {
                            return 'Cancelado';
                        }

                        return $state ?? 'Sin definir';
                    })
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
                TextColumn::make('total')
                    ->label('Total')
                    ->money('ARS')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('estado_orden')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'preparando' => 'Preparando',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado',
                    ]),
                SelectFilter::make('metodo_entrega')
                    ->label('Entrega')
                    ->options([
                        'pickup' => 'Retiro en el local',
                        'delivery' => 'Envío a domicilio',
                    ]),
            ])
            ->recordActions([
                Action::make('confirmar')
                    ->label('Confirmar pedido')
                    ->color('success')
                    ->icon(Heroicon::OutlinedCheck)
                    ->iconButton()
                    ->tooltip('Confirmar pedido')
                    ->extraAttributes([
                        'style' => 'background-color: var(--success-100); border: 1px solid var(--success-300); border-radius: 9999px; height: 2.5rem; margin: 0; width: 2.5rem;',
                    ])
                    ->requiresConfirmation()
                    ->modalIcon(Heroicon::OutlinedExclamationTriangle)
                    ->modalIconColor('warning')
                    ->modalHeading('Confirmar pedido')
                    ->modalDescription('El estado cambiará de pendiente a confirmado.')
                    ->modalSubmitActionLabel('Confirmar pedido')
                    ->visible(function (Order $record): bool {
                        return $record->estado_orden === 'pendiente';
                    })
                    ->action(function (Order $record): void {
                        $record->update(['estado_orden' => 'confirmado']);
                    })
                    ->successNotificationTitle('Pedido confirmado'),
                Action::make('cancelar')
                    ->label('Cancelar pedido')
                    ->color('danger')
                    ->icon(Heroicon::OutlinedXMark)
                    ->iconButton()
                    ->tooltip('Cancelar pedido')
                    ->extraAttributes([
                        'style' => 'background-color: var(--danger-100); border: 1px solid var(--danger-300); border-radius: 9999px; height: 2.5rem; margin: 0; width: 2.5rem;',
                    ])
                    ->requiresConfirmation()
                    ->modalIcon(Heroicon::OutlinedExclamationTriangle)
                    ->modalIconColor('danger')
                    ->modalHeading('Cancelar pedido')
                    ->modalDescription('El estado cambiará de pendiente a cancelado.')
                    ->modalSubmitActionLabel('Cancelar pedido')
                    ->visible(function (Order $record): bool {
                        return $record->estado_orden === 'pendiente';
                    })
                    ->action(function (Order $record): void {
                        $record->update(['estado_orden' => 'cancelado']);
                    })
                    ->successNotificationTitle('Pedido cancelado'),
                ViewAction::make(),
            ]);
    }
}
