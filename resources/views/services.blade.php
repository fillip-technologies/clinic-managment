@extends('layouts.app')

@section('title', '| Services')

@section('content')

<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-blue));">
    <div class="max-w-4xl mx-auto text-center text-white">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5 bg-white/15">Services</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Diabetes, Hypertension, Obesity and Lifestyle Care</h1>
        <p class="text-white/80 text-lg">A document-led clinic workflow for diagnosis, examination, monitoring, investigations, prescriptions and follow-up.</p>
    </div>
</section>

<section class="py-20 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-6">
        @foreach ([
            ['Diabetes Management', 'Blood sugar review, HbA1c, hypoglycemia history, family history, complication screening and personalized medicines.', ['Glucometer guidance', 'Diet and walking plan', 'Micro and macro vascular review']],
            ['Hypertension & Cardiometabolic Risk', 'BP, lipids, CHD, stroke and CKD risk stratification with preventive care planning.', ['BP and pulse review', 'Lipid profile tracking', 'Kidney and heart risk']],
            ['Obesity Clinic', 'BMI, waist, hip, waist-hip ratio, sleep, OSA and lifestyle counseling.', ['Anthropometry', 'Exercise planning', 'Sleep and meditation']],
            ['Diabetic Foot Care', 'Structured foot-risk assessment for ulcers, neuropathy, vascular status and skin changes.', ['Monofilament testing', 'Dorsalis pedis pulse', 'Ulcer risk screening']],
            ['Clinical Ultrasonology', 'Ultrasound services by Dr. Sushmita Mukherjee for clinical support.', ['USG review', 'Abdomen assessment', 'Follow-up reporting']],
            ['Investigations', 'Lab and diagnostic tracking across sugar, lipids, kidney, liver, thyroid, vitamins and cardiac tests.', ['CBC and ESR', 'HbA1c and lipids', 'EKG, Echo and USG']],
        ] as $s)
        <div class="rounded-lg border border-gray-100 p-6 shadow-sm bg-white">
            <h2 class="text-xl font-extrabold mb-3" style="color: var(--color-dark);">{{ $s[0] }}</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-5">{{ $s[1] }}</p>
            <ul class="space-y-2">
                @foreach ($s[2] as $item)
                <li class="flex gap-2 text-sm text-gray-700"><span class="font-bold text-emerald-700">✓</span>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</section>

<section class="py-16 px-6" style="background: var(--color-light);">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-extrabold text-center mb-10" style="color: var(--color-dark);">Common Investigation Panel</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach (['CBC, TLC, DLC, ESR', 'Blood Sugar F / PP, HbA1c', 'Chol, HDL, LDL, VLDL, TG', 'Urine, ACR, Microalbumin', 'Urea, Creatinine, eGFR', 'SGPT, Bilirubin, Alk Phos', 'Vitamin D3, B12, Calcium', 'TSH, T3, T4, EKG, Echo, USG'] as $test)
            <div class="rounded-lg bg-white border border-emerald-100 p-4 text-sm font-semibold text-gray-700">{{ $test }}</div>
            @endforeach
        </div>
    </div>
</section>

@endsection
