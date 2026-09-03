@extends('admin.loyout.master')

@section('content')
    @include('admin.shared.patient_datatable', [
        'records' => $records,
        'title' => 'Clinical Records Database',
        'icon' => 'fa-table text-[#1f6e96]',
        'exportType' => 'all',
        'subtitle' => 'Comprehensive registry of all registered clinic patients and clinical visits'
    ])
@endsection
