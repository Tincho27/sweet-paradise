@extends('layouts.landing')

@section('title','Checkout | Sweet Paradise')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')

<section class="checkout-header">
    <div class="container">
        <nav class="breadcrumb">
            <a href="/">Inicio</a>
            <span>/</span>
            <a href="{{ route('products') }}">Productos</a>
            <span>/</span>
            <a href="{{ route('cart') }}">Carrito</a>
            <span>/</span>
            <span>Checkout</span>
        </nav>

        <h1>Finalizar compra</h1>

        <p class="section-lead">
            Completá tus datos para confirmar el pedido.
            Una vez recibido verificaremos el pago y comenzaremos
            la elaboración.
        </p>
    </div>
</section>

<section class="checkout-section">
    <div class="container">
        <div class="checkout-layout">
            <form id="checkoutForm" class="checkout-form" method="POST" action="{{ route('checkoutStore') }}">
                @csrf

                <section class="checkout-card">
                    <h2>Contacto</h2>

                    <div class="form-grid">
                        <div class="form-field-full form-field-center">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $userEmail ?? '') }}" />
                        </div>
                    </div>
                </section>

                <section class="checkout-card">
                    <h2>Entrega</h2>

                    <div class="radio-group">
                        <label class="delivery-option">
                            <input type="radio" name="delivery_type" value="pickup" checked>
                            <span class="delivery-option-icon" aria-hidden="true">🏪</span>
                            <span class="delivery-option-content">
                                <strong>Retiro en el local</strong>
                                <small>Pasás a buscar tu pedido.</small>
                            </span>
                        </label>

                        <label class="delivery-option">
                            <input type="radio" name="delivery_type" value="delivery">
                            <span class="delivery-option-icon" aria-hidden="true">🚚</span>
                            <span class="delivery-option-content">
                                <strong>Envío a domicilio</strong>
                                <small>Ingresá tu dirección de entrega.</small>
                            </span>
                        </label>
                    </div>

                    <div class="delivery-note" id="storeAddressBox">
                        <strong>Dirección del local:</strong>
                        <span>{{ $storeAddress ?? 'No se cargó la dirección del local todavía.' }}</span>
                    </div>

                    <div class="delivery-address" id="deliveryAddressBox" hidden>
                        <label>Dirección</label>

                        <input
                            id="deliveryAddressInput"
                            name="delivery_address"
                            type="text"
                            value="{{ old('delivery_address') }}"
                            placeholder="Calle, altura, piso..."
                            disabled
                        >
                    </div>

                    <br>

                    <p class="checkout-note">
                        Importante: Por favor, solo agregar la fecha si es necesaria para un mini evento (para evento grande se encuentra la seccion Mesa dulce), y con un tiempo razonable. Muchas gracias.
                    </p>

                    <label>Fecha deseada</label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}">
                </section>

                <section class="checkout-card">
                    <h2>Método de pago</h2>

                    <div class="payment-box">
                        <div class="payment-header">
                            <span class="payment-title">Transferencia bancaria</span>
                            <span class="payment-badge">Próximamente más métodos</span>
                        </div>

                        <p class="payment-note">
                            En esta seccion se podrán seleccionar diferentes metodos para acreditar en el futuro. En la proxima seccion se le otorgará el Alias para poder realizar el pago.
                        </p>
                    </div>
                </section>

                <section class="checkout-card">
                    <h2>Observaciones</h2>

                    <textarea
                        name="observaciones"
                        rows="5"
                        placeholder="Ej.: sin frutos secos, horario de entrega, dedicatoria..."
                    >{{ old('observaciones') }}</textarea>
                </section>

            </form>

            <aside class="checkout-summary">
                <div class="summary-card">
                    <h2>Resumen del pedido</h2>

                    @foreach ($cartItems as $item)
                        <div class="summary-product">
                            <span>
                                {{ $item->productVariant->product->nombre }} - {{ $item->productVariant->nombre }} x{{ $item->cantidad }}
                            </span>
                            <strong>${{ number_format($item->precio_unitario_snapshot * $item->cantidad, 0, ',', '.') }}</strong>
                        </div>
                    @endforeach

                    <hr>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>${{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Envío</span>
                        <strong>{{ $envio }}</strong>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <strong>${{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    <button class="btn checkout-btn" type="submit" form="checkoutForm">
                        Confirmar pedido
                    </button>

                    <p class="confirmation-note">
                        Al confirmar el pedido se generará una solicitud
                        pendiente de verificación manual.
                        Una vez validado el pago nos pondremos en contacto.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    const pickupRadio = document.querySelector('input[name="delivery_type"][value="pickup"]');
    const deliveryRadio = document.querySelector('input[name="delivery_type"][value="delivery"]');
    const storeAddressBox = document.getElementById('storeAddressBox');
    const deliveryAddressBox = document.getElementById('deliveryAddressBox');
    const deliveryAddressInput = document.getElementById('deliveryAddressInput');

    function syncDeliveryUI() {
        const isDelivery = deliveryRadio.checked;

        storeAddressBox.hidden = isDelivery;
        deliveryAddressBox.hidden = ! isDelivery;
        deliveryAddressInput.disabled = ! isDelivery;
    }

    pickupRadio.addEventListener('change', syncDeliveryUI);
    deliveryRadio.addEventListener('change', syncDeliveryUI);
    syncDeliveryUI();
})();
</script>
@endsection
