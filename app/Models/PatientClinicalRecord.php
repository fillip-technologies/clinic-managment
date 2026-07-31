<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientClinicalRecord extends Model
{
      protected $table = 'patient_clinical_records';
      protected $fillable = [
        'patient_id',
        'newly_detected',
        'duration_of_diabetes',
        'start_insulin_date',
        'stop_insulin_date',
        'attachment',
        'height_cm',
        'weight_kg',
        'bmi',
        'waist_height_ratio',
        'bmi_group',
        'waist_cm',
        'hip_cm',
        'waist_hip_ratio',
        'social_class',
        'income_class',
        'education',
        'physical_activity',
        'veg_nonveg',
        'htn',
        'sbp',
        'dbp',
        'hb_percent',
        'plt',
        'mcv',
        'creatinine',
        'egfr',
        'acr',
        'uric_acid',
        'urine_cast_cell',
        'na_plus',
        'k_plus',
        'i_calcium',
        'phosphorus',
        'sgpt',
        'sgot',
        'alkp',
        'hiv',
        'hbsag',
        'hcv',
        'fib_score',
        'fib_scan',
        'temprature',
        'usg',
        'chol',
        'tg',
        'hdl',
        'ldl',
        'bsf',
        'bspp',
        'hba1c',
        'tsh',
        't3',
        't4',
        'vitamin_d25',
        'vitamin_b12',
        's_cortisol',
        'dex_skip_test',
        'ophthalmic_ex',
        'foot_ev',
        'car_echo_ev',
        'diabetes',
        'hypertension',
        'obesity',
        'infection'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }


}
