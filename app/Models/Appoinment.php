<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    protected $table = 'appoinments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'patient_name',
        'age',
        'father_name',
        'phone',
        'mail',
        'address',
        'patient_type',
        'appointment_type',
        'appointment_scheduled_date',
        'message',
    ];

    protected $casts = [
        'appointment_scheduled_date' => 'date',
    ];
}
