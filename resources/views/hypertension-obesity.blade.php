@extends('layouts.app')

@section('content')
<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
    <div class="max-w-4xl mx-auto text-center text-white">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Hypertension, Obesity and Lifestyle Clinic</h1>
        <p class="text-white/85 text-lg">BP, cardiometabolic risk, BMI, waist-hip ratio, sleep, exercise and diet planning.</p>
    </div>
</section>
<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6">
        @foreach (['Pulse, BP, SPO2 and clinical examination', 'Height, weight, BMI, waist, hip and W/H ratio', 'Lipids, MAFLD, OSA, CKD, CHD and stroke-risk review', 'Smoking, tobacco, alcohol, sleep and behaviour counseling', 'Walking, exercise, meditation and diet plan', 'Risk stratification and follow-up strategy'] as $item)
        <div class="rounded-lg p-5 bg-white border border-emerald-100 shadow-sm flex gap-3">
            <span class="font-bold text-emerald-700">✓</span>
            <p class="text-gray-700">{{ $item }}</p>
        </div>
        @endforeach
    </div>
</section>
@endsection
