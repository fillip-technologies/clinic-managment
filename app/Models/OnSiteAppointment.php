<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnSiteAppointment extends Model
{
    protected $table = 'on_site_appointment';
    protected $primaryKey = 'id';
    protected $fillable = ['patient_name', 'phone', 'mail', 'patient_type', 'message'];
}
