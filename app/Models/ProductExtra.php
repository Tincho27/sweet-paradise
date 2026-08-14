<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductExtra extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'precio_adicional' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItemExtras(): HasMany
    {
        return $this->hasMany(CartItemExtra::class);
    }

    public function orderItemExtras(): HasMany
    {
        return $this->hasMany(OrderItemExtra::class);
    }
}
