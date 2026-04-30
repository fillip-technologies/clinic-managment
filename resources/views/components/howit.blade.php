<section class="relative py-24 overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/neurology-bg.jpg') }}"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-900/95 via-teal-800/90 to-teal-700/80"></div>
    </div>

    <!-- AOS CDN -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <div class="relative max-w-7xl mx-auto px-6 text-white">

        <!-- Heading -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold">How It Works</h2>
            <p class="text-white/80 mt-3">
                Simple steps to get expert neurological care
            </p>
        </div>

        <!-- Steps -->
        <div class="relative grid md:grid-cols-4 gap-8">

            <!-- Line (desktop only) -->
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-[2px] bg-white/20"></div>

            <!-- STEP -->
            <div data-aos="fade-up" data-aos-delay="0"
                class="relative bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20 text-center group hover:bg-white/20 transition">

                <!-- Circle -->
                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-full bg-white/20 text-xl font-bold group-hover:scale-110 transition">
                    1
                </div>

                <h3 class="font-semibold text-lg">Book Appointment</h3>
                <p class="text-sm text-white/80 mt-2">
                    Schedule your consultation online or via call
                </p>
            </div>

            <!-- STEP -->
            <div data-aos="fade-up" data-aos-delay="150"
                class="relative bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20 text-center group hover:bg-white/20 transition">

                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-full bg-white/20 text-xl font-bold group-hover:scale-110 transition">
                    2
                </div>

                <h3 class="font-semibold text-lg">Consult Doctor</h3>
                <p class="text-sm text-white/80 mt-2">
                    Meet the specialist for evaluation & diagnosis
                </p>
            </div>

            <!-- STEP -->
            <div data-aos="fade-up" data-aos-delay="300"
                class="relative bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20 text-center group hover:bg-white/20 transition">

                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-full bg-white/20 text-xl font-bold group-hover:scale-110 transition">
                    3
                </div>

                <h3 class="font-semibold text-lg">Diagnosis & Treatment</h3>
                <p class="text-sm text-white/80 mt-2">
                    Get personalized treatment plan and procedures
                </p>
            </div>

            <!-- STEP -->
            <div data-aos="fade-up" data-aos-delay="450"
                class="relative bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20 text-center group hover:bg-white/20 transition">

                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-full bg-white/20 text-xl font-bold group-hover:scale-110 transition">
                    4
                </div>

                <h3 class="font-semibold text-lg">Recovery & Follow-up</h3>
                <p class="text-sm text-white/80 mt-2">
                    Continuous care for faster and safe recovery
                </p>
            </div>

        </div>

    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>

</section>