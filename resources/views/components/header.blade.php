<body class="bg-gray-100 font-sans">

<!-- Floating Glass Header -->
<header class="fixed top-5 left-1/2 transform -translate-x-1/2 w-11/12 z-50">
    <div class="backdrop-blur-xl bg-white/80 border border-white/30 shadow-xl rounded-full">

        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">

            <!-- Logo / Doctor Identity -->
            <div class="flex items-center gap-3">

                <!-- Profile Image -->
                <img src="{{ asset('images/dr-kundan.png') }}"
                    class="w-10 h-10 rounded-full object-cover border-2 border-orange-400"
                    alt="Dr Kundan">

                <!-- Name -->
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-gray-900">Dr. Kundan Kumar</p>
                    <p class="text-xs text-gray-500">Neurosurgeon</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">

                <a href="#" class="text-gray-700 hover:text-orange-500 transition">Home</a>
                <a href="#" class="text-gray-700 hover:text-orange-500 transition">Services</a>
                <a href="#" class="text-gray-700 hover:text-orange-500 transition">Conditions</a>
                <a href="#" class="text-gray-700 hover:text-orange-500 transition">About</a>
                <a href="#" class="text-gray-700 hover:text-orange-500 transition">Contact</a>

            </nav>

            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center gap-3">

                <!-- Call -->
                <a href="tel:+919999999999"
                    class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition text-sm">
                    Call
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/919999999999"
                    class="px-4 py-2 rounded-full bg-green-500 hover:bg-green-600 text-white text-sm shadow">
                    WhatsApp
                </a>

                <!-- Appointment -->
                <a href="#"
                    class="px-5 py-2 rounded-full bg-orange-500 hover:bg-orange-600 text-white text-sm shadow-lg">
                    Book Appointment
                </a>

            </div>

            <!-- Mobile Button -->
            <button id="menu-toggle" class="md:hidden">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden mt-3 backdrop-blur-xl bg-white/90 border border-white/30 shadow-xl rounded-2xl p-5 flex flex-col gap-4 text-center">

        <a href="#" class="text-gray-700 hover:text-orange-500">Home</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Services</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Conditions</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">About</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Contact</a>

        <a href="tel:+919999999999"
            class="px-4 py-2 rounded-full border border-gray-300 text-gray-700">
            Call Now
        </a>

        <a href="https://wa.me/919999999999"
            class="px-4 py-2 rounded-full bg-green-500 text-white">
            WhatsApp
        </a>

        <a href="#"
            class="px-4 py-2 rounded-full bg-orange-500 text-white">
            Book Appointment
        </a>

    </div>
</header>


<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

</body>