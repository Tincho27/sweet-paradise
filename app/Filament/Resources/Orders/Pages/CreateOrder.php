<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_number'] = 'SP-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        $data['canal'] = 'manual';
        $data['estado_orden'] = 'pendiente';
        $data['subtotal'] = 0;
        $data['total'] = 0;

        return $data;
    }

    protected function afterCreate(): void
    {
        $total = 0;

        $this->record->load('items.productVariant');

        foreach ($this->record->items as $item) {
            $total += $item->productVariant->precio * $item->cantidad;
        }

        $this->record->update([
            'subtotal' => $total,
            'total' => $total,
        ]);
    }
}
