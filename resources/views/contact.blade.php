@extends('layouts.app')

@section('title', '| Contact')

@section('content')
@if (session('success'))
<script>
    toastr.success("{{ session('success') }}")
</script>
@endif
    <section class="pt-36 pb-20 px-6" style="background: linear-gradient(135deg, var(--color-primary), var(--color-blue));">
        <div class="max-w-4xl mx-auto text-center text-white">
            <span
                class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5 bg-white/15">Contact</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold mb-5">Book a Visit at RCDHO</h1>
            <p class="text-white/80 text-lg">For new patients, follow-up, drug evaluation, investigations and ultrasound
                appointments.</p>
        </div>
    </section>

    <section class="py-10 px-6" style="background: var(--color-dark);">
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">
            <a href="tel:+918002268003" class="rounded-lg p-5 bg-white/10 border border-white/10 text-white">
                <p class="text-xs font-bold uppercase tracking-widest text-white/60">Phone</p>
                <p class="text-xl font-extrabold mt-1">8002268003</p>
            </a>
            <a href="mailto:drmukherjees@gmail.com" class="rounded-lg p-5 bg-white/10 border border-white/10 text-white">
                <p class="text-xs font-bold uppercase tracking-widest text-white/60">Email</p>
                <p class="text-lg font-extrabold mt-1">drmukherjees@gmail.com</p>
            </a>
            <a href="https://www.rcdho.org" target="_blank"
                class="rounded-lg p-5 bg-white/10 border border-white/10 text-white">
                <p class="text-xs font-bold uppercase tracking-widest text-white/60">Website</p>
                <p class="text-lg font-extrabold mt-1">www.rcdho.org</p>
            </a>
        </div>
    </section>

    <section class="py-20 px-6" style="background: var(--color-light);">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-10">
            <div class="rounded-lg bg-white p-8 shadow-sm border border-emerald-100">
                <h2 class="text-2xl font-extrabold mb-6" style="color: var(--color-dark);">Appointment Request</h2>
                <form action="{{ route('appoinmentstore') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <input type="text" name="patient_name" placeholder="Patient name"
                            class="w-full px-4 py-3 rounded-lg border border-emerald-100 outline-none focus:border-emerald-600 @error('patient_name')
border-red-600
                    @enderror">
                        <input type="tel" name="phone" placeholder="Mobile number"
                            class="w-full px-4 py-3 rounded-lg border border-emerald-100 outline-none focus:border-emerald-600 @error('phone')
border-red-600
                    @enderror">
                    </div>
                    <select name="patient_type"
                        class="w-full px-4 py-3 rounded-lg border border-emerald-100 outline-none focus:border-emerald-600 @error('patient_type')
border-rred-600
                @enderror">
                        <option value="New patient">New patient</option>
                        <option value="Old patient / follow-up">Old patient / follow-up</option>
                        <option value="Drug evaluation">Drug evaluation</option>
                        <option value="Investigation / ultrasound">Investigation / ultrasound</option>
                    </select>
                    <textarea name="message" rows="4" placeholder="Brief concern or appointment note"
                        class="w-full px-4 py-3 rounded-lg border border-emerald-100 outline-none focus:border-emerald-600 @error('message')
border-red-600
                @enderror"></textarea>
                    <button class="w-full py-3 rounded-lg text-white font-bold"
                        style="background: var(--color-primary);">Send Request</button>
                </form>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg bg-white p-7 shadow-sm border border-emerald-100">
                    <h3 class="text-2xl font-extrabold mb-2" style="color: var(--color-dark);">Patna Clinic</h3>
                    <p class="text-gray-700">Holding #404, "Sukhadaya", New Yarpur Road #1, Patna - 800001</p>
                    <p class="text-sm mt-4 text-gray-600">New and old patients: 09:00 AM to 02:00 PM</p>
                    <p class="text-sm text-gray-600">Drug evaluation: 04:00 PM to 06:00 PM</p>
                </div>
                <div class="rounded-lg bg-white p-7 shadow-sm border border-emerald-100">
                    <h3 class="text-2xl font-extrabold mb-2" style="color: var(--color-dark);">Samastipur Clinic</h3>
                    <p class="text-gray-700">Bengali Tola, Samastipur - 848101, Bihar</p>
                    <p class="text-sm mt-4 text-gray-600">Sunday closed. Call service and night service unavailable as per
                        clinic note.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
