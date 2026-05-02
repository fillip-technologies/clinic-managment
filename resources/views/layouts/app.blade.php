<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Kundan Kumar</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">

    {{-- Alpine.js (for dropdowns, toggles, etc.) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Your custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="icon" type="image/webp" href="{{ asset('images/skyhooks-logo.webp') }}">


    <style>
        :root {
            /* PRIMARY BRAND */
            --color-primary: #028694;

            /* SECONDARY (soft white/light teal) */
            --color-secondary: #5DCAD4;

            /* DARK TEXT / BASE */
            --color-dark: #1E293B;

            /* LIGHT BACKGROUND */
            --color-light: #F0F9FA;

            /* SOFT TEAL */
            --color-soft: #E1F5F7;
        }
    </style>



</head>

<body class="font-sans text-gray-800 bg-gray-50 overflow-x-hidden w-full">

    {{-- Include Header --}}
    @include('components.header')

    {{-- Page Content --}}
    <main class="min-h-screen ">
        @yield('content')
    </main>

    {{-- Include Footer --}}
    @include('components.footer')

    {{-- Your custom JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
