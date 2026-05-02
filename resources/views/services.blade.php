@extends('layouts.app')

@section('title', '| Services')

@section('content')

{{-- Hero --}}
<section class="pt-36 pb-20 px-6 relative overflow-hidden"
    style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 rounded-full" style="background: white; filter: blur(80px);"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full" style="background: white; filter: blur(100px);"></div>
    </div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
            style="background: rgba(255,255,255,0.2); color: white;">
            What We Treat
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-5 leading-tight">
            Neurology &amp; Neurosurgery<br>Services
        </h1>
        <p class="text-white/80 text-lg max-w-2xl mx-auto">
            Comprehensive brain, spine, and nerve care — delivered with precision, compassion, and the most advanced surgical techniques available in Bihar.
        </p>
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            <a href="{{ url('/contact') }}"
                class="px-6 py-3 rounded-xl font-semibold text-sm transition hover:-translate-y-0.5 shadow-lg"
                style="background: white; color: var(--color-primary);">
                Book Appointment →
            </a>
            <a href="tel:+918088152289"
                class="px-6 py-3 rounded-xl font-semibold text-sm transition hover:-translate-y-0.5"
                style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3);">
                📞 Call Now
            </a>
        </div>
    </div>
</section>

{{-- Stats Strip --}}
<section class="py-8 px-6" style="background: var(--color-dark);">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div><p class="text-3xl font-extrabold" style="color: var(--color-secondary);">6+</p><p class="text-xs text-white/60 mt-1">Specializations</p></div>
        <div><p class="text-3xl font-extrabold" style="color: var(--color-secondary);">10+</p><p class="text-xs text-white/60 mt-1">Years Experience</p></div>
        <div><p class="text-3xl font-extrabold" style="color: var(--color-secondary);">5000+</p><p class="text-xs text-white/60 mt-1">Patients Treated</p></div>
        <div><p class="text-3xl font-extrabold" style="color: var(--color-secondary);">98%</p><p class="text-xs text-white/60 mt-1">Success Rate</p></div>
    </div>
</section>

{{-- Services Grid --}}
<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4"
                style="background: var(--color-soft); color: var(--color-primary);">All Services</span>
            <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Comprehensive Neurological Care</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Each treatment plan is personalized, evidence-based, and delivered with the latest minimally invasive techniques.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Service 1: Brain Tumor Surgery --}}
            <div class="group relative rounded-3xl overflow-hidden shadow-lg transition-all duration-500 hover:shadow-2xl bg-white border border-gray-100 hover:border-teal-100 flex flex-col">
                <div class="h-64 overflow-hidden relative shrink-0">
                    <img src="https://images.pexels.com/photos/3938022/pexels-photo-3938022.jpeg?auto=compress&cs=tinysrgb&w=700" alt="Brain Surgery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-teal-500 text-white text-xs font-bold rounded-full mb-3 shadow">Neurosurgery</span>
                        <h3 class="text-2xl font-extrabold text-white">Brain Tumor Surgery</h3>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-1">
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Precision surgical resection of benign and malignant brain tumors utilizing advanced intraoperative neuro-navigation and microsurgical techniques to maximize safety and outcomes.
                    </p>
                    <ul class="space-y-2 mb-8 flex-1">
                        @foreach(['Gliomas & Meningiomas', 'Pituitary Tumors', 'Acoustic Neuromas'] as $item)
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-teal-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/contact') }}" class="inline-flex items-center gap-2 text-sm font-bold text-teal-600 group-hover:text-teal-700 transition w-max">
                        Book Consultation <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>

            {{-- Service 2: Spine Surgery --}}
            <div class="group relative rounded-3xl overflow-hidden shadow-lg transition-all duration-500 hover:shadow-2xl bg-white border border-gray-100 hover:border-teal-100 flex flex-col">
                <div class="h-64 overflow-hidden relative shrink-0">
                    <img src="https://images.pexels.com/photos/7659573/pexels-photo-7659573.jpeg?auto=compress&cs=tinysrgb&w=700" alt="Spine Surgery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-block px-3 py-1 bg-orange-400 text-white text-xs font-bold rounded-full mb-3 shadow">Spine</span>
                        <h3 class="text-2xl font-extrabold text-white">Spine Surgery</h3>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-1">
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Minimally invasive spine procedures to address disc herniation, spondylolisthesis, and spinal cord compression with reduced recovery time and lasting relief.
                    </p>
                    <ul class="space-y-2 mb-8 flex-1">
                        @foreach(['Cervical & Lumbar Disc Surgery', 'Spinal Fusion', 'Spinal Cord Tumors'] as $item)
                        <li class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-orange-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/contact') }}" class="inline-flex items-center gap-2 text-sm font-bold text-orange-500 group-hover:text-orange-600 transition w-max">
                        Book Consultation <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>

            {{-- Service 3: Stroke Management --}}
            <div class="group relative rounded-3xl p-8 shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 bg-white border border-gray-100 hover:border-teal-100 overflow-hidden flex flex-col">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl">⚡</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Stroke Management</h3>
                        <p class="text-xs font-semibold text-teal-600 mt-1">Emergency & Long-term Care</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 relative z-10 flex-1">Rapid diagnosis and intervention for ischemic and hemorrhagic strokes, including surgical decompression and clot evacuation.</p>
                <ul class="space-y-2 mb-0 relative z-10">
                    @foreach(['Ischemic Stroke Management', 'Brain Hemorrhage Surgery', 'Aneurysm Clipping'] as $item)
                    <li class="flex items-center gap-2 text-sm text-gray-700">
                        <span class="text-teal-500 font-bold">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Service 4: Head Injury --}}
            <div class="group relative rounded-3xl p-8 shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 bg-white border border-gray-100 hover:border-teal-100 overflow-hidden flex flex-col">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl">🤕</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Head Injury & Trauma</h3>
                        <p class="text-xs font-semibold text-teal-600 mt-1">Emergency Surgical Management</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 relative z-10 flex-1">Expert surgical management for traumatic brain injuries, ranging from mild concussions to severe hematomas and skull fractures.</p>
                <ul class="space-y-2 mb-0 relative z-10">
                    @foreach(['Subdural Hematoma', 'Skull Fractures', 'Raised ICP Management'] as $item)
                    <li class="flex items-center gap-2 text-sm text-gray-700">
                        <span class="text-teal-500 font-bold">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Service 5: Epilepsy --}}
            <div class="group relative rounded-3xl p-8 shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 bg-white border border-gray-100 hover:border-teal-100 overflow-hidden flex flex-col">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl">🧬</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Epilepsy Treatment</h3>
                        <p class="text-xs font-semibold text-teal-600 mt-1">Medical & Surgical Options</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 relative z-10 flex-1">Thorough pre-surgical evaluation and advanced surgical treatments for patients with drug-resistant epilepsy.</p>
                <ul class="space-y-2 mb-0 relative z-10">
                    @foreach(['Seizure Diagnosis', 'Medication Management', 'Temporal Lobectomy'] as $item)
                    <li class="flex items-center gap-2 text-sm text-gray-700">
                        <span class="text-teal-500 font-bold">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Service 6: Neuro OPD --}}
            <div class="group relative rounded-3xl p-8 shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 bg-gradient-to-br from-teal-700 to-teal-900 text-white overflow-hidden flex flex-col">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm">
                        <span class="text-2xl">🩺</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-white">Neuro OPD</h3>
                        <p class="text-xs font-medium text-teal-200 mt-1">Available at All Branches</p>
                    </div>
                </div>
                <p class="text-teal-50 text-sm leading-relaxed mb-8 relative z-10 flex-1">Comprehensive outpatient consultations covering the full spectrum of neurological conditions including headaches, vertigo, and nerve pain.</p>
                <a href="{{ url('/contact') }}" class="inline-flex items-center justify-center w-full py-3 rounded-xl bg-white text-teal-800 font-bold hover:bg-teal-50 transition shadow-lg relative z-10">
                    Book OPD Appointment
                </a>
            </div>

        </div>
    </div>
</section>

{{-- Why Choose Us for Treatment --}}
<section class="py-20 px-6" style="background: white;">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-5"
                    style="background: var(--color-soft); color: var(--color-primary);">Why Choose Us</span>
                <h2 class="text-3xl font-extrabold mb-5 leading-tight" style="color: var(--color-dark);">
                    What Sets Dr. Kundan Kumar<br>Apart from Others
                </h2>
                <div class="space-y-5">
                    @foreach([
                        ['🧠', 'Super-Specialist Training', 'MCh in Neurosurgery from GRMC Gwalior, trained at LBS Hospital, New Delhi.'],
                        ['🔬', 'Advanced Technology', '3T MRI, neuro-navigation systems, and endoscopic tools for minimal invasion.'],
                        ['🫂', 'Patient-Centered Approach', 'Every patient receives a personalized plan, not a template. We listen before we operate.'],
                        ['🌐', '3 Accessible Locations', 'Patna (daily OPD), Ara (Tuesday), and Siwan (Saturday) — closer to you.'],
                        ['🚑', '24/7 Emergency Response', 'Available round the clock for neurological emergencies.'],
                    ] as $w)
                    <div class="flex items-start gap-4">
                        <div class="text-2xl">{{ $w[0] }}</div>
                        <div>
                            <h3 class="font-bold mb-0.5" style="color: var(--color-dark);">{{ $w[1] }}</h3>
                            <p class="text-sm text-gray-500">{{ $w[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-1 rounded-3xl opacity-20 blur-xl"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));"></div>
                <img src="https://images.pexels.com/photos/4386466/pexels-photo-4386466.jpeg?auto=compress&cs=tinysrgb&w=700"
                    alt="Neurosurgery Excellence"
                    class="relative w-full h-[450px] object-cover rounded-3xl shadow-2xl">
                <div class="absolute bottom-5 left-5 right-5 rounded-2xl p-4 shadow-xl"
                    style="background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); border: 1px solid rgba(2,134,148,0.12);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                            style="background: var(--color-soft);">
                            <svg class="w-5 h-5" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm" style="color: var(--color-dark);">Board Certified Neurosurgeon</p>
                            <p class="text-xs text-gray-500">MBBS, MCh, DNB — Patna, Bihar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 px-6" style="background: var(--color-dark);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-extrabold text-white mb-4">Start Your Recovery Today</h2>
        <p class="text-white/70 mb-8">
            If you or a loved one is suffering from a neurological condition, don't wait. Early diagnosis and expert intervention leads to better outcomes.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}"
                class="px-8 py-3.5 rounded-xl text-white font-semibold shadow-lg transition hover:-translate-y-0.5"
                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                Book Appointment
            </a>
            <a href="https://wa.me/918088152289" target="_blank"
                class="px-8 py-3.5 rounded-xl font-semibold transition hover:-translate-y-0.5"
                style="background: #25D366; color: white;">
                💬 WhatsApp Us
            </a>
            <a href="{{ url('/clinics') }}"
                class="px-8 py-3.5 rounded-xl font-semibold transition hover:-translate-y-0.5"
                style="background: rgba(255,255,255,0.08); color: white; border: 1px solid rgba(255,255,255,0.15);">
                View Clinics
            </a>
        </div>
    </div>
</section>

@endsection
