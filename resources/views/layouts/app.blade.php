<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCDHO | DrMukherjeeS Clinic</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/life.webp') }}">

    <style>
        :root {
            --color-primary: #0f766e;
            --color-secondary: #f59e0b;
            --color-dark: #12343b;
            --color-light: #f4fbf8;
            --color-soft: #dff5ed;
            --color-blue: #2563eb;
        }
    </style>
</head>

<body class="font-sans text-gray-800 bg-white overflow-x-hidden w-full">
    @include('components.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('components.footer')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
