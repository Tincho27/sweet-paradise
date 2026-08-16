<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'costo_envio' => 'decimal:2',
            'descuento' => 'decimal:2',
            'extra' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'fecha_estimada' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function ingredientMovements(): HasMany
    {
        return $this->hasMany(IngredientMovement::class);
    }

    public function eventQuote(): HasOne
    {
        return $this->hasOne(EventQuote::class, 'converted_order_id');
    }
}
