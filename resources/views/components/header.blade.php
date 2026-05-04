<!-- Floating Glass Header -->
<header class="fixed top-5 left-1/2 transform -translate-x-1/2 w-11/12 z-50">
    <div class="backdrop-blur-xl bg-white/80 border border-white/30 shadow-xl rounded-full">

        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">

            <!-- Logo / Doctor Identity -->
            <div class="flex items-center gap-3">

                <!-- Profile Image -->
                <img src="{{ asset('images/dr-kundan.png') }}" class="w-10 h-10 rounded-full object-cover"
                    style="border: 2px solid var(--color-primary);" alt="Dr Kundan">

                <!-- Name -->
                <div class="leading-tight">
                    <p class="text-sm font-semibold" style="color: var(--color-dark);">Dr. Kundan Kumar</p>
                    <p class="text-xs text-gray-500">Neurosurgeon</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">

                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'font-semibold' : 'text-gray-700' }} transition"
                    style="color: {{ request()->is('/') ? 'var(--color-primary)' : 'var(--color-dark)' }};" {!! request()->is('/') ? '' : 'onmouseover="this.style.color=\\\'var(--color-primary)\\\'" onmouseout="this.style.color=\\\'var(--color-dark)\\\'"' !!}>Home</a>
                <!-- Services Dropdown -->
                <div class="relative group py-4 -my-4">
                    <a href="{{ url('/services') }}"
                        class="{{ request()->is('services') ? 'font-semibold' : 'text-gray-700' }} transition flex items-center gap-1"
                        style="color: {{ request()->is('services') ? 'var(--color-primary)' : 'var(--color-dark)' }};"
                        {!! request()->is('services') ? '' : 'onmouseover="this.style.color=\\\'var(--color-primary)\\\'" onmouseout="this.style.color=\\\'var(--color-dark)\\\'"' !!}>
                        Services
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <!-- Dropdown Menu -->
                    <div
                        class="absolute left-0 top-full mt-0 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                        <a href="{{ url('/services/neurology') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition border-b border-gray-50">Neurology</a>
                        <a href="{{ url('/services/orthopedics') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition border-b border-gray-50">Orthopedics</a>
                        <a href="{{ url('/services/general-surgery') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition">General
                            Surgery</a>
                    </div>
                </div>
                <a href="{{ url('/clinics') }}"
                    class="{{ request()->is('clinics') ? 'font-semibold' : 'text-gray-700' }} transition"
                    style="color: {{ request()->is('clinics') ? 'var(--color-primary)' : 'var(--color-dark)' }};" {!! request()->is('clinics') ? '' : 'onmouseover="this.style.color=\\\'var(--color-primary)\\\'" onmouseout="this.style.color=\\\'var(--color-dark)\\\'"' !!}>Clinics</a>
                <a href="{{ url('/about') }}"
                    class="{{ request()->is('about') ? 'font-semibold' : 'text-gray-700' }} transition"
                    style="color: {{ request()->is('about') ? 'var(--color-primary)' : 'var(--color-dark)' }};" {!! request()->is('about') ? '' : 'onmouseover="this.style.color=\\\'var(--color-primary)\\\'" onmouseout="this.style.color=\\\'var(--color-dark)\\\'"' !!}>About</a>
                <a href="{{ url('/contact') }}"
                    class="{{ request()->is('contact') ? 'font-semibold' : 'text-gray-700' }} transition"
                    style="color: {{ request()->is('contact') ? 'var(--color-primary)' : 'var(--color-dark)' }};" {!! request()->is('contact') ? '' : 'onmouseover="this.style.color=\\\'var(--color-primary)\\\'" onmouseout="this.style.color=\\\'var(--color-dark)\\\'"' !!}>Contact</a>

            </nav>

            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center gap-3">

                <!-- Call -->
                <a href="tel:+918088152289"
                    class="px-4 py-2 rounded-full text-sm font-medium transition hover:shadow-md"
                    style="border: 1px solid var(--color-primary); color: var(--color-primary); background: white;">
                    📞 Call
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/918088152289"
                    class="px-4 py-2 rounded-full text-white text-sm font-medium shadow transition hover:-translate-y-0.5"
                    style="background: #25D366;">
                    WhatsApp
                </a>

                <!-- Appointment -->
                <a href="#"
                    class="px-5 py-2 rounded-full text-white text-sm font-semibold shadow-lg transition hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                    Book Appointment
                </a>

            </div>

            <!-- Mobile Button -->
            <button id="menu-toggle" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" style="color: var(--color-dark);"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden mt-3 backdrop-blur-xl bg-white/90 border border-white/30 shadow-xl rounded-2xl p-5 flex-col gap-4 text-center">

        <a href="{{ url('/') }}"
            class="block py-1 transition {{ request()->is('/') ? 'font-semibold' : 'font-medium' }}"
            style="color: {{ request()->is('/') ? 'var(--color-primary)' : 'var(--color-dark)' }};">Home</a>
        <div class="py-1 flex flex-col items-center w-full" x-data="{ open: false }">
            <div class="flex items-center justify-center gap-2">
                <a href="{{ url('/services') }}"
                    class="transition {{ request()->is('services') ? 'font-semibold' : 'font-medium' }}"
                    style="color: {{ request()->is('services') ? 'var(--color-primary)' : 'var(--color-dark)' }};">Services</a>
                <button @click="open = !open"
                    class="p-1 rounded-full text-gray-500 bg-gray-50 hover:bg-gray-100 transition focus:outline-none shadow-sm">
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
            <div x-show="open" style="display: none;" x-transition
                class="flex flex-col gap-1 mt-3 bg-gray-50/80 rounded-xl p-2 w-full text-sm border border-gray-100 shadow-inner">
                <a href="{{ url('/services/neurology') }}"
                    class="block py-2 px-3 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">🧠
                    Neurology</a>
                <a href="{{ url('/services/orthopedics') }}"
                    class="block py-2 px-3 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">🦴
                    Orthopedics</a>
                <a href="{{ url('/services/general-surgery') }}"
                    class="block py-2 px-3 rounded-lg text-gray-600 hover:text-teal-600 hover:bg-teal-50 transition">⚕
                    General Surgery</a>
            </div>
        </div>
        <a href="{{ url('/clinics') }}"
            class="block py-1 transition {{ request()->is('clinics') ? 'font-semibold' : 'font-medium' }}"
            style="color: {{ request()->is('clinics') ? 'var(--color-primary)' : 'var(--color-dark)' }};">Clinics</a>
        <a href="{{ url('/about') }}"
            class="block py-1 transition {{ request()->is('about') ? 'font-semibold' : 'font-medium' }}"
            style="color: {{ request()->is('about') ? 'var(--color-primary)' : 'var(--color-dark)' }};">About</a>
        <a href="{{ url('/contact') }}"
            class="block py-1 transition {{ request()->is('contact') ? 'font-semibold' : 'font-medium' }}"
            style="color: {{ request()->is('contact') ? 'var(--color-primary)' : 'var(--color-dark)' }};">Contact</a>

        <a href="tel:+918088152289" class="block px-4 py-2 rounded-full text-sm font-medium"
            style="border: 1px solid var(--color-primary); color: var(--color-primary);">
            📞 Call Now
        </a>

        <a href="https://wa.me/918088152289" class="block px-4 py-2 rounded-full text-white text-sm font-medium"
            style="background: #25D366;">
            WhatsApp
        </a>

        <a href="#" class="block px-4 py-2 rounded-full text-white text-sm font-semibold"
            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
            Book Appointment
        </a>

    </div>
</header>



<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('flex');
    });
</script>