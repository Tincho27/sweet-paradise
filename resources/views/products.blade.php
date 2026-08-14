@extends('layouts.landing')

@section('title', 'Productos | Sweet Paradise')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
<section class="catalog-hero">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Inicio</a>
            <span>/</span>
            <span>Productos</span>
        </nav>

        <span class="catalog-subtitle">SWEET PARADISE</span>
        <h1>Nuestro Catálogo</h1>
        <p>Descubrí nuestros productos elaborados artesanalmente con ingredientes seleccionados.</p>
    </div>
</section>

<section class="catalog-page">
    <div class="container">
        <div class="catalog-top">
            <div>
                <h2 class="catalog-title">Todos los productos</h2>
                <p class="catalog-results">Mostrando <strong>{{ $products->count() }}</strong> productos</p>
            </div>
        </div>

        <div class="catalog-content">

                @if ($products->isEmpty())
                    <div class="catalog-empty">
                        <h3>No hay productos disponibles</h3>
                        <p>Próximamente vas a encontrar novedades en nuestro catálogo.</p>
                    </div>
                @else
                    <div class="products-grid products-grid-{{ min($products->count(), 3) }}">
                        @foreach ($products as $product)
                            @php
                                $variants = $product->activeVariants;
                                $variant = $variants->first();
                                $image = $product->images->first();
                                $price = $variant?->precio ?? 0;
                            @endphp
                            <article class="product-card">
                                <div class="product-image">
                                    <img src="{{ $image ? asset($image->url) : asset('images/alfajores.jpg') }}" alt="{{ $product->nombre }}">
                                </div>

                                <div class="product-info">
                                    <span class="badge">{{ $product->category->nombre ?? 'Producto' }}</span>
                                    <h3>{{ $product->nombre }}</h3>
                                    <p>{{ $product->descripcion }}</p>

                                    <div class="product-price">
                                        <span class="price">${{ number_format((float) $price, 0, ',', '.') }}</span>
                                    </div>
                                    @auth
                                        @if ($variant)
                                            <form action="{{ route('cartAdd', $product->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
                                                <button class="btn add-to-cart-btn" type="submit">
                                                    Agregar al carrito 🛒
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn add-to-cart-btn" type="button" disabled>
                                                Sin variantes disponibles
                                            </button>
                                        @endif
                                    @else
                                        <a class="btn add-to-cart-btn" href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}">
                                            Inicia sesion para comprar 🛒
                                        </a>
                                    @endauth
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
</section>

@endsection








