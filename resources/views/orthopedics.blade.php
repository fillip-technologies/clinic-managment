@extends('layouts.app')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="relative overflow-hidden" style="background: var(--color-dark); min-height: 90vh;">

    {{-- Background image with overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/orthopedics-hero.png') }}"
             alt="Orthopedics" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0" style="background: linear-gradient(120deg, rgba(2,134,148,0.85) 0%, rgba(30,41,59,0.92) 55%, rgba(30,41,59,0.98) 100%);"></div>
    </div>

    {{-- Decorative elements --}}
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
                <span style="color: var(--color-secondary);" class="opacity-100 font-semibold">Orthopedics</span>
            </nav>

            {{-- Label --}}
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-widest"
                  style="background: rgba(93,202,212,0.15); color: var(--color-secondary); border: 1px solid rgba(93,202,212,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Bone, Joint & Musculoskeletal
            </span>

            {{-- Heading --}}
            <div>
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-white mb-4">
                    Advanced<br>
                    <span style="color: var(--color-secondary);">Orthopedic Care</span>
                </h1>
                <p class="text-lg leading-relaxed max-w-lg" style="color: rgba(240,249,250,0.75);">
                    Expert management of fractures, joint replacements, sports injuries, and spine conditions. Combining surgical precision with evidence-based rehabilitation for lasting recovery.
                </p>
            </div>

            {{-- Stats row --}}
            <div class="flex flex-wrap gap-6">
                @php $heroStats = [['v'=>'10+','l'=>'Years\' Experience'],['v'=>'1500+','l'=>'Joint Cases'],['v'=>'97%','l'=>'Recovery Rate']]; @endphp
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
                   class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-bold text-base shadow-2xl transition-all hover:-translate-y-1"
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
                    <img src="{{ asset('images/orthopedics-hero.png') }}" alt="Advanced Orthopedic Care"
                         class="w-full object-cover" style="height: 480px; object-position: center;">
                    
                    {{-- Inner gradient overlay for depth --}}
                    <div class="absolute inset-0 opacity-80" style="background: linear-gradient(to top, rgba(15,23,42,1) 0%, transparent 40%);"></div>
                </div>

                {{-- Glassmorphism Floating Badge --}}
                <div class="absolute -bottom-6 -left-4 md:-left-8 flex items-center gap-4 px-6 py-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.5)] backdrop-blur-xl"
                     style="background: rgba(15,23,42,0.7); border: 1px solid rgba(93,202,212,0.2);">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(93,202,212,0.15);">
                        <svg class="w-6 h-6" fill="none" stroke="var(--color-secondary)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-white tracking-wide">DNB Surgery</p>
                        <p class="text-xs font-medium" style="color: var(--color-secondary);">Advanced Specialist</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ===================== CONDITIONS ===================== --}}
<section class="py-24 px-6" style="background: var(--color-light);">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-16">
            <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4"
                  style="background: var(--color-soft); color: var(--color-primary);">Conditions We Treat</span>
            <h2 class="text-4xl font-extrabold mb-3" style="color: var(--color-dark);">Orthopedic Conditions</h2>
            <p class="max-w-xl mx-auto text-base" style="color: rgba(30,41,59,0.6);">
                From hairline fractures to total joint replacement — evidence-based treatment for every bone and joint concern.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $conditions = [
                ['icon'=>'🦴','title'=>'Fracture Management','desc'=>'Precise surgical and non-surgical management of complex fractures including implant fixation for optimal alignment and healing.'],
                ['icon'=>'🏃','title'=>'Sports Injuries','desc'=>'Ligament tears, ACL/PCL repair, meniscal injuries, and rotator cuff repair for athletes and active individuals.'],
                ['icon'=>'🦿','title'=>'Joint Replacement','desc'=>'Total and partial knee, hip, and shoulder replacement surgery for arthritis and degenerative joint conditions.'],
                ['icon'=>'🦵','title'=>'Arthritis Treatment','desc'=>'Comprehensive management of osteoarthritis and rheumatoid arthritis through medical, physio, and surgical interventions.'],
                ['icon'=>'🔩','title'=>'Spine Surgery','desc'=>'Disc prolapse, spondylosis, and scoliosis correction with minimally invasive and open surgical techniques.'],
                ['icon'=>'🧒','title'=>'Pediatric Orthopedics','desc'=>'Treatment of congenital deformities, clubfoot, hip dysplasia, and growth plate injuries in children.'],
            ];
            @endphp
            @foreach($conditions as $c)
            <div class="group relative bg-white rounded-2xl p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl overflow-hidden"
                 style="border: 1px solid rgba(2,134,148,0.1);">
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

{{-- ===================== DOCTOR HIGHLIGHT ===================== --}}
<section class="py-24 px-6" style="background: white;">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Content --}}
            <div class="space-y-7">
                <span class="inline-block text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full"
                      style="background: var(--color-soft); color: var(--color-primary);">Why Choose Us</span>
                <h2 class="text-4xl font-extrabold leading-tight" style="color: var(--color-dark);">
                    Advanced Care for<br>Every Orthopedic Need
                </h2>
                <p class="text-base leading-relaxed" style="color: rgba(30,41,59,0.7);">
                    Dr. Kundan Kumar brings advanced surgical training and a patient-centred approach to every orthopedic case. With experience in minimally invasive procedures and complex reconstructions, he ensures faster recovery and better outcomes.
                </p>

                <div class="space-y-4">
                    @php $points = [
                        ['t'=>'Minimally Invasive Surgery','d'=>'Less pain, smaller incisions, and significantly faster recovery times'],
                        ['t'=>'Advanced Implants','d'=>'State-of-the-art joint prosthetics and fixation hardware for durable results'],
                        ['t'=>'Sports Medicine','d'=>'Specialized care for athletes — from acute injury to return-to-sport rehab'],
                        ['t'=>'Comprehensive Rehab','d'=>'Structured physiotherapy programs to restore full mobility and strength'],
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

            {{-- Image --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-2xl" style="border: 2px solid var(--color-soft);">
                    <img src="{{ asset('images/doctor-consult.png') }}" alt="Orthopedic Doctor"
                         class="w-full object-cover" style="height: 480px;">
                </div>
                <div class="absolute -bottom-6 -right-6 p-5 rounded-2xl shadow-2xl"
                     style="background: var(--color-primary);">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-extrabold text-white">1500+</p>
                            <p class="text-xs text-white/70">Joint Cases</p>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-white">97%</p>
                            <p class="text-xs text-white/70">Recovery</p>
                        </div>
                    </div>
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
                A well-defined treatment journey from first assessment to full rehabilitation for lasting relief.
            </p>
        </div>
        <div class="grid md:grid-cols-4 gap-6 relative">
            <div class="absolute top-10 left-16 right-16 h-0.5 hidden md:block"
                 style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>
            @php $steps = [
                ['n'=>'01','t'=>'Assessment','d'=>'Physical exam, X-rays, and MRI/CT to accurately diagnose your musculoskeletal condition.'],
                ['n'=>'02','t'=>'Treatment Plan','d'=>'Personalised plan — conservative or surgical — based on your age, activity level, and severity.'],
                ['n'=>'03','t'=>'Procedure','d'=>'Minimally invasive or open surgery with state-of-the-art implants by an expert surgical team.'],
                ['n'=>'04','t'=>'Rehabilitation','d'=>'Structured physiotherapy program to restore full mobility, strength, and confidence.'],
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
              style="background: rgba(255,255,255,0.15); color: white;">Get Relief Today</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
            Suffering from Bone<br>or Joint Pain?
        </h2>
        <p class="text-lg max-w-xl mx-auto" style="color: rgba(255,255,255,0.8);">
            Expert orthopedic care is just one call away. Book your consultation with Dr. Kundan Kumar today.
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
