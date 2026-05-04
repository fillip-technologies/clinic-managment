@extends('layouts.app')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="relative overflow-hidden" style="background: var(--color-dark); min-height: 90vh;">

    {{-- Background image with overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/neurology-hero.png') }}"
             alt="Neurology" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0" style="background: linear-gradient(120deg, rgba(2,134,148,0.85) 0%, rgba(30,41,59,0.92) 55%, rgba(30,41,59,0.98) 100%);"></div>
    </div>

    {{-- Decorative circles --}}
    <div class="absolute top-24 right-0 w-[500px] h-[500px] rounded-full opacity-10 blur-3xl pointer-events-none" style="background: var(--color-secondary);"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full opacity-10 blur-3xl pointer-events-none" style="background: var(--color-primary);"></div>

    <div class="relative max-w-7xl mx-auto px-6 pt-40 pb-28 flex flex-col lg:flex-row items-center gap-16">

        {{-- Left: Content --}}
        <div class="flex-1 space-y-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm" style="color: var(--color-secondary); opacity: 0.8;">
                <a href="{{ url('/') }}" class="hover:opacity-100 transition">Home</a>
                <span>/</span>
                <a href="{{ url('/services') }}" class="hover:opacity-100 transition">Services</a>
                <span>/</span>
                <span style="color: var(--color-secondary);" class="opacity-100 font-semibold">Neurology</span>
            </nav>

            {{-- Label --}}
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-widest"
                  style="background: rgba(93,202,212,0.15); color: var(--color-secondary); border: 1px solid rgba(93,202,212,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Brain & Nervous System
            </span>

            {{-- Heading --}}
            <div>
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-white mb-4">
                    Expert Neurology<br>
                    <span style="color: var(--color-secondary);">& Brain Care</span>
                </h1>
                <p class="text-lg leading-relaxed max-w-lg" style="color: rgba(240,249,250,0.75);">
                    Advanced diagnosis and surgical treatment of brain, spine, and peripheral nerve disorders — delivered with precision, compassion, and 10+ years of specialized expertise.
                </p>
            </div>

            {{-- Stats row --}}
            <div class="flex flex-wrap gap-6">
                @php $heroStats = [['v'=>'10+','l'=>'Years\' Experience'],['v'=>'3000+','l'=>'Brain Cases'],['v'=>'95%','l'=>'Success Rate']]; @endphp
                @foreach($heroStats as $st)
                <div class="text-center">
                    <p class="text-3xl font-extrabold" style="color: var(--color-secondary);">{{ $st['v'] }}</p>
                    <p class="text-xs font-medium mt-1" style="color: rgba(240,249,250,0.6);">{{ $st['l'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- CTA buttons --}}
            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/918088152289"
                   class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-bold text-base shadow-2xl transition-all hover:-translate-y-1 hover:shadow-xl"
                   style="background: var(--color-primary);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Book Consultation
                </a>
                <a href="tel:+918088152289"
                   class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl font-bold text-base transition-all hover:-translate-y-1"
                   style="background: rgba(255,255,255,0.08); color: white; border: 1.5px solid rgba(93,202,212,0.4);">
                    📞 Call Now
                </a>
            </div>

        </div>

        {{-- Right: Image Visual --}}
        <div class="flex-1 flex justify-center mt-10 lg:mt-0 relative z-10">
            <div class="relative w-full max-w-lg">
                {{-- Decorative glow behind image --}}
                <div class="absolute inset-0 blur-3xl opacity-30 rounded-full scale-90 transform translate-y-4" style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>
                
                {{-- Main image --}}
                <div class="relative rounded-[2rem] overflow-hidden shadow-2xl transition duration-500 hover:scale-[1.02]" style="border: 1px solid rgba(93,202,212,0.3); background: rgba(30,41,59,0.5);">
                    <img src="{{ asset('images/scan.png') }}" alt="Advanced Brain Scan Analysis"
                         class="w-full object-cover" style="height: 480px; object-position: center;">
                    
                    {{-- Inner gradient overlay for depth --}}
                    <div class="absolute inset-0 opacity-80" style="background: linear-gradient(to top, rgba(15,23,42,1) 0%, transparent 40%);"></div>
                </div>

                {{-- Glassmorphism Floating Badge --}}
                <div class="absolute -bottom-6 -left-4 md:-left-8 flex items-center gap-4 px-6 py-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.5)] backdrop-blur-xl"
                     style="background: rgba(15,23,42,0.7); border: 1px solid rgba(93,202,212,0.2);">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(93,202,212,0.15);">
                        <svg class="w-6 h-6" fill="none" stroke="var(--color-secondary)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-white tracking-wide">MCh Neurosurgery</p>
                        <p class="text-xs font-medium" style="color: var(--color-secondary);">Advanced Specialist</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ===================== WHAT WE TREAT ===================== --}}
<section class="py-24 px-6" style="background: var(--color-light);">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-16">
            <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4"
                  style="background: var(--color-soft); color: var(--color-primary);">Conditions We Treat</span>
            <h2 class="text-4xl font-extrabold mb-3" style="color: var(--color-dark);">Neurological Conditions</h2>
            <p class="max-w-xl mx-auto text-base" style="color: rgba(30,41,59,0.6);">
                From common headaches to complex brain tumors — expert diagnosis and surgical treatment under one roof.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $conditions = [
                ['icon'=>'🧠','title'=>'Brain Tumors','desc'=>'Surgical removal of benign and malignant brain tumors using advanced neuro-navigation for maximum safety and precision.'],
                ['icon'=>'⚡','title'=>'Epilepsy & Seizures','desc'=>'Comprehensive evaluation and management including anti-epileptic therapy and epilepsy surgery for drug-resistant cases.'],
                ['icon'=>'🩸','title'=>'Stroke & Hemorrhage','desc'=>'Emergency and elective management of stroke, cerebral hemorrhage, and aneurysms with life-saving surgical interventions.'],
                ['icon'=>'🦴','title'=>'Spine Disorders','desc'=>'Disc herniation, spinal stenosis, spondylolisthesis, and deformity corrections including minimally invasive surgeries.'],
                ['icon'=>'💧','title'=>'Hydrocephalus','desc'=>'VP shunt surgeries and endoscopic procedures for both pediatric and adult hydrocephalus management.'],
                ['icon'=>'🔬','title'=>'Peripheral Nerve','desc'=>'Carpal tunnel syndrome, ulnar nerve compression, and nerve injury repair with advanced microsurgical techniques.'],
            ];
            @endphp
            @foreach($conditions as $i => $c)
            <div class="group relative bg-white rounded-2xl p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
                 style="border: 1px solid rgba(2,134,148,0.1);">
                {{-- Top accent bar --}}
                <div class="absolute top-0 left-0 right-0 h-1 rounded-t-2xl transition-all duration-300 group-hover:h-1.5"
                     style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                     style="background: var(--color-soft);">{{ $c['icon'] }}</div>
                <h3 class="text-lg font-bold mb-2" style="color: var(--color-dark);">{{ $c['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color: rgba(30,41,59,0.65);">{{ $c['desc'] }}</p>
                <div class="mt-5 inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide transition-all group-hover:gap-2.5"
                     style="color: var(--color-primary);">
                    Learn More
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ===================== DOCTOR SECTION ===================== --}}
<section class="py-24 px-6" style="background: white;">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Image --}}
            <div class="relative order-2 lg:order-1">
                <div class="rounded-3xl overflow-hidden shadow-2xl" style="border: 2px solid var(--color-soft);">
                    <img src="{{ asset('images/doctor-consult.png') }}" alt="Dr. Kundan Kumar - Neurologist"
                         class="w-full object-cover" style="height: 480px;">
                </div>
                {{-- Floating card --}}
                <div class="absolute -bottom-6 -right-6 p-5 rounded-2xl shadow-2xl max-w-xs"
                     style="background: white; border: 1px solid var(--color-soft);">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--color-soft);">
                            <svg class="w-5 h-5" fill="none" stroke="#028694" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--color-dark);">Dr. Kundan Kumar</p>
                            <p class="text-xs" style="color: var(--color-primary);">MCh Neurosurgery</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="rounded-xl py-2" style="background: var(--color-soft);">
                            <p class="text-base font-extrabold" style="color: var(--color-primary);">10+</p>
                            <p class="text-xs" style="color: rgba(30,41,59,0.6);">Years</p>
                        </div>
                        <div class="rounded-xl py-2" style="background: var(--color-light);">
                            <p class="text-base font-extrabold" style="color: var(--color-dark);">3000+</p>
                            <p class="text-xs" style="color: rgba(30,41,59,0.6);">Cases</p>
                        </div>
                        <div class="rounded-xl py-2" style="background: var(--color-soft);">
                            <p class="text-base font-extrabold" style="color: var(--color-primary);">95%</p>
                            <p class="text-xs" style="color: rgba(30,41,59,0.6);">Success</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-7 order-1 lg:order-2">
                <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full"
                      style="background: var(--color-soft); color: var(--color-primary);">Meet Your Specialist</span>
                <h2 class="text-4xl font-extrabold leading-tight" style="color: var(--color-dark);">
                    Why Choose Dr. Kundan<br>for Neurology?
                </h2>
                <p class="text-base leading-relaxed" style="color: rgba(30,41,59,0.7);">
                    Dr. Kundan Kumar holds an MCh in Neurosurgery from GRMC Gwalior and is trained at LBS Hospital, New Delhi. He combines advanced surgical techniques with a compassionate, patient-first approach to deliver the best neurological outcomes.
                </p>

                <div class="space-y-4">
                    @php $points = [
                        ['t'=>'Advanced Training','d'=>'MCh Neurosurgery from GRMC Gwalior with training at LBS Hospital, New Delhi'],
                        ['t'=>'Precision Surgery','d'=>'Neuro-navigation and minimally invasive techniques for safer outcomes'],
                        ['t'=>'Comprehensive Care','d'=>'From first consultation through surgery to complete post-op rehabilitation'],
                        ['t'=>'Accessible Clinics','d'=>'Serving patients in Patna and Siwan - Bihar\'s trusted neurosurgeon'],
                    ]; @endphp
                    @foreach($points as $p)
                    <div class="flex items-start gap-4 p-4 rounded-2xl" style="background: var(--color-light); border: 1px solid rgba(2,134,148,0.08);">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5" style="background: var(--color-soft);">
                            <svg class="w-4 h-4" fill="none" stroke="#028694" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--color-dark);">{{ $p['t'] }}</p>
                            <p class="text-sm mt-0.5" style="color: rgba(30,41,59,0.6);">{{ $p['d'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ===================== PROCESS ===================== --}}
<section class="py-24 px-6" style="background: var(--color-light);">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-16">
            <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4"
                  style="background: var(--color-soft); color: var(--color-primary);">How It Works</span>
            <h2 class="text-4xl font-extrabold mb-3" style="color: var(--color-dark);">Your Path to Recovery</h2>
            <p class="max-w-lg mx-auto" style="color: rgba(30,41,59,0.6);">
                A structured, patient-first approach from first consultation to complete neurological recovery.
            </p>
        </div>

        <div class="grid md:grid-cols-4 gap-6 relative">
            {{-- Connecting line --}}
            <div class="absolute top-10 left-16 right-16 h-0.5 hidden md:block"
                 style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>

            @php $steps = [
                ['n'=>'01','t'=>'Consultation','d'=>'In-depth assessment of symptoms, medical history, and neurological examination.'],
                ['n'=>'02','t'=>'Diagnosis','d'=>'Advanced MRI, CT scans, and EEG for accurate diagnosis of your condition.'],
                ['n'=>'03','t'=>'Treatment Plan','d'=>'Customised plan: surgical, medical, or minimally invasive approach.'],
                ['n'=>'04','t'=>'Recovery','d'=>'Structured follow-up to monitor progress and ensure complete healing.'],
            ]; @endphp

            @foreach($steps as $s)
            <div class="relative text-center p-7 rounded-2xl bg-white transition hover:shadow-xl"
                 style="border: 1px solid rgba(2,134,148,0.1);">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-extrabold text-lg mx-auto mb-5 relative z-10 shadow-lg"
                     style="background: var(--color-primary);">{{ $s['n'] }}</div>
                <h3 class="text-base font-bold mb-2" style="color: var(--color-dark);">{{ $s['t'] }}</h3>
                <p class="text-sm leading-relaxed" style="color: rgba(30,41,59,0.6);">{{ $s['d'] }}</p>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="relative py-24 px-6 overflow-hidden" style="background: var(--color-primary);">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle, var(--color-secondary) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="absolute right-0 top-0 w-96 h-96 rounded-full opacity-20 blur-3xl" style="background: var(--color-dark);"></div>
    <div class="relative max-w-4xl mx-auto text-center space-y-7">
        <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full"
              style="background: rgba(255,255,255,0.15); color: white;">Get Expert Care Now</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
            Ready for Expert<br>Neurological Care?
        </h2>
        <p class="text-lg max-w-xl mx-auto" style="color: rgba(255,255,255,0.8);">
            Neurological symptoms need prompt evaluation. Don't delay — book your consultation today with Dr. Kundan Kumar.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="https://wa.me/918088152289"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl font-bold text-base shadow-xl transition hover:-translate-y-1"
               style="background: white; color: var(--color-primary);">
                📅 Book Appointment
            </a>
            <a href="tel:+918088152289"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl font-bold text-base transition hover:-translate-y-1"
               style="background: rgba(255,255,255,0.15); color: white; border: 1.5px solid rgba(255,255,255,0.4);">
                📞 +91 80881 52289
            </a>
        </div>
    </div>
</section>

@endsection
