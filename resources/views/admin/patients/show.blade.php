@extends('admin.loyout.master')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .detail-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .detail-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07);
        }
        .section-header {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .metric-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #64748b;
            margin-bottom: 0.2rem;
        }
        .metric-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
        }
        @media print {
            aside, topbar, .no-print {
                display: none !important;
            }
            main {
                padding: 0 !important;
                background: white !important;
            }
            .detail-card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                break-inside: avoid;
            }
        }
    </style>

@php
    $record = $record ?? new \App\Models\PatientClinicalRecord(['patient_id' => $patient->id ?? 0]);
@endphp

    <div class="max-w-7xl mx-auto space-y-6 pb-12">
        <!-- Top Navigation & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm no-print">
            <div class="flex items-center gap-3">
                {{-- <a href="{{ route('list.patient') }}"
                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 border border-slate-200 transition">
                    <i class="fas fa-arrow-left"></i>
                </a> --}}
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-800 flex items-center gap-2">
                        <span>Patient Clinical Profile</span>
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-bold bg-indigo-100 text-indigo-700">
                            {{ $patient->registration_no ?? 'ID #' . ($patient->id ?? $record->patient_id) }}
                        </span>
                    </h1>
                    <p class="text-xs text-slate-500">Comprehensive patient history and clinical laboratory details</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" onclick="window.print()"
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition">
                    <i class="fas fa-print"></i> Print Profile
                </button>

                <a href="{{ route('addnewReport', $record->id ?? $patient->id) }}"
                    class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-sm hover:shadow transition">
                    <i class="fas fa-plus-circle"></i> Add Follow-up Visit
                </a>

                <a href="{{ route('patient.edit', $patient->id ?? $record->patient_id) }}?record_id={{ $record->id }}"
                    class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-sm hover:shadow transition">
                    <i class="fas fa-edit"></i> Edit Record
                </a>
            </div>
        </div>

        <!-- Patient Master Identity Card -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <!-- Background glow circle -->
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-5">
                    <!-- Avatar -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-indigo-600/60 border-2 border-indigo-400/40 flex items-center justify-center text-white text-2xl sm:text-3xl font-bold uppercase shadow-inner flex-shrink-0">
                        {{ $patient->patient_name ? substr($patient->patient_name, 0, 2) : 'PT' }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                {{ $patient->patient_name ?? 'Unnamed Patient' }}
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ ($patient->gender ?? '') === 'Female' ? 'bg-pink-500/30 text-pink-200 border border-pink-400/30' : 'bg-blue-500/30 text-blue-200 border border-blue-400/30' }}">
                                {{ $patient->gender ?? 'Not Specified' }}
                            </span>
                            @if(!empty($patient->rcdho_grade))
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                                    {{ $patient->rcdho_grade }}
                                </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-1.5 text-xs text-slate-300 mt-2">
                            <div>
                                <span class="text-slate-400">Age:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->age ? $patient->age . ' yrs' : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Mobile:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->mobile_no ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Guardian:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->father_husband_name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Reg Date:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->record_date ? \Carbon\Carbon::parse($patient->record_date)->format('d M Y') : 'N/A' }}</span>
                            </div>
                        </div>

                        @if(!empty($patient->address))
                            <div class="mt-2 text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-indigo-400"></i>
                                <span>{{ $patient->address }}</span>
                            </div>
                        @endif

                        <!-- Clinical Disease / Condition Tags -->
                        <div class="flex flex-wrap items-center gap-1.5 mt-3">
                            @if(!empty($record->diabetes))
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-blue-500/20 text-blue-300 border border-blue-400/30">
                                    <i class="fas fa-notes-medical mr-1"></i>Diabetes: {{ $record->diabetes }}
                                </span>
                            @endif
                            @if(!empty($record->hypertension) || !empty($record->htn))
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-red-500/20 text-red-300 border border-red-400/30">
                                    <i class="fas fa-heart-pulse mr-1"></i>Hypertension: {{ $record->hypertension ?? ($record->htn ? 'Yes' : 'No') }}
                                </span>
                            @endif
                            @if(!empty($record->obesity))
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                                    <i class="fas fa-weight-scale mr-1"></i>Obesity: {{ $record->obesity }}
                                </span>
                            @endif
                            @if(!empty($record->infection))
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-purple-500/20 text-purple-300 border border-purple-400/30">
                                    <i class="fas fa-virus mr-1"></i>Infection: {{ $record->infection }}
                                </span>
                            @endif
                            @if(!empty($record->temprature))
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold {{ floatval($record->temprature) > 99.4 ? 'bg-red-500/30 text-red-200 border-red-400/40' : 'bg-emerald-500/20 text-emerald-300 border-emerald-400/30' }}">
                                    <i class="fas fa-thermometer-half mr-1"></i>Temp: {{ $record->temprature }}°F
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Record status badges -->
                <div class="flex md:flex-col items-end gap-2 text-right">
                    <div class="bg-white/10 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/10 text-xs">
                        <p class="text-slate-300 text-[10px] uppercase font-semibold">Latest Visit Record</p>
                        <p class="font-bold text-white text-sm">
                            {{ $record->record_date ? \Carbon\Carbon::parse($record->record_date)->format('d M Y') : ($record->created_at ? $record->created_at->format('d M Y') : 'Today') }}
                        </p>
                    </div>
                    <span class="text-[11px] text-slate-400">
                        {{ $allRecords->count() }} total visit records on file
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Tab Switcher -->
        <div class="flex items-center gap-3 border-b border-slate-200 no-print">
            <button type="button" onclick="switchDetailTab('profile')" id="tab-btn-profile"
                class="px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-indigo-600 text-indigo-600 transition">
                <i class="fas fa-file-medical"></i>
                <span>Clinical Profile & Records</span>
            </button>
            <button type="button" onclick="switchDetailTab('analytics')" id="tab-btn-analytics"
                class="px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 transition">
                <i class="fas fa-chart-line text-indigo-500"></i>
                <span>Health Trends & Graphs</span>
            </button>
        </div>

        <div id="content-profile" class="space-y-6">
            <!-- Key Clinical Alerts & Metrics Header (KPI Row) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <!-- BMI -->
                @php
                    $bmiVal = floatval($record->bmi ?? 0);
                    $bmiBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    if ($bmiVal >= 25) $bmiBg = 'bg-red-50 text-red-700 border-red-200';
                    elseif ($bmiVal >= 23) $bmiBg = 'bg-amber-50 text-amber-700 border-amber-200';
                @endphp
            <div class="p-4 rounded-2xl border {{ $bmiBg }} flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">BMI (kg/m²)</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $record->bmi ?: 'N/A' }}</span>
                </div>
                <span class="text-xs font-semibold">{{ $record->bmi_group ?: ($bmiVal >= 25 ? 'Obese' : ($bmiVal >= 23 ? 'Overweight' : 'Normal')) }}</span>
            </div>

            <!-- Blood Pressure -->
            @php
                $sbp = intval($record->sbp ?? 0);
                $dbp = intval($record->dbp ?? 0);
                $bpBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                if ($sbp >= 140 || $dbp >= 90) $bpBg = 'bg-red-50 text-red-700 border-red-200';
                elseif ($sbp >= 130 || $dbp >= 85) $bpBg = 'bg-amber-50 text-amber-700 border-amber-200';
            @endphp
            <div class="p-4 rounded-2xl border {{ $bpBg }} flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">Blood Pressure</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">
                        {{ $record->sbp && $record->dbp ? $record->sbp . '/' . $record->dbp : ($record->sbp ? $record->sbp : 'N/A') }}
                    </span>
                    <span class="text-[10px] ml-0.5">mmHg</span>
                </div>
                <span class="text-xs font-semibold">{{ $sbp >= 140 ? 'Hypertensive' : ($sbp >= 130 ? 'Pre-HTN' : 'Normal') }}</span>
            </div>

            <!-- HbA1c -->
            @php
                $hba1c = floatval($record->hba1c ?? 0);
                $hba1cBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                if ($hba1c >= 6.5) $hba1cBg = 'bg-red-50 text-red-700 border-red-200';
                elseif ($hba1c >= 5.7) $hba1cBg = 'bg-amber-50 text-amber-700 border-amber-200';
            @endphp
            <div class="p-4 rounded-2xl border {{ $hba1cBg }} flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">HbA1c</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $record->hba1c ? $record->hba1c . '%' : 'N/A' }}</span>
                </div>
                <span class="text-xs font-semibold">{{ $hba1c >= 6.5 ? 'Diabetic' : ($hba1c >= 5.7 ? 'Pre-diabetic' : 'Normal') }}</span>
            </div>

            <!-- Fasting Sugar (BSF) -->
            <div class="p-4 rounded-2xl bg-indigo-50 text-indigo-800 border border-indigo-200 flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">Blood Sugar (BSF)</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $record->bsf ?: 'N/A' }}</span>
                    <span class="text-[10px] ml-0.5">mg/dL</span>
                </div>
                <span class="text-xs font-semibold">PP: {{ $record->bspp ? $record->bspp . ' mg/dL' : 'N/A' }}</span>
            </div>

            <!-- Renal (Creatinine) -->
            <div class="p-4 rounded-2xl bg-slate-50 text-slate-800 border border-slate-200 flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">Creatinine / eGFR</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $record->creatinine ?: 'N/A' }}</span>
                    <span class="text-[10px] ml-0.5">mg/dL</span>
                </div>
                <span class="text-xs font-semibold">eGFR: {{ $record->egfr ?: 'N/A' }}</span>
            </div>

            <!-- Insulin Therapy -->
            @php
                $insulinStatus = 'Not on';
                $insulinBg = 'bg-slate-100 text-slate-700 border-slate-200';
                if (!empty($record->start_insulin_date)) {
                    if (empty($record->stop_insulin_date)) {
                        $insulinStatus = 'Active Insulin';
                        $insulinBg = 'bg-purple-50 text-purple-700 border-purple-200';
                    } else {
                        $insulinStatus = 'Stopped';
                        $insulinBg = 'bg-amber-50 text-amber-700 border-amber-200';
                    }
                }
            @endphp
            <div class="p-4 rounded-2xl border {{ $insulinBg }} flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">Insulin Therapy</span>
                <div class="my-1">
                    <span class="text-lg sm:text-xl font-bold">{{ $insulinStatus }}</span>
                </div>
                <span class="text-[11px] truncate">
                    @if($record->start_insulin_date)
                        Since: {{ \Carbon\Carbon::parse($record->start_insulin_date)->format('M Y') }}
                    @else
                        No Insulin Recorded
                    @endif
                </span>
            </div>
        </div>

        <!-- Detailed Clinical Breakdown Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COLUMN 1: Physical Measurements, Anthropometry & Lifestyle -->
            <div class="space-y-6">
                <!-- Anthropometry -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-ruler-combined text-indigo-500"></i>
                        Anthropometry & Body Metrics
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="metric-label">Height</p>
                            <p class="metric-value">{{ $record->height_cm ? $record->height_cm . ' cm' : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Weight</p>
                            <p class="metric-value">{{ $record->weight_kg ? $record->weight_kg . ' kg' : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">BMI</p>
                            <p class="metric-value">{{ $record->bmi ? $record->bmi . ' kg/m²' : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">BMI Group</p>
                            <p class="metric-value">{{ $record->bmi_group ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Waist Circumference</p>
                            <p class="metric-value">{{ $record->waist_cm ? $record->waist_cm . ' cm' : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Hip Circumference</p>
                            <p class="metric-value">{{ $record->hip_cm ? $record->hip_cm . ' cm' : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Waist-to-Hip Ratio</p>
                            <p class="metric-value">{{ $record->waist_hip_ratio ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Waist-to-Height Ratio</p>
                            <p class="metric-value">{{ $record->waist_height_ratio ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Body Temperature</p>
                            <p class="metric-value {{ floatval($record->temprature ?? 0) > 99.4 ? 'text-red-600 font-bold' : '' }}">
                                {{ $record->temprature ? $record->temprature . ' °F' : '98.6 °F' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Lifestyle & Socio-demographics -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-user-tag text-indigo-500"></i>
                        Lifestyle & Social Factors
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="metric-label">Diet Pattern</p>
                            <p class="metric-value">{{ $record->veg_nonveg ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Physical Activity</p>
                            <p class="metric-value">{{ $record->physical_activity ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Social Class</p>
                            <p class="metric-value">{{ $record->social_class ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="metric-label">Income Class</p>
                            <p class="metric-value">{{ $record->income_class ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="metric-label">Education Level</p>
                            <p class="metric-value">{{ $record->education ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Diabetes & Insulin History -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-syringe text-indigo-500"></i>
                        Diabetes & Insulin Details
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Newly Detected:</span>
                            <span class="text-xs font-bold {{ ($record->newly_detected ?? '') == 'Yes' ? 'text-amber-600' : 'text-slate-800' }}">
                                {{ $record->newly_detected ?? 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Duration of Diabetes:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->duration_of_diabetes ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Start Insulin Date:</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $record->start_insulin_date ? \Carbon\Carbon::parse($record->start_insulin_date)->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Stop Insulin Date:</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $record->stop_insulin_date ? \Carbon\Carbon::parse($record->stop_insulin_date)->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Insulin Brand:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->insuline_brand ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Insulin Unit:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->insuline_unit ?: 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMN 2: Comprehensive Laboratory Findings -->
            <div class="space-y-6">
                <!-- CBC & Renal Panel -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-vial text-indigo-500"></i>
                        CBC & Renal Panel (KFT)
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Hemoglobin (Hb %)</p>
                            <p class="metric-value">{{ $record->hb_percent ? $record->hb_percent . ' g/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Platelet Count (PLT)</p>
                            <p class="metric-value">{{ $record->plt ? $record->plt . ' cells/µL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">MCV</p>
                            <p class="metric-value">{{ $record->mcv ? $record->mcv . ' fL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Serum Creatinine</p>
                            <p class="metric-value">{{ $record->creatinine ? $record->creatinine . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">eGFR</p>
                            <p class="metric-value">{{ $record->egfr ? $record->egfr . ' mL/min' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">ACR</p>
                            <p class="metric-value">{{ $record->acr ? $record->acr . ' mg/g' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Serum Uric Acid</p>
                            <p class="metric-value">{{ $record->uric_acid ? $record->uric_acid . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Urine Cast Cell</p>
                            <p class="metric-value">{{ $record->urine_cast_cell ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Electrolytes & Liver Function (LFT) -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-flask text-indigo-500"></i>
                        Electrolytes & Liver (LFT)
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Sodium (Na+)</p>
                            <p class="metric-value">{{ $record->na_plus ? $record->na_plus . ' mEq/L' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Potassium (K+)</p>
                            <p class="metric-value">{{ $record->k_plus ? $record->k_plus . ' mEq/L' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Ionized Calcium</p>
                            <p class="metric-value">{{ $record->i_calcium ? $record->i_calcium . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Phosphorus</p>
                            <p class="metric-value">{{ $record->phosphorus ? $record->phosphorus . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">SGPT (ALT)</p>
                            <p class="metric-value">{{ $record->sgpt ? $record->sgpt . ' U/L' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">SGOT (AST)</p>
                            <p class="metric-value">{{ $record->sgot ? $record->sgot . ' U/L' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl col-span-2">
                            <p class="metric-label">Alkaline Phosphatase (ALKP)</p>
                            <p class="metric-value">{{ $record->alkp ? $record->alkp . ' U/L' : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Lipid Profile -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-heartbeat text-indigo-500"></i>
                        Lipid Profile
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Total Cholesterol</p>
                            <p class="metric-value">{{ $record->chol ? $record->chol . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Triglycerides (TG)</p>
                            <p class="metric-value">{{ $record->tg ? $record->tg . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">HDL Cholesterol</p>
                            <p class="metric-value">{{ $record->hdl ? $record->hdl . ' mg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">LDL Cholesterol</p>
                            <p class="metric-value">{{ $record->ldl ? $record->ldl . ' mg/dL' : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMN 3: Endocrine, Thyroid, Vitamins, Specialist Exams & Attachments -->
            <div class="space-y-6">
                <!-- Endocrine & Thyroid Panel -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-dna text-indigo-500"></i>
                        Thyroid, Hormones & Vitamins
                    </h3>
                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">TSH</p>
                            <p class="metric-value">{{ $record->tsh ? $record->tsh . ' µIU/mL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">T3</p>
                            <p class="metric-value">{{ $record->t3 ? $record->t3 . ' ng/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">T4</p>
                            <p class="metric-value">{{ $record->t4 ? $record->t4 . ' µg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Vitamin D (25-OH)</p>
                            <p class="metric-value">{{ $record->vitamin_d25 ? $record->vitamin_d25 . ' ng/mL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Vitamin B12</p>
                            <p class="metric-value">{{ $record->vitamin_b12 ? $record->vitamin_b12 . ' pg/mL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <p class="metric-label">Serum Cortisol</p>
                            <p class="metric-value">{{ $record->s_cortisol ? $record->s_cortisol . ' µg/dL' : 'N/A' }}</p>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl col-span-2">
                            <p class="metric-label">Dex. Suppression Test</p>
                            <p class="metric-value">{{ $record->dex_skip_test ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Serology & Imaging -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-shield-virus text-indigo-500"></i>
                        Serology & Hepatic Imaging
                    </h3>
                    <div class="grid grid-cols-3 gap-2 text-center mb-3">
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">HIV</span>
                            <p class="text-xs font-bold {{ ($record->hiv ?? '') == 'Positive' ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $record->hiv ?? 'Not Tested' }}
                            </p>
                        </div>
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">HBsAg</span>
                            <p class="text-xs font-bold {{ ($record->hbsag ?? '') == 'Positive' ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $record->hbsag ?? 'Not Tested' }}
                            </p>
                        </div>
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-200">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">HCV</span>
                            <p class="text-xs font-bold {{ ($record->hcv ?? '') == 'Positive' ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $record->hcv ?? 'Not Tested' }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between p-2 bg-slate-50 rounded-lg">
                            <span class="text-slate-600 font-medium">FIB Score:</span>
                            <span class="font-bold text-slate-800">{{ $record->fib_score ?: 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-lg">
                            <span class="text-slate-600 font-medium">FibroScan:</span>
                            <span class="font-bold text-slate-800">{{ $record->fib_scan ? $record->fib_scan . ' kPa' : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-lg">
                            <span class="text-slate-600 font-medium">Median Stiffness:</span>
                            <span class="font-bold text-slate-800">{{ $record->median_stiffness ? $record->median_stiffness . ' kPa' : 'N/A' }}</span>
                        </div>
                        <div class="p-2 bg-slate-50 rounded-lg">
                            <span class="text-slate-600 font-medium block mb-1">USG Abdomen Findings:</span>
                            <p class="font-semibold text-slate-800">{{ $record->usg ?: 'No findings recorded' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Specialist Clinical Evaluations -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-stethoscope text-indigo-500"></i>
                        Specialist Evaluations
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="font-bold text-slate-700 flex items-center gap-1.5 mb-1">
                                <i class="fas fa-eye text-indigo-500"></i> Ophthalmic (Eye/Retina) Exam:
                            </span>
                            <p class="text-slate-600">{{ $record->ophthalmic_ex ?: 'No abnormalities noted / Not performed' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="font-bold text-slate-700 flex items-center gap-1.5 mb-1">
                                <i class="fas fa-shoe-prints text-indigo-500"></i> Diabetic Foot Evaluation:
                            </span>
                            <p class="text-slate-600">{{ $record->foot_ev ?: 'No ulcers / Sensation intact / Not performed' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="font-bold text-slate-700 flex items-center gap-1.5 mb-1">
                                <i class="fas fa-heart text-indigo-500"></i> Cardiac Echo Summary:
                            </span>
                            <p class="text-slate-600">{{ $record->car_echo_ev ?: 'Normal systolic function / Not performed' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Attached Prescription / Lab Scans -->
                <div class="detail-card p-5">
                    <h3 class="section-header">
                        <i class="fas fa-paperclip text-indigo-500"></i>
                        Attached Prescription / Documents
                    </h3>
                    @if(!empty($record->attachment))
                        <div class="p-3 bg-indigo-50/50 rounded-xl border border-indigo-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate max-w-[75%]">
                                <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                <span class="text-xs font-semibold text-slate-700 truncate" title="{{ basename($record->attachment) }}">
                                    {{ basename($record->attachment) }}
                                </span>
                            </div>
                            <a href="{{ route('patient.attachment', $record->id) }}" target="_blank"
                                class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition flex items-center gap-1 shadow-sm">
                                <i class="fas fa-external-link-alt text-[10px]"></i> View
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4 text-slate-400 text-xs">
                            <i class="fas fa-file-excel text-2xl mb-1 text-slate-300 block"></i>
                            No document or prescription scan attached.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Longitudinal Consultation Visit History Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-history text-indigo-600"></i>
                    All Consultation & Visit History for {{ $patient->patient_name ?? 'this patient' }}
                </h3>
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('patient.export', $patient->id) }}"
                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                        <i class="fas fa-file-csv text-sm"></i>
                        <span>Export All Records (CSV)</span>
                    </a>
                    <span class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-xl font-bold">
                        {{ $allRecords->count() }} Visit(s) Recorded
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Visit Date</th>
                            <th class="px-4 py-3">BMI</th>
                            <th class="px-4 py-3">BP (SBP/DBP)</th>
                            <th class="px-4 py-3">HbA1c</th>
                            <th class="px-4 py-3">Creatinine</th>
                            <th class="px-4 py-3">Insulin Status</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($allRecords as $vRecord)
                            <tr class="hover:bg-slate-50 transition {{ $vRecord->id == $record->id ? 'bg-indigo-50/40 font-semibold' : '' }}">
                                <td class="px-4 py-3 text-slate-800">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-check text-indigo-500"></i>
                                        <span>{{ $vRecord->record_date ? \Carbon\Carbon::parse($vRecord->record_date)->format('d M Y') : $vRecord->created_at->format('d M Y') }}</span>
                                        @if($vRecord->id == $record->id)
                                            <span class="text-[10px] bg-indigo-600 text-white px-2 py-0.5 rounded-full font-medium">Viewing</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $vRecord->bmi ? $vRecord->bmi . ' (' . ($vRecord->bmi_group ?? 'Normal') . ')' : '-' }}</td>
                                <td class="px-4 py-3 font-mono text-xs">{{ $vRecord->sbp && $vRecord->dbp ? $vRecord->sbp . '/' . $vRecord->dbp : '-' }}</td>
                                <td class="px-4 py-3">{{ $vRecord->hba1c ? $vRecord->hba1c . '%' : '-' }}</td>
                                <td class="px-4 py-3">{{ $vRecord->creatinine ? $vRecord->creatinine . ' mg/dL' : '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($vRecord->start_insulin_date)
                                        <span class="text-xs text-purple-700 bg-purple-50 px-2 py-0.5 rounded font-semibold">
                                            {{ $vRecord->stop_insulin_date ? 'Stopped' : 'Active' }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($vRecord->id == $record->id)
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-600 text-white shadow-sm inline-block">
                                            Viewing
                                        </span>
                                    @else
                                        <a href="{{ route('patient.show', $patient->id) }}?record_id={{ $vRecord->id }}"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white transition inline-block">
                                            View Details
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-slate-400">No other records on file.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End of #content-profile -->
    </div>

    <!-- Patient Health Trends & Graphs Content -->
    <div id="content-analytics" class="space-y-6 hidden">

            @php
                // Chronological records for charts
                $sortedRecords = $allRecords->sortBy('id')->values();
                $totalVisits = $sortedRecords->count();
                $baselineRecord = $sortedRecords->first();
                $latestRecord = $sortedRecords->last();

                // Quick latest values
                $currSbp = intval($latestRecord->sbp ?? $record->sbp ?? 0);
                $currDbp = intval($latestRecord->dbp ?? $record->dbp ?? 0);
                $currHba1c = floatval($latestRecord->hba1c ?? $record->hba1c ?? 0);
                $currBsf = floatval($latestRecord->bsf ?? $record->bsf ?? 0);
                $currBspp = floatval($latestRecord->bspp ?? $record->bspp ?? 0);
                $currBmi = floatval($latestRecord->bmi ?? $record->bmi ?? 0);
                $currWeight = floatval($latestRecord->weight_kg ?? $record->weight_kg ?? 0);
                $currCreatinine = floatval($latestRecord->creatinine ?? $record->creatinine ?? 0);
                $currEgfr = floatval($latestRecord->egfr ?? $record->egfr ?? 0);

                // Helper to compute SVG graph coordinates
                if (!function_exists('calcSvgChart')) {
                    function calcSvgChart($records, $field, $minDefault = 0, $maxDefault = 100) {
                        $data = [];
                        foreach ($records as $r) {
                            $val = $r->$field;
                            if (!is_null($val) && $val !== '' && is_numeric($val)) {
                                $dateStr = $r->created_at ? $r->created_at->format('d M') : ($r->record_date ? \Carbon\Carbon::parse($r->record_date)->format('d M') : 'V#' . $r->id);
                                $data[] = [
                                    'label' => $dateStr,
                                    'full_date' => $r->created_at ? $r->created_at->format('d M Y') : 'Visit #' . $r->id,
                                    'value' => floatval($val),
                                    'id' => $r->id
                                ];
                            }
                        }
                        if (empty($data)) return null;

                        $values = array_column($data, 'value');
                        $minVal = min($values);
                        $maxVal = max($values);
                        $minY = min($minVal * 0.85, $minDefault);
                        $maxY = max($maxVal * 1.15, $maxDefault);
                        if ($maxY == $minY) { $maxY += 10; $minY = max(0, $minY - 10); }

                        $width = 500;
                        $height = 160;
                        $padX = 45;
                        $padY = 28;
                        $chartW = $width - (2 * $padX);
                        $chartH = $height - (2 * $padY);

                        $count = count($data);
                        $points = [];
                        $svgPoints = [];

                        foreach ($data as $i => $item) {
                            $x = $count > 1 ? $padX + ($i * ($chartW / ($count - 1))) : ($width / 2);
                            $norm = ($item['value'] - $minY) / ($maxY - $minY);
                            $y = ($height - $padY) - ($norm * $chartH);
                            $points[] = [
                                'x' => round($x, 1),
                                'y' => round($y, 1),
                                'label' => $item['label'],
                                'full_date' => $item['full_date'],
                                'value' => $item['value'],
                                'id' => $item['id']
                            ];
                            $svgPoints[] = round($x, 1) . ',' . round($y, 1);
                        }

                        $polylineStr = implode(' ', $svgPoints);
                        $firstX = $points[0]['x'];
                        $lastX = end($points)['x'];
                        $bottomY = $height - $padY;
                        $polygonStr = "{$firstX},{$bottomY} {$polylineStr} {$lastX},{$bottomY}";

                        return [
                            'points' => $points,
                            'polyline' => $polylineStr,
                            'polygon' => $polygonStr,
                            'minY' => round($minY, 1),
                            'maxY' => round($maxY, 1),
                            'latest' => end($data)['value'],
                            'baseline' => $data[0]['value'],
                            'count' => $count
                        ];
                    }
                }

                // Compute SVG chart data for all metrics
                $svgSbp = calcSvgChart($sortedRecords, 'sbp', 60, 180);
                $svgDbp = calcSvgChart($sortedRecords, 'dbp', 40, 110);
                $svgHba1c = calcSvgChart($sortedRecords, 'hba1c', 4, 12);
                $svgBsf = calcSvgChart($sortedRecords, 'bsf', 60, 200);
                $svgBspp = calcSvgChart($sortedRecords, 'bspp', 80, 250);
                $svgBmi = calcSvgChart($sortedRecords, 'bmi', 15, 38);
                $svgWeight = calcSvgChart($sortedRecords, 'weight_kg', 30, 110);
                $svgCreatinine = calcSvgChart($sortedRecords, 'creatinine', 0.4, 3.5);
                $svgEgfr = calcSvgChart($sortedRecords, 'egfr', 20, 120);
                $svgChol = calcSvgChart($sortedRecords, 'chol', 80, 260);
                $svgTg = calcSvgChart($sortedRecords, 'tg', 50, 250);
                $svgHdl = calcSvgChart($sortedRecords, 'hdl', 20, 80);
                $svgLdl = calcSvgChart($sortedRecords, 'ldl', 30, 180);
                $svgSgpt = calcSvgChart($sortedRecords, 'sgpt', 10, 100);
                $svgSgot = calcSvgChart($sortedRecords, 'sgot', 10, 100);
                $svgAlkp = calcSvgChart($sortedRecords, 'alkp', 30, 180);
                $svgHb = calcSvgChart($sortedRecords, 'hb_percent', 6, 18);
                $svgPlt = calcSvgChart($sortedRecords, 'plt', 50, 400);
                $svgTemp = calcSvgChart($sortedRecords, 'temprature', 96, 104);
            @endphp

            <!-- Overview Header Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-7 text-white shadow-xl">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-white/10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 flex items-center gap-1.5">
                                <i class="fas fa-chart-line text-indigo-300"></i> Patient Longitudinal Analytics
                            </span>
                            <span class="text-xs text-slate-400">
                                {{ $totalVisits }} {{ \Illuminate\Support\Str::plural('Consultation', $totalVisits) }} Recorded
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            Patient Health Trends & Trajectory Graphs
                        </h2>
                        <p class="text-xs text-slate-300 mt-1 max-w-2xl">
                            Visual tracking of vitals, blood pressure, glycemic control, kidney function, lipid profile, and liver enzymes across all clinical consultations.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center">
                            <span class="text-[10px] uppercase font-bold text-slate-300 block">Baseline Date</span>
                            <span class="text-xs font-bold text-white">
                                {{ $baselineRecord && $baselineRecord->created_at ? $baselineRecord->created_at->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center">
                            <span class="text-[10px] uppercase font-bold text-slate-300 block">Latest Follow-up</span>
                            <span class="text-xs font-bold text-white">
                                {{ $latestRecord && $latestRecord->created_at ? $latestRecord->created_at->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 4 Quick Key Metric Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Blood Pressure</span>
                        <div class="text-xl sm:text-2xl font-black text-white my-1">
                            {{ $currSbp && $currDbp ? $currSbp . '/' . $currDbp : ($currSbp ? $currSbp : 'N/A') }} <span class="text-[11px] font-normal text-slate-400">mmHg</span>
                        </div>
                        <span class="text-[11px] {{ $currSbp >= 140 ? 'text-red-400 font-bold' : ($currSbp >= 130 ? 'text-amber-400 font-bold' : 'text-emerald-400 font-bold') }}">
                            {{ $currSbp >= 140 ? 'Hypertensive' : ($currSbp >= 130 ? 'Pre-Hypertension' : 'Normal Limit') }}
                        </span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Glycemic (HbA1c)</span>
                        <div class="text-xl sm:text-2xl font-black text-white my-1">
                            {{ $currHba1c ? $currHba1c . '%' : 'N/A' }}
                        </div>
                        <span class="text-[11px] {{ $currHba1c >= 6.5 ? 'text-red-400 font-bold' : ($currHba1c >= 5.7 ? 'text-amber-400 font-bold' : 'text-emerald-400 font-bold') }}">
                            {{ $currHba1c >= 6.5 ? 'Diabetic Range' : ($currHba1c >= 5.7 ? 'Pre-Diabetic' : 'Normal Limit') }}
                        </span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">BMI & Weight</span>
                        <div class="text-xl sm:text-2xl font-black text-white my-1">
                            {{ $currBmi ?: 'N/A' }} <span class="text-[11px] font-normal text-slate-400">{{ $currWeight ? '(' . $currWeight . ' kg)' : '' }}</span>
                        </div>
                        <span class="text-[11px] {{ $currBmi >= 25 ? 'text-red-400 font-bold' : ($currBmi >= 23 ? 'text-amber-400 font-bold' : 'text-emerald-400 font-bold') }}">
                            {{ $currBmi >= 25 ? 'Obese' : ($currBmi >= 23 ? 'Overweight' : 'Normal Weight') }}
                        </span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Renal (Creatinine)</span>
                        <div class="text-xl sm:text-2xl font-black text-white my-1">
                            {{ $currCreatinine ? $currCreatinine : 'N/A' }} <span class="text-[11px] font-normal text-slate-400">{{ $currCreatinine ? 'mg/dL' : '' }}</span>
                        </div>
                        <span class="text-[11px] text-slate-300 font-bold">
                            eGFR: {{ $currEgfr ? $currEgfr . ' mL/min' : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Graph Category Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 bg-white p-2.5 rounded-2xl border border-slate-200 shadow-sm no-print">
                <button type="button" onclick="filterGraphSection('all')" class="graph-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition" data-category="all">
                    All Graphs (8)
                </button>
                <button type="button" onclick="filterGraphSection('vitals')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="vitals">
                    🩺 Blood Pressure & Vitals
                </button>
                <button type="button" onclick="filterGraphSection('diabetes')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="diabetes">
                    🩸 Diabetes & Sugar
                </button>
                <button type="button" onclick="filterGraphSection('weight')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="weight">
                    ⚖️ Weight & BMI
                </button>
                <button type="button" onclick="filterGraphSection('kidney')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="kidney">
                    🧪 Kidney (KFT)
                </button>
                <button type="button" onclick="filterGraphSection('lipid')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="lipid">
                    🫀 Lipids & Cholesterol
                </button>
                <button type="button" onclick="filterGraphSection('liver')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="liver">
                    🧬 Liver Enzymes (LFT)
                </button>
                <button type="button" onclick="filterGraphSection('blood')" class="graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-category="blood">
                    🩸 CBC & Hemoglobin
                </button>
            </div>

            <!-- 8 Clinical Graphs Grid (Native SVG + Vector Visualization) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- 1. Blood Pressure Trajectory Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="vitals">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Blood Pressure Trajectory</h4>
                                <span class="text-xs text-slate-500">Systolic (SBP) & Diastolic (DBP) in mmHg</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex items-center gap-1 text-[11px] font-bold text-red-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> SBP
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-bold text-blue-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> DBP
                            </span>
                        </div>
                    </div>

                    @if($svgSbp && !empty($svgSbp['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <!-- Grid Lines -->
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSbp['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgSbp['minY'] + $svgSbp['maxY'])/2) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSbp['minY'] }}</text>

                                <!-- SBP Target Line (120 mmHg) -->
                                @php
                                    $normT = min(1, max(0, (120 - $svgSbp['minY']) / ($svgSbp['maxY'] - $svgSbp['minY'])));
                                    $targetY = 132 - ($normT * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetY }}" x2="455" y2="{{ $targetY }}" stroke="#10b981" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.8" />
                                <text x="455" y="{{ $targetY - 4 }}" text-anchor="end" font-size="8" fill="#059669" font-weight="bold">Target: ≤ 120/80 mmHg</text>

                                <!-- SBP Area & Polyline -->
                                @if($svgSbp['count'] > 1)
                                    <polygon points="{{ $svgSbp['polygon'] }}" fill="rgba(239, 68, 68, 0.12)" />
                                    <polyline points="{{ $svgSbp['polyline'] }}" fill="none" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                <!-- SBP Points -->
                                @foreach($svgSbp['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#ef4444" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 16 }}" y="{{ $p['y'] - 20 }}" width="32" height="14" rx="4" fill="#ef4444" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No blood pressure records logged yet
                        </div>
                    @endif
                </div>

                <!-- 2. Glycemic Control & Diabetes Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="diabetes">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                                <i class="fas fa-droplet"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Glycemic Control & Diabetes</h4>
                                <span class="text-xs text-slate-500">HbA1c (%) & Fasting Sugar (BSF mg/dL)</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Target: HbA1c &lt; 5.7%</span>
                    </div>

                    @if($svgHba1c && !empty($svgHba1c['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgHba1c['maxY'] }}%</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgHba1c['minY'] + $svgHba1c['maxY'])/2, 1) }}%</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgHba1c['minY'] }}%</text>

                                @php
                                    $normH = min(1, max(0, (5.7 - $svgHba1c['minY']) / ($svgHba1c['maxY'] - $svgHba1c['minY'])));
                                    $targetHbY = 132 - ($normH * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetHbY }}" x2="455" y2="{{ $targetHbY }}" stroke="#10b981" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.8" />
                                <text x="455" y="{{ $targetHbY - 4 }}" text-anchor="end" font-size="8" fill="#059669" font-weight="bold">Normal Cutoff: &lt; 5.7%</text>

                                @if($svgHba1c['count'] > 1)
                                    <polygon points="{{ $svgHba1c['polygon'] }}" fill="rgba(225, 29, 72, 0.12)" />
                                    <polyline points="{{ $svgHba1c['polyline'] }}" fill="none" stroke="#e11d48" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgHba1c['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#e11d48" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#e11d48" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}%</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No HbA1c lab tests recorded yet
                        </div>
                    @endif
                </div>

                <!-- 3. Weight & BMI Trajectory Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="weight">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                <i class="fas fa-weight-scale"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Body Weight & BMI Trajectory</h4>
                                <span class="text-xs text-slate-500">BMI (kg/m²) & Weight (kg) over consultations</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Healthy: &lt; 23 kg/m²</span>
                    </div>

                    @if($svgBmi && !empty($svgBmi['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgBmi['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgBmi['minY'] + $svgBmi['maxY'])/2, 1) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgBmi['minY'] }}</text>

                                @php
                                    $normB = min(1, max(0, (23 - $svgBmi['minY']) / ($svgBmi['maxY'] - $svgBmi['minY'])));
                                    $targetBmiY = 132 - ($normB * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetBmiY }}" x2="455" y2="{{ $targetBmiY }}" stroke="#10b981" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.8" />
                                <text x="455" y="{{ $targetBmiY - 4 }}" text-anchor="end" font-size="8" fill="#059669" font-weight="bold">Normal BMI: &lt; 23 kg/m²</text>

                                @if($svgBmi['count'] > 1)
                                    <polygon points="{{ $svgBmi['polygon'] }}" fill="rgba(245, 158, 11, 0.12)" />
                                    <polyline points="{{ $svgBmi['polyline'] }}" fill="none" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgBmi['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#f59e0b" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#f59e0b" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No BMI or weight measurements recorded yet
                        </div>
                    @endif
                </div>

                <!-- 4. Kidney Function (KFT) Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="kidney">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center font-bold">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Kidney Function (KFT)</h4>
                                <span class="text-xs text-slate-500">Serum Creatinine (mg/dL) & eGFR</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Normal Creat: 0.6 - 1.2</span>
                    </div>

                    @if($svgCreatinine && !empty($svgCreatinine['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgCreatinine['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgCreatinine['minY'] + $svgCreatinine['maxY'])/2, 1) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgCreatinine['minY'] }}</text>

                                @if($svgCreatinine['count'] > 1)
                                    <polygon points="{{ $svgCreatinine['polygon'] }}" fill="rgba(13, 148, 136, 0.12)" />
                                    <polyline points="{{ $svgCreatinine['polyline'] }}" fill="none" stroke="#0d9488" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgCreatinine['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#0d9488" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#0d9488" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No Creatinine renal tests recorded yet
                        </div>
                    @endif
                </div>

                <!-- 5. Lipid Profile & Cholesterol Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="lipid">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Lipid Profile & Cholesterol</h4>
                                <span class="text-xs text-slate-500">Total Cholesterol (mg/dL)</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Target: &lt; 200 mg/dL</span>
                    </div>

                    @if($svgChol && !empty($svgChol['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgChol['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgChol['minY'] + $svgChol['maxY'])/2) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgChol['minY'] }}</text>

                                @if($svgChol['count'] > 1)
                                    <polygon points="{{ $svgChol['polygon'] }}" fill="rgba(37, 99, 235, 0.12)" />
                                    <polyline points="{{ $svgChol['polyline'] }}" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgChol['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#2563eb" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#2563eb" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No Lipid Profile cholesterol records logged yet
                        </div>
                    @endif
                </div>

                <!-- 6. Liver Enzymes (LFT) Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="liver">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                <i class="fas fa-dna"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Liver Function Tests (LFT)</h4>
                                <span class="text-xs text-slate-500">SGPT / ALT Enzymes (U/L)</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Normal SGPT: &lt; 45 U/L</span>
                    </div>

                    @if($svgSgpt && !empty($svgSgpt['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSgpt['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgSgpt['minY'] + $svgSgpt['maxY'])/2) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSgpt['minY'] }}</text>

                                @if($svgSgpt['count'] > 1)
                                    <polygon points="{{ $svgSgpt['polygon'] }}" fill="rgba(16, 185, 129, 0.12)" />
                                    <polyline points="{{ $svgSgpt['polyline'] }}" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgSgpt['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#10b981" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#10b981" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No Liver Function SGPT tests recorded yet
                        </div>
                    @endif
                </div>

                <!-- 7. Complete Blood Count (CBC) Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="blood">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                                <i class="fas fa-vial"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Complete Blood Count (CBC)</h4>
                                <span class="text-xs text-slate-500">Hemoglobin (Hb %)</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Normal Hb: 12 - 16%</span>
                    </div>

                    @if($svgHb && !empty($svgHb['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgHb['maxY'] }}%</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgHb['minY'] + $svgHb['maxY'])/2, 1) }}%</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgHb['minY'] }}%</text>

                                @if($svgHb['count'] > 1)
                                    <polygon points="{{ $svgHb['polygon'] }}" fill="rgba(190, 18, 60, 0.12)" />
                                    <polyline points="{{ $svgHb['polyline'] }}" fill="none" stroke="#be123c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgHb['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#be123c" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#be123c" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}%</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No Hemoglobin blood tests recorded yet
                        </div>
                    @endif
                </div>

                <!-- 8. Body Temperature Log Graph -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="vitals">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                <i class="fas fa-thermometer-half"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Body Temperature Log</h4>
                                <span class="text-xs text-slate-500">Body Temperature (°F)</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Normal: 98.6 °F</span>
                    </div>

                    @if($svgTemp && !empty($svgTemp['points']))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgTemp['maxY'] }}°F</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgTemp['minY'] + $svgTemp['maxY'])/2, 1) }}°F</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgTemp['minY'] }}°F</text>

                                @php
                                    $normT = min(1, max(0, (98.6 - $svgTemp['minY']) / ($svgTemp['maxY'] - $svgTemp['minY'])));
                                    $targetTempY = 132 - ($normT * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetTempY }}" x2="455" y2="{{ $targetTempY }}" stroke="#10b981" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.8" />
                                <text x="455" y="{{ $targetTempY - 4 }}" text-anchor="end" font-size="8" fill="#059669" font-weight="bold">Normal Baseline: 98.6 °F</text>

                                @if($svgTemp['count'] > 1)
                                    <polygon points="{{ $svgTemp['polygon'] }}" fill="rgba(124, 58, 237, 0.12)" />
                                    <polyline points="{{ $svgTemp['polyline'] }}" fill="none" stroke="#7c3aed" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @foreach($svgTemp['points'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.6" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="#ffffff" stroke="#7c3aed" stroke-width="3" />
                                    <rect x="{{ $p['x'] - 18 }}" y="{{ $p['y'] - 20 }}" width="36" height="14" rx="4" fill="#7c3aed" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="9" font-weight="bold" fill="#ffffff">{{ $p['value'] }}°</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No temperature readings recorded yet
                        </div>
                    @endif
                </div>

            </div>

            <!-- Consultation Visit Record Log Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-list-check text-indigo-600"></i>
                        Chronological Consultation Record Log
                    </h3>
                    <div class="flex items-center gap-2.5">
                        <a href="{{ route('patient.export', $patient->id) }}"
                            class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5">
                            <i class="fas fa-file-csv"></i>
                            <span>Export Patient Data (CSV)</span>
                        </a>
                        <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1.5 rounded-xl">
                            {{ $totalVisits }} Recorded Data Point(s)
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 uppercase font-bold text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Consultation Date</th>
                                <th class="px-4 py-3">BP (SBP/DBP)</th>
                                <th class="px-4 py-3">HbA1c</th>
                                <th class="px-4 py-3">Fasting (BSF)</th>
                                <th class="px-4 py-3">BMI / Wt</th>
                                <th class="px-4 py-3">Creatinine</th>
                                <th class="px-4 py-3">SGPT</th>
                                <th class="px-4 py-3">Temp</th>
                                <th class="px-4 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sortedRecords as $vRec)
                                <tr class="hover:bg-slate-50 {{ $vRec->id == $record->id ? 'bg-indigo-50/40 font-semibold' : '' }}">
                                    <td class="px-4 py-3 text-slate-800 font-bold">
                                        {{ $vRec->created_at ? $vRec->created_at->format('d M Y') : 'Visit #' . $vRec->id }}
                                        @if($vRec->id == $record->id)
                                            <span class="ml-1 text-[9px] bg-indigo-600 text-white px-1.5 py-0.5 rounded font-bold">Viewing</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-mono">{{ $vRec->sbp && $vRec->dbp ? $vRec->sbp . '/' . $vRec->dbp : ($vRec->sbp ?: '-') }}</td>
                                    <td class="px-4 py-3">{{ $vRec->hba1c ? $vRec->hba1c . '%' : '-' }}</td>
                                    <td class="px-4 py-3">{{ $vRec->bsf ? $vRec->bsf . ' mg/dL' : '-' }}</td>
                                    <td class="px-4 py-3">{{ $vRec->bmi ? $vRec->bmi : '-' }} {{ $vRec->weight_kg ? '(' . $vRec->weight_kg . 'kg)' : '' }}</td>
                                    <td class="px-4 py-3">{{ $vRec->creatinine ? $vRec->creatinine . ' mg/dL' : '-' }}</td>
                                    <td class="px-4 py-3">{{ $vRec->sgpt ? $vRec->sgpt . ' U/L' : '-' }}</td>
                                    <td class="px-4 py-3">{{ $vRec->temprature ? $vRec->temprature . ' °F' : '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('patient.show', $patient->id) }}?record_id={{ $vRec->id }}"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white transition inline-block">
                                            Inspect Visit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- End of #content-analytics -->

    </div>

    <!-- Scripts for Tab Switching and Category Filter -->
    <script>
        function switchDetailTab(tabName) {
            const profileContent = document.getElementById('content-profile');
            const analyticsContent = document.getElementById('content-analytics');
            const btnProfile = document.getElementById('tab-btn-profile');
            const btnAnalytics = document.getElementById('tab-btn-analytics');

            if (tabName === 'analytics') {
                if (profileContent) profileContent.classList.add('hidden');
                if (analyticsContent) analyticsContent.classList.remove('hidden');

                if (btnProfile) btnProfile.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 transition";
                if (btnAnalytics) btnAnalytics.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-indigo-600 text-indigo-600 transition";
            } else {
                if (analyticsContent) analyticsContent.classList.add('hidden');
                if (profileContent) profileContent.classList.remove('hidden');

                if (btnAnalytics) btnAnalytics.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 transition";
                if (btnProfile) btnProfile.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-indigo-600 text-indigo-600 transition";
            }
        }

        function filterGraphSection(category) {
            document.querySelectorAll('.graph-filter-btn').forEach(btn => {
                if (btn.getAttribute('data-category') === category) {
                    btn.className = "graph-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition";
                } else {
                    btn.className = "graph-filter-btn px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition";
                }
            });

            document.querySelectorAll('.graph-card').forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // Auto-switch to analytics tab if URL contains ?tab=analytics or #graphs
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'analytics' || window.location.hash === '#graphs' || window.location.hash === '#analytics') {
                switchDetailTab('analytics');
            }
        });
    </script>
@endsection
