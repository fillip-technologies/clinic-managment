@extends('admin.loyout.master')
@section('content')
@if ($errors->any())
<script>
    @foreach ($errors->all() as $error)
        toastr.error(@json($error));
    @endforeach
</script>
@endif
<style>
        body {
            background: #f0f5fc;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        .card-shadow {
            box-shadow: 0 20px 40px -12px rgba(0, 20, 30, 0.2);
        }

        .input-focus {
            transition: all 0.15s ease;
        }

        .input-focus:focus {
            border-color: #1f6e96;
            box-shadow: 0 0 0 4px rgba(31, 110, 150, 0.12);
            background-color: white;
        }

        .section-chip {
            background: #e6eff7;
            color: #1a4c66;
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .inline-bg {
            background: #f7faff;
            border: 1px solid #e2ecf5;
        }

        label i {
            color: #3e7b9e;
            width: 1.1rem;
        }

        .badge-soft {
            background: #d7e5f0;
            color: #115073;
            padding: 0.2rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* make placeholder lighter */
        ::placeholder {
            color: #b0c8db;
            font-weight: 300;
            font-size: 0.85rem;
        }

        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%235f7e98' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            appearance: none;
        }
    </style>



    <div class="w-full max-w-7xl bg-white rounded-3xl card-shadow p-6 md:p-9 transition-all m-auto">

        <div class="flex flex-wrap items-center justify-between border-b border-[#e2ebf3] pb-5 mb-7">
            <div class="flex items-center gap-3">
                <i class="fas fa-notes-medical text-3xl text-[#1f6e96]"></i>
                <h1 class="text-2xl md:text-3xl font-semibold text-[#0b2a3f] tracking-tight">Patient Clinical Record
                </h1>
            </div>
            <div class="flex items-center gap-3 mt-2 sm:mt-0">
                <span class="badge-soft"><i class="far fa-calendar-alt mr-1"></i> New Registration</span>
                <span
                    class="bg-[#eaf1f9] px-4 py-1.5 rounded-full text-sm font-medium text-[#1f5a7a] border border-[#c7dae9]">
                    <i class="far fa-clock mr-1"></i> Today
                </span>
            </div>
        </div>

        <!-- ====== FORM with name & value attributes (Laravel friendly) ====== -->
        <form action="{{ route('store.patient') }}" class="space-y-7" method="POST" action="/patient-records" enctype="multipart/form-data">
            @csrf

            <!-- === SECTION 1: Personal & Demographics === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-user-circle text-[#1f6e96]"></i>
                    <span>Personal & Demographics</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
                    <!-- Date -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="far fa-calendar-alt"></i> Date</label>
                        <input type="date" name="record_date" value="{{ old('record_date', date('Y-m-d')) }}"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- Patient's Name -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="far fa-user"></i> Patient’s Name</label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" placeholder="Full name"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- AGE -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="far fa-calendar"></i> Age</label>
                        <input type="number" name="age" value="{{ old('age') }}" placeholder="Years"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- GENDER -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-venus-mars"></i> Gender</label>
                        <select name="gender"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender')=='Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <!-- Father / Husband -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-user-friends"></i> Father / Husband</label>
                        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" placeholder="Name"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- RCDHO GRADE -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-layer-group"></i> RCDHO Grade</label>
                        <select name="rcdho_grade"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                            <option value="">Select</option>
                            <option value="Grade I" {{ old('rcdho_grade')=='Grade I' ? 'selected' : '' }}>Grade I</option>
                            <option value="Grade II" {{ old('rcdho_grade')=='Grade II' ? 'selected' : '' }}>Grade II</option>
                            <option value="Grade III" {{ old('rcdho_grade')=='Grade III' ? 'selected' : '' }}>Grade III</option>
                        </select>
                    </div>
                    <!-- Address -->
                    <div class="col-span-1 sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-map-pin"></i> Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, city, state"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- Mobile No -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-phone-alt"></i> Mobile No.</label>
                        <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="+91 98765 43210"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <!-- New Registration No. -->
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold uppercase tracking-wide text-[#2f5a77] mb-1"><i
                                class="fas fa-id-card"></i> New Reg. No.</label>
                        <input type="text" name="registration_no" value="{{ old('registration_no', 'REG-2026-001') }}" placeholder="REG-2026-001"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                </div>
            </div>

            <!-- === SECTION 2: Diabetes & Insulin === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-syringe text-[#1f6e96]"></i>
                    <span>Diabetes & Insulin</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div><label class="block text-xs font-semibold uppercase text-[#2f5a77] mb-1"><i
                                class="far fa-check-circle"></i> Newly detected</label>
                        <select name="newly_detected"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                            <option value="No" {{ old('newly_detected')=='No' ? 'selected' : '' }}>No</option>
                            <option value="Yes" {{ old('newly_detected')=='Yes' ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-semibold uppercase text-[#2f5a77] mb-1"><i
                                class="far fa-clock"></i> Duration of Diabetes</label>
                        <input type="text" name="duration_of_diabetes" value="{{ old('duration_of_diabetes') }}" placeholder="e.g. 5 yrs"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <div><label class="block text-xs font-semibold uppercase text-[#2f5a77] mb-1"><i
                                class="fas fa-play"></i> START INSULIN DATE</label>
                        <input type="date" name="insulin_start_date" value="{{ old('insulin_start_date') }}"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                    <div><label class="block text-xs font-semibold uppercase text-[#2f5a77] mb-1"><i
                                class="fas fa-stop"></i> STOP INSULIN DATE</label>
                        <input type="date" name="insulin_stop_date" value="{{ old('insulin_stop_date') }}"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm bg-[#fafdff] input-focus">
                    </div>
                </div>
                <!-- ATTACHMENT -->
                <div class="mt-3">
                    <label class="block text-xs font-semibold uppercase text-[#2f5a77] mb-1"><i
                            class="fas fa-paperclip"></i> ATTACHMENT</label>
                    <input type="file" name="attachment"
                        class="w-full rounded-xl border border-[#d3dfea] px-4 py-2 text-sm bg-[#fafdff] input-focus file:mr-4 file:rounded-full file:border-0 file:bg-[#d7e5f0] file:px-4 file:py-1.5 file:text-sm file:font-medium file:text-[#115073] hover:file:bg-[#c2d8e9]">
                </div>
            </div>

            <!-- === SECTION 3: Anthropometry === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-ruler-vertical text-[#1f6e96]"></i>
                    <span>Anthropometry & Body metrics</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Height (cm)</label>
                        <input type="number" step="0.1" name="height" value="{{ old('height') }}" placeholder="cm"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" placeholder="kg"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">BMI (kg/m²)</label>
                        <input type="number" step="0.01" name="bmi" value="{{ old('bmi') }}" placeholder="auto"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Waist / Height ratio</label>
                        <input type="number" step="0.01" name="waist_height_ratio" value="{{ old('waist_height_ratio') }}" placeholder="0.0"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">BMI Group</label>
                        <select name="bmi_group"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Normal" {{ old('bmi_group')=='Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Overweight" {{ old('bmi_group')=='Overweight' ? 'selected' : '' }}>Overweight</option>
                            <option value="Obese" {{ old('bmi_group')=='Obese' ? 'selected' : '' }}>Obese</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Waist (cm)</label>
                        <input type="number" step="0.1" name="waist" value="{{ old('waist') }}" placeholder="cm"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Hip (cm)</label>
                        <input type="number" step="0.1" name="hip" value="{{ old('hip') }}" placeholder="cm"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Waist/Hip ratio</label>
                        <input type="number" step="0.01" name="waist_hip_ratio" value="{{ old('waist_hip_ratio') }}" placeholder="0.0"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                </div>
            </div>

            <!-- === SECTION 4: Social & Lifestyle === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-people-arrows text-[#1f6e96]"></i>
                    <span>Social & Lifestyle</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Social class</label>
                        <select name="social_class"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Upper" {{ old('social_class')=='Upper' ? 'selected' : '' }}>Upper</option>
                            <option value="Middle" {{ old('social_class')=='Middle' ? 'selected' : '' }}>Middle</option>
                            <option value="Lower" {{ old('social_class')=='Lower' ? 'selected' : '' }}>Lower</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Income class</label>
                        <select name="income_class"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="High" {{ old('income_class')=='High' ? 'selected' : '' }}>High</option>
                            <option value="Medium" {{ old('income_class')=='Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="Low" {{ old('income_class')=='Low' ? 'selected' : '' }}>Low</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Education</label>
                        <select name="education"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Graduate" {{ old('education')=='Graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="Post-grad" {{ old('education')=='Post-grad' ? 'selected' : '' }}>Post-grad</option>
                            <option value="School" {{ old('education')=='School' ? 'selected' : '' }}>School</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Physical activity</label>
                        <select name="physical_activity"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Sedentary" {{ old('physical_activity')=='Sedentary' ? 'selected' : '' }}>Sedentary</option>
                            <option value="Moderate" {{ old('physical_activity')=='Moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="Active" {{ old('physical_activity')=='Active' ? 'selected' : '' }}>Active</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Veg / Non-veg</label>
                        <select name="diet_type"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Vegetarian" {{ old('diet_type')=='Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                            <option value="Non-vegetarian" {{ old('diet_type')=='Non-vegetarian' ? 'selected' : '' }}>Non-vegetarian</option>
                            <option value="Vegan" {{ old('diet_type')=='Vegan' ? 'selected' : '' }}>Vegan</option>
                        </select></div>
                </div>
            </div>

            <!-- === SECTION 5: Vitals & labs (grid) === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-heartbeat text-[#1f6e96]"></i>
                    <span>Vitals & Clinical labs</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HTN</label>
                        <select name="htn"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="No" {{ old('htn')=='No' ? 'selected' : '' }}>No</option>
                            <option value="Yes" {{ old('htn')=='Yes' ? 'selected' : '' }}>Yes</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">SBP</label>
                        <input type="number" name="sbp" value="{{ old('sbp') }}" placeholder="mmHg"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">DBP</label>
                        <input type="number" name="dbp" value="{{ old('dbp') }}" placeholder="mmHg"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HB %</label>
                        <input type="text" name="hb" value="{{ old('hb') }}" placeholder="g/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">PLT</label>
                        <input type="text" name="plt" value="{{ old('plt') }}" placeholder="cells/µL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">MCV</label>
                        <input type="text" name="mcv" value="{{ old('mcv') }}" placeholder="fL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Creatinine</label>
                        <input type="text" name="creatinine" value="{{ old('creatinine') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">EGFr</label>
                        <input type="text" name="egfr" value="{{ old('egfr') }}" placeholder="mL/min"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">ACR</label>
                        <input type="text" name="acr" value="{{ old('acr') }}" placeholder="mg/g"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Uric acid</label>
                        <input type="text" name="uric_acid" value="{{ old('uric_acid') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Urine cast cell</label>
                        <input type="text" name="urine_cast_cell" value="{{ old('urine_cast_cell') }}" placeholder="cells"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Na+</label>
                        <input type="text" name="sodium" value="{{ old('sodium') }}" placeholder="mEq/L"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">K+</label>
                        <input type="text" name="potassium" value="{{ old('potassium') }}" placeholder="mEq/L"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">I. calcium</label>
                        <input type="text" name="ionized_calcium" value="{{ old('ionized_calcium') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Phosphorus</label>
                        <input type="text" name="phosphorus" value="{{ old('phosphorus') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">SGPT</label>
                        <input type="text" name="sgpt" value="{{ old('sgpt') }}" placeholder="U/L"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">SGOT</label>
                        <input type="text" name="sgot" value="{{ old('sgot') }}" placeholder="U/L"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">ALKP</label>
                        <input type="text" name="alkp" value="{{ old('alkp') }}" placeholder="U/L"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HIV</label>
                        <select name="hiv"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Negative" {{ old('hiv')=='Negative' ? 'selected' : '' }}>Negative</option>
                            <option value="Positive" {{ old('hiv')=='Positive' ? 'selected' : '' }}>Positive</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Hbsag</label>
                        <select name="hbsag"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Negative" {{ old('hbsag')=='Negative' ? 'selected' : '' }}>Negative</option>
                            <option value="Positive" {{ old('hbsag')=='Positive' ? 'selected' : '' }}>Positive</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HCV</label>
                        <select name="hcv"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus">
                            <option value="Negative" {{ old('hcv')=='Negative' ? 'selected' : '' }}>Negative</option>
                            <option value="Positive" {{ old('hcv')=='Positive' ? 'selected' : '' }}>Positive</option>
                        </select></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Fib score</label>
                        <input type="text" name="fib_score" value="{{ old('fib_score') }}" placeholder="score"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Fib Scan</label>
                        <input type="text" name="fib_scan" value="{{ old('fib_scan') }}" placeholder="kPa"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">USG</label>
                        <input type="text" name="usg" value="{{ old('usg') }}" placeholder="Findings"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Chol.</label>
                        <input type="text" name="cholesterol" value="{{ old('cholesterol') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">TG.</label>
                        <input type="text" name="triglycerides" value="{{ old('triglycerides') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HDL</label>
                        <input type="text" name="hdl" value="{{ old('hdl') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">LDL</label>
                        <input type="text" name="ldl" value="{{ old('ldl') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">BSF</label>
                        <input type="text" name="bsf" value="{{ old('bsf') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">BSPP</label>
                        <input type="text" name="bspp" value="{{ old('bspp') }}" placeholder="mg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">HBA1c</label>
                        <input type="text" name="hba1c" value="{{ old('hba1c') }}" placeholder="%"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">TSH</label>
                        <input type="text" name="tsh" value="{{ old('tsh') }}" placeholder="µIU/mL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">T3</label>
                        <input type="text" name="t3" value="{{ old('t3') }}" placeholder="ng/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">T4</label>
                        <input type="text" name="t4" value="{{ old('t4') }}" placeholder="µg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Vitamin D25</label>
                        <input type="text" name="vitamin_d25" value="{{ old('vitamin_d25') }}" placeholder="ng/mL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Vitamin B12</label>
                        <input type="text" name="vitamin_b12" value="{{ old('vitamin_b12') }}" placeholder="pg/mL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">S.CORTISOL</label>
                        <input type="text" name="cortisol" value="{{ old('cortisol') }}" placeholder="µg/dL"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]">Dex Skp.. TEst</label>
                        <input type="text" name="dex_skip_test" value="{{ old('dex_skip_test') }}" placeholder="result"
                            class="w-full rounded-xl border border-[#d3dfea] px-3 py-2 text-sm input-focus"></div>
                </div>
            </div>

            <!-- === SECTION 6: Specialist evaluations === -->
            <div>
                <div class="flex items-center gap-2 text-[#124263] font-semibold text-base mb-3">
                    <i class="fas fa-stethoscope text-[#1f6e96]"></i>
                    <span>Specialist Evaluations</span>
                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#d3e2f0] to-transparent ml-2"></span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-xs font-semibold text-[#2f5a77]"><i class="fas fa-eye"></i>
                            OPHTHALMIC EX</label>
                        <input type="text" name="ophthalmic_exam" value="{{ old('ophthalmic_exam') }}" placeholder="Findings"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm input-focus">
                    </div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]"><i class="fas fa-shoe-prints"></i>
                            FOOT Ev.</label>
                        <input type="text" name="foot_exam" value="{{ old('foot_exam') }}" placeholder="Foot exam"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm input-focus">
                    </div>
                    <div><label class="block text-xs font-semibold text-[#2f5a77]"><i class="fas fa-heart"></i> Car.
                            Echo Ev.</label>
                        <input type="text" name="echo_exam" value="{{ old('echo_exam') }}" placeholder="Echo summary"
                            class="w-full rounded-xl border border-[#d3dfea] px-4 py-2.5 text-sm input-focus">
                    </div>
                </div>
            </div>

            <!-- === ACTION BUTTONS === -->
            <div class="flex flex-wrap justify-end items-center gap-4 pt-5 border-t border-[#e2ebf3] mt-8">
                <button type="reset"
                    class="px-7 py-2.5 rounded-full border border-[#b7cddf] text-[#1f5a7a] font-medium hover:bg-[#ecf3fa] transition text-sm"><i
                        class="fas fa-undo-alt mr-1"></i> Reset</button>
                <button type="submit"
                    class="px-9 py-2.5 rounded-full bg-[#1f6e96] hover:bg-[#16547a] text-white font-medium shadow-md shadow-[#1f6e96]/25 transition text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Record
                </button>
            </div>

        </form>
    </div>

    <!-- minimal JS for demo (console log) -->
    <script>
        (function() {
            const form = document.getElementById('patientForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // professional demo: gather data & log
                const formData = new FormData(form);
                const entries = Object.fromEntries(formData.entries());
                console.log('📋 Patient Form Data:', entries);
                alert('✅ Form submitted (check console for data).');
            });
        })();
    </script>
@endsection
