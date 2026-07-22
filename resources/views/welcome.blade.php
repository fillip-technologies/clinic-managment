@extends('layouts.app')

@section('content')

<section class="relative overflow-hidden pt-32 pb-16 lg:pt-40 lg:pb-24" style="background: var(--color-light);">
    <div class="absolute inset-0">
        <img src="{{ asset('images/doctors-2.jpg') }}" class="w-full h-full object-cover" alt="Clinic care team">
        <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(15,118,110,0.96), rgba(244,251,248,0.70));"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="text-white">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-bold border border-white/25 bg-white/15">
                    RCDHO | Established 2002
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mt-6">
                    Research Centre for Diabetes, Hypertension and Obesity
                </h1>
                <p class="text-xl font-semibold mt-5 text-amber-200">DrMukherjeeS Clinic Pvt. Ltd.</p>
                <p class="text-lg text-white/85 max-w-xl mt-4">
                    Complete metabolic care for diabetes, blood pressure, obesity, lifestyle correction, foot examination, investigations and ultrasound support.
                </p>
                <div class="flex flex-wrap gap-4 mt-8">
                    <a href="tel:+918002268003" class="inline-flex items-center px-6 py-3 rounded-lg text-white font-bold shadow-lg" style="background: var(--color-secondary);">
                        Call 8002268003
                    </a>
                    <a href="{{ url('/services') }}" class="inline-flex items-center px-6 py-3 rounded-lg bg-white font-bold shadow-lg" style="color: var(--color-primary);">
                        View Services
                    </a>
                </div>
            </div>

            <div class="bg-white/95 rounded-2xl shadow-2xl p-6 lg:p-8 border border-white/70">
                <p class="text-xs font-extrabold uppercase tracking-widest mb-3" style="color: var(--color-primary);">Clinical Team</p>
                <div class="space-y-5">
                    <div>
                        <h2 class="text-2xl font-extrabold" style="color: var(--color-dark);">Dr. Supriyo Mukherjee</h2>
                        <p class="text-sm text-gray-600 mt-1">M.D. Internal Medicine, KGMC (Lucknow)</p>
                        <p class="text-sm text-gray-600">M.Sc. Advancing Diabetes Care (UK), Senior Fellow IDF, FICP, FDI</p>
                        <p class="text-sm font-bold mt-2" style="color: var(--color-secondary);">Gold Medal in Medicine</p>
                    </div>
                    <div class="border-t border-gray-100 pt-5">
                        <h2 class="text-2xl font-extrabold" style="color: var(--color-dark);">Dr. Sushmita Mukherjee</h2>
                        <p class="text-sm text-gray-600 mt-1">M.B.B.S. (B.U.), CC.USG</p>
                        <p class="text-sm font-bold" style="color: var(--color-primary);">Clinical Ultrasonologist</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-8" style="background: var(--color-dark);">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div><p class="text-3xl font-extrabold text-white">2002</p><p class="text-white/60 text-sm">Established</p></div>
        <div><p class="text-3xl font-extrabold text-white">2</p><p class="text-white/60 text-sm">Clinic Locations</p></div>
        <div><p class="text-3xl font-extrabold text-white">15</p><p class="text-white/60 text-sm">Days Prescription Validity</p></div>
        <div><p class="text-3xl font-extrabold text-white">Sun</p><p class="text-white/60 text-sm">Closed</p></div>
    </div>
</section>

<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="max-w-3xl mb-12">
            <span class="inline-block text-xs font-extrabold uppercase tracking-widest px-3 py-1 rounded-full mb-4" style="background: var(--color-soft); color: var(--color-primary);">Patient Care</span>
            <h2 class="text-3xl lg:text-4xl font-extrabold" style="color: var(--color-dark);">Services designed around long-term metabolic health</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ([
                ['Diabetes Care', 'Diagnosis, classification, glucose monitoring, HbA1c review, medication planning and complication screening.', 'bg-emerald-50 text-emerald-700'],
                ['Hypertension & Heart Risk', 'BP monitoring, stroke-CHD-CKD risk review, lipid profile tracking and preventive management.', 'bg-blue-50 text-blue-700'],
                ['Obesity & Lifestyle', 'Anthropometry, BMI, waist-hip ratio, sleep, exercise, diet and sustainable weight-management planning.', 'bg-amber-50 text-amber-700'],
                ['Diabetic Foot Examination', 'Neuropathy, pulses, ulcer risk, skin status, deformity checks, monofilament and vibration testing.', 'bg-rose-50 text-rose-700'],
                ['Investigations', 'CBC, sugar, lipid profile, kidney, liver, thyroid, vitamins, urine, ECG/EKG, echo and ultrasound coordination.', 'bg-cyan-50 text-cyan-700'],
                ['Clinical Ultrasonology', 'Ultrasound support by Dr. Sushmita Mukherjee for better clinical assessment and follow-up.', 'bg-violet-50 text-violet-700'],
            ] as $service)
            <div class="rounded-lg border border-gray-100 p-6 shadow-sm hover:shadow-lg transition bg-white">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center {{ $service[2] }} mb-5">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <h3 class="text-xl font-extrabold mb-3" style="color: var(--color-dark);">{{ $service[0] }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $service[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
        <img src="{{ asset('images/doctor-consult.png') }}" class="w-full rounded-lg shadow-xl object-cover" alt="Patient consultation">
        <div>
            <span class="inline-block text-xs font-extrabold uppercase tracking-widest px-3 py-1 rounded-full mb-4" style="background: white; color: var(--color-primary);">Prescription Flow</span>
            <h2 class="text-3xl font-extrabold mb-5" style="color: var(--color-dark);">From registration to follow-up, every visit is structured</h2>
            <div class="space-y-4">
                @foreach ([
                    'Demography, history and clinical examination',
                    'Anthropometric details: height, weight, BMI, waist, hip and build',
                    'Family history, comorbidities, allergies, personal habits and sleep',
                    'Investigations and medication / drug evaluation',
                    'Lifestyle management with diet, walking, exercise, sleep and meditation plan',
                ] as $step)
                <div class="flex gap-3">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: var(--color-primary);">✓</div>
                    <p class="text-gray-700">{{ $step }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6">
        <div class="rounded-lg p-8 border border-emerald-100" style="background: var(--color-light);">
            <h3 class="text-2xl font-extrabold mb-3" style="color: var(--color-dark);">Patna</h3>
            <p class="text-gray-700">Holding #404, "Sukhadaya", New Yarpur Road #1, Patna - 800001</p>
            <p class="text-sm font-bold mt-4" style="color: var(--color-primary);">New and old patients: 09:00 AM to 02:00 PM</p>
            <p class="text-sm text-gray-600">Drug evaluation: 04:00 PM to 06:00 PM</p>
        </div>
        <div class="rounded-lg p-8 border border-emerald-100" style="background: var(--color-light);">
            <h3 class="text-2xl font-extrabold mb-3" style="color: var(--color-dark);">Samastipur</h3>
            <p class="text-gray-700">Bengali Tola, Samastipur - 848101, Bihar</p>
            <p class="text-sm font-bold mt-4" style="color: var(--color-primary);">Sunday closed</p>
            <p class="text-sm text-gray-600">Call service and night service unavailable as per clinic note.</p>
        </div>
    </div>
</section>

@endsection
