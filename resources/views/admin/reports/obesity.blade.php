@extends('admin.loyout.master')

@section('content')
    @include('admin.shared.patient_datatable', [
        'records' => $records,
        'title' => 'Obesity Patient Registry',
        'icon' => 'fa-weight-scale text-amber-500',
        'exportType' => 'obesity',
        'showAtRisk' => false,
        'subtitle' => 'Targeted cohort report for patients with BMI ≥ 25 or obesity indicators'
    ])
@endsection
