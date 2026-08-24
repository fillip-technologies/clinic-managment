@extends('admin.loyout.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-7 max-w-7xl mx-auto pb-10">

        <!-- Page Header & Diagnostic Matrix Reference Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-white/10 relative z-10">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 flex items-center gap-1.5">
                            <i class="fas fa-microscope text-indigo-300"></i> Medical Research & Disease Analytics
                        </span>
                        <span class="text-xs text-slate-400">
                            Population Health Cohort Analysis
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Epidemiological & Disease Matrix Analytics
                    </h1>
                    <p class="text-xs text-slate-300 mt-1 max-w-2xl">
                        Comprehensive disease prevalence, pre-condition early detection, multi-morbidity cross-tabulation, and clinical research metrics based on standardized diagnostic criteria.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center">
                        <span class="text-[10px] uppercase font-bold text-slate-300 block">Total Patients</span>
                        <span class="text-lg font-black text-white">{{ $totalPatients }}</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center">
                        <span class="text-[10px] uppercase font-bold text-slate-300 block">Clinical Records</span>
                        <span class="text-lg font-black text-white">{{ $totalConsultations }}</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center">
                        <span class="text-[10px] uppercase font-bold text-slate-300 block">Multi-Morbidity</span>
                        <span class="text-lg font-black text-amber-300">
                            {{ $totalConsultations > 0 ? round(($multiMorbidity / $totalConsultations) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Diagnostic Matrix Reference Box (Direct from Clinical Diagnostic Criteria) -->
            <div class="mt-6 pt-2">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-indigo-200 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fas fa-table text-indigo-400"></i> Standardized Diagnostic Parameter Matrix Reference
                    </span>
                    <span class="text-[11px] text-slate-400">Clinical Cut-off Guidelines</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-amber-300 block">Pre-Diabetes</span>
                        <p class="text-xs text-white font-semibold mt-0.5">HbA1c 5.7% - 6.4%</p>
                        <span class="text-[10px] text-slate-400">BSF 100-125 mg/dL</span>
                    </div>
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-red-400 block">Diabetes</span>
                        <p class="text-xs text-white font-semibold mt-0.5">HbA1c &gt; 6.5%</p>
                        <span class="text-[10px] text-slate-400">BSF &ge; 126 mg/dL</span>
                    </div>
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-amber-300 block">Pre-Hypertension</span>
                        <p class="text-xs text-white font-semibold mt-0.5">SBP &gt; 130 mmHg</p>
                        <span class="text-[10px] text-slate-400">DBP 85-89 mmHg</span>
                    </div>
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-red-400 block">Hypertension</span>
                        <p class="text-xs text-white font-semibold mt-0.5">SBP &gt; 140 / DBP &gt; 90</p>
                        <span class="text-[10px] text-slate-400">Stage 1 & 2 HTN</span>
                    </div>
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-emerald-400 block">Obesity</span>
                        <p class="text-xs text-white font-semibold mt-0.5">BMI &gt; 25.0 kg/m²</p>
                        <span class="text-[10px] text-slate-400">Overweight 23-24.9</span>
                    </div>
                    <div class="bg-white/5 hover:bg-white/10 transition p-3 rounded-xl border border-white/10">
                        <span class="text-[10px] font-bold uppercase text-purple-400 block">Infection / Fever</span>
                        <p class="text-xs text-white font-semibold mt-0.5">Temp &gt; 99.4 °F</p>
                        <span class="text-[10px] text-slate-400">Acute Infection</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Core Disease Spectrum Analysis Cards (Stratified by Pre-Condition vs Disease) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- 1. Glycemic Spectrum (Diabetes & Pre-Diabetes) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold">
                            <i class="fas fa-droplet text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Glycemic Spectrum</h3>
                            <span class="text-[11px] text-slate-500">HbA1c & Fasting Glucose</span>
                        </div>
                    </div>
                    <span class="text-xs font-black px-2 py-0.5 rounded-full bg-rose-50 text-rose-700">
                        {{ $diabetes + $preDiabetes }}/{{ $totalConsultations }}
                    </span>
                </div>

                <div class="space-y-2.5 my-3">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-red-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> Diabetes (HbA1c &gt; 6.5%)
                            </span>
                            <span class="font-bold text-slate-700">{{ $diabetes }} ({{ $totalConsultations > 0 ? round(($diabetes / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($diabetes / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-amber-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pre-Diabetes (5.7 - 6.4%)
                            </span>
                            <span class="font-bold text-slate-700">{{ $preDiabetes }} ({{ $totalConsultations > 0 ? round(($preDiabetes / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($preDiabetes / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-emerald-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Normoglycemic (&lt; 5.7%)
                            </span>
                            <span class="font-bold text-slate-700">{{ $normalGlycemic }} ({{ $totalConsultations > 0 ? round(($normalGlycemic / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($normalGlycemic / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-2.5 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                    <span>Clinical Risk:</span>
                    <span class="font-bold {{ $diabetes > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $totalConsultations > 0 ? round((($diabetes + $preDiabetes) / $totalConsultations) * 100, 1) : 0 }}% Affected
                    </span>
                </div>
            </div>

            <!-- 2. Blood Pressure Spectrum (Hypertension & Pre-HTN) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                            <i class="fas fa-heart-pulse text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Blood Pressure</h3>
                            <span class="text-[11px] text-slate-500">Systolic & Diastolic mmHg</span>
                        </div>
                    </div>
                    <span class="text-xs font-black px-2 py-0.5 rounded-full bg-red-50 text-red-700">
                        {{ $hypertension + $preHypertension }}/{{ $totalConsultations }}
                    </span>
                </div>

                <div class="space-y-2.5 my-3">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-red-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> HTN (SBP &gt; 140 / DBP &gt; 90)
                            </span>
                            <span class="font-bold text-slate-700">{{ $hypertension }} ({{ $totalConsultations > 0 ? round(($hypertension / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($hypertension / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-amber-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pre-HTN (130-139 mmHg)
                            </span>
                            <span class="font-bold text-slate-700">{{ $preHypertension }} ({{ $totalConsultations > 0 ? round(($preHypertension / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($preHypertension / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-emerald-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Normal BP (&le; 120/80)
                            </span>
                            <span class="font-bold text-slate-700">{{ $normalBp }} ({{ $totalConsultations > 0 ? round(($normalBp / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($normalBp / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-2.5 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                    <span>Vascular Burden:</span>
                    <span class="font-bold {{ $hypertension > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $totalConsultations > 0 ? round((($hypertension + $preHypertension) / $totalConsultations) * 100, 1) : 0 }}% Elevated
                    </span>
                </div>
            </div>

            <!-- 3. Anthropometric & Obesity Spectrum -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                            <i class="fas fa-weight-scale text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Obesity & Adiposity</h3>
                            <span class="text-[11px] text-slate-500">BMI kg/m² (Asian Standards)</span>
                        </div>
                    </div>
                    <span class="text-xs font-black px-2 py-0.5 rounded-full bg-amber-50 text-amber-700">
                        {{ $obese + $overweight }}/{{ $totalConsultations }}
                    </span>
                </div>

                <div class="space-y-2.5 my-3">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-red-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> Obese (BMI &gt; 25.0)
                            </span>
                            <span class="font-bold text-slate-700">{{ $obese }} ({{ $totalConsultations > 0 ? round(($obese / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($obese / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-amber-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Overweight (23.0 - 24.9)
                            </span>
                            <span class="font-bold text-slate-700">{{ $overweight }} ({{ $totalConsultations > 0 ? round(($overweight / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($overweight / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-emerald-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Normal BMI (18.5 - 22.9)
                            </span>
                            <span class="font-bold text-slate-700">{{ $normalBmi }} ({{ $totalConsultations > 0 ? round(($normalBmi / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($normalBmi / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-2.5 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                    <span>Adiposity Burden:</span>
                    <span class="font-bold {{ $obese > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $totalConsultations > 0 ? round((($obese + $overweight) / $totalConsultations) * 100, 1) : 0 }}% Excess Wt
                    </span>
                </div>
            </div>

            <!-- 4. Infection & Inflammatory Status -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                            <i class="fas fa-virus text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Infection & Fever</h3>
                            <span class="text-[11px] text-slate-500">Temperature & Pathogen Log</span>
                        </div>
                    </div>
                    <span class="text-xs font-black px-2 py-0.5 rounded-full bg-purple-50 text-purple-700">
                        {{ $infection }}/{{ $totalConsultations }}
                    </span>
                </div>

                <div class="space-y-2.5 my-3">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-purple-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Febrile / Infection (&gt; 99.4°F)
                            </span>
                            <span class="font-bold text-slate-700">{{ $infection }} ({{ $totalConsultations > 0 ? round(($infection / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($infection / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-emerald-600 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Afebrile / Normal (&le; 99.4°F)
                            </span>
                            <span class="font-bold text-slate-700">{{ $normalTemp }} ({{ $totalConsultations > 0 ? round(($normalTemp / $totalConsultations) * 100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalConsultations > 0 ? ($normalTemp / $totalConsultations) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-7 pt-2.5 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                    <span>Active Infection:</span>
                    <span class="font-bold {{ $infection > 0 ? 'text-purple-600' : 'text-emerald-600' }}">
                        {{ $totalConsultations > 0 ? round(($infection / $totalConsultations) * 100, 1) : 0 }}% Prevalence
                    </span>
                </div>
            </div>

        </div>

        <!-- Medical Research Comorbidity & Multi-Morbidity Panels -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-project-diagram text-indigo-600"></i>
                        Cardiometabolic Multi-Morbidity & Research Biomarkers
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        High-value clinical research intersections for early intervention and complication prevention
                    </p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-full w-fit">
                    Medical Research Indices
                </span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- 1. Metabolic Syndrome Triad -->
                <div class="bg-gradient-to-br from-rose-50 to-orange-50/50 p-4 rounded-2xl border border-rose-200/60 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-rose-800 tracking-wider block">Metabolic Triad</span>
                        <span class="text-[11px] text-rose-600 font-medium">Diab + HTN + Obese</span>
                        <div class="text-2xl font-black text-rose-900 my-2">{{ $metabolicTriad }}</div>
                    </div>
                    <span class="text-[11px] font-bold text-rose-700 bg-rose-100/80 px-2 py-0.5 rounded-md w-fit">
                        {{ $totalConsultations > 0 ? round(($metabolicTriad / $totalConsultations) * 100, 1) : 0 }}% Cohort
                    </span>
                </div>

                <!-- 2. Cardio-Renal Risk -->
                <div class="bg-gradient-to-br from-amber-50 to-yellow-50/50 p-4 rounded-2xl border border-amber-200/60 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-amber-800 tracking-wider block">Cardio-Renal Risk</span>
                        <span class="text-[11px] text-amber-600 font-medium">HTN + High Creat/eGFR</span>
                        <div class="text-2xl font-black text-amber-900 my-2">{{ $cardioRenal }}</div>
                    </div>
                    <span class="text-[11px] font-bold text-amber-700 bg-amber-100/80 px-2 py-0.5 rounded-md w-fit">
                        {{ $totalConsultations > 0 ? round(($cardioRenal / $totalConsultations) * 100, 1) : 0 }}% Cohort
                    </span>
                </div>

                <!-- 3. Diabetic Nephropathy Risk -->
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50/50 p-4 rounded-2xl border border-teal-200/60 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-teal-800 tracking-wider block">Diabetic Nephropathy</span>
                        <span class="text-[11px] text-teal-600 font-medium">Diabetes + Creat &ge; 1.3</span>
                        <div class="text-2xl font-black text-teal-900 my-2">{{ $diabeticNephropathy }}</div>
                    </div>
                    <span class="text-[11px] font-bold text-teal-700 bg-teal-100/80 px-2 py-0.5 rounded-md w-fit">
                        {{ $totalConsultations > 0 ? round(($diabeticNephropathy / $totalConsultations) * 100, 1) : 0 }}% Cohort
                    </span>
                </div>

                <!-- 4. Hepatic Steatosis / NAFLD Risk -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50/50 p-4 rounded-2xl border border-emerald-200/60 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-emerald-800 tracking-wider block">Hepatic Stress / NAFLD</span>
                        <span class="text-[11px] text-emerald-600 font-medium">Elevated SGPT &ge; 45 U/L</span>
                        <div class="text-2xl font-black text-emerald-900 my-2">{{ $liverStress }}</div>
                    </div>
                    <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md w-fit">
                        {{ $totalConsultations > 0 ? round(($liverStress / $totalConsultations) * 100, 1) : 0 }}% Cohort
                    </span>
                </div>

                <!-- 5. Multi-Morbidity Burden -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50/50 p-4 rounded-2xl border border-indigo-200/60 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-indigo-800 tracking-wider block">Multi-Morbidity</span>
                        <span class="text-[11px] text-indigo-600 font-medium">&ge; 2 Chronic Conditions</span>
                        <div class="text-2xl font-black text-indigo-900 my-2">{{ $multiMorbidity }}</div>
                    </div>
                    <span class="text-[11px] font-bold text-indigo-700 bg-indigo-100/80 px-2 py-0.5 rounded-md w-fit">
                        {{ $totalConsultations > 0 ? round(($multiMorbidity / $totalConsultations) * 100, 1) : 0 }}% Cohort
                    </span>
                </div>
            </div>
        </div>

        <!-- Visual Clinical Research Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Chart 1: Disease Matrix Distribution (Doughnut Chart) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Disease Prevalence Stratification</h4>
                        <span class="text-xs text-slate-500">Distribution across primary matrix conditions</span>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">Prevalence</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="diseaseMatrixChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Monthly Longitudinal Progression -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Longitudinal Consultation Progression</h4>
                        <span class="text-xs text-slate-500">Monthly patient volume & disease trends</span>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700">Monthly</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Patient Cohort Explorer & Research Data Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-users-viewfinder text-indigo-600"></i>
                        Clinical Patient Cohort Explorer
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Stratified patient records with exact diagnostic parameters and classified risk categories
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <input type="text" id="cohortSearch" placeholder="Search patient name, phone, metric..."
                        class="px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none w-56 sm:w-64 bg-slate-50/60">
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <button type="button" onclick="filterCohort('all')" class="cohort-filter-btn px-3.5 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition" data-filter="all">
                    All Records ({{ $allRecords->count() }})
                </button>
                <button type="button" onclick="filterCohort('diabetic')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="diabetic">
                    🩸 Diabetic ({{ $diabetes }})
                </button>
                <button type="button" onclick="filterCohort('htn')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="htn">
                    🩺 Hypertensive ({{ $hypertension }})
                </button>
                <button type="button" onclick="filterCohort('obese')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="obese">
                    ⚖️ Obese ({{ $obesity }})
                </button>
                <button type="button" onclick="filterCohort('infection')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="infection">
                    🌡️ Infection ({{ $infection }})
                </button>
                <button type="button" onclick="filterCohort('triad')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="triad">
                    🧬 Metabolic Triad ({{ $metabolicTriad }})
                </button>
                <button type="button" onclick="filterCohort('multimorbidity')" class="cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition" data-filter="multimorbidity">
                    📊 Multi-Morbidity ({{ $multiMorbidity }})
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs text-left text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 uppercase font-bold text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Patient Name</th>
                            <th class="px-4 py-3">HbA1c / Glucose</th>
                            <th class="px-4 py-3">BP (SBP/DBP)</th>
                            <th class="px-4 py-3">BMI / Wt</th>
                            <th class="px-4 py-3">Temp</th>
                            <th class="px-4 py-3">Renal (Creat/eGFR)</th>
                            <th class="px-4 py-3">Diagnostic Classification</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="cohortTableBody" class="divide-y divide-slate-100">
                        @forelse($allRecords as $r)
                            <tr class="cohort-row hover:bg-slate-50 transition"
                                data-name="{{ strtolower($r->patient->patient_name ?? '') }}"
                                data-diab="{{ $r->diab_class }}"
                                data-htn="{{ $r->htn_class }}"
                                data-bmi="{{ $r->bmi_class }}"
                                data-temp="{{ $r->temp_class }}"
                                data-triad="{{ $r->is_metabolic_triad ? 'yes' : 'no' }}"
                                data-multi="{{ $r->is_multimorbidity ? 'yes' : 'no' }}">

                                <td class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap">
                                    {{ $r->patient->patient_name ?? 'Patient #' . $r->patient_id }}
                                    <div class="text-[10px] text-slate-400 font-normal">
                                        {{ $r->patient->gender ?? 'N/A' }} {{ $r->patient->age ? '• ' . $r->patient->age . ' yrs' : '' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-bold {{ $r->hba1c >= 6.5 ? 'text-red-600' : ($r->hba1c >= 5.7 ? 'text-amber-600' : 'text-slate-700') }}">
                                        {{ $r->hba1c ? $r->hba1c . '%' : '-' }}
                                    </span>
                                    <div class="text-[10px] text-slate-400">
                                        BSF: {{ $r->bsf ? $r->bsf . ' mg/dL' : '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 font-mono whitespace-nowrap">
                                    <span class="font-bold {{ $r->sbp >= 140 || $r->dbp >= 90 ? 'text-red-600' : ($r->sbp >= 130 ? 'text-amber-600' : 'text-slate-700') }}">
                                        {{ $r->sbp && $r->dbp ? $r->sbp . '/' . $r->dbp : ($r->sbp ?: '-') }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-bold {{ $r->bmi >= 25 ? 'text-red-600' : ($r->bmi >= 23 ? 'text-amber-600' : 'text-slate-700') }}">
                                        {{ $r->bmi ? $r->bmi : '-' }}
                                    </span>
                                    <div class="text-[10px] text-slate-400">
                                        {{ $r->weight_kg ? $r->weight_kg . ' kg' : '' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-bold {{ $r->temprature > 99.4 ? 'text-purple-600' : 'text-slate-700' }}">
                                        {{ $r->temprature ? $r->temprature . '°F' : '-' }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-bold {{ $r->creatinine >= 1.3 ? 'text-amber-600' : 'text-slate-700' }}">
                                        {{ $r->creatinine ? $r->creatinine . ' mg/dL' : '-' }}
                                    </span>
                                    <div class="text-[10px] text-slate-400">
                                        eGFR: {{ $r->egfr ?: '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if($r->diab_class === 'Diabetes')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700">Diabetes</span>
                                        @elseif($r->diab_class === 'Pre-Diabetes')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700">Pre-Diabetic</span>
                                        @endif

                                        @if($r->htn_class === 'Hypertension')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700">HTN</span>
                                        @elseif($r->htn_class === 'Pre-Hypertension')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700">Pre-HTN</span>
                                        @endif

                                        @if($r->bmi_class === 'Obese')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-orange-100 text-orange-700">Obese</span>
                                        @elseif($r->bmi_class === 'Overweight')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700">Overweight</span>
                                        @endif

                                        @if($r->temp_class === 'Infection')
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-100 text-purple-700">Infection</span>
                                        @endif

                                        @if($r->is_metabolic_triad)
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-600 text-white">Triad</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <a href="{{ route('patient.show', $r->patient_id) }}?record_id={{ $r->id }}"
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white transition inline-block">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-slate-400">
                                    No patient clinical records found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Scripts for Cohort Filter and Charts -->
    <script>
        function filterCohort(type) {
            document.querySelectorAll('.cohort-filter-btn').forEach(btn => {
                if (btn.getAttribute('data-filter') === type) {
                    btn.className = "cohort-filter-btn px-3.5 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition";
                } else {
                    btn.className = "cohort-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition";
                }
            });

            document.querySelectorAll('.cohort-row').forEach(row => {
                let show = false;
                if (type === 'all') show = true;
                else if (type === 'diabetic' && (row.dataset.diab === 'Diabetes' || row.dataset.diab === 'Pre-Diabetes')) show = true;
                else if (type === 'htn' && (row.dataset.htn === 'Hypertension' || row.dataset.htn === 'Pre-Hypertension')) show = true;
                else if (type === 'obese' && (row.dataset.bmi === 'Obese' || row.dataset.bmi === 'Overweight')) show = true;
                else if (type === 'infection' && row.dataset.temp === 'Infection') show = true;
                else if (type === 'triad' && row.dataset.triad === 'yes') show = true;
                else if (type === 'multimorbidity' && row.dataset.multi === 'yes') show = true;

                row.style.display = show ? '' : 'none';
            });
        }

        // Live search filter
        document.getElementById('cohortSearch')?.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.cohort-row').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });

        // Charts Initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Chart 1: Disease Matrix Distribution Doughnut
            const ctxMatrix = document.getElementById('diseaseMatrixChart');
            if (ctxMatrix) {
                new Chart(ctxMatrix, {
                    type: 'doughnut',
                    data: {
                        labels: ['Diabetes', 'Pre-Diabetes', 'Hypertension', 'Pre-HTN', 'Obesity', 'Infection', 'Normals'],
                        datasets: [{
                            data: [
                                {{ $diabetes }},
                                {{ $preDiabetes }},
                                {{ $hypertension }},
                                {{ $preHypertension }},
                                {{ $obesity }},
                                {{ $infection }},
                                {{ $normalGlycemic }}
                            ],
                            backgroundColor: [
                                '#ef4444',
                                '#f59e0b',
                                '#dc2626',
                                '#fbbf24',
                                '#ea580c',
                                '#8b5cf6',
                                '#10b981'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            // Chart 2: Monthly Longitudinal Progression
            const ctxTrend = document.getElementById('monthlyTrendChart');
            if (ctxTrend) {
                const monthlyData = @json($monthlyTrend);
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const labels = monthlyData.map(m => monthNames[m.month - 1] || 'M' + m.month);

                new Chart(ctxTrend, {
                    type: 'bar',
                    data: {
                        labels: labels.length > 0 ? labels : ['Aug 2026'],
                        datasets: [
                            {
                                label: 'Total Consultations',
                                data: monthlyData.length > 0 ? monthlyData.map(m => m.total) : [{{ $totalConsultations }}],
                                backgroundColor: '#6366f1',
                                borderRadius: 6
                            },
                            {
                                label: 'Diabetes',
                                data: monthlyData.length > 0 ? monthlyData.map(m => m.diabetes_count) : [{{ $diabetes }}],
                                backgroundColor: '#ef4444',
                                borderRadius: 6
                            },
                            {
                                label: 'Hypertension',
                                data: monthlyData.length > 0 ? monthlyData.map(m => m.hypertension_count) : [{{ $hypertension }}],
                                backgroundColor: '#f59e0b',
                                borderRadius: 6
                            },
                            {
                                label: 'Obesity',
                                data: monthlyData.length > 0 ? monthlyData.map(m => m.obesity_count) : [{{ $obesity }}],
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, suggestedMax: 10 }
                        }
                    }
                });
            }
        });
    </script>
@endsection
