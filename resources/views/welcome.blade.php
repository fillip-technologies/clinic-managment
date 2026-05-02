@extends('layouts.app')

@section('content')

    <section class="relative overflow-hidden">

        <!-- Background -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/doctors-2.jpg') }}" class="w-full h-full object-cover" alt="Neurosurgery Background">

            <!-- Overlay -->
            <div class="absolute inset-0" style="
                        background: linear-gradient(
                            to right,
                            rgba(2, 134, 148, 0.95),
                            rgba(240, 249, 250, 0.4)
                        );
                    ">
            </div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-20">

            <div class="grid lg:grid-cols-2 gap-10 items-center">

                <!-- LEFT -->
                <div class="text-white space-y-6">

                    <!-- Badge -->
                    <span class="inline-block px-4 py-2 text-sm rounded-full backdrop-blur border border-white/20"
                        style="background: rgba(2, 134, 148, 0.2);">
                        🧠 Neurosurgeon | Brain & Spine Specialist
                    </span>

                    <!-- Name -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                        Dr. Kundan Kumar
                    </h1>

                    <!-- Qualification -->
                    <p class="text-xl font-semibold" style="color: var(--color-soft);">
                        MBBS, DNB, MCh (Neurosurgery)
                    </p>

                    <!-- Description -->
                    <p class="text-lg text-white/80 max-w-xl">
                        Providing advanced brain, spine, and nerve care with precision,
                        experience, and a patient-first approach in Patna.
                    </p>

                    <!-- CTA -->
                    <div class="flex flex-wrap gap-4">

                        <!-- WhatsApp -->
                        <a href="https://wa.me/918088152289"
                            class="inline-flex items-center px-6 py-3 text-lg font-medium rounded-lg text-white shadow-lg transition"
                            style="background: var(--color-secondary);">
                            WhatsApp Now
                        </a>

                        <!-- Book Appointment -->
                        <a href="#"
                            class="inline-flex items-center px-6 py-3 text-lg font-medium rounded-lg shadow-lg transition"
                            style="background: var(--color-light); color: var(--color-primary);">
                            Book Appointment
                        </a>

                    </div>

                </div>

                <!-- RIGHT IMAGE -->
                <div class="relative hidden lg:block">

                    <img src="{{ asset('images/dr-kundan.png') }}" alt="Dr Kundan Kumar" class="rounded-2xl shadow-2xl">

                    <!-- Tag -->
                    <div class="absolute bottom-4 left-4 px-4 py-2 rounded-lg shadow-md text-sm font-medium"
                        style="background: white; color: var(--color-dark);">
                        ✔ Consultant Neurosurgeon
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- quick trust strip -->
    <x-quicktruststrip />

    <!-- about doctor -->
    <x-aboutdoctor />

    <!-- catlouge -->
    <x-catlouge />

    <!-- conditions treated -->
    <x-conditionstreated />

    <x-whysecond />

    <x-branches />

    <!-- services-->
    <x-services />




    <!-- howit -->
    <x-howit />

    <!-- whychooseus-->
    <x-whychooseus />

    <!-- testimonials -->
    <x-testimonials />

    <!-- location & timing -->
    <x-locationtiming />

    <!--faq-->
    <x-faq />


@endsection