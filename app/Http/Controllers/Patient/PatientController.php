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
            'gender' => 'nullable|in:Male,Female,Other',
            'father_husband_name' => 'nullable|string|max:255',
            'rcdho_grade' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'mobile_no' => 'nullable|string|max:20',
            'registration_no' => 'nullable|string|max:50|unique:patients,registration_no',


            'newly_detected' => 'nullable|in:Yes,No',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'start_insulin_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date|after_or_equal:start_insulin_date',
            'attachment' => 'nullable|file',


            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|in:Normal,Overweight,Obese',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',


            'social_class' => 'nullable|in:Upper,Middle,Lower',
            'income_class' => 'nullable|in:High,Medium,Low',
            'education' => 'nullable|in:Graduate,Post-grad,School',
            'physical_activity' => 'nullable|in:Sedentary,Moderate,Active',
            'veg_nonveg' => 'nullable|in:Vegetarian,Non-vegetarian,Vegan',

            'htn' => 'nullable|in:Yes,No',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|in:Negative,Positive',
            'hbsag' => 'nullable|in:Negative,Positive',
            'hcv' => 'nullable|in:Negative,Positive',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:20',
            'usg' => 'nullable|string|max:255',
            'chol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
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
            'dex_skip_test' => 'nullable|string|max:50',
            'temprature' => 'nullable|string',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
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

        if (
            $request->hba1c >= 6.5 ||
            $request->fbs >= 126 ||
            $request->rbs >= 200
        ) {
            $diabetes = "Diabetes";
        }


        if (
            $request->sbp >= 130 ||
            $request->dbp >= 90
        ) {
            $hypertension = "Hypertension";
        }

        if (
            $request->temprature >= 99.4 ||
            $request->wbc > 11000 ||
            $request->crp > 10
        ) {
            $infection = "Infection";
        }

        if (
            $request->bmi >= 25 ||
            ($request->gender == 'Male' && $request->waist > 90) ||
            ($request->gender == 'Female' && $request->waist > 80)
        ) {
            $obesity = "Obesity";
        }




        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
        }

        $patient = Patient::create([
            'record_date' => $request->record_date,
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'father_husband_name' => $request->guardian_name,
            'rcdho_grade' => $request->rcdho_grade,
            'address' => $request->address,
            'mobile_no' => $request->mobile,
            'registration_no' => $request->registration_no,
        ]);

        PatientClinicalRecord::create([
            "patient_id" => $patient->id,
            'newly_detected' => $request->newly_detected,
            'duration_of_diabetes' => $request->diabetes_duration,
            'start_insulin_date' => $request->insulin_start_date,
            'stop_insulin_date' => $request->insulin_stop_date,
            'attachment' => $attachmentPath,
            'height_cm' => $request->height,
            'weight_kg' => $request->weight,
            'bmi' => $request->bmi,
            'temprature' => $request->temprature,
            'waist_height_ratio' => $request->waist_height_ratio,
            'bmi_group' => $request->bmi_group,
            'waist_cm' => $request->waist,
            'hip_cm' => $request->hip,
            'waist_hip_ratio' => $request->waist_hip_ratio,
            'social_class' => $request->social_class,
            'income_class' => $request->income_class,
            'education' => $request->education,
            'physical_activity' => $request->physical_activity,
            'veg_nonveg' => $request->veg_nonveg,
            'htn' => $request->htn,
            'sbp' => $request->sbp,
            'dbp' => $request->dbp,
            'hb_percent' => $request->hb,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->sodium,
            'k_plus' => $request->potassium,
            'i_calcium' => $request->ionized_calcium,
            'phosphorus' => $request->phosphorus,
            'sgpt' => $request->sgpt,
            'sgot' => $request->sgot,
            'alkp' => $request->alkp,
            'hiv' => $request->hiv,
            'hbsag' => $request->hbsag,
            'hcv' => $request->hcv,
            'fib_score' => $request->fib_score,
            'fib_scan' => $request->fib_scan,
            'usg' => $request->usg,
            'chol' => $request->cholesterol,
            'tg' => $request->tg,
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
            's_cortisol' => $request->cortisol,
            'dex_skip_test' => $request->dex_suppression_test,
            'ophthalmic_ex' => $request->ophthalmic_exam,
            'foot_ev' => $request->foot_exam,
            'car_echo_ev' => $request->echo_exam,
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

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:Male,Female,Other',
            'father_husband_name' => 'nullable|string|max:255',
            'rcdho_grade' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'mobile_no' => 'nullable|string|max:20',

            'registration_no' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('patients', 'registration_no')->ignore($patient->id),
            ],

            'newly_detected' => 'nullable|in:Yes,No',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'start_insulin_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date|after_or_equal:start_insulin_date',
            'attachment' => 'nullable|file',

            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|in:Normal,Overweight,Obese',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',

            'social_class' => 'nullable|in:Upper,Middle,Lower',
            'income_class' => 'nullable|in:High,Medium,Low',
            'education' => 'nullable|in:Graduate,Post-grad,School',
            'physical_activity' => 'nullable|in:Sedentary,Moderate,Active',
            'veg_nonveg' => 'nullable|in:Vegetarian,Non-vegetarian,Vegan',

            'htn' => 'nullable|in:Yes,No',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|in:Negative,Positive',
            'hbsag' => 'nullable|in:Negative,Positive',
            'hcv' => 'nullable|in:Negative,Positive',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:20',
            'usg' => 'nullable|string|max:255',
            'chol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
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
            'dex_skip_test' => 'nullable|string|max:50',
            'temprature' => 'nullable|string',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $diabetes = "Normal";
        $hypertension = "Normal";
        $infection = "Normal";
        $obesity = "Normal";

        if ($request->hba1c >= 6.5 || $request->fbs >= 126 || $request->rbs >= 200) {
            $diabetes = "Diabetes";
        }

        if ($request->sbp >= 130 || $request->dbp >= 90) {
            $hypertension = "Hypertension";
        }

        if ($request->temprature >= 99.4 || $request->wbc > 11000 || $request->crp > 10) {
            $infection = "Infection";
        }

        if (
            $request->bmi >= 25 ||
            ($request->gender == 'Male' && $request->waist_cm > 90) ||
            ($request->gender == 'Female' && $request->waist_cm > 80)
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


        $patient->update([
            'record_date' => $request->record_date,
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'father_husband_name' => $request->guardian_name,
            'rcdho_grade' => $request->rcdho_grade,
            'address' => $request->address,
            'mobile_no' => $request->mobile,
            'registration_no' => $request->registration_no,
        ]);


        $matchAttributes = ['patient_id' => $patient->id];
        if (!empty($record?->id)) {
            $matchAttributes['id'] = $record->id;
        }

        PatientClinicalRecord::updateOrCreate(
            $matchAttributes,
            [
                'newly_detected' => $request->newly_detected,
                'duration_of_diabetes' => $request->diabetes_duration,
                'start_insulin_date' => $request->insulin_start_date,
                'stop_insulin_date' => $request->insulin_stop_date,
                'attachment' => $attachmentPath,
                'height_cm' => $request->height,
                'weight_kg' => $request->weight,
                'bmi' => $request->bmi,
                'temprature' => $request->temprature,
                'waist_height_ratio' => $request->waist_height_ratio,
                'bmi_group' => $request->bmi_group,
                'waist_cm' => $request->waist,
                'hip_cm' => $request->hip,
                'waist_hip_ratio' => $request->waist_hip_ratio,
                'social_class' => $request->social_class,
                'income_class' => $request->income_class,
                'education' => $request->education,
                'physical_activity' => $request->physical_activity,
                'veg_nonveg' => $request->veg_nonveg,
                'htn' => $request->htn,
                'sbp' => $request->sbp,
                'dbp' => $request->dbp,
                'hb_percent' => $request->hb,
                'plt' => $request->plt,
                'mcv' => $request->mcv,
                'creatinine' => $request->creatinine,
                'egfr' => $request->egfr,
                'acr' => $request->acr,
                'uric_acid' => $request->uric_acid,
                'urine_cast_cell' => $request->urine_cast_cell,
                'na_plus' => $request->sodium,
                'k_plus' => $request->potassium,
                'i_calcium' => $request->ionized_calcium,
                'phosphorus' => $request->phosphorus,
                'sgpt' => $request->sgpt,
                'sgot' => $request->sgot,
                'alkp' => $request->alkp,
                'hiv' => $request->hiv,
                'hbsag' => $request->hbsag,
                'hcv' => $request->hcv,
                'fib_score' => $request->fib_score,
                'fib_scan' => $request->fib_scan,
                'usg' => $request->usg,
                'chol' => $request->cholesterol,
                'tg' => $request->tg,
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
                's_cortisol' => $request->cortisol,
                'dex_skip_test' => $request->dex_suppression_test,
                'ophthalmic_ex' => $request->ophthalmic_exam,
                'foot_ev' => $request->foot_exam,
                'car_echo_ev' => $request->echo_exam,
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
            'newly_detected' => 'nullable|in:Yes,No',
            'duration_of_diabetes' => 'nullable|string|max:50',
            'start_insulin_date' => 'nullable|date',
            'stop_insulin_date' => 'nullable|date|after_or_equal:start_insulin_date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',


            'height_cm' => 'nullable|numeric|min:0|max:300',
            'weight_kg' => 'nullable|numeric|min:0|max:500',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'waist_height_ratio' => 'nullable|numeric|min:0|max:5',
            'bmi_group' => 'nullable|in:Normal,Overweight,Obese',
            'waist_cm' => 'nullable|numeric|min:0|max:300',
            'hip_cm' => 'nullable|numeric|min:0|max:300',
            'waist_hip_ratio' => 'nullable|numeric|min:0|max:5',
            'social_class' => 'nullable|in:Upper,Middle,Lower',
            'income_class' => 'nullable|in:High,Medium,Low',
            'education' => 'nullable|in:Graduate,Post-grad,School',
            'physical_activity' => 'nullable|in:Sedentary,Moderate,Active',
            'veg_nonveg' => 'nullable|in:Vegetarian,Non-vegetarian,Vegan',

            'htn' => 'nullable|in:Yes,No',
            'sbp' => 'nullable|numeric|min:0|max:300',
            'dbp' => 'nullable|numeric|min:0|max:200',
            'hb_percent' => 'nullable|string|max:20',
            'plt' => 'nullable|string|max:20',
            'mcv' => 'nullable|string|max:20',
            'creatinine' => 'nullable|string|max:20',
            'egfr' => 'nullable|string|max:20',
            'acr' => 'nullable|string|max:20',
            'uric_acid' => 'nullable|string|max:20',
            'urine_cast_cell' => 'nullable|string|max:20',
            'na_plus' => 'nullable|string|max:20',
            'k_plus' => 'nullable|string|max:20',
            'i_calcium' => 'nullable|string|max:20',
            'phosphorus' => 'nullable|string|max:20',
            'sgpt' => 'nullable|string|max:20',
            'sgot' => 'nullable|string|max:20',
            'alkp' => 'nullable|string|max:20',
            'hiv' => 'nullable|in:Negative,Positive',
            'hbsag' => 'nullable|in:Negative,Positive',
            'hcv' => 'nullable|in:Negative,Positive',
            'fib_score' => 'nullable|string|max:20',
            'fib_scan' => 'nullable|string|max:20',
            'usg' => 'nullable|string|max:255',
            'chol' => 'nullable|string|max:20',
            'tg' => 'nullable|string|max:20',
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
            'dex_skip_test' => 'nullable|string|max:50',
            'ophthalmic_ex' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
        ]);
        $results = [
            'HbA1c'       => checkReport('hba1c', $request->hba1c),
            'SBP'         => checkReport('sbp', $request->sbp),
            'DBP'         => checkReport('dbp', $request->dbp),
            'BMI'         => checkReport('bmi', $request->bmi),
            'Temperature' => checkReport('temperature', $request->temperature),
        ];

        $patientId = $request->patient_id;
        if (!$patientId) {
            $patient = Patient::find($id);
            if ($patient) {
                $patientId = $patient->id;
            } else {
                $rec = PatientClinicalRecord::find($id);
                $patientId = $rec?->patient_id;
            }
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
            'duration_of_diabetes' => $request->duration_of_diabetes,
            'start_insulin_date' => $request->start_insulin_date,
            'stop_insulin_date' => $request->stop_insulin_date,
            'attachment' => $attachmentPath,
            'height_cm' => $request->height_cm,
            'weight_kg' => $request->weight_kg,
            'bmi' => $request->bmi,
            'waist_height_ratio' => $request->waist_height_ratio,
            'bmi_group' => $request->bmi_group,
            'waist_cm' => $request->waist_cm,
            'hip_cm' => $request->hip_cm,
            'waist_hip_ratio' => $request->waist_hip_ratio,

            'social_class' => $request->social_class,
            'income_class' => $request->income_class,
            'education' => $request->education,
            'physical_activity' => $request->physical_activity,
            'veg_nonveg' => $request->veg_nonveg,

            'htn' => $request->htn,
            'sbp' => $request->sbp,
            'dbp' => $request->dbp,
            'hb_percent' => $request->hb,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->sodium,
            'k_plus' => $request->potassium,
            'i_calcium' => $request->ionized_calcium,
            'phosphorus' => $request->phosphorus,
            'sgpt' => $request->sgpt,
            'sgot' => $request->sgot,
            'alkp' => $request->alkp,
            'hiv' => $request->hiv,
            'hbsag' => $request->hbsag,
            'hcv' => $request->hcv,
            'fib_score' => $request->fib_score,
            'fib_scan' => $request->fib_scan,
            'usg' => $request->usg,
            'chol' => $request->cholesterol,
            'tg' => $request->tg,
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
            's_cortisol' => $request->cortisol,
            'dex_skip_test' => $request->dex_suppression_test,
            'ophthalmic_ex' => $request->ophthalmic_exam,
            'foot_ev' => $request->foot_exam,
            'car_echo_ev' => $request->echo_exam,
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
}

