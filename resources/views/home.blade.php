@extends('layouts.landing')

@section('title', 'Sweet Paradise')

@section('content')
<section class="hero">
<div class="overlay">
  <h1>Sweet Paradise</h1>
  <p>Pasteleria artesanal premium. Tortas, tartas, minis y postres diseñados para convertir cualquier momento en una celebración inolvidable.</p>
  <div class="hero-actions">
    <a class="btn" href="#destacados">Ver Promociones</a>
    <a class="btn secondary" href="#catering">Quiero mi mesa dulce</a>
  </div>
</div>
</section>

<section id="destacados">
  <div class="container">
    <h2>Productos Destacados</h2>
    <p class="section-lead">Una selección de los productos destacados del catálogo.</p>
    <div class="promo-grid promo-grid-{{ min($featuredProducts->count(), 3) }}">
      @forelse ($featuredProducts as $product)
        @php
          $image = $product->orderedImages->first();
          $variant = $product->activeVariants->first();
        @endphp
        <article class="promo-card {{ $product->promo ? 'promo' : '' }}">
          <div class="top">
            <span>{{ $product->promo ? 'PROMO' : 'DESTACADO' }}</span>
            @if ($variant)
              <span>${{ number_format((float) $variant->precio, 0, ',', '.') }}</span>
            @endif
          </div>
          <div class="content">
            <img src="{{ $image ? asset($image->url) : asset('images/alfajores.jpg') }}" alt="{{ $product->nombre }}">
            <h3>{{ $product->nombre }}</h3>
            <p>{{ $product->descripcion ?: 'Producto destacado de Sweet Paradise.' }}</p>
            <div class="promo-actions">
              <span class="badge">{{ $product->category?->nombre ?? 'Producto' }}</span>
              <a class="catalog-product-link" href="{{ route('products') }}">Ver productos</a>
            </div>
          </div>
        </article>
      @empty
        <p class="featured-empty">Próximamente vas a encontrar productos destacados.</p>
      @endforelse
    </div>
  </div>
</section>

<section id="catering">
  <div class="container">
    <div class="catering-box">
      <div>
        <h3>¿Querés una mesa dulce o catering para tu evento?</h3>
        <p>Podés responder una pequeña encuesta para que podamos armarte una propuesta más precisa según la cantidad de personas, el servicio gastronómico y los productos que te gustaría incluir.</p>
        <div class="options">
          <div class="option"><div><strong>Cantidad de invitados</strong><span>50, 100, 150, 200 o otro</span></div><div>→</div></div>
          <div class="option"><div><strong>Servicio del evento</strong><span>Solo mesa dulce, almuerzo, cena o catering completo</span></div><div>→</div></div>
          <div class="option"><div><strong>Productos preferidos</strong><span>Tartas, shots, minis, tortas y combinaciones</span></div><div>→</div></div>
        </div>
      </div>
      <div style="text-align:center">
        <h3 style="font-size:1.7rem;margin-bottom:12px">Armemos tu propuesta</h3>
        <p style="margin-bottom:20px">Respondé unas preguntas rápidas y te ayudamos a cotizar mejor.</p>
        <a class="btn" href="{{ route('mesa.dulce') }}">Responder encuesta</a>
      </div>
    </div>
  </div>
</section>

<section id="nosotros">
<div class="container">
<h2>{{ $settings['nosotros_titulo'] ?? '¿Por qué elegirnos?' }}</h2>
<div class="features">
<div class="feature"><h3>Personalización</h3><p>{{ $settings['nosotros_personalizacion'] ?? 'Cada pedido es único.' }}</p></div>
<div class="feature"><h3>Delivery</h3><p>{{ $settings['nosotros_delivery'] ?? 'Entregas rápidas y seguras.' }}</p></div>
<div class="feature"><h3>Calidad</h3><p>{{ $settings['nosotros_calidad'] ?? 'Ingredientes seleccionados.' }}</p></div>
<div class="feature"><h3>Experiencia</h3><p>{{ $settings['nosotros_experiencia'] ?? 'Cientos de clientes felices.' }}</p></div>
</div>
</div>
</section>

<section id="opiniones">
<div class="container">
<h2>Opiniones</h2>
<div class="testimonials">
<div class="testimonial">★★★★★<br><br>"{{ $settings['opinion_1_texto'] ?? 'La torta quedó increíble y superó nuestras expectativas.' }}"<br><b>- {{ $settings['opinion_1_autor'] ?? 'María G.' }}</b></div>
<div class="testimonial">★★★★★<br><br>"{{ $settings['opinion_2_texto'] ?? 'Excelente atención y productos deliciosos.' }}"<br><b>- {{ $settings['opinion_2_autor'] ?? 'Juan P.' }}</b></div>
<div class="testimonial">★★★★★<br><br>"{{ $settings['opinion_3_texto'] ?? 'Los cupcakes fueron un éxito en el evento.' }}"<br><b>- {{ $settings['opinion_3_autor'] ?? 'Sofía R.' }}</b></div>
</div>
</div>
</section>

<section id="instagram">
<div class="container">
<a class="instagram-profile-link" href="{{ $settings['instagram_url'] ?? 'https://www.instagram.com/sweetparadise.azul/' }}" target="_blank" rel="noopener noreferrer" aria-label="Abrir perfil de Instagram">
  <h2>Instagram</h2>
  <svg class="contact-icon instagram-icon" viewBox="0 0 24 24" aria-hidden="true">
    <rect x="3" y="3" width="18" height="18" rx="5" />
    <circle cx="12" cy="12" r="4" />
    <circle cx="17.2" cy="6.8" r="1" class="instagram-dot" />
  </svg>
</a>
<div class="instagram">
<img src="{{ asset('images/foto-random.jpg') }}" alt="Instagram 1">
<img src="{{ asset('images/foto-random2.jpg') }}" alt="Instagram 2">
<img src="{{ asset('images/foto-random3.jpg') }}" alt="Instagram 3">
<img src="{{ asset('images/foto-random4.jpg') }}" alt="Instagram 4">
</div>
</div>
</section>

<section id="contacto">
<div class="container">
<h2>Contacto</h2>
<div class="contact">
<div>
<h3>Sweet Paradise</h3>
<p>{{ $settings['ciudad_contacto'] ?? 'Mar del Plata, Buenos Aires' }}</p>
<a class="contact-link" href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}" target="_blank" rel="noopener noreferrer" aria-label="Abrir WhatsApp">
  <svg class="contact-icon whatsapp-icon" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M20.5 11.5a8.5 8.5 0 0 1-12.55 7.48L3.5 20.5l1.52-4.33A8.5 8.5 0 1 1 20.5 11.5Z" />
    <path d="M9 7.7c.2-.45.42-.46.66-.46h.57c.2 0 .4.02.5.26l.78 1.85c.08.2.07.4-.06.57l-.42.55c-.13.16-.08.34.03.48.36.66.92 1.2 1.58 1.56.15.08.3.1.45-.05l.55-.65c.16-.18.34-.2.55-.12l1.78.82c.22.1.26.3.23.5-.1.68-.5 1.26-1.1 1.57-.36.18-.83.3-1.42.16-1.03-.25-2.38-1.15-3.5-2.24-1.1-1.08-2-2.48-2.27-3.5-.14-.54-.03-1.07.16-1.44Z" />
  </svg>
  <span>{{ $settings['telefono_contacto'] ?? '+54 11 5555-4444' }}</span>
</a>
<p>{{ $settings['email_contacto'] ?? 'contacto@sweetparadise.com' }}</p>
</div>
<form id="contact-form">
<input id="contact-name" required placeholder="Nombre">
<input id="contact-email" required type="email" placeholder="Correo">
<textarea id="contact-message" required placeholder="Mensaje"></textarea>
<button class="btn" style="margin-top:10px">Enviar</button>
</form>
</div>
</div>
</section>

@endsection

@section('scripts')
<script>
  document.getElementById('contact-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const name = document.getElementById('contact-name').value;
    const email = document.getElementById('contact-email').value;
    const message = document.getElementById('contact-message').value;
    const whatsapp = "{{ $settings['whatsapp'] ?? '' }}";
    const text = `Hola, soy ${name}.\nEmail: ${email}.\nConsulta: ${message}`;

    window.open(`https://wa.me/${whatsapp}?text=${encodeURIComponent(text)}`, '_blank');
  });

</script>
@endsection
