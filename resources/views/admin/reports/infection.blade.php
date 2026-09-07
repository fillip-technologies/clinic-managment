@extends('admin.loyout.master')

@section('content')
    @include('admin.shared.patient_datatable', [
        'records' => $records,
        'title' => 'Infection & Fever Patient Registry',
        'icon' => 'fa-virus text-emerald-500',
        'exportType' => 'infection',
        'showAtRisk' => false,
        'subtitle' => 'Targeted cohort report for infectious diseases, fever (Temp > 99.4°F), and febrile presentations'
    ])
@endsection
