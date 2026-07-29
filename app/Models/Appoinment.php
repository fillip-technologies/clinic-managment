<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['patient_name','phone','patient_type','message'];
    protected $table = "appoinments";
}
