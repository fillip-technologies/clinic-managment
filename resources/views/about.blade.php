@extends('layouts.app')

@section('title', '| Doctors')

@section('content')

<section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-blue));">
    <div class="max-w-5xl mx-auto text-center text-white">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5 bg-white/15">Clinical Team</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Doctors at DrMukherjeeS Clinic</h1>
        <p class="text-white/80 text-lg">Specialized internal medicine, diabetes care and clinical ultrasonology under the RCDHO care model.</p>
    </div>
</section>

<section class="py-20 px-6 bg-white">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-8">
        <div class="rounded-lg border border-emerald-100 p-8 shadow-sm">
            <p class="text-xs font-extrabold uppercase tracking-widest mb-3" style="color: var(--color-primary);">Director, RCDHO</p>
            <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Dr. Supriyo Mukherjee</h2>
            <ul class="space-y-2 text-gray-700">
                <li>M.D. Internal Medicine, KGMC (Lucknow)</li>
                <li>M.Sc. (Distinction) Advancing Diabetes Care (UK)</li>
                <li>Senior Fellow, International Diabetes Federation (IDF)</li>
                <li>Fellow Indian College of Physicians (FICP)</li>
                <li>Fellow Diabetes India (FDI)</li>
                <li class="font-bold" style="color: var(--color-secondary);">Gold Medal in Medicine</li>
            </ul>
            <p class="text-sm text-gray-500 mt-5">Regd. No. 27256 | Regd. No. 8482/2018 Vide Sr. No. 8303</p>
        </div>

        <div class="rounded-lg border border-emerald-100 p-8 shadow-sm" style="background: var(--color-light);">
            <p class="text-xs font-extrabold uppercase tracking-widest mb-3" style="color: var(--color-primary);">Clinical Ultrasonologist</p>
            <h2 class="text-3xl font-extrabold mb-3" style="color: var(--color-dark);">Dr. Sushmita Mukherjee</h2>
            <ul class="space-y-2 text-gray-700">
                <li>M.B.B.S. (B.U.)</li>
                <li>CC.USG</li>
                <li>Clinical Ultrasonologist</li>
            </ul>
            <p class="text-sm text-gray-500 mt-5">Reg. No. 28996</p>
        </div>
    </div>
</section>

<section class="py-20 px-6" style="background: var(--color-light);">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
        <img src="{{ asset('images/doctors.png') }}" class="rounded-lg shadow-xl w-full object-cover" alt="Clinic doctors">
        <div>
            <span class="inline-block text-xs font-extrabold uppercase tracking-widest px-3 py-1 rounded-full mb-4 bg-white" style="color: var(--color-primary);">RCDHO Approach</span>
            <h2 class="text-3xl font-extrabold mb-5" style="color: var(--color-dark);">Building perfection in resource constraints</h2>
            <p class="text-gray-700 leading-relaxed">
                The clinic documentation emphasizes complete history, examination, risk stratification, investigations, lifestyle planning and follow-up. The website has been aligned to that same structured patient journey.
            </p>
        </div>
    </div>
</section>

@endsection
