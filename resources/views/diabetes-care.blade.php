@extends('layouts.app')

@section('content')
<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-blue));">
    <div class="max-w-4xl mx-auto text-center text-white">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Diabetes Care</h1>
        <p class="text-white/80 text-lg">Structured evaluation, monitoring, medication review and complication screening.</p>
    </div>
</section>
<section class="py-20 px-6 bg-white">
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-6">
        @foreach (['Blood sugar fasting / post-prandial and HbA1c review', 'Hypoglycemia, family history and autoimmune history assessment', 'Microvascular and macrovascular complication screening', 'Glucometer, glucose chart and diet counseling', 'Diabetic foot examination and ulcer-risk review', 'Medication and follow-up planning'] as $item)
        <div class="rounded-lg p-5 border border-emerald-100 shadow-sm flex gap-3">
            <span class="font-bold text-emerald-700">✓</span>
            <p class="text-gray-700">{{ $item }}</p>
        </div>
        @endforeach
    </div>
</section>
@endsection
