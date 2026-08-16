<?php

namespace App\Filament\Resources\EventQuotes\Schemas;

use App\Models\EventQuote;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EventQuoteInfolist
{
    public static function createInfolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de contacto')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Cliente')
                            ->placeholder('Sin usuario'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->placeholder('Sin email'),
                        TextEntry::make('telefono')
                            ->label('Teléfono')
                            ->placeholder('Sin teléfono'),
                    ])
                    ->columns(2),
                Section::make('Datos del evento')
                    ->schema([
                        TextEntry::make('cantidad_personas')
                            ->label('Personas')
                            ->placeholder('No especificado'),
                        TextEntry::make('cantidad_personas_otro')
                            ->label('Otra cantidad')
                            ->placeholder('No corresponde'),
                        TextEntry::make('fecha_evento')
                            ->label('Fecha del evento')
                            ->date('d/m/Y')
                            ->placeholder('Sin fecha'),
                        TextEntry::make('servicio')
                            ->label('Servicio'),
                        TextEntry::make('servicio_otro')
                            ->label('Otro servicio')
                            ->placeholder('No corresponde'),
                    ])
                    ->columns(2),
                Section::make('Mesa dulce')
                    ->schema([
                        TextEntry::make('productos_preferidos')
                            ->label('Productos elegidos')
                            ->placeholder('Sin productos')
                            ->columnSpanFull(),
                        TextEntry::make('producto_otro')
                            ->label('Otro producto')
                            ->placeholder('No corresponde'),
                        TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->placeholder('Sin observaciones')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Seguimiento')
                    ->schema([
                        TextEntry::make('estado')
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
                        TextEntry::make('created_at')
                            ->label('Solicitud enviada')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2),
                Section::make('Pedido vinculado')
                    ->schema([
                        TextEntry::make('convertedOrder.order_number')
                            ->label('Pedido')
                            ->placeholder('Sin pedido vinculado'),
                    ])
                    ->footerActions([
                        Action::make('aceptar')
                            ->label('Vincular pedido')
                            ->color('primary')
                            ->icon(Heroicon::OutlinedLink)
                            ->schema([
                                Select::make('converted_order_id')
                                    ->label('Pedido')
                                    ->options(Order::query()
                                        ->whereDoesntHave('eventQuote')
                                        ->orderByDesc('created_at')
                                        ->pluck('order_number', 'id')
                                        ->all())
                                    ->searchable()
                                    ->required(),
                            ])
                            ->modalHeading('Aceptar y vincular pedido')
                            ->modalDescription('Seleccioná el pedido que corresponde a esta solicitud.')
                            ->modalSubmitActionLabel('Vincular pedido y aceptar')
                            ->disabled(function (EventQuote $record): bool {
                                return $record->estado !== 'pendiente';
                            })
                            ->action(function (array $data, EventQuote $record): void {
                                $record->update([
                                    'converted_order_id' => $data['converted_order_id'],
                                    'estado' => 'aceptado',
                                ]);
                            })
                            ->successNotificationTitle('Solicitud aceptada y pedido vinculado'),
                    ]),
                Section::make('Acciones de la solicitud')
                    ->footerActions([
                        Action::make('rechazar')
                            ->label('Rechazar solicitud')
                            ->color('danger')
                            ->icon(Heroicon::OutlinedXMark)
                            ->requiresConfirmation()
                            ->modalHeading('Rechazar solicitud')
                            ->modalDescription('La solicitud se marcará como rechazada.')
                            ->modalSubmitActionLabel('Rechazar')
                            ->disabled(function (EventQuote $record): bool {
                                return $record->estado !== 'pendiente';
                            })
                            ->action(function (EventQuote $record): void {
                                $record->update(['estado' => 'rechazado']);
                            })
                            ->successNotificationTitle('Solicitud rechazada'),
                    ]),
            ]);
    }
}
