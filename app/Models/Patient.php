<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'id';
    protected $table = "patients";
    protected $fillable = [
        'patient_name',
        'dob',
        'gender',
        'record_date',
        'address',
        'mobile_no',
        'mail',
        'rcdho_grade',
        'registration_no',
        'follow_up_reg_no',
        'father_husband_name',
    ];

    protected $casts = [
        'dob' => 'date',
        'record_date' => 'date',
    ];

    /**
     * Dynamically compute the patient's age from dob.
     */
    public function getAgeAttribute()
    {
        if ($this->dob) {
            return \Carbon\Carbon::parse($this->dob)->age;
        }
        return null;
    }


    public function clinicalRecords()
    {
        return $this->hasMany(PatientClinicalRecord::class, 'patient_id');
    }

    public function patintRecord()
    {
        return $this->hasMany(PatientClinicalRecord::class, 'patient_id');
    }

    public function latestRecord()
    {
        return $this->hasOne(PatientClinicalRecord::class, 'patient_id')->latestOfMany('id');
    }


}
