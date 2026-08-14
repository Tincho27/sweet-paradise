<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with([
            'items.productVariant.product.category',
            'items.productVariant.product.images',
            'items.productVariant.product.variants',
        ])->where('user_id', $user->id)->first();

        if (! $cart) {
            $cart = Cart::create(['user_id' => $user->id]);
            $cart->load([
                'items.productVariant.product.category',
                'items.productVariant.product.images',
                'items.productVariant.product.variants',
            ]);
        }

        $cartItems = $cart->items;
        $itemsCount = $cartItems->sum('cantidad');
        $total = 0;

        foreach ($cartItems as $item) {
            $subtotal = $item->precio_unitario_snapshot * $item->cantidad;
            $total = $total + $subtotal;
        }

        return view('cart', compact('cart', 'cartItems', 'itemsCount', 'total'));
    }

    public function addToCart($product_id, Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (! $cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }

        $product = Product::find($product_id);

        if (! $product) {
            return redirect()->route('products')->with('error', 'El producto no existe.');
        }

        $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
        ]);

        $variant = ProductVariant::where('product_id', $product->id)
            ->where('id', $request->integer('product_variant_id'))
            ->where('activo', true)
            ->first();

        if (! $variant) {
            return redirect()->route('products')->with('error', 'La variante seleccionada no pertenece a este producto o no está activa.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            $cartItem->cantidad++;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'cantidad' => 1,
                'precio_unitario_snapshot' => $variant->precio,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Producto agregado al carrito.');
    }

    public function increaseQuantity($cart_item_id, Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (! $cart) {
            return redirect()->route('cart')->with('error', 'No se encontró tu carrito.');
        }

        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('cart_id', $cart->id)
            ->first();

        if (! $cartItem) {
            return redirect()->route('cart')->with('error', 'No se encontró el producto en tu carrito.');
        }

        $cartItem->cantidad++;
        $cartItem->save();

        return redirect()->route('cart');
    }

    public function decreaseQuantity($cart_item_id, Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (! $cart) {
            return redirect()->route('cart')->with('error', 'No se encontró tu carrito.');
        }

        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('cart_id', $cart->id)
            ->first();

        if (! $cartItem) {
            return redirect()->route('cart')->with('error', 'No se encontró el producto en tu carrito.');
        }

        if ($cartItem->cantidad <= 1) {
            return redirect()->route('cart')->with('error', 'El producto ya está en la cantidad mínima.');
        }

        $cartItem->cantidad--;
        $cartItem->save();

        return redirect()->route('cart');
    }

    public function removeItem($cart_item_id, Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (! $cart) {
            return redirect()->route('cart')->with('error', 'No se encontró tu carrito.');
        }

        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('cart_id', $cart->id)
            ->first();

        if (! $cartItem) {
            return redirect()->route('cart')->with('error', 'No se encontró el producto en tu carrito.');
        }

        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Producto eliminado del carrito.');
    }

    public function updateVariant($cart_item_id, Request $request)
    {
        $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
        ]);

        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (! $cart) {
            return redirect()->route('cart')->with('error', 'No se encontró tu carrito.');
        }

        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('cart_id', $cart->id)
            ->first();

        if (! $cartItem) {
            return redirect()->route('cart')->with('error', 'No se encontró el producto en tu carrito.');
        }

        $variant = ProductVariant::with('product')->find($request->integer('product_variant_id'));

        if (! $variant || $variant->product_id !== $cartItem->productVariant->product_id) {
            return redirect()->route('cart')->with('error', 'La variante seleccionada no pertenece a este producto.');
        }

        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variant->id)
            ->where('id', '!=', $cartItem->id)
            ->first();

        if ($existingItem) {
            $existingItem->cantidad += $cartItem->cantidad;
            $existingItem->precio_unitario_snapshot = $variant->precio;
            $existingItem->save();

            $cartItem->delete();
        } else {
            $cartItem->product_variant_id = $variant->id;
            $cartItem->precio_unitario_snapshot = $variant->precio;
            $cartItem->save();
        }

        return redirect()->route('cart')->with('success', 'Variante actualizada.');
    }
}

