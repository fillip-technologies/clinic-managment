<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientClinicalRecord;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function diabetesReport(){
        $records = PatientClinicalRecord::with(['patient'])->where('diabetes','Diabetes')->get();
        return view('admin.reports.diabetes',compact('records'));
    }

    public function obesityReport(){
        $records = PatientClinicalRecord::with(['patient'])->where('obesity','Obesity')->get();
        return view('admin.reports.obesity',compact('records'));
    }

    public function hypertensioReport(){
        $records = PatientClinicalRecord::with(['patient'])->where('hypertension','Hypertension')->get();
        return view('admin.reports.hypertension',compact('records'));
    }

    public function InfectionReport(){
        $records = PatientClinicalRecord::with(['patient'])->where('infection','Infection')->get();
        return view('admin.reports.infection',compact('records'));
    }
}
