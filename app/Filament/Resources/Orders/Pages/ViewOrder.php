<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
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
                ->visible(fn (Order $record): bool => $record->estado_orden === 'pendiente')
                ->action(fn (Order $record) => $record->update(['estado_orden' => 'confirmado']))
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
                ->visible(fn (Order $record): bool => $record->estado_orden === 'pendiente')
                ->action(fn (Order $record) => $record->update(['estado_orden' => 'cancelado']))
                ->successNotificationTitle('Pedido cancelado'),
        ];
    }
}
