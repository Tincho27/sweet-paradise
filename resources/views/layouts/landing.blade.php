<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Sweet Paradise')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}-soft-palette">
@yield('page-styles')
</head>
<body>
@include('partials.header')

@if (session('login_success'))
  <div class="login-success" role="status">
    <span aria-hidden="true">✓</span>
    {{ session('login_success') }}
  </div>
@endif

<main>
@yield('content')
</main>

@include('partials.footer')

@yield('scripts')
</body>
</html>
