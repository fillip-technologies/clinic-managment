{{-- 
    Shared Reusable Patient DataTable Component
    Used by:
    - /admin/patient/list (All Patients)
    - /admin/diabetes/report (Diabetes Report)
    - /admin/hypertensio/report (Hypertension Report)
    - /admin/obesity/report (Obesity Report)
    - /admin/Infection/report (Infection Report)
--}}

@php
    $pageTitle = $title ?? 'Clinical Records Database';
    $pageIcon = $icon ?? 'fa-table text-[#1f6e96]';
    $pageSubtitle = $subtitle ?? 'Live clinical tracking & patient management';
    $exportTypeKey = $exportType ?? 'all';
@endphp

<!-- DataTables CSS & JS Assets -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<style>
    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        border: 1px solid #e9eff5;
    }

    /* Subtle readable font sizing */
    #patientTable {
        font-size: 0.8125rem; /* ~13px */
    }

    #patientTable thead th {
        font-size: 0.8125rem;
        font-weight: 700;
        color: #124263;
        padding: 0.75rem 0.75rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    #patientTable thead th.sorting,
    #patientTable thead th.sorting_asc,
    #patientTable thead th.sorting_desc {
        padding-right: 2rem !important;
    }

    #patientTable tbody td {
        font-size: 0.8125rem;
        padding: 0.65rem 0.75rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    #patientTable tbody tr td:not(:last-child) {
        cursor: pointer;
    }

    #patientTable tbody tr:hover td:not(:last-child) {
        background-color: #f4f9ff;
    }

    /* Custom Sleek Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d3dfea;
        border-radius: 12px;
        padding: 0.35rem 0.85rem;
        margin-left: 0.5rem;
        background: #fafdff;
        font-size: 0.8125rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #1f6e96;
        box-shadow: 0 0 0 3px rgba(31, 110, 150, 0.1);
        outline: none;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d3dfea;
        border-radius: 12px;
        padding: 0.3rem 0.85rem;
        background: #fafdff;
        font-size: 0.8125rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.35rem 0.8rem;
        border-radius: 8px;
        border: 1px solid #d3dfea;
        margin: 0 2px;
        background: white;
        font-size: 0.8125rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1f6e96 !important;
        color: white !important;
        border-color: #1f6e96 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e6eff7 !important;
        border-color: #1f6e96 !important;
    }

    .badge-status {
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-critical {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-normal {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .action-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        font-size: 0.8rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-add {
        background: #1f6e96;
        color: white;
        border-radius: 12px;
        padding: 0.45rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }

    .btn-add:hover {
        background: #16547a;
        box-shadow: 0 4px 12px rgba(31, 110, 150, 0.3);
    }

    .tooltip-trigger {
        position: relative;
        cursor: pointer;
    }

    .value-critical {
        color: #dc2626;
        font-weight: 700;
    }

    .value-warning {
        color: #d97706;
        font-weight: 600;
    }

    .value-normal {
        color: #059669;
        font-weight: 600;
    }

    .status-dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        margin-left: 3px;
    }

    .status-dot.critical {
        background: #dc2626;
    }

    .status-dot.warning {
        background: #d97706;
    }

    .status-dot.normal {
        background: #059669;
    }
</style>

<div class="max-w-full mx-auto">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-[#0b2a3f] flex items-center gap-3">
                <i class="fas {{ $pageIcon }}"></i>
                {{ $pageTitle }}
            </h1>
            <p class="text-xs sm:text-sm text-[#5a7e9a] mt-1">
                <i class="far fa-clock mr-1"></i> {{ $pageSubtitle }}
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Export CSV Button -->
            <a href="{{ route('analytics.disease.export', ['type' => $exportTypeKey]) }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-3.5 py-2 rounded-xl transition shadow-md shadow-emerald-600/20 flex items-center gap-1.5"
                title="Export this dataset as CSV">
                <i class="fas fa-file-excel"></i>
                <span>Export CSV</span>
            </a>

            <!-- New Record Button -->
            <a href="{{ route('patient.form') }}" class="btn-add text-xs py-2">
                <i class="fas fa-plus mr-1.5"></i>New Record
            </a>

            <!-- Refresh Button -->
            <button
                class="bg-white border border-[#d3dfea] rounded-xl px-3.5 py-2 text-xs text-[#1f5a7a] hover:bg-[#f0f7fe] transition flex items-center gap-1.5"
                onclick="refreshTable()">
                <i class="fas fa-sync-alt"></i>
                <span class="hidden sm:inline">Refresh</span>
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <!-- Stats Row -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-5 pb-4 border-b border-[#e9eff5]">
            <div class="bg-[#f8fcff] rounded-xl p-3 text-center border border-slate-100">
                <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Total Patients</span>
                <p class="text-xl font-bold text-[#0b2a3f]" id="totalRecords">{{ $records->count() }}</p>
            </div>
            <div class="bg-[#f8fcff] rounded-xl p-3 text-center border border-slate-100">
                <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Newly Detected</span>
                <p class="text-xl font-bold text-[#1f6e96]" id="newlyDetected">
                    {{ $records->filter(fn($p) => ($p->latestRecord?->newly_detected ?? $p->newly_detected) == 'Yes' || ($p->latestRecord?->newly_detected ?? $p->newly_detected) == 1)->count() }}
                </p>
            </div>
            <div class="bg-[#f8fcff] rounded-xl p-3 text-center border border-slate-100">
                <span class="text-xs text-[#5a7e9a] uppercase font-semibold">On Insulin</span>
                <p class="text-xl font-bold text-[#8b5cf6]" id="onInsulin">
                    {{ $records->filter(fn($p) => ($p->latestRecord?->start_insulin_date ?? $p->start_insulin_date) && !($p->latestRecord?->stop_insulin_date ?? $p->stop_insulin_date))->count() }}
                </p>
            </div>
            <div class="bg-[#f8fcff] rounded-xl p-3 text-center border border-slate-100">
                <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Hypertension</span>
                <p class="text-xl font-bold text-[#ef4444]" id="hypertension">
                    {{ $records->filter(fn($p) => ($p->latestRecord?->htn ?? $p->htn) == 'Yes' || ($p->latestRecord?->hypertension ?? $p->hypertension) == 'Hypertension' || floatval($p->latestRecord?->sbp ?? $p->sbp) >= 140 || floatval($p->latestRecord?->dbp ?? $p->dbp) >= 90)->count() }}
                </p>
            </div>
            <div class="bg-[#f8fcff] rounded-xl p-3 text-center border border-slate-100">
                <span class="text-xs text-[#5a7e9a] uppercase font-semibold">At Risk</span>
                <p class="text-xl font-bold text-[#f59e0b]" id="atRisk">
                    {{ $records->filter(fn($p) => floatval($p->latestRecord?->bmi ?? $p->bmi) > 25 || floatval($p->latestRecord?->hba1c ?? $p->hba1c) > 6.5 || floatval($p->latestRecord?->sbp ?? $p->sbp) > 140 || floatval($p->latestRecord?->dbp ?? $p->dbp) > 90)->count() }}
                </p>
            </div>
        </div>

        <!-- DataTable (table will be wrapped by DataTables dom so controls stay fixed) -->
        <table id="patientTable" class="display responsive nowrap w-full min-w-[1150px]" style="width:100%">
                <thead class="bg-[#f4f9ff] text-[#124263]">
                    <tr>
                        <th class="w-10">#</th>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Age/Gender</th>
                        <th>Mobile</th>
                        <th>BMI</th>
                        <th>HbA1c</th>
                        <th>BP</th>
                        <th>Diabetes</th>
                        <th>Insulin</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $item)
                        @php
                            if ($item instanceof \App\Models\Patient) {
                                $patient = $item;
                                $clinical = $item->latestRecord;
                            } else {
                                $patient = $item->patient ?? new \App\Models\Patient();
                                $clinical = $item;
                            }

                            $bmi = floatval($clinical->bmi ?? 0);
                            $hba1c = floatval($clinical->hba1c ?? 0);
                            $sbp = floatval($clinical->sbp ?? 0);
                            $dbp = floatval($clinical->dbp ?? 0);
                            $temp = floatval($clinical->temprature ?? $clinical->temperature ?? 98.6);

                            // BMI Status
                            $bmiStatus = 'normal';
                            $bmiLabel = 'Normal';
                            if ($bmi > 25) {
                                $bmiStatus = 'critical';
                                $bmiLabel = 'Obese (>25)';
                            } elseif ($bmi >= 23 && $bmi <= 25) {
                                $bmiStatus = 'warning';
                                $bmiLabel = 'Overweight';
                            }

                            // HbA1c Status
                            $hba1cStatus = 'normal';
                            $hba1cLabel = 'Normal';
                            if ($hba1c >= 6.5) {
                                $hba1cStatus = 'critical';
                                $hba1cLabel = 'Diabetes (>6.5%)';
                            } elseif ($hba1c >= 5.7 && $hba1c < 6.5) {
                                $hba1cStatus = 'warning';
                                $hba1cLabel = 'Pre-Diabetes';
                            }

                            // BP Status
                            $bpStatus = 'normal';
                            $bpLabel = 'Normal';
                            if ($sbp > 140 || $dbp > 90) {
                                $bpStatus = 'critical';
                                $bpLabel = 'Hypertension';
                            } elseif ($sbp > 130 || $dbp > 90) {
                                $bpStatus = 'warning';
                                $bpLabel = 'Pre-Hypertension';
                            }

                            // Overall Status
                            $overallStatus = 'normal';
                            $statusLabel = 'Normal';
                            if (
                                $bmiStatus === 'critical' ||
                                $hba1cStatus === 'critical' ||
                                $bpStatus === 'critical'
                            ) {
                                $overallStatus = 'critical';
                                $statusLabel = 'Critical';
                            } elseif (
                                $bmiStatus === 'warning' ||
                                $hba1cStatus === 'warning' ||
                                $bpStatus === 'warning'
                            ) {
                                $overallStatus = 'warning';
                                $statusLabel = 'At Risk';
                            }

                            $statusBadgeClass =
                                $overallStatus === 'critical'
                                    ? 'badge-critical'
                                    : ($overallStatus === 'warning'
                                        ? 'badge-warning'
                                        : 'badge-normal');

                            $abnormalCount = 0;
                            if ($bmi > 25) {
                                $abnormalCount++;
                            }
                            if ($hba1c >= 5.7) {
                                $abnormalCount++;
                            }
                            if ($sbp > 130 || $dbp > 90) {
                                $abnormalCount++;
                            }
                            if ($temp > 99.4) {
                                $abnormalCount++;
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $patient->record_date ? \Carbon\Carbon::parse($patient->record_date)->format('d/m/Y') : ($clinical?->created_at ? $clinical->created_at->format('d/m/Y') : '-') }}
                            </td>
                            <td>
                                <a href="{{ route('patient.show', $patient->id) }}" class="font-bold text-[#1f6e96] hover:underline">
                                    {{ $patient->patient_name ?? 'N/A' }}
                                </a>
                                <small class="text-slate-400 block text-[11px]">ID: {{ $patient->id }} {{ $patient->registration_no ? '| ' . $patient->registration_no : '' }}</small>
                            </td>
                            <td>{{ $patient->age ?? '-' }} / {{ $patient->gender ?? '-' }}</td>
                            <td>{{ $patient->mobile_no ?? '-' }}</td>
                            <td>
                                @php
                                    $bmiColor = 'value-normal';
                                    if ($bmi > 25) {
                                        $bmiColor = 'value-critical';
                                    } elseif ($bmi >= 23) {
                                        $bmiColor = 'value-warning';
                                    }
                                @endphp
                                <span class="tooltip-trigger {{ $bmiColor }}" title="BMI: {{ $bmiLabel }}">
                                    {{ $clinical?->bmi ?? '-' }}
                                    @if ($bmi > 25)
                                        <span class="status-dot critical"></span>
                                    @elseif($bmi >= 23)
                                        <span class="status-dot warning"></span>
                                    @else
                                        <span class="status-dot normal"></span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @php
                                    $hba1cColor = 'value-normal';
                                    if ($hba1c >= 6.5) {
                                        $hba1cColor = 'value-critical';
                                    } elseif ($hba1c >= 5.7) {
                                        $hba1cColor = 'value-warning';
                                    }
                                @endphp
                                <span class="tooltip-trigger {{ $hba1cColor }}" title="HbA1c: {{ $hba1cLabel }}">
                                    {{ $clinical?->hba1c ? $clinical->hba1c . '%' : '-' }}
                                    @if ($hba1c >= 6.5)
                                        <span class="status-dot critical"></span>
                                    @elseif($hba1c >= 5.7)
                                        <span class="status-dot warning"></span>
                                    @else
                                        <span class="status-dot normal"></span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @php
                                    $bpColor = 'value-normal';
                                    if ($sbp > 140 || $dbp > 90) {
                                        $bpColor = 'value-critical';
                                    } elseif ($sbp > 130 || $dbp > 90) {
                                        $bpColor = 'value-warning';
                                    }
                                @endphp
                                <span class="tooltip-trigger {{ $bpColor }}" title="BP: {{ $bpLabel }}">
                                    {{ $clinical && ($clinical->sbp || $clinical->dbp) ? $clinical->sbp . '/' . $clinical->dbp : '-' }}
                                    @if ($sbp > 140 || $dbp > 90)
                                        <span class="status-dot critical"></span>
                                    @elseif($sbp > 130 || $dbp > 90)
                                        <span class="status-dot warning"></span>
                                    @else
                                        <span class="status-dot normal"></span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if ($clinical?->newly_detected == 'Yes' || $clinical?->newly_detected == 1)
                                    <span class="badge-status bg-blue-100 text-blue-700"><i class="fas fa-bolt mr-1"></i>New</span>
                                @elseif($clinical?->duration_of_diabetes)
                                    <span class="badge-status bg-gray-100 text-gray-600">{{ $clinical->duration_of_diabetes }} yrs</span>
                                @else
                                    <span class="badge-status bg-gray-50 text-gray-400">Normal</span>
                                @endif
                            </td>
                            <td>
                                @if ($clinical?->start_insulin_date && !$clinical?->stop_insulin_date)
                                    <span class="badge-status bg-purple-100 text-purple-700"><i class="fas fa-syringe mr-1"></i>Active</span>
                                @elseif($clinical?->start_insulin_date && $clinical?->stop_insulin_date)
                                    <span class="badge-status bg-gray-100 text-gray-600">Stopped</span>
                                @else
                                    <span class="badge-status bg-gray-50 text-gray-400">Not on</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-status {{ $statusBadgeClass }}">
                                    @if ($overallStatus === 'critical')
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                    @elseif($overallStatus === 'warning')
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                    @else
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @endif
                                    {{ $statusLabel }}
                                    @if ($abnormalCount > 0)
                                        <span class="ml-1 px-1.5 py-0.5 bg-white/30 rounded-full text-xs">{{ $abnormalCount }}</span>
                                    @endif
                                </span>
                                @if ($temp > 99.4)
                                    <span class="badge-status badge-critical ml-1"><i class="fas fa-thermometer-half mr-1"></i>Fever</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('patient.show', $patient->id) }}"
                                        class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center" title="View Patient Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('addnewReport', $clinical?->id ?? $patient->id) }}"
                                        class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center" title="Add Follow-up Visit">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('patient.edit', $patient->id) }}"
                                        class="action-btn bg-yellow-50 text-yellow-600 hover:bg-yellow-100 flex items-center justify-center"
                                        title="Edit Patient">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('patient.delete', $patient->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this patient and all clinical records?')"
                                            class="action-btn bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center" title="Delete Patient">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>

<!-- DataTable Initialization & Scripts -->
<script>
    let patientDataTable;

    $(document).ready(function() {
        patientDataTable = $('#patientTable').DataTable({
            responsive: {
                details: {
                    type: 'inline',
                    target: 0
                }
            },
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search patient records...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ patients",
                infoEmpty: "No patient records found",
                infoFiltered: "(filtered from _MAX_ total)",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            },
            dom: '<"flex flex-col sm:flex-row items-center justify-between gap-4 mb-4"lf><"overflow-x-auto custom-scrollbar w-full pb-2"t><"flex flex-col sm:flex-row items-center justify-between gap-4 mt-4"ip>',
            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [11],
                    orderable: false
                }
            ]
        });

        // Allow clicking anywhere on the row to toggle expansion
        $('#patientTable tbody').on('click', 'tr td:not(:last-child):not(.dtr-control)', function(e) {
            if ($(e.target).closest('.action-btn, a, button, form, input, select').length) {
                return;
            }
            $(this).closest('tr').find('td.dtr-control').trigger('click');
        });
    });

    function refreshTable() {
        location.reload();
    }
</script>
