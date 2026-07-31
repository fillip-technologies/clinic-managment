<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorData extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','file','report_type'];
    protected $table = "doctor_data";

}
