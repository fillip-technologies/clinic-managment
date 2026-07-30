<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'id';
    protected $table = "patients";
    protected $fillable = [
        'patient_name',
        'age',
        'gender',
        'record_date',
        'address',
        'mobile_no',
        'rcdho_grade',
        'registration_no',
        'father_husband_name',
        ];


        public function patintRecord(){
            return $this->hasMany(PatientClinicalRecord::class);
        }


}
