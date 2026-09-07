<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    protected $table = 'appoinments';
    protected $primaryKey = 'id';
    protected $fillable = ['patient_name', 'age', 'phone', 'mail', 'patient_type', 'appointment_type', 'message'];
}
