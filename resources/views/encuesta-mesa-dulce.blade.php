@extends('layouts.landing')

@section('title', 'Encuesta mesa dulce | Sweet Paradise')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('css/encuesta-mesa-dulce.css') }}">
@endsection

@section('content')
<div class="wrap">
  <section class="mesa-hero">
    <h1>Encuesta rápida para mesa dulce o catering</h1>
    <p>Respondé estas preguntas para que Sweet Paradise pueda entender mejor tu evento y armar una propuesta más precisa.</p>
  </section>

  <form id="encuesta" class="card survey-form" method="POST" action="{{ route('mesa.dulce.store') }}">
    @csrf

    @if (session('success'))
      <div class="form-alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="form-alert error">Revisá los campos marcados e intentá nuevamente.</div>
    @endif

    <h2>1. ¿Cuántas personas concurrirán al evento?</h2>
    <p class="helper">Podés elegir una opción o escribir otro valor.</p>

    <div class="option-list">
      <label class="option"><span><strong>50 personas</strong><span>Evento chico</span></span><input type="radio" name="personas" value="50" @checked(old('personas') === '50')></label>
      <label class="option"><span><strong>100 personas</strong><span>Evento mediano</span></span><input type="radio" name="personas" value="100" @checked(old('personas') === '100')></label>
      <label class="option"><span><strong>150 personas</strong><span>Evento grande</span></span><input type="radio" name="personas" value="150" @checked(old('personas') === '150')></label>
      <label class="option"><span><strong>200 personas</strong><span>Evento muy grande</span></span><input type="radio" name="personas" value="200" @checked(old('personas') === '200')></label>
      <label class="option"><span><strong>Otro...</strong><span>Especificar cantidad</span></span><input type="radio" name="personas" value="otro" @checked(old('personas') === 'otro')></label>
    </div>

    <div class="row">
      <input id="personasOtro" name="personas_otro" type="number" min="1" value="{{ old('personas_otro') }}" placeholder="Si elegiste 'otro', escribí la cantidad">
      <input id="fechaEvento" name="fecha_evento" type="date" value="{{ old('fecha_evento') }}">
    </div>

    <div class="grid section-grid">
      <section class="question-panel">
        <h2>2. ¿La mesa dulce será el único servicio gastronómico del evento?</h2>
        <div class="option-list">
          <label class="option"><span><strong>Sí</strong><span>La mesa dulce es el único servicio</span></span><input type="radio" name="servicio" value="solo-mesa" @checked(old('servicio') === 'solo-mesa')></label>
          <label class="option"><span><strong>No, habrá almuerzo</strong><span>Además de la mesa dulce</span></span><input type="radio" name="servicio" value="almuerzo" @checked(old('servicio') === 'almuerzo')></label>
          <label class="option"><span><strong>No, habrá cena</strong><span>Además de la mesa dulce</span></span><input type="radio" name="servicio" value="cena" @checked(old('servicio') === 'cena')></label>
          <label class="option"><span><strong>No, habrá comida y servicio de catering</strong><span>Evento completo</span></span><input type="radio" name="servicio" value="catering" @checked(old('servicio') === 'catering')></label>
          <label class="option"><span><strong>Otro...</strong><span>Especificar</span></span><input type="radio" name="servicio" value="otro" @checked(old('servicio') === 'otro')></label>
        </div>
        <label class="other-field-label" for="servicioOtro">Si elegiste “Otro”, especificá cuál servicio necesitás.</label>
        <input id="servicioOtro" name="servicio_otro" type="text" value="{{ old('servicio_otro') }}" placeholder="">
      </section>

      <section class="question-panel">
        <h2>3. ¿Con qué productos te gustaría que esté conformada tu mesa dulce?</h2>
        <p class="helper">Podés elegir más de una opción.</p>
        <div class="option-list">
          <label class="option"><span><strong>Tartas</strong><span>Variedad principal</span></span><input type="checkbox" name="productos[]" value="tartas" @checked(in_array('tartas', old('productos', [])))></label>
          <label class="option"><span><strong>Shots</strong><span>Porciones pequeñas</span></span><input type="checkbox" name="productos[]" value="shots" @checked(in_array('shots', old('productos', [])))></label>
          <label class="option"><span><strong>Tartas y variedades minis</strong><span>Shots, petit fours, etc.</span></span><input type="checkbox" name="productos[]" value="tartas-minis" @checked(in_array('tartas-minis', old('productos', [])))></label>
          <label class="option"><span><strong>Tortas y tartas</strong><span>Combinación clásica</span></span><input type="checkbox" name="productos[]" value="tortas-tartas" @checked(in_array('tortas-tartas', old('productos', [])))></label>
          <label class="option"><span><strong>Otro...</strong><span>Especificar</span></span><input type="checkbox" name="productos[]" value="otro" @checked(in_array('otro', old('productos', [])))></label>
        </div>
        <label class="other-field-label" for="productoOtro">Si marcaste “Otro”, indicá cuál producto te gustaría incluir.</label>
        <input id="productoOtro" name="producto_otro" type="text" value="{{ old('producto_otro') }}" placeholder="">
      </section>
    </div>

    <div class="survey-observations">
      <div>
        <label class="field-label" for="observaciones">4. Observaciones del evento</label>
        <textarea id="observaciones" name="observaciones" placeholder="Fecha, lugar, estilo del evento, colores, preferencias, etc.">{{ old('observaciones') }}</textarea>
      </div>

      <aside class="summary" hidden>
        <h2>Resumen</h2>
        <p class="helper">Esto luego te sirve para pasarle una propuesta clara al cliente o para enviar el pedido al panel.</p>
        <ul class="summary-list">
          <li>Elegir cantidad de personas</li>
          <li>Indicar si hay otros servicios gastronómicos</li>
          <li>Seleccionar productos preferidos</li>
          <li>Agregar observaciones del evento</li>
        </ul>
      </aside>
    </div>

    <section class="contact-panel">
      <h2>Datos de contacto</h2>
      <p class="helper">Usaremos estos datos para comunicarnos sobre tu propuesta.</p>

      <div class="row">
        <div>
          <label class="field-label" for="email">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div>
          <label class="field-label" for="telefono">Teléfono</label>
          <input id="telefono" name="telefono" type="tel" value="{{ old('telefono', auth()->user()->phone) }}" placeholder="Ej.: 11 1234 5678" required>
        </div>
      </div>
    </section>

    <div class="row actions-row">
      <button type="submit" class="btn">Enviar respuesta</button>
      <a class="btn secondary" href="{{ route('home') }}">Volver al home</a>
    </div>
  </form>

  <section class="card" hidden>
    <h2>Opciones futuras</h2>
    <div class="badge-row">
      <span class="badge">Presupuesto automático</span>
      <span class="badge">Selección de productos</span>
      <span class="badge">Envío por WhatsApp</span>
      <span class="badge">Historial de encuestas</span>
    </div>
    <p class="helper">Cuando quieras, esta encuesta puede crecer a un flujo más completo con precios, disponibilidad y previsualización del pedido.</p>
  </section>

  <p class="footer-note">Sweet Paradise · Encuesta de mesa dulce / catering</p>
</div>
@endsection
