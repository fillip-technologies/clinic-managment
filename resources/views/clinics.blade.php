@extends('layouts.app')

@section('title', '| Clinics')

@section('content')

    {{-- Hero Banner --}}
    <section class="pt-36 pb-16 px-6"
        style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
        <div class="max-w-7xl mx-auto text-center">
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
                style="background: rgba(255,255,255,0.2); color: white;">
                Our Locations
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">Our Clinics & Branches</h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                Dr. Kundan Kumar's clinics are spread across Bihar — bringing world-class neurological care closer to you.
            </p>
        </div>
    </section>

    {{-- Clinics Grid --}}
    <section class="py-20 px-6" style="background: var(--color-light);">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-14">
                <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4"
                    style="background: var(--color-soft); color: var(--color-primary);">
                    3 Branches
                </span>
                <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Find a Clinic Near You</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Each branch is equipped with modern facilities and staffed by
                    experienced medical professionals.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                {{-- PATNA BRANCH --}}
                <div class="group relative rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                    style="background: white; border: 1px solid rgba(2,134,148,0.12);">

                    {{-- Top Accent --}}
                    <div class="h-2 w-full"
                        style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>

                    <div class="p-7 space-y-5">

                        {{-- Badge --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                    style="background: var(--color-soft);">
                                    <svg class="w-6 h-6" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M15 10h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-extrabold" style="color: var(--color-dark);">Patna</p>
                                    <p class="text-xs font-semibold uppercase tracking-wide"
                                        style="color: var(--color-primary);">Main Branch</p>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
                                style="background: var(--color-soft); color: var(--color-primary);">
                                <span class="w-2 h-2 rounded-full inline-block" style="background: #22c55e;"></span>Open
                            </span>
                        </div>

                        <div class="border-t" style="border-color: rgba(2,134,148,0.08);"></div>

                        {{-- Details --}}
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0zM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Address</p>
                                    <p class="text-sm" style="color: var(--color-dark);">NSMCH, Bihta, Patna, Bihar –
                                        800014</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Timing</p>
                                    <p class="text-sm" style="color: var(--color-dark);">Mon – Fri: 9:00 AM – 2:00 PM</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Contact</p>
                                    <p class="text-sm" style="color: var(--color-dark);">+91 80881 52289</p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-3 pt-1">
                            <a href="tel:+918088152289"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition hover:-translate-y-0.5"
                                style="background: var(--color-primary);">
                                📞 Call Now
                            </a>
                            <a href="https://maps.google.com/?q=NSMCH+Sheikhpura+Patna" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition hover:-translate-y-0.5"
                                style="background: var(--color-soft); color: var(--color-primary); border: 1px solid rgba(2,134,148,0.2);">
                                📍 Directions
                            </a>
                        </div>

                    </div>
                </div>

                {{-- ARA BRANCH --}}
                <div class="group relative rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                    style="background: var(--color-dark); border: 1px solid rgba(255,255,255,0.06);">

                    <div class="h-2 w-full"
                        style="background: linear-gradient(to right, var(--color-secondary), var(--color-primary));"></div>

                    <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-full opacity-5"
                        style="background: var(--color-secondary);"></div>

                    <div class="relative p-7 space-y-5">

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                    style="background: rgba(93,202,212,0.15);">
                                    <svg class="w-6 h-6" fill="none" stroke="#5DCAD4" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M15 10h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-extrabold text-white">Ara</p>
                                    <p class="text-xs font-semibold uppercase tracking-wide"
                                        style="color: var(--color-secondary);">Branch Clinic</p>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
                                style="background: rgba(93,202,212,0.12); color: var(--color-secondary);">
                                <span class="w-2 h-2 rounded-full inline-block" style="background: #22c55e;"></span>Open
                            </span>
                        </div>

                        <div class="border-t" style="border-color: rgba(255,255,255,0.07);"></div>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: rgba(93,202,212,0.12);">
                                    <svg class="w-4 h-4" fill="none" stroke="#5DCAD4" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0zM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-secondary);">Address</p>
                                    <p class="text-sm" style="color: rgba(240,249,250,0.85);">Mahavir Tola Near LIC Office,
                                        ARA
                                        Bihar – 802301</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: rgba(93,202,212,0.12);">
                                    <svg class="w-4 h-4" fill="none" stroke="#5DCAD4" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-secondary);">Timing</p>
                                    <p class="text-sm" style="color: rgba(240,249,250,0.85);">Tuesday: 5:00 PM – 7:00 PM
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: rgba(93,202,212,0.12);">
                                    <svg class="w-4 h-4" fill="none" stroke="#5DCAD4" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-secondary);">Contact</p>
                                    <p class="text-sm" style="color: rgba(240,249,250,0.85);">+91 80881 52289</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-1">
                            <a href="tel:+918088152289"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition hover:-translate-y-0.5"
                                style="background: var(--color-primary);">
                                📞 Call Now
                            </a>
                            <a href="https://maps.google.com/?q=Ara+Bhojpur+Bihar" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition hover:-translate-y-0.5"
                                style="background: rgba(93,202,212,0.12); color: var(--color-secondary); border: 1px solid rgba(93,202,212,0.2);">
                                📍 Directions
                            </a>
                        </div>

                    </div>
                </div>

                {{-- SIWAN BRANCH --}}
                <div class="group relative rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                    style="background: white; border: 1px solid rgba(2,134,148,0.12);">

                    <div class="h-2 w-full"
                        style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>

                    <div class="p-7 space-y-5">

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                    style="background: var(--color-soft);">
                                    <svg class="w-6 h-6" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M15 10h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-extrabold" style="color: var(--color-dark);">Siwan</p>
                                    <p class="text-xs font-semibold uppercase tracking-wide"
                                        style="color: var(--color-primary);">Branch Clinic</p>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
                                style="background: var(--color-soft); color: var(--color-primary);">
                                <span class="w-2 h-2 rounded-full inline-block" style="background: #22c55e;"></span>Open
                            </span>
                        </div>

                        <div class="border-t" style="border-color: rgba(2,134,148,0.08);"></div>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0zM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Address</p>
                                    <p class="text-sm" style="color: var(--color-dark);">Holy spectra hospital, Near Dr.
                                        Shahnwaz Alam, Bindusar
                                        Road, Siwan – 841226
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Timing</p>
                                    <p class="text-sm" style="color: var(--color-dark);"> Sat: 10:00 AM – 3:00 PM</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                    style="background: var(--color-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5"
                                        style="color: var(--color-primary);">Contact</p>
                                    <p class="text-sm" style="color: var(--color-dark);">+91 80881 52289</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-1">
                            <a href="tel:+918088152289"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition hover:-translate-y-0.5"
                                style="background: var(--color-primary);">
                                📞 Call Now
                            </a>
                            <a href="https://maps.google.com/?q=Siwan+Bihar" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition hover:-translate-y-0.5"
                                style="background: var(--color-soft); color: var(--color-primary); border: 1px solid rgba(2,134,148,0.2);">
                                📍 Directions
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- Clinical Excellence Section --}}
    <section class="py-20 px-6" style="background: var(--color-light);">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-14 items-center">

                {{-- LEFT: Image with floating badge --}}
                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        {{-- Gradient border ring --}}
                        <div class="absolute -inset-1 rounded-3xl opacity-20 blur-xl"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                        </div>
                        <img src="https://images.pexels.com/photos/3938023/pexels-photo-3938023.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Advanced Surgical Suite" class="relative w-full h-[420px] object-cover rounded-3xl">
                        {{-- Dark overlay --}}
                        <div class="absolute inset-0 rounded-3xl"
                            style="background: linear-gradient(to top, rgba(2,134,148,0.4) 0%, transparent 60%);"></div>
                    </div>

                    {{-- Floating stat badge --}}
                    <div class="absolute bottom-6 left-6 right-6 rounded-2xl p-5 shadow-2xl"
                        style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(2,134,148,0.12);">
                        <p class="text-3xl font-extrabold" style="color: var(--color-primary);">10k+</p>
                        <p class="text-sm font-semibold mt-0.5" style="color: var(--color-dark);">Successful Procedures</p>
                        <p class="text-xs text-gray-500 mt-1">Delivering precision care across the region for over a decade.
                        </p>
                    </div>
                </div>

                {{-- RIGHT: Content --}}
                <div>
                    {{-- Label --}}
                    <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-5"
                        style="background: var(--color-soft); color: var(--color-primary);">
                        The NeuroPrecision Advantage
                    </span>

                    <h2 class="text-4xl font-extrabold leading-tight mb-8" style="color: var(--color-dark);">
                        Clinical Excellence<br>Guided by Compassion
                    </h2>

                    {{-- Feature 1 --}}
                    <div class="flex items-start gap-5 mb-8">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                            style="background: var(--color-soft);">
                            <svg class="w-6 h-6" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-1" style="color: var(--color-dark);">State-of-the-Art Tools</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Equipped with 3T MRI, intraoperative
                                neuro-navigation, and robotic-assisted surgical systems for <span
                                    style="color: var(--color-primary); font-weight:600;">unparalleled precision.</span></p>
                        </div>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="flex items-start gap-5 mb-8">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                            style="background: var(--color-soft);">
                            <svg class="w-6 h-6" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-1" style="color: var(--color-dark);">Expert Surgeons</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Our team consists of board-certified
                                neurosurgeons trained at global centers of excellence, bringing <span
                                    style="color: var(--color-primary); font-weight:600;">international standards</span> to
                                your city.</p>
                        </div>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                            style="background: var(--color-soft);">
                            <svg class="w-6 h-6" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-1" style="color: var(--color-dark);">Patient-First Care</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">We prioritize your comfort and understanding,
                                ensuring every treatment plan is <span
                                    style="color: var(--color-primary); font-weight:600;">personalized</span> to your
                                specific neurological health goals.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-20 px-6" style="background: white;">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4"
                    style="background: var(--color-soft); color: var(--color-primary);">
                    FAQs
                </span>
                <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Frequently Asked Questions</h2>
                <p class="text-gray-500">Everything you need to know before visiting our clinics.</p>
            </div>

            {{-- FAQ Items --}}
            <div class="space-y-4" id="faq-container">

                {{-- FAQ 1 --}}
                <div class="rounded-2xl overflow-hidden transition-all" style="border: 1px solid rgba(2,134,148,0.15);">
                    <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-6 py-5 text-left font-semibold transition"
                        style="background: var(--color-soft); color: var(--color-dark);">
                        <span>Do I need a prior appointment to visit the clinic?</span>
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-300 faq-icon" fill="none"
                            stroke="#028694" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-5 text-sm text-gray-600 leading-relaxed"
                        style="background: white; border-top: 1px solid rgba(2,134,148,0.08);">
                        While walk-ins are welcome, we strongly recommend booking an appointment in advance — especially for
                        the Ara and Siwan branches which operate on limited days. You can book via WhatsApp or call us
                        directly.
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="rounded-2xl overflow-hidden transition-all" style="border: 1px solid rgba(2,134,148,0.15);">
                    <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-6 py-5 text-left font-semibold transition"
                        style="background: var(--color-soft); color: var(--color-dark);">
                        <span>Which branch is best for emergency neurological care?</span>
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-300 faq-icon" fill="none"
                            stroke="#028694" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-5 text-sm text-gray-600 leading-relaxed"
                        style="background: white; border-top: 1px solid rgba(2,134,148,0.08);">
                        For emergencies, please visit the <strong style="color: var(--color-primary);">Patna (NSMCH,
                            Bihta)</strong> branch as it is our main branch with full diagnostic and surgical support. For
                        life-threatening emergencies, please call <strong>+91 80881 52289</strong> immediately.
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="rounded-2xl overflow-hidden transition-all" style="border: 1px solid rgba(2,134,148,0.15);">
                    <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-6 py-5 text-left font-semibold transition"
                        style="background: var(--color-soft); color: var(--color-dark);">
                        <span>What conditions does Dr. Kundan Kumar treat at these clinics?</span>
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-300 faq-icon" fill="none"
                            stroke="#028694" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-5 text-sm text-gray-600 leading-relaxed"
                        style="background: white; border-top: 1px solid rgba(2,134,148,0.08);">
                        Dr. Kundan Kumar specializes in brain tumors, spinal disc problems, stroke management, head
                        injuries, epilepsy, and complex nerve conditions. All branches offer OPD (outpatient) consultations,
                        while surgical procedures are performed at the Patna branch.
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="rounded-2xl overflow-hidden transition-all" style="border: 1px solid rgba(2,134,148,0.15);">
                    <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-6 py-5 text-left font-semibold transition"
                        style="background: var(--color-soft); color: var(--color-dark);">
                        <span>Are second opinions and reports review available?</span>
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-300 faq-icon" fill="none"
                            stroke="#028694" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-5 text-sm text-gray-600 leading-relaxed"
                        style="background: white; border-top: 1px solid rgba(2,134,148,0.08);">
                        Yes, absolutely. Patients are encouraged to bring existing MRI/CT scans and medical reports for
                        review. Dr. Kundan Kumar provides thorough second opinions at all clinic locations to help patients
                        make informed decisions about their treatment.
                    </div>
                </div>



            </div>
        </div>
    </section>


    {{-- Book Appointment CTA --}}
    <section class="py-16 px-6" style="background: var(--color-dark);">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white mb-4">Ready to Visit Us?</h2>
            <p class="text-white/70 mb-8">Book your appointment at any of our branches and get expert
                neurological care from
                Dr. Kundan Kumar.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/918088152289"
                    class="px-8 py-3 rounded-xl text-white font-semibold shadow-lg transition hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                    Book via WhatsApp
                </a>
                <a href="tel:+918088152289" class="px-8 py-3 rounded-xl font-semibold transition hover:-translate-y-0.5"
                    style="background: rgba(255,255,255,0.08); color: white; border: 1px solid rgba(255,255,255,0.15);">
                    📞 Call Now
                </a>
            </div>
        </div>
    </section>

    <script>
        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isOpen = !answer.classList.contains('hidden');

            // Close all
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = 'rotate(0deg)');
            document.querySelectorAll('#faq-container > div').forEach(d => d.style.borderColor = 'rgba(2,134,148,0.15)');

            // Open clicked if it was closed
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                btn.closest('div').style.borderColor = 'var(--color-primary)';
            }
        }
    </script>

@endsection