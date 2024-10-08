<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9HTXFZ4EK6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9HTXFZ4EK6');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://localhost/bootstrap/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    {{-- <link rel="manifest" href="{{ asset('/public/manifest.json') }}"> --}}
    <meta name="theme-color" content="#3c91e6">
    <!-- Safari on iOS -->
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#3c91e6">
    <link rel="stylesheet" href="http://localhost/fontawesome/css/all.min.css">
    <script src="http://localhost/bootstrap/dist/js/bootstrap.bundle.js"></script>
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="/css/app.css">
    <title>@yield('title', "Inscription")</title>
</head>
<body>
    <div id="app" class="container mt-4  ">
       
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>