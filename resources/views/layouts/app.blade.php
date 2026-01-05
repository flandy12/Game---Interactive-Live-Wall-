<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Jakarta Music Festival 2025</title>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">
    {{-- <script src="https://cdn.tiny.cloud/1/eurlu7d7btago4qbkngk9koxh3cn62potiv7f1ryk6kmosf7/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script> --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/app-second.css', // Added second CSS file
    ])

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @stack('styles')
</head>

<body class="bg-master overflow-hidden">

    @yield('content')

    @stack('scripts')
</body>

</html>
