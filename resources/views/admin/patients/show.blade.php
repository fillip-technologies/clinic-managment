@extends('admin.loyout.master')
@section('content')

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
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Stop Insulin Date:</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $record->stop_insulin_date ? \Carbon\Carbon::parse($record->stop_insulin_date)->format('d M Y') : 'N/A' }}
                            </span>
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
                            <a href="{{ asset('storage/' . $record->attachment) }}" target="_blank"
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
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-history text-indigo-600"></i>
                    All Consultation & Visit History for {{ $patient->patient_name ?? 'this patient' }}
                </h3>
                <span class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-bold">
                    {{ $allRecords->count() }} Visit(s) Recorded
                </span>
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
    </div>

@endsection
