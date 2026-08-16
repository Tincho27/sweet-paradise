<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\ProductVariant;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;

class OrderForm
{
    public static function createForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Cliente')
                    ->options(User::query()
                        ->where('is_admin', false)
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Select::make('metodo_entrega')
                    ->label('Entrega')
                    ->options([
                        'pickup' => 'Retiro en el local',
                        'delivery' => 'Envío a domicilio',
                    ])
                    ->required(),
                TextInput::make('direccion_envio')
                    ->label('Dirección de envío'),
                DatePicker::make('fecha_estimada')
                    ->label('Fecha estimada'),
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->columnSpanFull(),
                Repeater::make('items')
                    ->label('Productos')
                    ->relationship()
                    ->schema([
                        Select::make('product_variant_id')
                            ->label('Producto y tamaño')
                            ->options(ProductVariant::query()
                                ->with('product')
                                ->orderBy('product_id')
                                ->get()
                                ->mapWithKeys(function (ProductVariant $variant): array {
                                    return [
                                        $variant->id => $variant->product->nombre . ' - ' . $variant->nombre,
                                    ];
                                })
                                ->all())
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $variant = ProductVariant::find($state);

                                if (! $variant) {
                                    $set('precio_unitario_snapshot', null);

                                    return;
                                }

                                $set('precio_unitario_snapshot', $variant->precio);
                            })
                            ->required(),
                        TextInput::make('cantidad')
                            ->label('Cantidad')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                        TextInput::make('precio_unitario_snapshot')
                            ->label('Precio unitario')
                            ->numeric()
                            ->minValue(0)
                            ->readOnly()
                            ->required(),
                    ])
                    ->minItems(1)
                    ->columns(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
