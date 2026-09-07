@extends('admin.loyout.master')
@section('content')
    @php
        $totalP = $patients ?? 0;
        $diabPct = $totalP > 0 ? round((($diabetes ?? 0) / $totalP) * 100, 1) : 0;
        $htnPct = $totalP > 0 ? round((($hypertension ?? 0) / $totalP) * 100, 1) : 0;
        $obePct = $totalP > 0 ? round((($obesity ?? 0) / $totalP) * 100, 1) : 0;
        $infPct = $totalP > 0 ? round((($infection ?? 0) / $totalP) * 100, 1) : 0;
    @endphp

    <!-- Unified Hospital EHR Clinical Metric Bar -->
    <div class="glass-card rounded-2xl border border-slate-200/80 shadow-sm mb-8 overflow-hidden bg-white/90 backdrop-blur-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
            
            <!-- 1. Total Patients -->
            <a href="{{ route('list.patient') }}"
                class="group p-5 border-b sm:border-b-0 sm:border-r border-slate-100 hover:bg-slate-50/80 transition-all duration-200 flex flex-col justify-between relative">
                <div class="h-1 w-full bg-indigo-500 absolute top-0 left-0"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Registry</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalP }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Total Registered Patients</p>
                </div>
            </a>

            <!-- 2. Diabetes -->
            <a href="{{ route('report.diabetesReport') }}"
                class="group p-5 border-b sm:border-b-0 sm:border-r border-slate-100 hover:bg-slate-50/80 transition-all duration-200 flex flex-col justify-between relative">
                <div class="h-1 w-full bg-rose-500 absolute top-0 left-0"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Diabetes Patients</span>
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition-all shadow-sm">
                        <i class="fas fa-droplet text-sm"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $diabetes ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $diabPct }}% of total cohort</p>
                </div>
            </a>

            <!-- 3. Hypertension -->
            <a href="{{ route('report.hypertensioReport') }}"
                class="group p-5 border-b sm:border-b-0 lg:border-r border-slate-100 hover:bg-slate-50/80 transition-all duration-200 flex flex-col justify-between relative">
                <div class="h-1 w-full bg-emerald-500 absolute top-0 left-0"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Hypertension</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                        <i class="fas fa-heart-pulse text-sm"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $hypertension ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $htnPct }}% of total cohort</p>
                </div>
            </a>

            <!-- 4. Obesity -->
            <a href="{{ route('report.obesityReport') }}"
                class="group p-5 border-b sm:border-b-0 sm:border-r border-slate-100 hover:bg-slate-50/80 transition-all duration-200 flex flex-col justify-between relative sm:col-span-1">
                <div class="h-1 w-full bg-amber-500 absolute top-0 left-0"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Obesity Patients</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all shadow-sm">
                        <i class="fas fa-weight-scale text-sm"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $obesity ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $obePct }}% of total cohort</p>
                </div>
            </a>

            <!-- 5. Infection -->
            <a href="{{ route('report.InfectionReport') }}"
                class="group p-5 hover:bg-slate-50/80 transition-all duration-200 flex flex-col justify-between relative sm:col-span-2 lg:col-span-1">
                <div class="h-1 w-full bg-purple-500 absolute top-0 left-0"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Infection Patients</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all shadow-sm">
                        <i class="fas fa-virus text-sm"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $infection ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $infPct }}% of total cohort</p>
                </div>
            </a>

        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-800">Recent Patients</h2>
            <a href="{{ url('admin/patient/list') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                View all <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>

        <div class="table-wrap overflow-x-auto">
            <table class="min-w-full text-sm text-slate-700">
                <thead class="text-slate-500 border-b border-slate-200/70">
                    <tr>
                        <th class="text-left py-3 px-4 font-medium">#</th>
                        <th class="text-left py-3 px-4 font-medium">Patient Name</th>
                        <th class="text-left py-3 px-4 font-medium">Mobile No</th>
                        <th class="text-left py-3 px-4 font-medium">Registration No</th>
                        <th class="text-left py-3 px-4 font-medium">Record Date</th>
                        <th class="text-left py-3 px-4 font-medium">Age</th>
                        <th class="text-left py-3 px-4 font-medium">Gender</th>
                        <th class="text-left py-3 px-4 font-medium">Address</th>
                        <th class="text-left py-3 px-4 font-medium">RCDHO Grade</th>

                    </tr>
                </thead>

                <tbody>
                    @forelse($allPatient as $data)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-medium">
                                {{ $loop->iteration }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $data->patient_name }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $data->mobile_no }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $data->registration_no }}
                            </td>

                            <td class="py-3 px-4">
                                {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                            </td>

                            <td class="py-3 px-4">
                                {{ $data->age }}
                            </td>

                            <td class="py-3 px-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs
                                {{ $data->gender == 'Male'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($data->gender == 'Female'
                                        ? 'bg-pink-100 text-pink-700'
                                        : 'bg-gray-100 text-gray-700') }}">
                                    {{ $data->gender }}
                                </span>
                            </td>

                            <td class="py-3 px-4">
                                {{ Str::limit($data->address ?? '', 30) }}
                            </td>

                            <td class="py-3 px-4">
                                @if ($data->rcdho_grade)
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                                        {{ $data->rcdho_grade }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-slate-500">
                                No patient records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
