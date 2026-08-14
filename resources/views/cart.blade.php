@extends('layouts.landing')

@section('title', 'Mi Carrito | Sweet Paradise')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
<section class="cart-header">
    <div class="container">
        <nav class="breadcrumb">
            <a href="/">Inicio</a>
            <span>/</span>
            <a href="{{ route('products') }}">Productos</a>
            <span>/</span>
            <span>Carrito</span>
        </nav>

        <h1>Mi carrito</h1>

        <p class="section-lead">
            Tenés <strong>{{ $itemsCount }}</strong> productos agregados. Podés revisar el resumen antes de finalizar tu compra.
        </p>
    </div>
</section>

<section class="cart-section">
    <div class="container">
        @if (session('success'))
            <p class="cart-feedback cart-feedback-success">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="cart-feedback cart-feedback-error">{{ session('error') }}</p>
        @endif

        <div class="cart-layout">
            <div class="cart-products">
                @if ($cartItems->count() > 0)
                    @foreach ($cartItems as $item)
                        @php
                            $variant = $item->productVariant;
                            $product = $variant->product;
                            $image = $product->images->first();
                            $variants = $product->variants ?? collect();
                            $showRemoveHint = $item->cantidad == 1;
                        @endphp

                        <article class="cart-item">
                            <div class="cart-image">
                                <img src="{{ $image ? asset($image->url) : asset('images/alfajores.jpg') }}" alt="{{ $product->nombre }}">
                            </div>

                            <div class="cart-info">
                                <span class="badge">
                                    {{ $product->category->nombre }}
                                </span>

                                <h2>{{ $product->nombre }}</h2>

                                <div class="variant-field">
                                    <label for="variant-{{ $item->id }}">Variante</label>
                                    <form action="{{ route('cartVariant', $item->id) }}" method="POST" class="variant-form">
                                        @csrf
                                        <select id="variant-{{ $item->id }}" name="product_variant_id" class="variant-select">
                                            @foreach ($variants as $variantOption)
                                                <option
                                                    value="{{ $variantOption->id }}"
                                                    @selected($variantOption->id === $variant->id)
                                                >
                                                    {{ $variantOption->nombre }}@if ($variantOption->descripcion) - {{ $variantOption->descripcion }}@endif - ${{ number_format((float) $variantOption->precio, 2, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="variant-update-button">Actualizar variante</button>
                                    </form>
                                </div>

                                <p class="cart-description">
                                    {{ $product->descripcion }}
                                </p>
                            </div>

                            <div class="cart-price">
                                <span class="price">
                                    ${{ number_format((float) $item->precio_unitario_snapshot, 2, ',', '.') }}
                                </span>

                                <div class="quantity-selector">
                                    <div class="quantity-decrease-wrap">
                                        <form action="{{ route('cartDecrease', $item->id) }}" method="POST">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="quantity-decrease-btn"
                                                @if ($showRemoveHint) disabled @endif
                                            >
                                                -
                                            </button>
                                        </form>

                                            @if ($showRemoveHint)
                                                <div class="quantity-tooltip">
                                                    Para quitarlo, usá eliminar.
                                                </div>
                                            @endif
                                    </div>
                                    <span>{{ $item->cantidad }}</span>
                                    <form action="{{ route('cartIncrease', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">+</button>
                                    </form>
                                </div>

                                <div class="subtotal">
                                    Subtotal
                                    <strong>
                                        ${{ number_format((float) ($item->precio_unitario_snapshot * $item->cantidad), 2, ',', '.') }}
                                    </strong>
                                </div>

                                <form action="{{ route('cartRemove', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="remove-item" type="submit">
                                        Eliminar
                                    </button>
                                </form>

                                <div class="variant-note">
                                    Precio según variante seleccionada
                                </div>
                            </div>
                        </article>
                    @endforeach
                @else
                    <div class="cart-empty">
                        <p>No hay productos cargados todavía.</p>
                    </div>
                @endif
            </div>

            <aside class="cart-summary">
                <div class="summary-card">
                    <h2>Resumen del pedido</h2>

                    <div class="summary-row">
                        <span>Productos</span>
                        <strong>{{ $itemsCount }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Envío</span>
                        <strong>A calcular</strong>
                    </div>

                    <div class="summary-row">
                        <span>Descuentos</span>
                        <strong>-</strong>
                    </div>

                    <hr>

                    <div class="summary-total">
                        <span>Total</span>
                        <strong>${{ $total }}</strong>
                    </div>

                    @if ($cartItems->count() > 0)
                        <a class="btn checkout-btn" href="{{ route('checkout') }}">
                            Finalizar compra
                        </a>
                    @else
                        <button class="btn checkout-btn" type="button" disabled>
                            Finalizar compra
                        </button>
                    @endif

                    <div class="summary-benefits">
                        <div class="benefit">✅ Pago seguro</div>
                        <div class="benefit">🍰 Elaboración artesanal</div>
                        <div class="benefit">🚚 Entrega coordinada</div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
