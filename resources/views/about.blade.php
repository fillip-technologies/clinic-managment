@extends('layouts.app')

@section('title', '| About Dr. Kundan Kumar')

@section('content')

{{-- Hero Banner --}}
<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left --}}
            <div class="text-white">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
                    style="background: rgba(255,255,255,0.2); color: white;">
                    Meet The Doctor
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight">Dr. Kundan Kumar</h1>
                <p class="text-xl font-semibold mb-3" style="color: rgba(255,255,255,0.85);">MBBS, MCh (Neurosurgery)</p>
                <p class="text-white/80 text-lg leading-relaxed max-w-xl">
                    Senior Consultant Neurosurgeon specializing in complex brain, spine, and nerve disorders — bringing world-class neurological care to Bihar.
                </p>
                <div class="flex flex-wrap gap-3 mt-7">
                    <div class="px-4 py-2 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,0.15); color: white;">🧠 Brain Surgery</div>
                    <div class="px-4 py-2 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,0.15); color: white;">🦴 Spine Surgery</div>
                    <div class="px-4 py-2 rounded-xl text-sm font-semibold" style="background: rgba(255,255,255,0.15); color: white;">⚡ Neurology</div>
                </div>
            </div>
            {{-- Right: Floating profile card --}}
            <div class="relative flex justify-center">
                <div class="relative w-72">
                    <div class="absolute -inset-2 rounded-3xl opacity-40 blur-xl" style="background: rgba(255,255,255,0.3);"></div>
                    <img src="{{ asset('images/why.jpg') }}" alt="Dr. Kundan Kumar"
                        class="relative w-full rounded-3xl shadow-2xl object-cover" style="border: 4px solid rgba(255,255,255,0.4);">
                    <div class="absolute -bottom-5 left-4 right-4 rounded-2xl p-4 shadow-xl"
                        style="background: rgba(255,255,255,0.97); backdrop-filter: blur(12px);">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 rounded-full animate-pulse" style="background: #22c55e;"></div>
                            <span class="text-xs font-bold uppercase tracking-wide" style="color: var(--color-primary);">Available for Consultation</span>
                        </div>
                        <p class="font-bold" style="color: var(--color-dark);">Dr. Kundan Kumar</p>
                        <p class="text-xs text-gray-500">Senior Consultant Neurosurgeon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Strip --}}
<section class="py-10 px-6" style="background: var(--color-dark);">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div>
            <p class="text-3xl font-extrabold" style="color: var(--color-secondary);">10+</p>
            <p class="text-sm text-white/70 mt-1">Years of Experience</p>
        </div>
        <div>
            <p class="text-3xl font-extrabold" style="color: var(--color-secondary);">5000+</p>
            <p class="text-sm text-white/70 mt-1">Patients Treated</p>
        </div>
        <div>
            <p class="text-3xl font-extrabold" style="color: var(--color-secondary);">98%</p>
            <p class="text-sm text-white/70 mt-1">Success Rate</p>
        </div>
        <div>
            <p class="text-3xl font-extrabold" style="color: var(--color-secondary);">3</p>
            <p class="text-sm text-white/70 mt-1">Clinic Locations</p>
        </div>
    </div>
</section>

{{-- Doctor Details Section --}}
<section class="py-20 px-6" style="background: white;">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-start">

            {{-- LEFT: Photo + floating card --}}
            <div class="relative">
                <div class="absolute -inset-1 rounded-3xl opacity-20 blur-xl"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.pexels.com/photos/5327655/pexels-photo-5327655.jpeg?auto=compress&cs=tinysrgb&w=800&h=1000&fit=crop"
                        alt="Dr. Kundan Kumar – Neurosurgeon"
                        class="w-full h-[500px] object-cover object-top">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>
                <div class="absolute -bottom-8 left-6 right-6 bg-white rounded-2xl shadow-2xl p-5"
                    style="border: 1px solid rgba(2,134,148,0.12);">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide" style="color: var(--color-secondary);">Senior Consultant</p>
                            <h3 class="text-xl font-extrabold mt-0.5" style="color: var(--color-dark);">Dr. Kundan Kumar</h3>
                            <p class="text-sm text-gray-500">MBBS, MCh (Neurosurgery)</p>
                        </div>
                        <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Details --}}
            <div class="pt-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-5" style="background: var(--color-soft);">
                    <div class="w-2 h-2 rounded-full" style="background: var(--color-primary);"></div>
                    <span class="text-sm font-semibold uppercase tracking-wider" style="color: var(--color-primary);">About The Doctor</span>
                </div>
                <h2 class="text-3xl font-extrabold mb-4 leading-tight" style="color: var(--color-dark);">
                    Dedicated to Neurological <br>Excellence in Bihar
                </h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Dr. Kundan Kumar is a highly experienced and board-certified Neurosurgeon with over a decade of specialization in treating complex brain, spinal cord, and peripheral nerve conditions. He completed his MCh in Neurosurgery from a premier institution and has trained at national centers of excellence.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    His approach combines the latest minimally invasive surgical techniques with a deep commitment to patient education and compassionate care. He believes every patient deserves to fully understand their diagnosis and treatment options.
                </p>

                {{-- Qualifications --}}
                <div class="space-y-3 mb-8">
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3" style="color: var(--color-primary);">Qualifications</h3>
                    @foreach ([
                        ['MBBS', 'Bachelor of Medicine & Bachelor of Surgery'],
                        ['MCh (Neurosurgery)', 'Magister Chirurgiae – Neurosurgery'],
                        ['DNB (Neurosurgery)', 'Diplomate of National Board'],
                    ] as $q)
                    <div class="flex items-center gap-3 p-3 rounded-xl" style="background: var(--color-soft);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: var(--color-primary);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm" style="color: var(--color-dark);">{{ $q[0] }}</p>
                            <p class="text-xs text-gray-500">{{ $q[1] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ url('/contact') }}"
                        class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg transition hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                        Book Appointment
                    </a>
                    <a href="tel:+918088152289"
                        class="px-6 py-3 rounded-xl font-semibold transition hover:-translate-y-0.5"
                        style="border: 2px solid var(--color-primary); color: var(--color-primary); background: white;">
                        📞 Call Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Specializations --}}
<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4"
                style="background: var(--color-soft); color: var(--color-primary);">Specializations</span>
            <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Areas of Expertise</h2>
            <p class="text-gray-500 max-w-lg mx-auto">World-class surgical and clinical expertise across the full spectrum of neurological conditions.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ([
                ['🧠', 'Brain Tumor Surgery', 'Surgical resection of benign and malignant brain tumors using neuro-navigation and microsurgery.'],
                ['🦴', 'Spine Surgery', 'Minimally invasive techniques for disc herniation, spondylosis, and spinal instability.'],
                ['⚡', 'Stroke & Neurovascular', 'Emergency and elective management of strokes, aneurysms, and AVMs.'],
                ['🤕', 'Head Injury & Trauma', 'Emergency decompression and management of traumatic brain injuries.'],
                ['🧬', 'Epilepsy Surgery', 'Surgical evaluation and treatment for medically refractory epilepsy.'],
                ['🩺', 'Neuro OPD Consultation', 'Comprehensive outpatient consultations for headaches, vertigo, nerve pain, and more.'],
            ] as $s)
            <div class="rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-xl"
                style="background: white; border: 1px solid rgba(2,134,148,0.1);">
                <div class="text-3xl mb-3">{{ $s[0] }}</div>
                <h3 class="font-bold text-lg mb-2" style="color: var(--color-dark);">{{ $s[1] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $s[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Experience Timeline --}}
<section class="py-20 px-6 relative" style="background: #fcfdfd;">
    <!-- Abstract background element -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-[20%] left-[-10%] w-96 h-96 rounded-full opacity-30" style="background: var(--color-soft); filter: blur(80px);"></div>
        <div class="absolute bottom-[10%] right-[-5%] w-72 h-72 rounded-full opacity-20" style="background: var(--color-primary); filter: blur(100px);"></div>
    </div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block text-xs font-extrabold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 shadow-sm"
                style="background: white; color: var(--color-primary); border: 1px solid rgba(2,134,148,0.1);">Career Journey</span>
            <h2 class="text-4xl font-extrabold" style="color: var(--color-dark);">Experience & Training</h2>
            <p class="text-gray-500 mt-4 max-w-lg mx-auto">A continuous journey of excellence and dedication to mastering neurological and spinal care.</p>
        </div>
        
        <div class="relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-teal-200 before:to-transparent">
            @foreach ([
                ['2014', 'MBBS Completed', 'Graduated from a reputed medical college with distinction. Foundation of medical expertise.', '🎓'],
                ['2019', 'MCh – Neurosurgery', 'Super-specialization in Neurosurgery. Intensive training in advanced microsurgery, endoscopy, and neuro-navigation.', '🧠'],
                ['2020', 'DNB – Neurosurgery', 'Awarded Diplomate of National Board in Neurosurgery, recognizing supreme national standards.', '📜'],
                ['2021', 'Senior Consultant', 'Joined NSMCH, Bihta Patna as Senior Consultant Neurosurgeon, leading complex surgical cases.', '🏥'],
                ['2022+', 'Multi-Branch Practice', 'Extended services to Ara and Siwan to ensure top-tier neuro-care is accessible across Bihar.', '🚀'],
            ] as $index => $e)
            
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active mb-12 last:mb-0">
                <!-- Timeline Marker -->
                <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform duration-300 group-hover:scale-110"
                    style="box-shadow: 0 0 0 4px rgba(2, 134, 148, 0.1);">
                    <div class="w-3 h-3 rounded-full" style="background: var(--color-primary);"></div>
                </div>
                
                <!-- Card -->
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-3xl shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 bg-white border border-gray-100 group-hover:border-teal-100 relative overflow-hidden">
                    <!-- Subtle hover glow -->
                    <div class="absolute -top-20 -right-20 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    
                    <div class="flex items-center justify-between mb-3 relative z-10">
                        <span class="inline-block text-xs font-bold px-3 py-1 rounded-full"
                            style="background: var(--color-soft); color: var(--color-primary);">{{ $e[0] }}</span>
                        <span class="text-2xl opacity-80">{{ $e[3] }}</span>
                    </div>
                    <h3 class="font-extrabold text-xl mb-2 relative z-10" style="color: var(--color-dark);">{{ $e[1] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed relative z-10">{{ $e[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 px-6" style="background: var(--color-dark);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-extrabold text-white mb-4">Book a Consultation Today</h2>
        <p class="text-white/70 mb-8">Get expert neurological care from Dr. Kundan Kumar at a clinic near you.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}"
                class="px-8 py-3 rounded-xl text-white font-semibold shadow-lg transition hover:-translate-y-0.5"
                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                Get in Touch
            </a>
            <a href="{{ url('/clinics') }}"
                class="px-8 py-3 rounded-xl font-semibold transition hover:-translate-y-0.5"
                style="background: rgba(255,255,255,0.08); color: white; border: 1px solid rgba(255,255,255,0.15);">
                View Clinics
            </a>
        </div>
    </div>
</section>

@endsection
