<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientClinicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function patientList(){
        $records = PatientClinicalRecord::with(['patient'])->latest()->get();

        return view('admin.patients.listing',compact('records'));
    }

    public function createPatient(){
        return view('admin.patients.patient');
    }

    public function store(Request $request)
    {
        // dd($request->all());

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

            'ophthalmic_ex' => 'nullable|string|max:500',
            'foot_ev' => 'nullable|string|max:500',
            'car_echo_ev' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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

        $record = PatientClinicalRecord::create([
            "patient_id"=>$patient->id,
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
            'hb_percent' => $request->hb_percent,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->na_plus,
            'k_plus' => $request->k_plus,
            'i_calcium' => $request->i_calcium,
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
            'chol' => $request->chol,
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
            's_cortisol' => $request->s_cortisol,
            'dex_skip_test' => $request->dex_skip_test,
            'ophthalmic_ex' => $request->ophthalmic_ex,
            'foot_ev' => $request->foot_ev,
            'car_echo_ev' => $request->car_echo_ev,
        ]);

        return redirect()->route("list.patient")
            ->with('success', 'Patient clinical record created successfully!');
    }


    public function show($id)
    {
        $record = PatientClinicalRecord::findOrFail($id);
        return view('admin.patient-records.show', compact('record'));
    }


    public function edit($id)
    {
        $record = PatientClinicalRecord::findOrFail($id);
        return view('admin.patients.edit', compact('record'));
    }


    public function update(Request $request, $id)
    {
        $record = PatientClinicalRecord::findOrFail($id);
        $patient = Patient::findOrFail($record->patient_id);

        $validator = Validator::make($request->all(), [
            'record_date' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:Male,Female,Other',
            'father_husband_name' => 'nullable|string|max:255',
            'rcdho_grade' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'mobile_no' => 'nullable|string|max:20',
            'registration_no' => 'nullable|string|max:50|unique:patients,registration_no,' . $id,

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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if ($request->hasFile('attachment')) {

            if ($record->attachment) {
                Storage::disk('public')->delete($record->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
            $record->attachment = $attachmentPath;
        }
        $patient->update([
            'patient_name'         => $request->patient_name,
            'age'                  => $request->age,
            'gender'               => $request->gender,
            'address'              => $request->address,
            'mobile_no'            => $request->mobile,
            'father_husband_name'  => $request->guardian_name,
            'record_date'          => $request->record_date,
            'registration_no'  => $request->registration_no,
            'rcdho_grade'          => $request->rcdho_grade,
        ]);

        $record->update($request->except(['_token', '_method', 'attachment']));
        return redirect()->route('list.patient')
            ->with('success', 'Patient clinical record updated successfully!');
    }


    public function destroy($id)
    {
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



        public function addnewReport($id){
            $data = PatientClinicalRecord::with(['patient'])->findOrFail($id);
            return view('admin.patients.secreport',compact('data'));
        }

        public function createNewRecord(Request $request,$id){

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


            $creation = PatientClinicalRecord::find($id);

            $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('patient-attachments', $filename, 'public');
        }
            $creation::create([
            "patient_id"=>$request->patient_id,
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
            'hb_percent' => $request->hb_percent,
            'plt' => $request->plt,
            'mcv' => $request->mcv,
            'creatinine' => $request->creatinine,
            'egfr' => $request->egfr,
            'acr' => $request->acr,
            'uric_acid' => $request->uric_acid,
            'urine_cast_cell' => $request->urine_cast_cell,
            'na_plus' => $request->na_plus,
            'k_plus' => $request->k_plus,
            'i_calcium' => $request->i_calcium,
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
            'chol' => $request->chol,
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
            's_cortisol' => $request->s_cortisol,
            'dex_skip_test' => $request->dex_skip_test,
            'ophthalmic_ex' => $request->ophthalmic_ex,
            'foot_ev' => $request->foot_ev,
            'car_echo_ev' => $request->car_echo_ev,
            ]);
        }





}


