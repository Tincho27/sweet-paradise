<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_redirects_when_the_cart_is_empty(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('checkout'));

        $response->assertRedirect(route('cart'));
    }

    public function test_checkout_creates_order_items_and_clears_the_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $variant = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'precio' => 1500,
        ]);
        $cart = Cart::create(['user_id' => $user->id]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $variant->id,
            'cantidad' => 2,
            'precio_unitario_snapshot' => 1500,
        ]);

        $response = $this->actingAs($user)->post(route('checkoutStore'), [
            'email' => 'comprador@example.com',
            'delivery_type' => 'pickup',
            'observaciones' => 'Sin dedicatoria',
        ]);

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();

        $response->assertRedirect(route('confirmation', ['order_number' => $order->order_number]));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'email' => 'comprador@example.com',
            'subtotal' => 3000,
            'total' => 3000,
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_variant_id' => $variant->id,
            'cantidad' => 2,
            'precio_unitario_snapshot' => 1500,
        ]);
        $this->assertDatabaseCount('cart_items', 0);
    }
}
