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
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-stretch">
        <!-- Administrative Office -->
        <div class="rounded-lg bg-white shadow-sm border border-emerald-100 p-8 flex flex-col justify-between">
            <div>
                <div class="h-1.5 rounded-full mb-6" style="background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));"></div>
                <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Administrative Office</h2>
                <p class="text-gray-700">Holding #404, "Sukhadaya", New Yarpur Road #1, Patna - 800001</p>
                <p class=" mt-4 text-gray-600 text-sm">Phone: 8002268003</p>
            </div>
        </div>

        <!-- Clinic Address -->
        <div class="rounded-lg bg-white shadow-sm border border-emerald-100 p-8 flex flex-col justify-between">
            <div>
                <div class="h-1.5 rounded-full mb-6" style="background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));"></div>
                <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Clinic Address</h2>
                <p class="text-gray-700">Bengali Tola, Samastipur - 848101, Bihar</p>
                <div class="mt-6 space-y-2 text-sm text-gray-600">
                    <p>New and old patients: 09:00 AM to 02:00 PM</p>
                    <p>Drug evaluation: 04:00 PM to 06:00 PM</p>
                    <p>Sunday closed</p>
                    <p>Please call before visiting for availability.</p>
                </div>
            </div>
            <div class="mt-6 space-y-2 text-sm text-gray-600">
                <p>Phone: 8002268003</p>
            </div>
        </div>
    </div>
</section>

@endsection
