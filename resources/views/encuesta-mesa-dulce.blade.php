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

  <form id="encuesta" class="card survey-form">
    <h2>1. ¿Cuántas personas concurrirán al evento?</h2>
    <p class="helper">Podés elegir una opción o escribir otro valor.</p>

    <div class="option-list">
      <label class="option"><span><strong>50 personas</strong><span>Evento chico</span></span><input type="radio" name="personas" value="50"></label>
      <label class="option"><span><strong>100 personas</strong><span>Evento mediano</span></span><input type="radio" name="personas" value="100"></label>
      <label class="option"><span><strong>150 personas</strong><span>Evento grande</span></span><input type="radio" name="personas" value="150"></label>
      <label class="option"><span><strong>200 personas</strong><span>Evento muy grande</span></span><input type="radio" name="personas" value="200"></label>
      <label class="option"><span><strong>Otro...</strong><span>Especificar cantidad</span></span><input type="radio" name="personas" value="otro"></label>
    </div>

    <div class="row">
      <input id="personasOtro" type="text" placeholder="Si elegiste 'otro', escribí la cantidad">
      <input id="fechaEvento" type="date">
    </div>

    <div class="grid section-grid">
      <section class="question-panel">
        <h2>2. ¿La mesa dulce será el único servicio gastronómico del evento?</h2>
        <div class="option-list">
          <label class="option"><span><strong>Sí</strong><span>La mesa dulce es el único servicio</span></span><input type="checkbox" name="servicio" value="solo-mesa"></label>
          <label class="option"><span><strong>No, habrá almuerzo</strong><span>Además de la mesa dulce</span></span><input type="checkbox" name="servicio" value="almuerzo"></label>
          <label class="option"><span><strong>No, habrá cena</strong><span>Además de la mesa dulce</span></span><input type="checkbox" name="servicio" value="cena"></label>
          <label class="option"><span><strong>No, habrá comida y servicio de catering</strong><span>Evento completo</span></span><input type="checkbox" name="servicio" value="catering"></label>
          <label class="option"><span><strong>Otro...</strong><span>Especificar</span></span><input type="checkbox" name="servicio" value="otro"></label>
        </div>
      </section>

      <section class="question-panel">
        <h2>3. ¿Con qué productos te gustaría que esté conformada tu mesa dulce?</h2>
        <p class="helper">Podés elegir más de una opción.</p>
        <div class="option-list">
          <label class="option"><span><strong>Tartas</strong><span>Variedad principal</span></span><input type="checkbox" name="productos" value="tartas"></label>
          <label class="option"><span><strong>Shots</strong><span>Porciones pequeñas</span></span><input type="checkbox" name="productos" value="shots"></label>
          <label class="option"><span><strong>Tartas y variedades minis</strong><span>Shots, petit fours, etc.</span></span><input type="checkbox" name="productos" value="tartas-minis"></label>
          <label class="option"><span><strong>Tortas y tartas</strong><span>Combinación clásica</span></span><input type="checkbox" name="productos" value="tortas-tartas"></label>
          <label class="option"><span><strong>Otro...</strong><span>Especificar</span></span><input type="checkbox" name="productos" value="otro"></label>
        </div>
      </section>
    </div>

    <div class="survey-observations">
      <div>
        <label class="field-label" for="observaciones">4. Observaciones del evento</label>
        <textarea id="observaciones" placeholder="Fecha, lugar, estilo del evento, colores, preferencias, etc."></textarea>
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

    <div class="row actions-row">
      <button type="button" class="btn" onclick="enviarResumen()">Enviar respuesta</button>
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

@section('scripts')
<script>
function enviarResumen(){
  const personas = [...document.querySelectorAll('input[name="personas"]:checked')].map(i => i.value);
  const servicio = [...document.querySelectorAll('input[name="servicio"]:checked')].map(i => i.value);
  const productos = [...document.querySelectorAll('input[name="productos"]:checked')].map(i => i.value);
  const otro = document.getElementById('personasOtro').value.trim();
  const mensaje = [
    'Sweet Paradise - Encuesta',
    `Personas: ${personas.join(', ') || 'sin elegir'}${otro ? ' / ' + otro : ''}`,
    `Servicio: ${servicio.join(', ') || 'sin elegir'}`,
    `Productos: ${productos.join(', ') || 'sin elegir'}`,
    `Observaciones: ${document.getElementById('observaciones').value || 'sin observaciones'}`
  ].join('\n');
  alert(mensaje);
}
</script>
@endsection
