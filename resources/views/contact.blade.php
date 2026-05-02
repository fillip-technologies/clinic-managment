@extends('layouts.app')

@section('title', '| Contact Us')

@section('content')

    {{-- Hero --}}
    <section class="pt-36 pb-16 px-6"
        style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
                style="background: rgba(255,255,255,0.2); color: white;">
                Get In Touch
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">Contact Dr. Kundan Kumar</h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                Reach out for appointments, second opinions, or emergency consultations. We're here to help you every step
                of the way.
            </p>
        </div>
    </section>

    {{-- Quick Contact Strip --}}
    <section class="py-10 px-6" style="background: var(--color-dark);">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="tel:+918088152289" class="flex items-center gap-4 p-5 rounded-2xl transition hover:-translate-y-1"
                style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.08);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                    style="background: var(--color-primary);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5" style="color: var(--color-secondary);">Phone
                    </p>
                    <p class="text-white font-semibold">+91 80881 52289</p>
                </div>
            </a>
            <a href="https://wa.me/918088152289" target="_blank"
                class="flex items-center gap-4 p-5 rounded-2xl transition hover:-translate-y-1"
                style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.08);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background: #25D366;">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path
                            d="M12 0C5.373 0 0 5.373 0 12c0 2.117.554 4.107 1.523 5.84L.057 23.5l5.835-1.531A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-4.984-1.365l-.357-.212-3.707.972.99-3.614-.233-.37A9.818 9.818 0 1112 21.818z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5" style="color: var(--color-secondary);">
                        WhatsApp</p>
                    <p class="text-white font-semibold">+91 80881 52289</p>
                </div>
            </a>
            <a href="mailto:kundankumar911@gmail.com"
                class="flex items-center gap-4 p-5 rounded-2xl transition hover:-translate-y-1"
                style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.08);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                    style="background: var(--color-secondary);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide mb-0.5" style="color: var(--color-secondary);">Email
                    </p>
                    <p class="text-white font-semibold">kundankumar911@gmail.com</p>
                </div>
            </a>
        </div>
    </section>

    {{-- Contact Form + Info --}}
    <section class="py-20 px-6" style="background: var(--color-light);">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12">

                {{-- LEFT: Contact Form --}}
                <div class="rounded-3xl p-8 shadow-xl" style="background: white; border: 1px solid rgba(2,134,148,0.1);">
                    <div class="mb-6">
                        <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3"
                            style="background: var(--color-soft); color: var(--color-primary);">Send a Message</span>
                        <h2 class="text-2xl font-extrabold" style="color: var(--color-dark);">Book an Appointment</h2>
                        <p class="text-gray-500 text-sm mt-1">Fill the form and we'll get back to you within 24 hours.</p>
                    </div>

                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wide mb-1.5"
                                    style="color: var(--color-dark);">Full Name</label>
                                <input type="text" name="name" placeholder="Your full name" required
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition"
                                    style="background: var(--color-soft); border: 1.5px solid transparent; color: var(--color-dark);"
                                    onfocus="this.style.borderColor='var(--color-primary)'"
                                    onblur="this.style.borderColor='transparent'">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wide mb-1.5"
                                    style="color: var(--color-dark);">Phone Number</label>
                                <input type="tel" name="phone" placeholder="+91 XXXXX XXXXX" required
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition"
                                    style="background: var(--color-soft); border: 1.5px solid transparent; color: var(--color-dark);"
                                    onfocus="this.style.borderColor='var(--color-primary)'"
                                    onblur="this.style.borderColor='transparent'">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wide mb-1.5"
                                style="color: var(--color-dark);">Email (Optional)</label>
                            <input type="email" name="email" placeholder="your@email.com"
                                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition"
                                style="background: var(--color-soft); border: 1.5px solid transparent; color: var(--color-dark);"
                                onfocus="this.style.borderColor='var(--color-primary)'"
                                onblur="this.style.borderColor='transparent'">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wide mb-1.5"
                                style="color: var(--color-dark);">Preferred Branch</label>
                            <select name="branch" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition"
                                style="background: var(--color-soft); border: 1.5px solid transparent; color: var(--color-dark);"
                                onfocus="this.style.borderColor='var(--color-primary)'"
                                onblur="this.style.borderColor='transparent'">
                                <option value="">Select a clinic</option>
                                <option>Patna – NSMCH, Bihta (Main Branch)</option>
                                <option>Ara – Near LIC Office (Tuesday: 5–7 PM)</option>
                                <option>Siwan – Bindusar Road (Saturday: 10 AM–3 PM)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wide mb-1.5"
                                style="color: var(--color-dark);">Your Concern / Message</label>
                            <textarea name="message" rows="4" placeholder="Briefly describe your symptoms or concern..."
                                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition resize-none"
                                style="background: var(--color-soft); border: 1.5px solid transparent; color: var(--color-dark);"
                                onfocus="this.style.borderColor='var(--color-primary)'"
                                onblur="this.style.borderColor='transparent'"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide transition hover:-translate-y-0.5 hover:shadow-lg"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                            Send Message →
                        </button>
                    </form>
                </div>

                {{-- RIGHT: Clinic Info --}}
                <div class="space-y-6">
                    <div>
                        <span class="inline-block text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3"
                            style="background: var(--color-soft); color: var(--color-primary);">Our Locations</span>
                        <h2 class="text-2xl font-extrabold mb-2" style="color: var(--color-dark);">Visit a Clinic Near You
                        </h2>
                        <p class="text-gray-500 text-sm">Walk-ins welcome, but appointments preferred for better service.
                        </p>
                    </div>

                    {{-- Patna --}}
                    <div class="rounded-2xl p-6 transition hover:-translate-y-1 hover:shadow-lg"
                        style="background: white; border: 1px solid rgba(2,134,148,0.12);">
                        <div class="h-1.5 w-full rounded-full mb-4"
                            style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));">
                        </div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                style="background: var(--color-soft);">
                                <svg class="w-5 h-5" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-extrabold" style="color: var(--color-dark);">Patna – Main Branch</p>
                                <p class="text-xs" style="color: var(--color-primary);">NSMCH, Bihta, Patna – 800014</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">⏰ Mon – Fri: 9:00 AM – 2:00 PM</p>
                        <p class="text-sm text-gray-500">📞 +91 80881 52289</p>
                    </div>

                    {{-- Ara --}}
                    <div class="rounded-2xl p-6 transition hover:-translate-y-1 hover:shadow-lg"
                        style="background: white; border: 1px solid rgba(2,134,148,0.12);">
                        <div class="h-1.5 w-full rounded-full mb-4"
                            style="background: linear-gradient(to right, var(--color-secondary), var(--color-primary));">
                        </div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                style="background: var(--color-soft);">
                                <svg class="w-5 h-5" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-extrabold" style="color: var(--color-dark);">Ara – Branch Clinic</p>
                                <p class="text-xs" style="color: var(--color-primary);">Mahavir Tola, Near LIC Office, Ara –
                                    802301</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">⏰ Tuesday: 5:00 PM – 7:00 PM</p>
                        <p class="text-sm text-gray-500">📞 +91 95727 37464</p>
                    </div>

                    {{-- Siwan --}}
                    <div class="rounded-2xl p-6 transition hover:-translate-y-1 hover:shadow-lg"
                        style="background: white; border: 1px solid rgba(2,134,148,0.12);">
                        <div class="h-1.5 w-full rounded-full mb-4"
                            style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));">
                        </div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                                style="background: var(--color-soft);">
                                <svg class="w-5 h-5" fill="none" stroke="#028694" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-extrabold" style="color: var(--color-dark);">Siwan – Branch Clinic</p>
                                <p class="text-xs" style="color: var(--color-primary);">Near Dr. Shahnwaz Alam, Bindusar
                                    Road, Siwan – 841226</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">⏰ Saturday: 10:00 AM – 3:00 PM</p>
                        <p class="text-sm text-gray-500">📞 +91 80881 52289</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Google Map + Emergency CTA --}}
    <section class="py-16 px-6" style="background: var(--color-dark);">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white mb-3">Need Immediate Help?</h2>
            <p class="text-white/70 mb-8">For neurological emergencies, do not wait — contact us immediately.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+918088152289"
                    class="px-8 py-4 rounded-xl text-white font-bold text-lg shadow-lg transition hover:-translate-y-1"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));">
                    📞 Call Now: +91 80881 52289
                </a>
                <a href="https://wa.me/918088152289" target="_blank"
                    class="px-8 py-4 rounded-xl font-bold text-lg transition hover:-translate-y-1"
                    style="background: #25D366; color: white;">
                    💬 WhatsApp Us
                </a>
            </div>
        </div>
    </section>

@endsection