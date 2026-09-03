@extends('admin.loyout.master')

@section('content')
    @include('admin.shared.patient_datatable', [
        'records' => $records,
        'title' => 'Diabetes Patient Registry',
        'icon' => 'fa-droplet text-red-500',
        'exportType' => 'diabetes',
        'subtitle' => 'Targeted cohort report for patients diagnosed with Diabetes (HbA1c ≥ 6.5% or Fasting Glucose ≥ 126 mg/dL)'
    ])
@endsection
