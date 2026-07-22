@extends('layouts.app')

@section('title', '| Clinics')

@section('content')

<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-blue));">
    <div class="max-w-4xl mx-auto text-center text-white">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5 bg-white/15">Locations</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">RCDHO Clinic Locations</h1>
        <p class="text-white/80 text-lg">Patna and Samastipur care centers for diabetes, hypertension, obesity and ultrasound services.</p>
    </div>
</section>

<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
        @foreach ([
            ['Patna', 'Holding #404, "Sukhadaya", New Yarpur Road #1, Patna - 800001', 'New and old patients: 09:00 AM to 02:00 PM', 'Drug evaluation: 04:00 PM to 06:00 PM'],
            ['Samastipur', 'Bengali Tola, Samastipur - 848101, Bihar', 'Sunday closed', 'Please call before visiting for availability.'],
        ] as $clinic)
        <div class="rounded-lg bg-white shadow-sm border border-emerald-100 p-8">
            <div class="h-1.5 rounded-full mb-6" style="background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));"></div>
            <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">{{ $clinic[0] }}</h2>
            <p class="text-gray-700">{{ $clinic[1] }}</p>
            <div class="mt-6 space-y-2 text-sm text-gray-600">
                <p>{{ $clinic[2] }}</p>
                <p>{{ $clinic[3] }}</p>
                <p>Phone: 8002268003</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
