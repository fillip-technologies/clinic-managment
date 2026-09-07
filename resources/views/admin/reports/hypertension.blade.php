@extends('admin.loyout.master')

@section('content')
    @include('admin.shared.patient_datatable', [
        'records' => $records,
        'title' => 'Hypertension Patient Registry',
        'icon' => 'fa-heart-pulse text-rose-500',
        'exportType' => 'hypertension',
        'showAtRisk' => false,
        'subtitle' => 'Targeted cohort report for patients with elevated Blood Pressure (SBP ≥ 140 or DBP ≥ 90 mmHg)'
    ])
@endsection
