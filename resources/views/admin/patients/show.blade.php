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
        .print-only {
            display: none;
        }

        @page {
            size: A4 portrait;
            margin: 12mm 10mm 12mm 10mm;
        }

        @media print {
            /* 1. Reset Root & Document Constraints */
            html, body {
                height: auto !important;
                min-height: 100% !important;
                overflow: visible !important;
                background: #ffffff !important;
                color: #0f172a !important;
                font-size: 11px !important;
                line-height: 1.35 !important;
            }

            /* 2. Unconstrain all layout wrappers from master layout */
            .flex.h-screen,
            .h-screen,
            .overflow-hidden,
            .overflow-y-auto,
            div[class*="h-screen"],
            main {
                height: auto !important;
                min-height: auto !important;
                max-height: none !important;
                overflow: visible !important;
                position: static !important;
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }

            /* 3. Hide all non-printable UI elements */
            aside,
            nav,
            header,
            footer,
            topbar,
            .no-print,
            button,
            #tab-btn-profile,
            #tab-btn-analytics,
            .graph-filter-btn {
                display: none !important;
            }

            /* 4. Display print-only elements */
            .print-only {
                display: block !important;
            }

            /* 5. Force exact ink and background colors */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* 6. Ensure Clinical Profile is always displayed on print */
            #content-profile {
                display: block !important;
            }

            /* 7. Avoid cutting cards across pages awkwardly */
            .detail-card,
            .rounded-2xl,
            .rounded-3xl,
            section,
            table,
            tr {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                box-shadow: none !important;
            }

            /* 8. Refined card borders for print */
            .detail-card {
                border: 1px solid #94a3b8 !important;
                border-radius: 6px !important;
                padding: 10px 14px !important;
                margin-bottom: 12px !important;
                background: #ffffff !important;
            }

            .detail-card-header {
                border-bottom: 1.5px solid #0f172a !important;
                padding-bottom: 5px !important;
                margin-bottom: 8px !important;
                font-size: 12px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
            }

            /* 9. Patient Master Identity Card print optimization */
            .bg-gradient-to-r {
                background: #0f172a !important;
                color: #ffffff !important;
                border: 1.5px solid #334155 !important;
                border-radius: 8px !important;
                padding: 12px 16px !important;
                margin-bottom: 12px !important;
            }

            /* 10. Table styling for multi-page print */
            .table-wrap, .overflow-x-auto {
                overflow: visible !important;
                width: 100% !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            th, td {
                padding: 3px 6px !important;
                font-size: 10px !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>

@php
    $record = $record ?? new \App\Models\PatientClinicalRecord(['patient_id' => $patient->id ?? 0]);
    $allRecords = $allRecords ?? ($patient && method_exists($patient, 'clinicalRecords') ? $patient->clinicalRecords()->orderBy('created_at', 'desc')->get() : collect());
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
                    </h1>
                    <p class="text-xs text-slate-500">Comprehensive patient history and clinical laboratory details</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="switchDetailTab('analytics')"
                    class="px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold flex items-center gap-1.5 border border-indigo-200 shadow-sm transition">
                    <i class="fas fa-chart-line text-indigo-600"></i> Health Trends & Graphs
                </button>

                <button type="button" onclick="window.print()"
                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition">
                    <i class="fas fa-print"></i> Print Profile
                </button>

                <a href="{{ route('addnewReport', $patient->id) }}"
                    class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-sm hover:shadow transition">
                    <i class="fas fa-plus-circle"></i> Add Follow-up Visit
                </a>

                <a href="{{ route('patient.edit', $patient->id ?? $record->patient_id) }}?record_id={{ $record->id }}"
                    class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 shadow-sm hover:shadow transition">
                    <i class="fas fa-edit"></i> Edit Record
                </a>
            </div>
        </div>

        <!-- Print-Only Medical Header -->
        <div class="print-only border-b-2 border-slate-800 pb-3 mb-4">
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">RCDHO CLINICAL REPORT</h1>
                    <p class="text-xs font-medium text-slate-600">Research Centre for Diabetes, Hypertension and Obesity</p>
                </div>
                <div class="text-right">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Patient Reg. No:</span>
                        <span class="text-base font-black font-mono text-slate-900 ml-1">{{ $patient->registration_no ?? 'ID #' . ($patient->id ?? $record->patient_id) }}</span>
                    </div>
                    @if(!empty($patient->follow_up_reg_no))
                        <div class="mt-0.5">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Follow-up Reg:</span>
                            <span class="text-sm font-black font-mono text-indigo-900 ml-1">{{ $patient->follow_up_reg_no }}</span>
                        </div>
                    @endif
                </div>
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
                        <!-- Patient Name & Category Badges -->
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

                        <!-- Demographics: Age, Guardian, Reg Date, Mobile -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-1.5 text-xs text-slate-300 mt-2">
                            <div>
                                <span class="text-slate-400">Age:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->age ? $patient->age . ' yrs' : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Guardian:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->father_husband_name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Reg Date:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->record_date ? \Carbon\Carbon::parse($patient->record_date)->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Mobile:</span>
                                <span class="font-semibold text-white ml-1">{{ $patient->mobile_no ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Registration Numbers: Below Age, Guardian, Reg Date -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1.5 text-xs text-slate-300 mt-2 pt-2 border-t border-white/10">
                            <div>
                                <span class="text-slate-400">Reg No:</span>
                                <span class="font-mono font-bold text-amber-300 ml-1">{{ $patient->registration_no ?? 'ID #' . ($patient->id ?? $record->patient_id) }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">Follow-up Reg No:</span>
                                <span class="font-mono font-bold {{ !empty($patient->follow_up_reg_no) ? 'text-purple-300' : 'text-slate-400' }} ml-1">
                                    {{ $patient->follow_up_reg_no ?: 'None' }}
                                </span>
                            </div>
                        </div>

                        @if(!empty($patient->address) || !empty($patient->mail))
                            <div class="mt-2 text-xs text-slate-300 flex flex-wrap items-center gap-4">
                                @if(!empty($patient->address))
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-indigo-400"></i>
                                        <span>{{ $patient->address }}</span>
                                    </div>
                                @endif
                                @if(!empty($patient->mail))
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-envelope text-indigo-400"></i>
                                        <a href="mailto:{{ $patient->mail }}" class="text-indigo-300 hover:text-indigo-100 hover:underline">{{ $patient->mail }}</a>
                                    </div>
                                @endif
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
                    <button type="button" onclick="switchDetailTab('analytics')" class="text-[11px] text-indigo-300 hover:text-white transition flex items-center gap-1 cursor-pointer">
                        <i class="fas fa-chart-line text-[10px]"></i>
                        <span>{{ $allRecords->count() }} visit records • View Trends &rarr;</span>
                    </button>
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
                <span class="ml-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-50 text-indigo-600 border border-indigo-200">
                    {{ $allRecords->count() }} {{ \Illuminate\Support\Str::plural('Visit', $allRecords->count()) }}
                </span>
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
                    elseif ($bmiVal > 0 && $bmiVal < 18.5) $bmiBg = 'bg-blue-50 text-blue-700 border-blue-200';
                @endphp
            <div class="p-4 rounded-2xl border {{ $bmiBg }} flex flex-col justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider">BMI (kg/m²)</span>
                <div class="my-1">
                    <span class="text-xl sm:text-2xl font-black">{{ $record->bmi ?: 'N/A' }}</span>
                </div>
                <span class="text-xs font-semibold">{{ $record->bmi_group ?: ($bmiVal >= 25 ? 'Obese' : ($bmiVal >= 23 ? 'Overweight' : ($bmiVal > 0 && $bmiVal < 18.5 ? 'Underweight' : 'Normal'))) }}</span>
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
                                {{ $record->start_insulin_date ? \Carbon\Carbon::parse($record->start_insulin_date)->format('d/m/Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Stop Insulin Date:</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $record->stop_insulin_date ? \Carbon\Carbon::parse($record->stop_insulin_date)->format('d/m/Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Injectables:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->insuline_brand ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Insulin Unit:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->insuline_unit ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">C PEPTIDE:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->c_peptide ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-xs text-slate-600 font-medium">Insulin Antibodies:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->insulin_antibodies ?: 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Mody Biomarkers:</span>
                            <span class="text-xs font-bold text-slate-800">{{ $record->mody_biomarkers ?: 'N/A' }}</span>
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
            <!-- End of .overflow-x-auto -->

            <!-- Print Footer -->
            <div class="print-only mt-8 pt-4 border-t-2 border-slate-700 text-xs text-slate-700">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="font-bold">RCDHO (DrMukherjeeS Clinic Pvt. Ltd.)</span> • Comprehensive Clinical Profile
                    </div>
                    <div>
                        <span class="font-bold">Patient Reg No:</span> <span class="font-mono font-bold">{{ $patient->registration_no ?? 'ID #' . $patient->id }}</span>
                        @if(!empty($patient->follow_up_reg_no))
                            <span class="ml-2 font-bold">| Follow-up Reg:</span> <span class="font-mono font-bold">{{ $patient->follow_up_reg_no }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-bold">Printed:</span> {{ date('d M Y, h:i A') }}
                    </div>
                </div>
            </div>
        </div>
        <!-- End of All Records Card -->

    </div>
    <!-- End of #content-profile -->

    <!-- Patient Health Trends & Graphs Content -->
    <div id="content-analytics" class="space-y-6 hidden">

            @php
                // Chronological records for charts (strictly ordered by record_date)
                $sortedRecords = $allRecords->sortBy(function($r) {
                    return $r->record_date ? \Carbon\Carbon::parse($r->record_date)->timestamp : ($r->created_at ? $r->created_at->timestamp : $r->id);
                })->values();
                $totalVisits = $sortedRecords->count();
                $baselineRecord = $sortedRecords->first();
                $latestRecord = $sortedRecords->last();

                // Helper to compute SVG graph coordinates
                if (!function_exists('calcSvgChart')) {
                    function calcSvgChart($records, $field, $minDefault = 0, $maxDefault = 100) {
                        $data = [];
                        foreach ($records as $r) {
                            $val = $r->$field;
                            if (!is_null($val) && $val !== '') {
                                $numVal = null;
                                if (is_numeric($val)) {
                                    $numVal = floatval($val);
                                } elseif (preg_match('/^(\d+(?:\.\d+)?)/', trim((string)$val), $m)) {
                                    $numVal = floatval($m[1]);
                                }
                                if ($numVal !== null) {
                                    $vDate = $r->record_date ? \Carbon\Carbon::parse($r->record_date) : $r->created_at;
                                    $dateStr = $vDate ? $vDate->format('d M') : 'V#' . $r->id;
                                    $fullDate = $vDate ? $vDate->format('d M Y') : 'Visit #' . $r->id;
                                    $data[] = [
                                        'label' => $dateStr,
                                        'full_date' => $fullDate,
                                        'value' => $numVal,
                                        'id' => $r->id
                                    ];
                                }
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

                // Dual Series Helper for Blood Pressure (SBP & DBP)
                if (!function_exists('calcSvgBpChart')) {
                    function calcSvgBpChart($records) {
                        $data = [];
                        $allValues = [];
                        foreach ($records as $r) {
                            $sbp = null;
                            $dbp = null;
                            if (!is_null($r->sbp) && $r->sbp !== '') {
                                if (is_numeric($r->sbp)) $sbp = floatval($r->sbp);
                                elseif (preg_match('/^(\d+(?:\.\d+)?)/', trim((string)$r->sbp), $m)) $sbp = floatval($m[1]);
                            }
                            if (!is_null($r->dbp) && $r->dbp !== '') {
                                if (is_numeric($r->dbp)) $dbp = floatval($r->dbp);
                                elseif (preg_match('/^(\d+(?:\.\d+)?)/', trim((string)$r->dbp), $m)) $dbp = floatval($m[1]);
                            }
                            if ($sbp !== null || $dbp !== null) {
                                if ($sbp !== null) $allValues[] = $sbp;
                                if ($dbp !== null) $allValues[] = $dbp;
                                $vDate = $r->record_date ? \Carbon\Carbon::parse($r->record_date) : $r->created_at;
                                $data[] = [
                                    'label' => $vDate ? $vDate->format('d M') : 'V#' . $r->id,
                                    'full_date' => $vDate ? $vDate->format('d M Y') : 'Visit #' . $r->id,
                                    'sbp' => $sbp,
                                    'dbp' => $dbp,
                                    'id' => $r->id
                                ];
                            }
                        }
                        if (empty($data) || empty($allValues)) return null;

                        $minVal = min($allValues);
                        $maxVal = max($allValues);
                        $minY = min($minVal * 0.85, 40);
                        $maxY = max($maxVal * 1.15, 180);
                        if ($maxY == $minY) { $maxY += 10; $minY = max(0, $minY - 10); }

                        $width = 500;
                        $height = 160;
                        $padX = 45;
                        $padY = 28;
                        $chartW = $width - (2 * $padX);
                        $chartH = $height - (2 * $padY);

                        $count = count($data);
                        $sbpPoints = [];
                        $dbpPoints = [];
                        $svgSbpPoints = [];
                        $svgDbpPoints = [];

                        foreach ($data as $i => $item) {
                            $x = $count > 1 ? $padX + ($i * ($chartW / ($count - 1))) : ($width / 2);
                            if ($item['sbp'] !== null) {
                                $normS = ($item['sbp'] - $minY) / ($maxY - $minY);
                                $yS = ($height - $padY) - ($normS * $chartH);
                                $sbpPoints[] = [
                                    'x' => round($x, 1),
                                    'y' => round($yS, 1),
                                    'label' => $item['label'],
                                    'full_date' => $item['full_date'],
                                    'value' => $item['sbp'],
                                    'id' => $item['id']
                                ];
                                $svgSbpPoints[] = round($x, 1) . ',' . round($yS, 1);
                            }
                            if ($item['dbp'] !== null) {
                                $normD = ($item['dbp'] - $minY) / ($maxY - $minY);
                                $yD = ($height - $padY) - ($normD * $chartH);
                                $dbpPoints[] = [
                                    'x' => round($x, 1),
                                    'y' => round($yD, 1),
                                    'label' => $item['label'],
                                    'full_date' => $item['full_date'],
                                    'value' => $item['dbp'],
                                    'id' => $item['id']
                                ];
                                $svgDbpPoints[] = round($x, 1) . ',' . round($yD, 1);
                            }
                        }

                        return [
                            'sbpPoints' => $sbpPoints,
                            'dbpPoints' => $dbpPoints,
                            'sbpPolyline' => implode(' ', $svgSbpPoints),
                            'dbpPolyline' => implode(' ', $svgDbpPoints),
                            'minY' => round($minY, 1),
                            'maxY' => round($maxY, 1),
                            'count' => $count
                        ];
                    }
                }

                // Dual Series Helper for Blood Sugar (Fasting BSF & Postprandial BSPP)
                if (!function_exists('calcSvgSugarChart')) {
                    function calcSvgSugarChart($records) {
                        $data = [];
                        $allValues = [];
                        foreach ($records as $r) {
                            $bsf = null;
                            $bspp = null;
                            if (!is_null($r->bsf) && $r->bsf !== '') {
                                if (is_numeric($r->bsf)) $bsf = floatval($r->bsf);
                                elseif (preg_match('/^(\d+(?:\.\d+)?)/', trim((string)$r->bsf), $m)) $bsf = floatval($m[1]);
                            }
                            if (!is_null($r->bspp) && $r->bspp !== '') {
                                if (is_numeric($r->bspp)) $bspp = floatval($r->bspp);
                                elseif (preg_match('/^(\d+(?:\.\d+)?)/', trim((string)$r->bspp), $m)) $bspp = floatval($m[1]);
                            }
                            if ($bsf !== null || $bspp !== null) {
                                if ($bsf !== null) $allValues[] = $bsf;
                                if ($bspp !== null) $allValues[] = $bspp;
                                $vDate = $r->record_date ? \Carbon\Carbon::parse($r->record_date) : $r->created_at;
                                $data[] = [
                                    'label' => $vDate ? $vDate->format('d M') : 'V#' . $r->id,
                                    'full_date' => $vDate ? $vDate->format('d M Y') : 'Visit #' . $r->id,
                                    'bsf' => $bsf,
                                    'bspp' => $bspp,
                                    'id' => $r->id
                                ];
                            }
                        }
                        if (empty($data) || empty($allValues)) return null;

                        $minVal = min($allValues);
                        $maxVal = max($allValues);
                        $minY = min($minVal * 0.85, 60);
                        $maxY = max($maxVal * 1.15, 200);
                        if ($maxY == $minY) { $maxY += 10; $minY = max(0, $minY - 10); }

                        $width = 500;
                        $height = 160;
                        $padX = 45;
                        $padY = 28;
                        $chartW = $width - (2 * $padX);
                        $chartH = $height - (2 * $padY);

                        $count = count($data);
                        $bsfPoints = [];
                        $bsppPoints = [];
                        $svgBsfPoints = [];
                        $svgBsppPoints = [];

                        foreach ($data as $i => $item) {
                            $x = $count > 1 ? $padX + ($i * ($chartW / ($count - 1))) : ($width / 2);
                            if ($item['bsf'] !== null) {
                                $normF = ($item['bsf'] - $minY) / ($maxY - $minY);
                                $yF = ($height - $padY) - ($normF * $chartH);
                                $bsfPoints[] = [
                                    'x' => round($x, 1),
                                    'y' => round($yF, 1),
                                    'label' => $item['label'],
                                    'full_date' => $item['full_date'],
                                    'value' => $item['bsf'],
                                    'id' => $item['id']
                                ];
                                $svgBsfPoints[] = round($x, 1) . ',' . round($yF, 1);
                            }
                            if ($item['bspp'] !== null) {
                                $normP = ($item['bspp'] - $minY) / ($maxY - $minY);
                                $yP = ($height - $padY) - ($normP * $chartH);
                                $bsppPoints[] = [
                                    'x' => round($x, 1),
                                    'y' => round($yP, 1),
                                    'label' => $item['label'],
                                    'full_date' => $item['full_date'],
                                    'value' => $item['bspp'],
                                    'id' => $item['id']
                                ];
                                $svgBsppPoints[] = round($x, 1) . ',' . round($yP, 1);
                            }
                        }

                        return [
                            'bsfPoints' => $bsfPoints,
                            'bsppPoints' => $bsppPoints,
                            'bsfPolyline' => implode(' ', $svgBsfPoints),
                            'bsppPolyline' => implode(' ', $svgBsppPoints),
                            'minY' => round($minY, 1),
                            'maxY' => round($maxY, 1),
                            'count' => $count
                        ];
                    }
                }

                // Compute SVG chart data for all metrics
                $svgBp = calcSvgBpChart($sortedRecords);
                $svgSugar = calcSvgSugarChart($sortedRecords);
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

            <!-- Graph Category Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 bg-white p-2.5 rounded-2xl border border-slate-200 shadow-sm no-print">
                <button type="button" onclick="filterGraphSection('all')" class="graph-filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition" data-category="all">
                    All Graphs (9)
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

            <!-- Clinical Graphs Grid (Native SVG + Vector Visualization) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- 1. Blood Pressure Trajectory Graph (SBP & DBP) -->
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

                    @if($svgBp && (!empty($svgBp['sbpPoints']) || !empty($svgBp['dbpPoints'])))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <!-- Grid Lines -->
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgBp['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgBp['minY'] + $svgBp['maxY'])/2) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgBp['minY'] }}</text>

                                <!-- Target Lines: SBP ≤ 120, DBP ≤ 80 -->
                                @php
                                    $normSbpT = min(1, max(0, (120 - $svgBp['minY']) / ($svgBp['maxY'] - $svgBp['minY'])));
                                    $targetSbpY = 132 - ($normSbpT * 104);
                                    $normDbpT = min(1, max(0, (80 - $svgBp['minY']) / ($svgBp['maxY'] - $svgBp['minY'])));
                                    $targetDbpY = 132 - ($normDbpT * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetSbpY }}" x2="455" y2="{{ $targetSbpY }}" stroke="#ef4444" stroke-width="1" stroke-dasharray="3,3" opacity="0.5" />
                                <line x1="45" y1="{{ $targetDbpY }}" x2="455" y2="{{ $targetDbpY }}" stroke="#3b82f6" stroke-width="1" stroke-dasharray="3,3" opacity="0.5" />
                                <text x="455" y="{{ $targetSbpY - 3 }}" text-anchor="end" font-size="8" fill="#ef4444" font-weight="bold">Target SBP: ≤120</text>
                                <text x="455" y="{{ $targetDbpY + 8 }}" text-anchor="end" font-size="8" fill="#3b82f6" font-weight="bold">Target DBP: ≤80</text>

                                <!-- Polylines -->
                                @if($svgBp['count'] > 1)
                                    @if(!empty($svgBp['sbpPolyline']))
                                        <polyline points="{{ $svgBp['sbpPolyline'] }}" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                    @if(!empty($svgBp['dbpPolyline']))
                                        <polyline points="{{ $svgBp['dbpPolyline'] }}" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                @endif

                                <!-- SBP Points & Vertical Drop Lines -->
                                @foreach($svgBp['sbpPoints'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.5" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#ffffff" stroke="#ef4444" stroke-width="2.5" />
                                    <rect x="{{ $p['x'] - 14 }}" y="{{ $p['y'] - 18 }}" width="28" height="13" rx="3" fill="#ef4444" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 8 }}" text-anchor="middle" font-size="8" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach

                                <!-- DBP Points -->
                                @foreach($svgBp['dbpPoints'] as $p)
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#ffffff" stroke="#3b82f6" stroke-width="2.5" />
                                    <rect x="{{ $p['x'] - 14 }}" y="{{ $p['y'] + 6 }}" width="28" height="13" rx="3" fill="#3b82f6" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] + 16 }}" text-anchor="middle" font-size="8" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No blood pressure records logged yet
                        </div>
                    @endif
                </div>

                <!-- 2. Blood Sugar Trajectory Graph (BSF & BSPP) -->
                <div class="graph-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm" data-category="diabetes">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                <i class="fas fa-droplet"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Blood Sugar Trajectory</h4>
                                <span class="text-xs text-slate-500">Fasting (BSF) & Postprandial (BSPP) in mg/dL</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex items-center gap-1 text-[11px] font-bold text-amber-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> BSF
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-bold text-purple-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> BSPP
                            </span>
                        </div>
                    </div>

                    @if($svgSugar && (!empty($svgSugar['bsfPoints']) || !empty($svgSugar['bsppPoints'])))
                        <div class="relative w-full overflow-hidden bg-slate-50/50 rounded-xl p-3 border border-slate-100">
                            <svg viewBox="0 0 500 160" class="w-full h-44 drop-shadow-sm select-none" preserveAspectRatio="none">
                                <!-- Grid Lines -->
                                <line x1="45" y1="28" x2="455" y2="28" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="32" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSugar['maxY'] }}</text>

                                <line x1="45" y1="80" x2="455" y2="80" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3,3" />
                                <text x="40" y="84" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ round(($svgSugar['minY'] + $svgSugar['maxY'])/2) }}</text>

                                <line x1="45" y1="132" x2="455" y2="132" stroke="#e2e8f0" stroke-width="1" />
                                <text x="40" y="136" text-anchor="end" font-size="9" fill="#94a3b8" font-family="monospace">{{ $svgSugar['minY'] }}</text>

                                <!-- Target Lines: BSF ≤ 100, BSPP ≤ 140 -->
                                @php
                                    $normBsfT = min(1, max(0, (100 - $svgSugar['minY']) / ($svgSugar['maxY'] - $svgSugar['minY'])));
                                    $targetBsfY = 132 - ($normBsfT * 104);
                                    $normBsppT = min(1, max(0, (140 - $svgSugar['minY']) / ($svgSugar['maxY'] - $svgSugar['minY'])));
                                    $targetBsppY = 132 - ($normBsppT * 104);
                                @endphp
                                <line x1="45" y1="{{ $targetBsfY }}" x2="455" y2="{{ $targetBsfY }}" stroke="#f59e0b" stroke-width="1" stroke-dasharray="3,3" opacity="0.5" />
                                <line x1="45" y1="{{ $targetBsppY }}" x2="455" y2="{{ $targetBsppY }}" stroke="#a855f7" stroke-width="1" stroke-dasharray="3,3" opacity="0.5" />
                                <text x="455" y="{{ $targetBsfY - 3 }}" text-anchor="end" font-size="8" fill="#d97706" font-weight="bold">Target BSF: ≤100</text>
                                <text x="455" y="{{ $targetBsppY + 8 }}" text-anchor="end" font-size="8" fill="#9333ea" font-weight="bold">Target BSPP: ≤140</text>

                                <!-- Polylines -->
                                @if($svgSugar['count'] > 1)
                                    @if(!empty($svgSugar['bsfPolyline']))
                                        <polyline points="{{ $svgSugar['bsfPolyline'] }}" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                    @if(!empty($svgSugar['bsppPolyline']))
                                        <polyline points="{{ $svgSugar['bsppPolyline'] }}" fill="none" stroke="#a855f7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                @endif

                                <!-- BSF Points & Drop Lines -->
                                @foreach($svgSugar['bsfPoints'] as $p)
                                    <line x1="{{ $p['x'] }}" y1="{{ $p['y'] }}" x2="{{ $p['x'] }}" y2="132" stroke="#cbd5e1" stroke-width="1" stroke-dasharray="2,2" opacity="0.5" />
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#ffffff" stroke="#f59e0b" stroke-width="2.5" />
                                    <rect x="{{ $p['x'] - 14 }}" y="{{ $p['y'] - 18 }}" width="28" height="13" rx="3" fill="#f59e0b" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] - 8 }}" text-anchor="middle" font-size="8" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                    <text x="{{ $p['x'] }}" y="148" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold">{{ $p['label'] }}</text>
                                @endforeach

                                <!-- BSPP Points -->
                                @foreach($svgSugar['bsppPoints'] as $p)
                                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4.5" fill="#ffffff" stroke="#a855f7" stroke-width="2.5" />
                                    <rect x="{{ $p['x'] - 14 }}" y="{{ $p['y'] + 6 }}" width="28" height="13" rx="3" fill="#a855f7" />
                                    <text x="{{ $p['x'] }}" y="{{ $p['y'] + 16 }}" text-anchor="middle" font-size="8" font-weight="bold" fill="#ffffff">{{ $p['value'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    @else
                        <div class="h-44 flex items-center justify-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            No blood sugar (BSF/BSPP) records logged yet
                        </div>
                    @endif
                </div>

                <!-- 3. Glycemic Control & Diabetes Graph -->
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
                                        {{ $vRec->record_date ? \Carbon\Carbon::parse($vRec->record_date)->format('d M Y') : ($vRec->created_at ? $vRec->created_at->format('d M Y') : 'Visit #' . $vRec->id) }}
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

                if (window.location.hash !== '#analytics') {
                    if (history.replaceState) {
                        history.replaceState(null, null, '#analytics');
                    } else {
                        window.location.hash = '#analytics';
                    }
                }
            } else {
                if (analyticsContent) analyticsContent.classList.add('hidden');
                if (profileContent) profileContent.classList.remove('hidden');

                if (btnAnalytics) btnAnalytics.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 transition";
                if (btnProfile) btnProfile.className = "px-5 py-3 text-sm font-bold flex items-center gap-2 border-b-2 border-indigo-600 text-indigo-600 transition";

                if (window.location.hash === '#analytics' || window.location.hash === '#graphs') {
                    if (history.replaceState) {
                        history.replaceState(null, null, '#profile');
                    } else {
                        window.location.hash = '#profile';
                    }
                }
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

        // Auto-switch to analytics tab if URL contains ?tab=analytics or #graphs or #analytics
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'analytics' || window.location.hash === '#graphs' || window.location.hash === '#analytics') {
                switchDetailTab('analytics');
            }
        });

        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#analytics' || window.location.hash === '#graphs') {
                switchDetailTab('analytics');
            } else if (window.location.hash === '#profile') {
                switchDetailTab('profile');
            }
        });
    </script>
@endsection
