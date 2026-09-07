<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientClinicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class PatientController extends Controller
{
    public function patientList()
    {
        $records = Patient::with(['latestRecord', 'clinicalRecords'])->latest()->get();

        return view('admin.patients.listing', compact('records'));
    }

    public function createPatient()
    {
        return view('admin.patients.patient');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:255',
            'father_husband_name' => 'nullable|string|max:255',
            'rcdho_grade' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|string|max:20',
            'mobile_no' => 'nullable|string|max:20',
            'mail' => 'nullable|email|max:255',
            'registration_no' => 'nullable|string|max:50|unique:patients,registration_no',

            'has_diabetes' => 'nullable',
            'newly_detected' => 'nullable|string|max:50',
            'diabetes_duration' => 'nullable|string|max:50',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'insuline_brand' => 'nullable|string|max:100',
            'insuline_unit' => 'nullable|string|max:100',
            'insulin_start_date' => 'nullable|date',
            'start_insulin_date' => 'nullable|date',
            'insulin_stop_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',

            'height' => 'nullable|numeric|min:0|max:300',
            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|string|max:50',
            'waist' => 'nullable|numeric|min:0|max:300',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',

            'social_class' => 'nullable|string|max:50',
            'income_class' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:100',
            'physical_activity' => 'nullable|string|max:50',
            'diet_type' => 'nullable|string|max:50',
            'veg_nonveg' => 'nullable|string|max:50',

            'htn' => 'nullable|string|max:50',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb' => 'nullable|string|max:20',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:50',
            'sodium' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'potassium' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'ionized_calcium' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|string|max:50',
            'hbsag' => 'nullable|string|max:50',
            'hcv' => 'nullable|string|max:50',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:50',
            'median_stiffness' => 'nullable|string|max:50',
            'usg' => 'nullable|string|max:500',
            'chol' => 'nullable|string|max:20',
            'cholesterol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
            'triglycerides' => 'nullable|string|max:20',
            'hdl' => 'nullable|string|max:20',
            'ldl' => 'nullable|string|max:20',
            'bsf' => 'nullable|string|max:20',
            'bspp' => 'nullable|string|max:20',
            'hba1c' => 'nullable|string|max:20',
            'tsh' => 'nullable|string|max:20',
            't3' => 'nullable|string|max:20',
            't4' => 'nullable|string|max:20',
            'vitamin_d25' => 'nullable|string|max:20',
            'vitamin_b12' => 'nullable|string|max:20',
            's_cortisol' => 'nullable|string|max:20',
            'cortisol' => 'nullable|string|max:20',
            'dex_skip_test' => 'nullable|string|max:100',
            'dex_suppression_test' => 'nullable|string|max:100',
            'temprature' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'ophthalmic_exam' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'foot_exam' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
            'echo_exam' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $diabetes = "Normal";
        $hypertension = "Normal";
        $infection = "Normal";
        $obesity = "Normal";

        $hba1c = $request->hba1c;
        $bsf = $request->bsf ?? $request->fbs;
        $bspp = $request->bspp ?? $request->rbs;

        if (
            $request->has_diabetes ||
            $request->newly_detected === 'Yes' ||
            ($request->filled('hba1c') && (float)$hba1c >= 6.5) ||
            ($request->filled('bsf') && (float)$bsf >= 126) ||
            ($request->filled('fbs') && (float)$bsf >= 126) ||
            ($request->filled('bspp') && (float)$bspp >= 200) ||
            ($request->filled('rbs') && (float)$bspp >= 200)
        ) {
            $diabetes = "Diabetes";
        }

        if (
            $request->htn === 'Yes' ||
            ($request->filled('sbp') && (float)$request->sbp >= 130) ||
            ($request->filled('dbp') && (float)$request->dbp >= 90)
        ) {
            $hypertension = "Hypertension";
        }

        $temperatureVal = $request->temprature ?? $request->temperature;
        if (
            ($request->filled('temprature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('temperature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('wbc') && (float)$request->wbc > 11000) ||
            ($request->filled('crp') && (float)$request->crp > 10)
        ) {
            $infection = "Infection";
        }

        $waistVal = $request->waist ?? $request->waist_cm;
        if (
            ($request->filled('bmi') && (float)$request->bmi >= 25) ||
            ($request->gender === 'Male' && !empty($waistVal) && (float)$waistVal > 90) ||
            ($request->gender === 'Female' && !empty($waistVal) && (float)$waistVal > 80)
        ) {
            $obesity = "Obesity";
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
        }

        $registrationNo = $request->registration_no;
        if (empty($registrationNo)) {
            $nextId = (Patient::max('id') ?? 0) + 1;
            $registrationNo = 'REG-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }

        $patient = Patient::create([
            'record_date' => $request->record_date,
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'father_husband_name' => $request->guardian_name ?? $request->father_husband_name,
            'rcdho_grade' => $request->rcdho_grade,
            'address' => $request->address,
            'mobile_no' => $request->mobile ?? $request->mobile_no,
            'mail' => $request->mail,
            'registration_no' => $registrationNo,
        ]);

        PatientClinicalRecord::create([
            "patient_id" => $patient->id,
            'newly_detected' => $request->newly_detected,
            'duration_of_diabetes' => $request->diabetes_duration ?? $request->duration_of_diabetes,
            'insuline_brand' => $request->insuline_brand,
            'insuline_unit' => $request->insuline_unit,
            'start_insulin_date' => $request->insulin_start_date ?? $request->start_insulin_date,
            'stop_insulin_date' => $request->insulin_stop_date ?? $request->stop_insulin_date,
            'attachment' => $attachmentPath,
            'height_cm' => $request->height ?? $request->height_cm,
            'weight_kg' => $request->weight ?? $request->weight_kg,
            'bmi' => $request->bmi,
            'temprature' => $request->temprature ?? $request->temperature,
            'waist_height_ratio' => $request->waist_height_ratio,
            'bmi_group' => $request->bmi_group,
            'waist_cm' => $request->waist ?? $request->waist_cm,
            'hip_cm' => $request->hip ?? $request->hip_cm,
            'waist_hip_ratio' => $request->waist_hip_ratio,
            'social_class' => $request->social_class,
            'income_class' => $request->income_class,
            'education' => $request->education,
            'physical_activity' => $request->physical_activity,
            'veg_nonveg' => $request->veg_nonveg ?? $request->diet_type,
            'htn' => $request->htn,
            'sbp' => $request->sbp,
            'dbp' => $request->dbp,
            'hb_percent' => $request->hb ?? $request->hb_percent,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->sodium ?? $request->na_plus,
            'k_plus' => $request->potassium ?? $request->k_plus,
            'i_calcium' => $request->ionized_calcium ?? $request->i_calcium,
            'phosphorus' => $request->phosphorus,
            'sgpt' => $request->sgpt,
            'sgot' => $request->sgot,
            'alkp' => $request->alkp,
            'hiv' => $request->hiv,
            'hbsag' => $request->hbsag,
            'hcv' => $request->hcv,
            'fib_score' => $request->fib_score,
            'fib_scan' => $request->fib_scan,
            'median_stiffness' => $request->median_stiffness,
            'usg' => $request->usg,
            'chol' => $request->cholesterol ?? $request->chol,
            'tg' => $request->triglycerides ?? $request->tg,
            'hdl' => $request->hdl,
            'ldl' => $request->ldl,
            'bsf' => $request->bsf,
            'bspp' => $request->bspp,
            'hba1c' => $request->hba1c,
            'tsh' => $request->tsh,
            't3' => $request->t3,
            't4' => $request->t4,
            'vitamin_d25' => $request->vitamin_d25,
            'vitamin_b12' => $request->vitamin_b12,
            's_cortisol' => $request->cortisol ?? $request->s_cortisol,
            'dex_skip_test' => $request->dex_suppression_test ?? $request->dex_skip_test,
            'ophthalmic_ex' => $request->ophthalmic_exam ?? $request->ophthalmic_ex,
            'foot_ev' => $request->foot_exam ?? $request->foot_ev,
            'car_echo_ev' => $request->echo_exam ?? $request->car_echo_ev,
            'diabetes' => $diabetes,
            'hypertension' => $hypertension,
            'obesity' => $obesity,
            'infection' => $infection,
        ]);

        return redirect()->route("list.patient")
            ->with('success', 'Patient clinical record created successfully!');
    }


    public function show(Request $request, $id)
    {
        $patient = Patient::with(['latestRecord', 'clinicalRecords'])->find($id);
        if ($patient) {
            $allRecords = $patient->clinicalRecords()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
            if ($request->filled('record_id')) {
                $record = $allRecords->firstWhere('id', $request->record_id);
            }
            if (!isset($record) || !$record) {
                $record = $allRecords->first();
            }
            if (!$record) {
                $record = new PatientClinicalRecord(['patient_id' => $patient->id]);
                $record->setRelation('patient', $patient);
            }
        } else {
            $record = PatientClinicalRecord::with(['patient'])->findOrFail($id);
            $patient = $record->patient ?? Patient::findOrFail($record->patient_id);
            $allRecords = PatientClinicalRecord::where('patient_id', $record->patient_id)
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('admin.patients.show', compact('record', 'patient', 'allRecords'));
    }


    public function edit(Request $request, $id)
    {
        $patient = Patient::with(['clinicalRecords'])->find($id);
        if ($patient) {
            $allRecords = $patient->clinicalRecords()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
            if ($request->filled('record_id')) {
                $record = $allRecords->firstWhere('id', $request->record_id);
            }
            if (!isset($record) || !$record) {
                $record = $allRecords->first();
            }
            if (!$record) {
                $record = new PatientClinicalRecord(['patient_id' => $patient->id]);
                $record->setRelation('patient', $patient);
            }
        } else {
            $record = PatientClinicalRecord::with(['patient'])->findOrFail($id);
            $patient = $record->patient ?? Patient::findOrFail($record->patient_id);
            $allRecords = $patient->clinicalRecords()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        }

        return view('admin.patients.edit', compact('record', 'patient', 'allRecords'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $record = PatientClinicalRecord::with(['patient'])->findOrFail($id);
            $patient = $record->patient ?? Patient::findOrFail($record->patient_id);
        } else {
            if ($request->filled('record_id') && $request->record_id > 0) {
                $record = PatientClinicalRecord::where('patient_id', $patient->id)->where('id', $request->record_id)->first();
            } else {
                $record = PatientClinicalRecord::where('patient_id', $patient->id)->latest('id')->first();
            }
        }

        if (!$record) {
            $record = new PatientClinicalRecord(['patient_id' => $patient->id]);
        }

        $regNoRules = ['nullable', 'string', 'max:50'];
        if ($request->filled('registration_no') && trim((string)$request->registration_no) !== trim((string)$patient->registration_no)) {
            $regNoRules[] = Rule::unique('patients', 'registration_no')->ignore($patient->id);
        }

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:255',
            'father_husband_name' => 'nullable|string|max:255',
            'rcdho_grade' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|string|max:20',
            'mobile_no' => 'nullable|string|max:20',
            'mail' => 'nullable|email|max:255',

            'registration_no' => $regNoRules,

            'has_diabetes' => 'nullable',
            'newly_detected' => 'nullable|string|max:50',
            'diabetes_duration' => 'nullable|string|max:50',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'insuline_brand' => 'nullable|string|max:100',
            'insuline_unit' => 'nullable|string|max:100',
            'insulin_start_date' => 'nullable|date',
            'start_insulin_date' => 'nullable|date',
            'insulin_stop_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',

            'height' => 'nullable|numeric|min:0|max:300',
            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|string|max:50',
            'waist' => 'nullable|numeric|min:0|max:300',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',

            'social_class' => 'nullable|string|max:50',
            'income_class' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:100',
            'physical_activity' => 'nullable|string|max:50',
            'diet_type' => 'nullable|string|max:50',
            'veg_nonveg' => 'nullable|string|max:50',

            'htn' => 'nullable|string|max:50',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb' => 'nullable|string|max:20',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:50',
            'sodium' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'potassium' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'ionized_calcium' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|string|max:50',
            'hbsag' => 'nullable|string|max:50',
            'hcv' => 'nullable|string|max:50',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:50',
            'median_stiffness' => 'nullable|string|max:50',
            'usg' => 'nullable|string|max:500',
            'chol' => 'nullable|string|max:20',
            'cholesterol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
            'triglycerides' => 'nullable|string|max:20',
            'hdl' => 'nullable|string|max:20',
            'ldl' => 'nullable|string|max:20',
            'bsf' => 'nullable|string|max:20',
            'bspp' => 'nullable|string|max:20',
            'hba1c' => 'nullable|string|max:20',
            'tsh' => 'nullable|string|max:20',
            't3' => 'nullable|string|max:20',
            't4' => 'nullable|string|max:20',
            'vitamin_d25' => 'nullable|string|max:20',
            'vitamin_b12' => 'nullable|string|max:20',
            's_cortisol' => 'nullable|string|max:20',
            'cortisol' => 'nullable|string|max:20',
            'dex_skip_test' => 'nullable|string|max:100',
            'dex_suppression_test' => 'nullable|string|max:100',
            'temprature' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'ophthalmic_exam' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'foot_exam' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
            'echo_exam' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $diabetes = "Normal";
        $hypertension = "Normal";
        $infection = "Normal";
        $obesity = "Normal";

        $hba1c = $request->hba1c;
        $bsf = $request->bsf ?? $request->fbs;
        $bspp = $request->bspp ?? $request->rbs;

        if (
            $request->has_diabetes ||
            $request->newly_detected === 'Yes' ||
            ($request->filled('hba1c') && (float)$hba1c >= 6.5) ||
            ($request->filled('bsf') && (float)$bsf >= 126) ||
            ($request->filled('fbs') && (float)$bsf >= 126) ||
            ($request->filled('bspp') && (float)$bspp >= 200) ||
            ($request->filled('rbs') && (float)$bspp >= 200)
        ) {
            $diabetes = "Diabetes";
        }

        if (
            $request->htn === 'Yes' ||
            ($request->filled('sbp') && (float)$request->sbp >= 130) ||
            ($request->filled('dbp') && (float)$request->dbp >= 90)
        ) {
            $hypertension = "Hypertension";
        }

        $temperatureVal = $request->temprature ?? $request->temperature;
        if (
            ($request->filled('temprature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('temperature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('wbc') && (float)$request->wbc > 11000) ||
            ($request->filled('crp') && (float)$request->crp > 10)
        ) {
            $infection = "Infection";
        }

        $waistVal = $request->waist ?? $request->waist_cm;
        $genderVal = $request->gender ?? $patient->gender ?? null;
        if (
            ($request->filled('bmi') && (float)$request->bmi >= 25) ||
            ($genderVal === 'Male' && !empty($waistVal) && (float)$waistVal > 90) ||
            ($genderVal === 'Female' && !empty($waistVal) && (float)$waistVal > 80)
        ) {
            $obesity = "Obesity";
        }

        $attachmentPath = $record?->attachment;

        if ($request->hasFile('attachment')) {
            if ($attachmentPath && Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
        }

        $registrationNo = $request->filled('registration_no') ? trim($request->registration_no) : $patient->registration_no;
        if (empty($registrationNo)) {
            $currentYear = date('Y');
            $latestPatient = Patient::whereYear('created_at', $currentYear)
                ->where('registration_no', 'like', "REG-{$currentYear}-%")
                ->orderBy('id', 'desc')
                ->first();

            $nextSequence = 1;
            if ($latestPatient && preg_match('/REG-\d{4}-(\d+)/', $latestPatient->registration_no, $matches)) {
                $nextSequence = (int)$matches[1] + 1;
            }

            $registrationNo = sprintf("REG-%s-%03d", $currentYear, $nextSequence);
        }

        $patient->update([
            'record_date' => $request->record_date,
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'father_husband_name' => $request->guardian_name ?? $request->father_husband_name,
            'rcdho_grade' => $request->rcdho_grade,
            'address' => $request->address,
            'mobile_no' => $request->mobile ?? $request->mobile_no,
            'mail' => $request->mail,
            'registration_no' => $registrationNo,
        ]);

        $matchAttributes = ['patient_id' => $patient->id];
        if (!empty($record?->id)) {
            $matchAttributes['id'] = $record->id;
        }

        PatientClinicalRecord::updateOrCreate(
            $matchAttributes,
            [
                'newly_detected' => $request->newly_detected,
                'duration_of_diabetes' => $request->diabetes_duration ?? $request->duration_of_diabetes,
                'insuline_brand' => $request->insuline_brand,
                'insuline_unit' => $request->insuline_unit,
                'start_insulin_date' => $request->insulin_start_date ?? $request->start_insulin_date,
                'stop_insulin_date' => $request->insulin_stop_date ?? $request->stop_insulin_date,
                'attachment' => $attachmentPath,
                'height_cm' => $request->height ?? $request->height_cm,
                'weight_kg' => $request->weight ?? $request->weight_kg,
                'bmi' => $request->bmi,
                'temprature' => $request->temprature ?? $request->temperature,
                'waist_height_ratio' => $request->waist_height_ratio,
                'bmi_group' => $request->bmi_group,
                'waist_cm' => $request->waist ?? $request->waist_cm,
                'hip_cm' => $request->hip ?? $request->hip_cm,
                'waist_hip_ratio' => $request->waist_hip_ratio,
                'social_class' => $request->social_class,
                'income_class' => $request->income_class,
                'education' => $request->education,
                'physical_activity' => $request->physical_activity,
                'veg_nonveg' => $request->veg_nonveg ?? $request->diet_type,
                'htn' => $request->htn,
                'sbp' => $request->sbp,
                'dbp' => $request->dbp,
                'hb_percent' => $request->hb ?? $request->hb_percent,
                'plt' => $request->plt,
                'mcv' => $request->mcv,
                'creatinine' => $request->creatinine,
                'egfr' => $request->egfr,
                'acr' => $request->acr,
                'uric_acid' => $request->uric_acid,
                'urine_cast_cell' => $request->urine_cast_cell,
                'na_plus' => $request->sodium ?? $request->na_plus,
                'k_plus' => $request->potassium ?? $request->k_plus,
                'i_calcium' => $request->ionized_calcium ?? $request->i_calcium,
                'phosphorus' => $request->phosphorus,
                'sgpt' => $request->sgpt,
                'sgot' => $request->sgot,
                'alkp' => $request->alkp,
                'hiv' => $request->hiv,
                'hbsag' => $request->hbsag,
                'hcv' => $request->hcv,
                'fib_score' => $request->fib_score,
                'fib_scan' => $request->fib_scan,
                'median_stiffness' => $request->median_stiffness,
                'usg' => $request->usg,
                'chol' => $request->cholesterol ?? $request->chol,
                'tg' => $request->triglycerides ?? $request->tg,
                'hdl' => $request->hdl,
                'ldl' => $request->ldl,
                'bsf' => $request->bsf,
                'bspp' => $request->bspp,
                'hba1c' => $request->hba1c,
                'tsh' => $request->tsh,
                't3' => $request->t3,
                't4' => $request->t4,
                'vitamin_d25' => $request->vitamin_d25,
                'vitamin_b12' => $request->vitamin_b12,
                's_cortisol' => $request->cortisol ?? $request->s_cortisol,
                'dex_skip_test' => $request->dex_suppression_test ?? $request->dex_skip_test,
                'ophthalmic_ex' => $request->ophthalmic_exam ?? $request->ophthalmic_ex,
                'foot_ev' => $request->foot_exam ?? $request->foot_ev,
                'car_echo_ev' => $request->echo_exam ?? $request->car_echo_ev,
                'diabetes' => $diabetes,
                'hypertension' => $hypertension,
                'obesity' => $obesity,
                'infection' => $infection,
            ]
        );

        return redirect()->route('list.patient')
            ->with('success', 'Patient clinical record updated successfully.');
    }
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            foreach ($patient->clinicalRecords as $rec) {
                if ($rec->attachment) {
                    Storage::disk('public')->delete($rec->attachment);
                }
                $rec->delete();
            }
            $patient->delete();
            return redirect()->route('list.patient')
                ->with('success', 'Patient and all clinical records deleted successfully!');
        }

        $record = PatientClinicalRecord::findOrFail($id);
        if ($record->attachment) {
            Storage::disk('public')->delete($record->attachment);
        }

        $record->delete();
        return redirect()->route('list.patient')
            ->with('success', 'Patient clinical record deleted successfully!');
    }


    public function search(Request $request)
    {
        $query = PatientClinicalRecord::query();

        if ($request->filled('patient_name')) {
            $query->where('patient_name', 'like', '%' . $request->patient_name . '%');
        }

        if ($request->filled('registration_no')) {
            $query->where('registration_no', 'like', '%' . $request->registration_no . '%');
        }

        if ($request->filled('mobile_no')) {
            $query->where('mobile_no', 'like', '%' . $request->mobile_no . '%');
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('record_date', [$request->from_date, $request->to_date]);
        }

        $records = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.patients.listing', compact('records'));
    }



    public function addnewReport($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $data = $patient->latestRecord ?? $patient->clinicalRecords()->latest('id')->first();
            if (!$data) {
                $data = new PatientClinicalRecord(['patient_id' => $patient->id]);
                $data->setRelation('patient', $patient);
            }
        } else {
            $data = PatientClinicalRecord::with(['patient'])->findOrFail($id);
        }

        return view('admin.patients.secreport', compact('data'));
    }

    public function createNewRecord(Request $request, $id)
    {
        $request->validate([
            'has_diabetes' => 'nullable',
            'newly_detected' => 'nullable|string|max:50',
            'diabetes_duration' => 'nullable|string|max:50',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'insuline_brand' => 'nullable|string|max:100',
            'insuline_unit' => 'nullable|string|max:100',
            'insulin_start_date' => 'nullable|date',
            'start_insulin_date' => 'nullable|date',
            'insulin_stop_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',

            'height' => 'nullable|numeric|min:0|max:300',
            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|string|max:50',
            'waist' => 'nullable|numeric|min:0|max:300',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',

            'social_class' => 'nullable|string|max:50',
            'income_class' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:100',
            'physical_activity' => 'nullable|string|max:50',
            'diet_type' => 'nullable|string|max:50',
            'veg_nonveg' => 'nullable|string|max:50',

            'htn' => 'nullable|string|max:50',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb' => 'nullable|string|max:20',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:50',
            'sodium' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'potassium' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'ionized_calcium' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|string|max:50',
            'hbsag' => 'nullable|string|max:50',
            'hcv' => 'nullable|string|max:50',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:50',
            'median_stiffness' => 'nullable|string|max:50',
            'usg' => 'nullable|string|max:500',
            'chol' => 'nullable|string|max:20',
            'cholesterol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
            'triglycerides' => 'nullable|string|max:20',
            'hdl' => 'nullable|string|max:20',
            'ldl' => 'nullable|string|max:20',
            'bsf' => 'nullable|string|max:20',
            'bspp' => 'nullable|string|max:20',
            'hba1c' => 'nullable|string|max:20',
            'tsh' => 'nullable|string|max:20',
            't3' => 'nullable|string|max:20',
            't4' => 'nullable|string|max:20',
            'vitamin_d25' => 'nullable|string|max:20',
            'vitamin_b12' => 'nullable|string|max:20',
            's_cortisol' => 'nullable|string|max:20',
            'cortisol' => 'nullable|string|max:20',
            'dex_skip_test' => 'nullable|string|max:100',
            'dex_suppression_test' => 'nullable|string|max:100',
            'temprature' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'ophthalmic_exam' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'foot_exam' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
            'echo_exam' => 'nullable|string|max:500',
        ]);

        $patientId = $request->patient_id;
        $patient = null;
        if (!$patientId) {
            $patient = Patient::find($id);
            if ($patient) {
                $patientId = $patient->id;
            } else {
                $rec = PatientClinicalRecord::find($id);
                $patientId = $rec?->patient_id;
                $patient = $rec?->patient;
            }
        } else {
            $patient = Patient::find($patientId);
        }

        $diabetes = "Normal";
        $hypertension = "Normal";
        $infection = "Normal";
        $obesity = "Normal";

        $hba1c = $request->hba1c;
        $bsf = $request->bsf ?? $request->fbs;
        $bspp = $request->bspp ?? $request->rbs;

        if (
            $request->has_diabetes ||
            $request->newly_detected === 'Yes' ||
            ($request->filled('hba1c') && (float)$hba1c >= 6.5) ||
            ($request->filled('bsf') && (float)$bsf >= 126) ||
            ($request->filled('fbs') && (float)$bsf >= 126) ||
            ($request->filled('bspp') && (float)$bspp >= 200) ||
            ($request->filled('rbs') && (float)$bspp >= 200)
        ) {
            $diabetes = "Diabetes";
        }

        if (
            $request->htn === 'Yes' ||
            ($request->filled('sbp') && (float)$request->sbp >= 130) ||
            ($request->filled('dbp') && (float)$request->dbp >= 90)
        ) {
            $hypertension = "Hypertension";
        }

        $temperatureVal = $request->temprature ?? $request->temperature;
        if (
            ($request->filled('temprature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('temperature') && (float)$temperatureVal >= 99.4) ||
            ($request->filled('wbc') && (float)$request->wbc > 11000) ||
            ($request->filled('crp') && (float)$request->crp > 10)
        ) {
            $infection = "Infection";
        }

        $waistVal = $request->waist ?? $request->waist_cm;
        $genderVal = $request->gender ?? $patient?->gender ?? null;
        if (
            ($request->filled('bmi') && (float)$request->bmi >= 25) ||
            ($genderVal === 'Male' && !empty($waistVal) && (float)$waistVal > 90) ||
            ($genderVal === 'Female' && !empty($waistVal) && (float)$waistVal > 80)
        ) {
            $obesity = "Obesity";
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
        }

        PatientClinicalRecord::create([
            "patient_id" => $patientId,
            'newly_detected' => $request->newly_detected,
            'duration_of_diabetes' => $request->diabetes_duration ?? $request->duration_of_diabetes,
            'insuline_brand' => $request->insuline_brand,
            'insuline_unit' => $request->insuline_unit,
            'start_insulin_date' => $request->insulin_start_date ?? $request->start_insulin_date,
            'stop_insulin_date' => $request->insulin_stop_date ?? $request->stop_insulin_date,
            'attachment' => $attachmentPath,
            'height_cm' => $request->height ?? $request->height_cm,
            'weight_kg' => $request->weight ?? $request->weight_kg,
            'bmi' => $request->bmi,
            'temprature' => $request->temprature ?? $request->temperature,
            'waist_height_ratio' => $request->waist_height_ratio,
            'bmi_group' => $request->bmi_group,
            'waist_cm' => $request->waist ?? $request->waist_cm,
            'hip_cm' => $request->hip ?? $request->hip_cm,
            'waist_hip_ratio' => $request->waist_hip_ratio,
            'social_class' => $request->social_class,
            'income_class' => $request->income_class,
            'education' => $request->education,
            'physical_activity' => $request->physical_activity,
            'veg_nonveg' => $request->veg_nonveg ?? $request->diet_type,
            'htn' => $request->htn,
            'sbp' => $request->sbp,
            'dbp' => $request->dbp,
            'hb_percent' => $request->hb ?? $request->hb_percent,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->sodium ?? $request->na_plus,
            'k_plus' => $request->potassium ?? $request->k_plus,
            'i_calcium' => $request->ionized_calcium ?? $request->i_calcium,
            'phosphorus' => $request->phosphorus,
            'sgpt' => $request->sgpt,
            'sgot' => $request->sgot,
            'alkp' => $request->alkp,
            'hiv' => $request->hiv,
            'hbsag' => $request->hbsag,
            'hcv' => $request->hcv,
            'fib_score' => $request->fib_score,
            'fib_scan' => $request->fib_scan,
            'median_stiffness' => $request->median_stiffness,
            'usg' => $request->usg,
            'chol' => $request->cholesterol ?? $request->chol,
            'tg' => $request->triglycerides ?? $request->tg,
            'hdl' => $request->hdl,
            'ldl' => $request->ldl,
            'bsf' => $request->bsf,
            'bspp' => $request->bspp,
            'hba1c' => $request->hba1c,
            'tsh' => $request->tsh,
            't3' => $request->t3,
            't4' => $request->t4,
            'vitamin_d25' => $request->vitamin_d25,
            'vitamin_b12' => $request->vitamin_b12,
            's_cortisol' => $request->cortisol ?? $request->s_cortisol,
            'dex_skip_test' => $request->dex_suppression_test ?? $request->dex_skip_test,
            'ophthalmic_ex' => $request->ophthalmic_exam ?? $request->ophthalmic_ex,
            'foot_ev' => $request->foot_exam ?? $request->foot_ev,
            'car_echo_ev' => $request->echo_exam ?? $request->car_echo_ev,
            'diabetes' => $diabetes,
            'hypertension' => $hypertension,
            'obesity' => $obesity,
            'infection' => $infection,
        ]);

        return redirect()->route('list.patient')
            ->with('success', 'New Report Added SuccessFuly');
    }


    public function diseaseAnalytics()
    {
        $allRecords = PatientClinicalRecord::with('patient')->latest()->get();
        $totalPatients = Patient::count();
        $totalConsultations = $allRecords->count();

        // 1. Diagnostic Matrix Aggregation (Pre-conditions vs Frank Disease)
        $diabetes = 0; $preDiabetes = 0; $normalGlycemic = 0;
        $hypertension = 0; $preHypertension = 0; $normalBp = 0;
        $obesity = 0; $overweight = 0; $normalBmi = 0; $underweight = 0;
        $infection = 0; $normalTemp = 0;

        // 2. Comorbidity & Medical Research Indices
        $metabolicTriad = 0;
        $cardioRenal = 0;
        $diabeticNephropathy = 0;
        $dyslipidemia = 0;
        $liverStress = 0;
        $multiMorbidity = 0;

        // 3. Demographic Cohort Stats
        $maleCount = 0; $femaleCount = 0;
        $ageUnder30 = 0; $age30to45 = 0; $age46to60 = 0; $ageOver60 = 0;

        // Process and classify each clinical record
        foreach ($allRecords as $r) {
            // Glycemic Matrix: HbA1c 5.7%-6.4% (Pre-Diabetes), >=6.5% (Diabetes)
            $hba1c = floatval($r->hba1c ?? 0);
            $bsf = floatval($r->bsf ?? 0);
            $diabStatus = strtolower($r->diabetes ?? '');
            $isDiab = $hba1c >= 6.5 || $bsf >= 126 || (str_contains($diabStatus, 'diabet') && !str_contains($diabStatus, 'pre'));
            $isPreDiab = (($hba1c >= 5.7 && $hba1c < 6.5) || ($bsf >= 100 && $bsf < 126) || str_contains($diabStatus, 'pre')) && !$isDiab;

            if ($isDiab) {
                $diabetes++;
                $r->diab_class = 'Diabetes';
            } elseif ($isPreDiab) {
                $preDiabetes++;
                $r->diab_class = 'Pre-Diabetes';
            } else {
                $normalGlycemic++;
                $r->diab_class = 'Normal';
            }

            // Blood Pressure Matrix: SBP > 130 or DBP > 85 (Pre-HTN), SBP >= 140 or DBP >= 90 (HTN)
            $sbp = intval($r->sbp ?? 0);
            $dbp = intval($r->dbp ?? 0);
            $htnStatus = strtolower($r->hypertension ?? '');
            $isHtn = $sbp >= 140 || $dbp >= 90 || str_contains($htnStatus, 'stage') || (str_contains($htnStatus, 'hyper') && !str_contains($htnStatus, 'pre'));
            $isPreHtn = (($sbp >= 130 && $sbp < 140) || ($dbp >= 85 && $dbp < 90) || str_contains($htnStatus, 'pre')) && !$isHtn;

            if ($isHtn) {
                $hypertension++;
                $r->htn_class = 'Hypertension';
            } elseif ($isPreHtn) {
                $preHypertension++;
                $r->htn_class = 'Pre-Hypertension';
            } else {
                $normalBp++;
                $r->htn_class = 'Normal';
            }

            // Obesity & BMI Matrix: BMI >= 25 (Obese), 23-24.9 (Overweight), <18.5 (Underweight)
            $bmi = floatval($r->bmi ?? 0);
            $obStatus = strtolower($r->obesity ?? '');
            $isObese = $bmi >= 25 || str_contains($obStatus, 'obese');
            $isOverweight = (($bmi >= 23 && $bmi < 25) || str_contains($obStatus, 'overweight')) && !$isObese;

            if ($isObese) {
                $obesity++;
                $r->bmi_class = 'Obese';
            } elseif ($isOverweight) {
                $overweight++;
                $r->bmi_class = 'Overweight';
            } elseif ($bmi > 0 && $bmi < 18.5) {
                $underweight++;
                $r->bmi_class = 'Underweight';
            } else {
                $normalBmi++;
                $r->bmi_class = 'Normal';
            }

            // Infection / Temperature Matrix: Temp > 99.4°F
            $temp = floatval($r->temprature ?? 0);
            $infStatus = strtolower($r->infection ?? '');
            $isInfection = $temp > 99.4 || (!empty($r->infection) && $infStatus !== 'normal');

            if ($isInfection) {
                $infection++;
                $r->temp_class = 'Infection';
            } else {
                $normalTemp++;
                $r->temp_class = 'Normal';
            }

            // Renal Complication Marker
            $creat = floatval($r->creatinine ?? 0);
            $egfr = floatval($r->egfr ?? 0);
            $isRenalHigh = $creat >= 1.3 || ($egfr > 0 && $egfr < 60);

            // Dyslipidemia Marker
            $chol = floatval($r->chol ?? 0);
            $tg = floatval($r->tg ?? 0);
            $isDyslip = $chol >= 200 || $tg >= 150;
            if ($isDyslip) $dyslipidemia++;

            // Liver Stress Marker
            $sgpt = floatval($r->sgpt ?? 0);
            $isLiverElevated = $sgpt >= 45;
            if ($isLiverElevated) $liverStress++;

            // Cross-Condition Research Comorbidities
            if ($isDiab && $isHtn && $isObese) $metabolicTriad++;
            if ($isHtn && $isRenalHigh) $cardioRenal++;
            if ($isDiab && $isRenalHigh) $diabeticNephropathy++;

            $chronicCount = ($isDiab ? 1 : 0) + ($isHtn ? 1 : 0) + ($isObese ? 1 : 0) + ($isDyslip ? 1 : 0) + ($isRenalHigh ? 1 : 0);
            if ($chronicCount >= 2) $multiMorbidity++;

            $r->is_metabolic_triad = ($isDiab && $isHtn && $isObese);
            $r->is_multimorbidity = ($chronicCount >= 2);

            // Demographics
            if ($r->patient) {
                $gender = strtolower($r->patient->gender ?? '');
                if ($gender === 'male') $maleCount++;
                elseif ($gender === 'female') $femaleCount++;

                $age = intval($r->patient->age ?? 0);
                if ($age > 0) {
                    if ($age < 30) $ageUnder30++;
                    elseif ($age <= 45) $age30to45++;
                    elseif ($age <= 60) $age46to60++;
                    else $ageOver60++;
                }
            }
        }

        // Monthly longitudinal trend
        $monthlyTrend = PatientClinicalRecord::selectRaw("
            MONTH(created_at) as month,
            COUNT(*) as total,
            SUM(CASE WHEN (hba1c >= 6.5 OR bsf >= 126 OR (diabetes IS NOT NULL AND LOWER(diabetes) LIKE '%diabet%')) THEN 1 ELSE 0 END) as diabetes_count,
            SUM(CASE WHEN (sbp >= 140 OR dbp >= 90 OR (hypertension IS NOT NULL AND LOWER(hypertension) LIKE '%hyper%')) THEN 1 ELSE 0 END) as hypertension_count,
            SUM(CASE WHEN (bmi >= 25 OR (obesity IS NOT NULL AND LOWER(obesity) LIKE '%obese%')) THEN 1 ELSE 0 END) as obesity_count,
            SUM(CASE WHEN (temprature > 99.4 OR (infection IS NOT NULL AND LOWER(infection) != 'normal')) THEN 1 ELSE 0 END) as infection_count
        ")
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get();

        $monthlyTrend->each(function ($item) {
            $item->prevalence_percentage = $item->total > 0
                ? round(($item->diabetes_count / $item->total * 100), 1)
                : 0;
        });

        $obese = $obesity;

        return view('admin.analytics.analytics', compact(
            'totalPatients',
            'totalConsultations',
            'allRecords',
            'diabetes',
            'preDiabetes',
            'normalGlycemic',
            'hypertension',
            'preHypertension',
            'normalBp',
            'obese',
            'obesity',
            'overweight',
            'normalBmi',
            'underweight',
            'infection',
            'normalTemp',
            'metabolicTriad',
            'cardioRenal',
            'diabeticNephropathy',
            'dyslipidemia',
            'liverStress',
            'multiMorbidity',
            'maleCount',
            'femaleCount',
            'ageUnder30',
            'age30to45',
            'age46to60',
            'ageOver60',
            'monthlyTrend'
        ));
    }

    public function exportDiseaseAnalytics(Request $request)
    {
        $type = strtolower($request->get('type', 'all'));
        $filename = 'disease_analytics_' . $type . '_' . date('Y-m-d_His') . '.csv';

        $query = PatientClinicalRecord::with('patient')->latest();

        // Specific disease filters
        if ($type === 'diabetes') {
            $query->where(function ($q) {
                $q->where('hba1c', '>=', 6.5)
                  ->orWhere('bsf', '>=', 126)
                  ->orWhere('diabetes', '!=', 'Normal');
            });
        } elseif ($type === 'pre_diabetes') {
            $query->where(function ($q) {
                $q->whereBetween('hba1c', [5.7, 6.4])
                  ->orWhereBetween('bsf', [100, 125])
                  ->orWhere('diabetes', 'like', '%pre%');
            });
        } elseif ($type === 'hypertension') {
            $query->where(function ($q) {
                $q->where('sbp', '>=', 140)
                  ->orWhere('dbp', '>=', 90)
                  ->orWhere('hypertension', '!=', 'Normal')
                  ->orWhere('htn', 'Yes');
            });
        } elseif ($type === 'pre_hypertension') {
            $query->where(function ($q) {
                $q->whereBetween('sbp', [130, 139])
                  ->orWhereBetween('dbp', [85, 89])
                  ->orWhere('hypertension', 'like', '%pre%');
            });
        } elseif ($type === 'obesity') {
            $query->where(function ($q) {
                $q->where('bmi', '>=', 25)
                  ->orWhere('obesity', '!=', 'Normal');
            });
        } elseif ($type === 'infection') {
            $query->where(function ($q) {
                $q->where('temprature', '>', 99.4)
                  ->orWhere('infection', '!=', 'Normal');
            });
        }

        $records = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($records, $type) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            if ($type === 'diabetes' || $type === 'pre_diabetes') {
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Diagnostic Status', 'HbA1c (%)', 'Fasting Blood Sugar (BSF mg/dL)', 'Postprandial Sugar (BSPP mg/dL)',
                    'Newly Detected', 'Duration of Diabetes (Yrs)', 'Insulin Start Date', 'Insulin Stop Date',
                    'Insulin Brand', 'Insulin Unit',
                    'BMI (kg/m²)', 'Weight (kg)', 'SBP (mmHg)', 'DBP (mmHg)',
                    'Serum Creatinine (mg/dL)', 'eGFR (mL/min)', 'Microalbuminuria ACR',
                    'Total Cholesterol', 'Triglycerides', 'HDL', 'LDL',
                    'Ophthalmic Exam', 'Foot Exam', 'Echo / Cardiac Exam'
                ]);

                foreach ($records as $r) {
                    $hba1c = floatval($r->hba1c ?? 0);
                    $bsf = floatval($r->bsf ?? 0);
                    $status = ($hba1c >= 6.5 || $bsf >= 126 || str_contains(strtolower($r->diabetes ?? ''), 'diabet')) ? 'Diabetes' : (($hba1c >= 5.7 || $bsf >= 100) ? 'Pre-Diabetes' : ($r->diabetes ?? 'Normal'));

                    fputcsv($handle, [
                        $r->id,
                        $r->patient_id,
                        $r->patient->patient_name ?? 'N/A',
                        $r->patient->age ?? 'N/A',
                        $r->patient->gender ?? 'N/A',
                        $r->patient->mobile ?? 'N/A',
                        $r->patient->address ?? 'N/A',
                        $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                        $status,
                        $r->hba1c ?: '-',
                        $r->bsf ?: '-',
                        $r->bspp ?: '-',
                        $r->newly_detected ?: '-',
                        $r->duration_of_diabetes ?: '-',
                        $r->start_insulin_date ?: '-',
                        $r->stop_insulin_date ?: '-',
                        $r->insuline_brand ?: '-',
                        $r->insuline_unit ?: '-',
                        $r->bmi ?: '-',
                        $r->weight_kg ?: '-',
                        $r->sbp ?: '-',
                        $r->dbp ?: '-',
                        $r->creatinine ?: '-',
                        $r->egfr ?: '-',
                        $r->acr ?: '-',
                        $r->chol ?: '-',
                        $r->tg ?: '-',
                        $r->hdl ?: '-',
                        $r->ldl ?: '-',
                        $r->ophthalmic_ex ?: '-',
                        $r->foot_ev ?: '-',
                        $r->car_echo_ev ?: '-'
                    ]);
                }
            } elseif ($type === 'hypertension' || $type === 'pre_hypertension') {
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Vascular Status', 'Known HTN History', 'Systolic BP (SBP mmHg)', 'Diastolic BP (DBP mmHg)',
                    'Pulse Pressure (mmHg)', 'Mean Arterial Pressure (MAP mmHg)',
                    'BMI (kg/m²)', 'HbA1c (%)', 'Creatinine (mg/dL)', 'eGFR (mL/min)',
                    'Serum Sodium (Na+)', 'Serum Potassium (K+)',
                    'Total Cholesterol', 'Triglycerides', 'HDL', 'LDL',
                    'Cardiac Echo Exam', 'Ophthalmic Exam'
                ]);

                foreach ($records as $r) {
                    $sbp = intval($r->sbp ?? 0);
                    $dbp = intval($r->dbp ?? 0);
                    $pp = ($sbp > 0 && $dbp > 0) ? ($sbp - $dbp) : '-';
                    $map = ($sbp > 0 && $dbp > 0) ? round($dbp + (($sbp - $dbp) / 3), 1) : '-';
                    $status = ($sbp >= 140 || $dbp >= 90 || str_contains(strtolower($r->hypertension ?? ''), 'stage')) ? 'Hypertension' : (($sbp >= 130 || $dbp >= 85) ? 'Pre-Hypertension' : ($r->hypertension ?? 'Normal'));

                    fputcsv($handle, [
                        $r->id,
                        $r->patient_id,
                        $r->patient->patient_name ?? 'N/A',
                        $r->patient->age ?? 'N/A',
                        $r->patient->gender ?? 'N/A',
                        $r->patient->mobile ?? 'N/A',
                        $r->patient->address ?? 'N/A',
                        $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                        $status,
                        $r->htn ?: ($r->hypertension ?? '-'),
                        $r->sbp ?: '-',
                        $r->dbp ?: '-',
                        $pp,
                        $map,
                        $r->bmi ?: '-',
                        $r->hba1c ?: '-',
                        $r->creatinine ?: '-',
                        $r->egfr ?: '-',
                        $r->na_plus ?: '-',
                        $r->k_plus ?: '-',
                        $r->chol ?: '-',
                        $r->tg ?: '-',
                        $r->hdl ?: '-',
                        $r->ldl ?: '-',
                        $r->car_echo_ev ?: '-',
                        $r->ophthalmic_ex ?: '-'
                    ]);
                }
            } elseif ($type === 'obesity') {
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Adiposity Status', 'Height (cm)', 'Weight (kg)', 'BMI (kg/m²)', 'BMI Category',
                    'Waist Circumference (cm)', 'Hip Circumference (cm)', 'Waist-Hip Ratio (WHR)', 'Waist-Height Ratio (WHtR)',
                    'Physical Activity', 'Diet (Veg/Non-Veg)', 'Social Class', 'Income Class',
                    'SBP (mmHg)', 'DBP (mmHg)', 'HbA1c (%)', 'Fasting Blood Sugar (BSF)',
                    'Total Cholesterol', 'Triglycerides', 'SGPT (ALT U/L)', 'SGOT (AST U/L)', 'ALKP',
                    'FibroScan Score', 'Median Stiffness', 'USG Findings'
                ]);

                foreach ($records as $r) {
                    $bmi = floatval($r->bmi ?? 0);
                    $status = ($bmi >= 25 || str_contains(strtolower($r->obesity ?? ''), 'obese')) ? 'Obese' : (($bmi >= 23) ? 'Overweight' : (($bmi > 0 && $bmi < 18.5) ? 'Underweight' : ($r->obesity ?? 'Normal')));

                    fputcsv($handle, [
                        $r->id,
                        $r->patient_id,
                        $r->patient->patient_name ?? 'N/A',
                        $r->patient->age ?? 'N/A',
                        $r->patient->gender ?? 'N/A',
                        $r->patient->mobile ?? 'N/A',
                        $r->patient->address ?? 'N/A',
                        $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                        $status,
                        $r->height_cm ?: '-',
                        $r->weight_kg ?: '-',
                        $r->bmi ?: '-',
                        $r->bmi_group ?: $status,
                        $r->waist_cm ?: '-',
                        $r->hip_cm ?: '-',
                        $r->waist_hip_ratio ?: '-',
                        $r->waist_height_ratio ?: '-',
                        $r->physical_activity ?: '-',
                        $r->veg_nonveg ?: '-',
                        $r->social_class ?: '-',
                        $r->income_class ?: '-',
                        $r->sbp ?: '-',
                        $r->dbp ?: '-',
                        $r->hba1c ?: '-',
                        $r->bsf ?: '-',
                        $r->chol ?: '-',
                        $r->tg ?: '-',
                        $r->sgpt ?: '-',
                        $r->sgot ?: '-',
                        $r->alkp ?: '-',
                        $r->fib_score ?: '-',
                        $r->median_stiffness ?: '-',
                        $r->usg ?: '-'
                    ]);
                }
            } elseif ($type === 'infection') {
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Infection Status', 'Body Temperature (°F)', 'Infection Diagnosis Details',
                    'Hemoglobin (Hb %)', 'Platelets (PLT)', 'MCV', 'Urine Routine / Cast Cells',
                    'HIV Serology', 'HBsAg Serology', 'HCV Serology',
                    'Serum Sodium (Na+)', 'Serum Potassium (K+)', 'Ionized Calcium', 'Phosphorus',
                    'Serum Creatinine', 'SGPT', 'Total Cholesterol'
                ]);

                foreach ($records as $r) {
                    $temp = floatval($r->temprature ?? 0);
                    $status = ($temp > 99.4 || (!empty($r->infection) && strtolower($r->infection) !== 'normal')) ? 'Infection / Febrile' : ($r->infection ?? 'Normal');

                    fputcsv($handle, [
                        $r->id,
                        $r->patient_id,
                        $r->patient->patient_name ?? 'N/A',
                        $r->patient->age ?? 'N/A',
                        $r->patient->gender ?? 'N/A',
                        $r->patient->mobile ?? 'N/A',
                        $r->patient->address ?? 'N/A',
                        $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                        $status,
                        $r->temprature ? $r->temprature . ' °F' : '-',
                        $r->infection ?: '-',
                        $r->hb_percent ?: '-',
                        $r->plt ?: '-',
                        $r->mcv ?: '-',
                        $r->urine_cast_cell ?: '-',
                        $r->hiv ?: '-',
                        $r->hbsag ?: '-',
                        $r->hcv ?: '-',
                        $r->na_plus ?: '-',
                        $r->k_plus ?: '-',
                        $r->i_calcium ?: '-',
                        $r->phosphorus ?: '-',
                        $r->creatinine ?: '-',
                        $r->sgpt ?: '-',
                        $r->chol ?: '-'
                    ]);
                }
            } elseif ($type === 'triad') {
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Diabetes Status', 'HbA1c (%)', 'BSF (mg/dL)',
                    'Hypertension Status', 'SBP (mmHg)', 'DBP (mmHg)',
                    'Obesity Status', 'BMI (kg/m²)', 'Weight (kg)',
                    'Serum Creatinine', 'eGFR', 'SGPT', 'Cholesterol', 'Triglycerides',
                    'Metabolic Triad Status'
                ]);

                foreach ($records as $r) {
                    $hba1c = floatval($r->hba1c ?? 0);
                    $bsf = floatval($r->bsf ?? 0);
                    $isDiab = $hba1c >= 6.5 || $bsf >= 126 || str_contains(strtolower($r->diabetes ?? ''), 'diabet');

                    $sbp = intval($r->sbp ?? 0);
                    $dbp = intval($r->dbp ?? 0);
                    $isHtn = $sbp >= 140 || $dbp >= 90 || str_contains(strtolower($r->hypertension ?? ''), 'stage') || str_contains(strtolower($r->hypertension ?? ''), 'hyper');

                    $bmi = floatval($r->bmi ?? 0);
                    $isObese = $bmi >= 25 || str_contains(strtolower($r->obesity ?? ''), 'obese');

                    if ($isDiab && $isHtn && $isObese) {
                        fputcsv($handle, [
                            $r->id,
                            $r->patient_id,
                            $r->patient->patient_name ?? 'N/A',
                            $r->patient->age ?? 'N/A',
                            $r->patient->gender ?? 'N/A',
                            $r->patient->mobile ?? 'N/A',
                            $r->patient->address ?? 'N/A',
                            $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                            $r->diabetes ?? 'Diabetes',
                            $r->hba1c ?: '-',
                            $r->bsf ?: '-',
                            $r->hypertension ?? 'Hypertension',
                            $r->sbp ?: '-',
                            $r->dbp ?: '-',
                            $r->obesity ?? 'Obese',
                            $r->bmi ?: '-',
                            $r->weight_kg ?: '-',
                            $r->creatinine ?: '-',
                            $r->egfr ?: '-',
                            $r->sgpt ?: '-',
                            $r->chol ?: '-',
                            $r->tg ?: '-',
                            'Metabolic Syndrome Triad (Active)'
                        ]);
                    }
                }
            } else {
                // Master All-Variables Comprehensive Clinical Research Export
                fputcsv($handle, [
                    'Record ID', 'Patient ID', 'Patient Name', 'Age', 'Gender', 'Mobile', 'Address', 'Consultation Date',
                    'Diabetes Classification', 'HbA1c (%)', 'Fasting Blood Sugar (BSF)', 'Postprandial Sugar (BSPP)', 'Newly Detected Diab', 'Duration Diab (Yrs)', 'Insulin Start', 'Insulin Stop', 'Insulin Brand', 'Insulin Unit',
                    'Hypertension Classification', 'Known HTN', 'SBP (mmHg)', 'DBP (mmHg)',
                    'Obesity Classification', 'Height (cm)', 'Weight (kg)', 'BMI (kg/m²)', 'BMI Group', 'Waist (cm)', 'Hip (cm)', 'WHR', 'WHtR', 'Diet', 'Activity', 'Social Class', 'Income Class',
                    'Infection Classification', 'Body Temp (°F)', 'Infection Notes', 'HIV', 'HBsAg', 'HCV', 'Urine Cast Cells',
                    'Hb (%)', 'Platelet Count', 'MCV',
                    'Creatinine (mg/dL)', 'eGFR (mL/min)', 'ACR', 'Uric Acid', 'Na+', 'K+', 'Ionized Calcium', 'Phosphorus',
                    'SGPT (ALT)', 'SGOT (AST)', 'ALKP', 'FibroScan Score', 'Median Stiffness', 'USG Notes',
                    'Total Cholesterol', 'Triglycerides', 'HDL', 'LDL',
                    'TSH', 'T3', 'T4', 'Vitamin D25', 'Vitamin B12', 'Serum Cortisol', 'Dexamethasone Test',
                    'Ophthalmic Exam', 'Foot Exam', 'Echo Exam'
                ]);

                foreach ($records as $r) {
                    fputcsv($handle, [
                        $r->id,
                        $r->patient_id,
                        $r->patient->patient_name ?? 'N/A',
                        $r->patient->age ?? 'N/A',
                        $r->patient->gender ?? 'N/A',
                        $r->patient->mobile ?? 'N/A',
                        $r->patient->address ?? 'N/A',
                        $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                        $r->diabetes ?? 'Normal',
                        $r->hba1c ?: '-',
                        $r->bsf ?: '-',
                        $r->bspp ?: '-',
                        $r->newly_detected ?: '-',
                        $r->duration_of_diabetes ?: '-',
                        $r->start_insulin_date ?: '-',
                        $r->stop_insulin_date ?: '-',
                        $r->insuline_brand ?: '-',
                        $r->insuline_unit ?: '-',
                        $r->hypertension ?? 'Normal',
                        $r->htn ?: '-',
                        $r->sbp ?: '-',
                        $r->dbp ?: '-',
                        $r->obesity ?? 'Normal',
                        $r->height_cm ?: '-',
                        $r->weight_kg ?: '-',
                        $r->bmi ?: '-',
                        $r->bmi_group ?: '-',
                        $r->waist_cm ?: '-',
                        $r->hip_cm ?: '-',
                        $r->waist_hip_ratio ?: '-',
                        $r->waist_height_ratio ?: '-',
                        $r->veg_nonveg ?: '-',
                        $r->physical_activity ?: '-',
                        $r->social_class ?: '-',
                        $r->income_class ?: '-',
                        $r->infection ?? 'Normal',
                        $r->temprature ? $r->temprature . ' °F' : '-',
                        $r->infection ?: '-',
                        $r->hiv ?: '-',
                        $r->hbsag ?: '-',
                        $r->hcv ?: '-',
                        $r->urine_cast_cell ?: '-',
                        $r->hb_percent ?: '-',
                        $r->plt ?: '-',
                        $r->mcv ?: '-',
                        $r->creatinine ?: '-',
                        $r->egfr ?: '-',
                        $r->acr ?: '-',
                        $r->uric_acid ?: '-',
                        $r->na_plus ?: '-',
                        $r->k_plus ?: '-',
                        $r->i_calcium ?: '-',
                        $r->phosphorus ?: '-',
                        $r->sgpt ?: '-',
                        $r->sgot ?: '-',
                        $r->alkp ?: '-',
                        $r->fib_score ?: '-',
                        $r->median_stiffness ?: '-',
                        $r->usg ?: '-',
                        $r->chol ?: '-',
                        $r->tg ?: '-',
                        $r->hdl ?: '-',
                        $r->ldl ?: '-',
                        $r->tsh ?: '-',
                        $r->t3 ?: '-',
                        $r->t4 ?: '-',
                        $r->vitamin_d25 ?: '-',
                        $r->vitamin_b12 ?: '-',
                        $r->s_cortisol ?: '-',
                        $r->dex_skip_test ?: '-',
                        $r->ophthalmic_ex ?: '-',
                        $r->foot_ev ?: '-',
                        $r->car_echo_ev ?: '-'
                    ]);
                }
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportPatientRecords($id)
    {
        $patient = Patient::with(['clinicalRecords' => function ($q) {
            $q->orderBy('id', 'asc');
        }])->findOrFail($id);

        $patientNameClean = \Illuminate\Support\Str::slug($patient->patient_name ?? 'patient', '_');
        $filename = 'patient_' . $patient->id . '_' . $patientNameClean . '_clinical_history_' . date('Y-m-d') . '.csv';

        $records = $patient->clinicalRecords;

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($patient, $records) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Patient ID',
                'Patient Name',
                'Age',
                'Gender',
                'Mobile',
                'Email',
                'Address',
                'Marital Status',
                'Occupation',
                'Education',
                'Registration Date',
                'Visit / Record ID',
                'Consultation Date',
                'Diabetes Classification',
                'HbA1c (%)',
                'Fasting Blood Sugar BSF (mg/dL)',
                'Postprandial Sugar BSPP (mg/dL)',
                'Newly Detected Diabetes',
                'Duration of Diabetes (Yrs)',
                'Insulin Start Date',
                'Insulin Stop Date',
                'Insulin Brand',
                'Insulin Unit',
                'Hypertension Classification',
                'Known HTN History',
                'Systolic BP SBP (mmHg)',
                'Diastolic BP DBP (mmHg)',
                'Pulse Pressure (mmHg)',
                'Mean Arterial Pressure (MAP mmHg)',
                'Obesity Classification',
                'Height (cm)',
                'Weight (kg)',
                'BMI (kg/m²)',
                'BMI Category Group',
                'Waist (cm)',
                'Hip (cm)',
                'Waist-Hip Ratio (WHR)',
                'Waist-Height Ratio (WHtR)',
                'Diet (Veg/Non-Veg)',
                'Physical Activity Level',
                'Social Class',
                'Income Class',
                'Infection Status',
                'Body Temperature (°F)',
                'Infection Details',
                'HIV Serology',
                'HBsAg Serology',
                'HCV Serology',
                'Urine Cast Cells',
                'Hemoglobin Hb (%)',
                'Platelets PLT (10^3/uL)',
                'MCV (fL)',
                'Serum Creatinine (mg/dL)',
                'eGFR (mL/min/1.73m²)',
                'Microalbuminuria ACR (mg/g)',
                'Uric Acid (mg/dL)',
                'Serum Sodium Na+ (mEq/L)',
                'Serum Potassium K+ (mEq/L)',
                'Ionized Calcium (mg/dL)',
                'Serum Phosphorus (mg/dL)',
                'SGPT ALT (U/L)',
                'SGOT AST (U/L)',
                'Alkaline Phosphatase ALKP (U/L)',
                'FibroScan Score',
                'Median Stiffness',
                'USG Findings',
                'Total Cholesterol (mg/dL)',
                'Triglycerides TG (mg/dL)',
                'HDL Cholesterol (mg/dL)',
                'LDL Cholesterol (mg/dL)',
                'TSH (uIU/mL)',
                'T3 (ng/dL)',
                'T4 (ug/dL)',
                'Vitamin D25 (ng/mL)',
                'Vitamin B12 (pg/mL)',
                'Serum Cortisol (ug/dL)',
                'Dexamethasone Suppression Test',
                'Ophthalmic Eye Exam',
                'Diabetic Foot Exam',
                'Cardiac Echo / Carotid Exam'
            ]);

            foreach ($records as $r) {
                $sbp = intval($r->sbp ?? 0);
                $dbp = intval($r->dbp ?? 0);
                $pp = ($sbp > 0 && $dbp > 0) ? ($sbp - $dbp) : '-';
                $map = ($sbp > 0 && $dbp > 0) ? round($dbp + (($sbp - $dbp) / 3), 1) : '-';

                fputcsv($handle, [
                    $patient->id,
                    $patient->patient_name ?? 'N/A',
                    $patient->age ?? 'N/A',
                    $patient->gender ?? 'N/A',
                    $patient->mobile_no ?? $patient->mobile ?? 'N/A',
                    $patient->mail ?? 'N/A',
                    $patient->address ?? 'N/A',
                    $patient->marital_status ?? 'N/A',
                    $patient->occupation ?? 'N/A',
                    $patient->education ?? 'N/A',
                    $patient->created_at ? $patient->created_at->format('Y-m-d') : 'N/A',
                    $r->id,
                    $r->created_at ? $r->created_at->format('Y-m-d H:i') : 'N/A',
                    $r->diabetes ?? 'Normal',
                    $r->hba1c ?: '-',
                    $r->bsf ?: '-',
                    $r->bspp ?: '-',
                    $r->newly_detected ?: '-',
                    $r->duration_of_diabetes ?: '-',
                    $r->start_insulin_date ?: '-',
                    $r->stop_insulin_date ?: '-',
                    $r->insuline_brand ?: '-',
                    $r->insuline_unit ?: '-',
                    $r->hypertension ?? 'Normal',
                    $r->htn ?: '-',
                    $r->sbp ?: '-',
                    $r->dbp ?: '-',
                    $pp,
                    $map,
                    $r->obesity ?? 'Normal',
                    $r->height_cm ?: '-',
                    $r->weight_kg ?: '-',
                    $r->bmi ?: '-',
                    $r->bmi_group ?: '-',
                    $r->waist_cm ?: '-',
                    $r->hip_cm ?: '-',
                    $r->waist_hip_ratio ?: '-',
                    $r->waist_height_ratio ?: '-',
                    $r->veg_nonveg ?: '-',
                    $r->physical_activity ?: '-',
                    $r->social_class ?: '-',
                    $r->income_class ?: '-',
                    $r->infection ?? 'Normal',
                    $r->temprature ? $r->temprature . ' °F' : '-',
                    $r->infection ?: '-',
                    $r->hiv ?: '-',
                    $r->hbsag ?: '-',
                    $r->hcv ?: '-',
                    $r->urine_cast_cell ?: '-',
                    $r->hb_percent ?: '-',
                    $r->plt ?: '-',
                    $r->mcv ?: '-',
                    $r->creatinine ?: '-',
                    $r->egfr ?: '-',
                    $r->acr ?: '-',
                    $r->uric_acid ?: '-',
                    $r->na_plus ?: '-',
                    $r->k_plus ?: '-',
                    $r->i_calcium ?: '-',
                    $r->phosphorus ?: '-',
                    $r->sgpt ?: '-',
                    $r->sgot ?: '-',
                    $r->alkp ?: '-',
                    $r->fib_score ?: '-',
                    $r->median_stiffness ?: '-',
                    $r->usg ?: '-',
                    $r->chol ?: '-',
                    $r->tg ?: '-',
                    $r->hdl ?: '-',
                    $r->ldl ?: '-',
                    $r->tsh ?: '-',
                    $r->t3 ?: '-',
                    $r->t4 ?: '-',
                    $r->vitamin_d25 ?: '-',
                    $r->vitamin_b12 ?: '-',
                    $r->s_cortisol ?: '-',
                    $r->dex_skip_test ?: '-',
                    $r->ophthalmic_ex ?: '-',
                    $r->foot_ev ?: '-',
                    $r->car_echo_ev ?: '-'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function viewAttachment($id)
    {
        $record = PatientClinicalRecord::find($id);

        if (!$record) {
            $record = PatientClinicalRecord::where('patient_id', $id)
                ->whereNotNull('attachment')
                ->latest('id')
                ->first();
        }

        if (!$record || empty($record->attachment) || !Storage::disk('public')->exists($record->attachment)) {
            return back()->with('error', 'The requested attachment file was not found on the server.');
        }

        return Storage::disk('public')->response($record->attachment);
    }
}

