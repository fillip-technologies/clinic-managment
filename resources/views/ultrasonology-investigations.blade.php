@extends('layouts.app')

@section('content')
<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-blue), var(--color-primary));">
    <div class="max-w-4xl mx-auto text-center text-white">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Ultrasonology and Investigations</h1>
        <p class="text-white/80 text-lg">Clinical ultrasound support and investigation tracking for complete follow-up.</p>
    </div>
</section>
<section class="py-20 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach (['CBC, TLC, DLC, ESR', 'Blood sugar F / PP', 'HbA1c', 'Chol, HDL, LDL, VLDL, TG', 'Urine Ex., Microalbumin, ACR', 'Urea, Creatinine, eGFR', 'SGPT, Bilirubin, Alk Phos', 'Vitamin D3, B12, Calcium', 'TSH, T3, T4', 'EKG, Echo, X-Ray', 'USG', 'Others as advised'] as $test)
            <div class="rounded-lg p-4 border border-emerald-100 shadow-sm font-semibold text-gray-700">{{ $test }}</div>
            @endforeach
        </div>
    </div>
</section>
@endsection
