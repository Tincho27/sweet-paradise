<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with('items.productVariant.product')->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Tu carrito está vacío. Agregá productos antes de finalizar la compra.');
        }

        $storeAddress = Setting::where('key', 'direccion')->value('value');

        $userEmail = $user->email;

        $cartItems = $cart->items;

        $subtotal = 0;
        
        foreach ($cartItems as $item) {
            $subtotal += $item->precio_unitario_snapshot * $item->cantidad;
        }

        $envio = 'A calcular';
        $total = $subtotal;

        return view('checkout', compact('cart', 'storeAddress', 'userEmail', 'cartItems', 'subtotal', 'envio', 'total'));
    }

    public function success(Request $request, string $order_number)
    {
        $order = Order::with([
            'items.productVariant.product',
        ])
            ->where('order_number', $order_number)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $settings = Setting::whereIn('key', [
            'alias',
            'cbu',
            'titular',
            'whatsapp',
            'instagram',
            'email_contacto',
        ])->pluck('value', 'key');

        return view('confirmation', compact('order', 'settings'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with('items')->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Tu carrito está vacío. Agregá productos antes de confirmar el pedido.');
        }

        $data = $request->validate([
            'email' => ['required', 'email'],
            'delivery_type' => ['required', 'in:pickup,delivery'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
            'fecha' => ['nullable', 'date'],
            'observaciones' => ['nullable', 'string'],
        ]);

        if ($data['delivery_type'] === 'delivery' && empty($data['delivery_address'])) {
            return back()
                ->withErrors(['delivery_address' => 'La dirección es obligatoria para envío a domicilio.'])
                ->withInput();
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->precio_unitario_snapshot * $item->cantidad;
        });

        $order = DB::transaction(function () use ($cart, $data, $subtotal, $user) {
            $createdOrder = Order::create([
                'user_id' => $user->id,
                'order_number' => 'SP-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                'email' => $data['email'],
                'canal' => 'web',
                'estado_orden' => 'pendiente',
                'metodo_entrega' => $data['delivery_type'],
                'direccion_envio' => $data['delivery_type'] === 'delivery' ? $data['delivery_address'] : null,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'observaciones' => $data['observaciones'] ?? null,
                'fecha_estimada' => $data['fecha'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $createdOrder->id,
                    'product_variant_id' => $item->product_variant_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario_snapshot' => $item->precio_unitario_snapshot,
                    'descuento_snapshot' => $item->descuento_snapshot,
                ]);
            }

            CartItem::where('cart_id', $cart->id)->delete();

            return $createdOrder;
        });


        return redirect()->route('confirmation', ['order_number' => $order->order_number]);
    }
}
