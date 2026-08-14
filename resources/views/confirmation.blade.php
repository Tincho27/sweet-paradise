@extends('layouts.landing')

@section('title', 'Pedido confirmado | Sweet Paradise')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
@endsection

@section('content')
<section class="order-success-header">
    <div class="container">
        <div class="thank-you-card">
            <div class="success-icon" aria-hidden="true">✓</div>

            <h1>¡Gracias por confiar en Sweet Paradise!</h1>

            <p class="section-lead">
                Recibimos tu pedido correctamente y queremos agradecerte por elegirnos para formar parte de un momento especial.
            </p>

            <p class="thank-you-message">
                Tu pedido quedó registrado correctamente. A continuación encontrarás la información necesaria para completar el pago y seguir el estado de tu pedido.
            </p>
        </div>
    </div>
</section>

<section class="order-section">
    <div class="container">
        <div class="order-layout">
            <div class="order-content">
                <section class="order-card">
                    <h2>Detalle del pedido</h2>

                    <p class="card-description">
                        Conservá este número de pedido: lo necesitarás para confirmar, consultar el estado de tu pedido o pedir ayuda si surge algún inconveniente.
                    </p>

                    <div class="info-grid">
                        <div class="info-item">
                            <span>Número de pedido</span>
                            <strong>{{ $order->order_number }}</strong>
                        </div>

                        <div class="info-item">
                            <span>Fecha</span>
                            <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                        </div>

                        <div class="info-item">
                            <span>Estado</span>
                            <strong class="status pending">
                                <span class="status-icon" aria-hidden="true">⌛</span>
                                {{ ucfirst($order->estado_orden) }}
                            </strong>
                        </div>
                    </div>
                </section>

                <section class="order-card payment-instructions-card">
                    <div class="payment-heading">
                        <div>
                            <span class="eyebrow">Método de pago</span>
                            <h2>Transferencia bancaria</h2>
                        </div>
                    </div>

                    <p class="card-description">
                        Realizá la transferencia por el total de tu pedido y luego enviá el comprobante para que podamos verificarlo.
                    </p>

                    <div class="bank-details">
                        <div class="bank-detail">
                            <span>Alias</span>
                            <strong>{{ $settings->get('alias') }}</strong>
                        </div>

                        <div class="bank-detail">
                            <span>CBU</span>
                            <strong>{{ $settings->get('cbu') }}</strong>
                        </div>

                        <div class="bank-detail">
                            <span>Titular</span>
                            <strong>{{ $settings->get('titular') }}</strong>
                        </div>

                        <div class="bank-detail bank-detail-total">
                            <span>Total a transferir</span>
                            <strong>${{ number_format($order->total, 2, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="receipt-box">
                        <strong>Importante: enviá el comprobante</strong>
                        <p>
                            Mandanos una foto o captura de la transferencia junto con tu número de pedido. Podés usar WhatsApp o Instagram, según prefieras.
                        </p>

                        <div class="contact-actions">
                            <a class="contact-action whatsapp-action" href="https://wa.me/{{ $settings->get('whatsapp') }}" target="_blank" rel="noopener noreferrer">
                                <svg class="contact-action-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.6 4.1 1.6 5.9L.2 24l6.5-1.7a11.8 11.8 0 0 0 5.4 1.3h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.1-1.2-6.1-3.5-8.3Zm-8.4 18.1h-.1c-1.7 0-3.4-.5-4.8-1.3l-.3-.2-3.8 1 1-3.7-.2-.3a9.7 9.7 0 0 1-1.5-5.2C2.4 6.5 6.7 2.2 12.1 2.2c2.6 0 5 1 6.9 2.9a9.7 9.7 0 0 1 2.9 6.9c0 5.4-4.4 9.6-9.8 9.6Zm5.3-7.2c-.3-.2-1.7-.8-2-.9-.3-.1-.5-.2-.7.2-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-1.7-.8-2.8-1.5-3.9-3.4-.3-.5.3-.5.8-1.6.1-.2.1-.4 0-.5-.1-.2-.7-1.7-.9-2.3-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.8 4.3 1.8.8 2.5.9 3.4.8.5-.1 1.7-.7 1.9-1.4.2-.7.2-1.3.1-1.5Z"/>
                                </svg>
                                <span>Enviar por WhatsApp</span>
                            </a>

                            <a class="contact-action instagram-action" href="https://www.instagram.com/{{ ltrim($settings->get('instagram'), '@') }}" target="_blank" rel="noopener noreferrer">
                                <svg class="contact-action-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="5" ry="5"></rect>
                                    <circle cx="12" cy="12" r="4"></circle>
                                    <circle class="instagram-dot" cx="17.4" cy="6.6" r="1"></circle>
                                </svg>
                                <span>Enviar por Instagram</span>
                            </a>
                        </div>
                    </div>
                </section>

                <section class="order-card">
                    <h2>¿Qué sucede ahora?</h2>

                    <div class="timeline">
                        <div class="step">
                            <div class="circle">1</div>
                            <div>
                                <h3>Revisaremos tu comprobante</h3>
                                <p>Verificaremos que la transferencia haya sido acreditada correctamente.</p>
                            </div>
                        </div>

                        <div class="step">
                            <div class="circle">2</div>
                            <div>
                                <h3>Te comunicaremos si tu pedido fue confirmado</h3>
                                <p>Una vez que verifiquemos el pago, te avisaremos que el pedido quedó confirmado.</p>
                            </div>
                        </div>

                        <div class="step">
                            <div class="circle">3</div>
                            <div>
                                <h3>Comenzaremos la elaboración</h3>
                                <p>Prepararemos tu pedido de forma artesanal utilizando ingredientes seleccionados.</p>
                            </div>
                        </div>

                        <div class="step">
                            <div class="circle">4</div>
                            <div>
                                <h3>Coordinaremos el retiro o la entrega</h3>
                                <p>Te indicaremos los detalles cuando tu pedido esté listo.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="order-card contact-card">
                    <h2>Contacto</h2>

                    <p class="card-description">
                        Si tenés algún inconveniente con el pago o con tu pedido, podés escribirnos por cualquiera de nuestros canales de contacto.
                    </p>

                    <div class="contact-grid">
                        <div>
                            <span>WhatsApp</span>
                            <strong>{{ $settings->get('whatsapp') }}</strong>
                        </div>

                        <div>
                            <span>Instagram</span>
                            <strong>{{ $settings->get('instagram') }}</strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>{{ $settings->get('email_contacto') }}</strong>
                        </div>
                    </div>
                </section>

                <div class="order-actions">
                    <a href="{{ route('home') }}" class="btn">Volver al inicio</a>
                </div>
            </div>

            <aside class="order-summary">
                <div class="summary-card">
                    <h2>Resumen del pedido</h2>

                    @foreach ($order->items as $item)
                        <div class="summary-product">
                            <span>
                                {{ $item->productVariant->product->nombre }} x{{ $item->cantidad }}
                            </span>
                            <strong>${{ number_format($item->precio_unitario_snapshot * $item->cantidad, 2, ',', '.') }}</strong>
                        </div>
                    @endforeach

                    <hr>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>${{ number_format($order->subtotal, 2, ',', '.') }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Envío</span>
                        <strong>
                            {{ $order->costo_envio !== null ? '$' . number_format($order->costo_envio, 2, ',', '.') : 'A calcular' }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Entrega</span>
                        <strong>{{ $order->metodo_entrega === 'delivery' ? 'Envío a domicilio' : 'Retiro en el local' }}</strong>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <strong>${{ number_format($order->total, 2, ',', '.') }}</strong>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
