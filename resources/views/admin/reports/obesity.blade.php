@extends('admin.loyout.master')
@section('content')
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        body {
            background: #f0f5fc;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .table-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px -12px rgba(0, 20, 30, 0.15);
            padding: 1.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d3dfea;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
            background: #fafdff;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #1f6e96;
            box-shadow: 0 0 0 3px rgba(31, 110, 150, 0.1);
            outline: none;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d3dfea;
            border-radius: 12px;
            padding: 0.3rem 1rem;
            background: #fafdff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.4rem 0.9rem;
            border-radius: 10px;
            border: 1px solid #d3dfea;
            margin: 0 2px;
            background: white;
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

        .dt-button {
            background: #1f6e96 !important;
            color: white !important;
            border: none !important;
            padding: 0.4rem 1rem !important;
            border-radius: 12px !important;
            font-size: 0.85rem !important;
            margin: 0 3px !important;
        }

        .dt-button:hover {
            background: #16547a !important;
        }

        .badge-status {
            padding: 0.2rem 0.7rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-critical {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            animation: pulse-critical 2s infinite;
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

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        @keyframes pulse-critical {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .action-btn {
            padding: 0.2rem 0.5rem;
            border-radius: 8px;
            transition: all 0.2s;
            margin: 0 2px;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .btn-add {
            background: #1f6e96;
            color: white;
            border-radius: 14px;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s;
            border: none;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-add:hover {
            background: #16547a;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px -4px rgba(31, 110, 150, 0.3);
            color: white;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .value-normal {
            color: #065f46;
        }

        .value-warning {
            color: #92400e;
        }

        .value-critical {
            color: #991b1b;
            font-weight: 700;
        }

        .tooltip-trigger {
            cursor: help;
            border-bottom: 1px dashed #94a3b8;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .status-dot.normal {
            background: #22c55e;
        }

        .status-dot.warning {
            background: #f59e0b;
        }

        .status-dot.critical {
            background: #ef4444;
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .modal-content .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .modal-content .close-btn:hover {
            color: #1f6e96;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #124263;
            margin-bottom: 0.3rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d3dfea;
            border-radius: 10px;
            background: #fafdff;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #1f6e96;
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 110, 150, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-submit {
            background: #1f6e96;
            color: white;
            border: none;
            padding: 0.6rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-submit:hover {
            background: #16547a;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #e2ebf3;
            color: #124263;
            border: none;
            padding: 0.6rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #d3dfea;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.6rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .alert-box {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            font-size: 0.8rem;
        }

        .alert-critical {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert-warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }
    </style>

    <div class="max-w-7xl mx-auto fade-in">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#0b2a3f] flex items-center gap-3">
                    <i class="fas fa-table text-[#1f6e96]"></i>
                   Obesity Patients Lists
                </h1>
                <p class="text-sm text-[#5a7e9a] mt-1"><i class="far fa-clock mr-1"></i> Last updated: <span
                        id="lastUpdated">Loading...</span></p>
            </div>
            <div class="flex gap-3 mt-3 md:mt-0">
                <a href="{{ route('patient.form') }}" class="btn-add">
                    <i class="fas fa-plus mr-2"></i>New Record
                </a>
                <button
                    class="bg-white border border-[#d3dfea] rounded-xl px-4 py-2 text-[#1f5a7a] hover:bg-[#f0f7fe] transition flex items-center gap-2"
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
                <div class="bg-[#f8fcff] rounded-xl p-3 text-center">
                    <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Total Records</span>
                    <p class="text-xl font-bold text-[#0b2a3f]" id="totalRecords">{{ $records->count() }}</p>
                </div>
                <div class="bg-[#f8fcff] rounded-xl p-3 text-center">
                    <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Newly Detected</span>
                    <p class="text-xl font-bold text-[#1f6e96]" id="newlyDetected">
                        {{ $records->where('newly_detected', true)->count() }}</p>
                </div>
                <div class="bg-[#f8fcff] rounded-xl p-3 text-center">
                    <span class="text-xs text-[#5a7e9a] uppercase font-semibold">On Insulin</span>
                    <p class="text-xl font-bold text-[#8b5cf6]" id="onInsulin">
                        {{ $records->filter(function ($r) {return $r->start_insulin_date && !$r->stop_insulin_date;})->count() }}
                    </p>
                </div>
                <div class="bg-[#f8fcff] rounded-xl p-3 text-center">
                    <span class="text-xs text-[#5a7e9a] uppercase font-semibold">Hypertension</span>
                    <p class="text-xl font-bold text-[#ef4444]" id="hypertension">
                        {{ $records->where('htn', true)->count() }}</p>
                </div>
                <div class="bg-[#f8fcff] rounded-xl p-3 text-center">
                    <span class="text-xs text-[#5a7e9a] uppercase font-semibold">At Risk</span>
                    <p class="text-xl font-bold text-[#f59e0b]" id="atRisk">
                        {{ $records->filter(function ($r) {return $r->bmi > 25 || $r->hba1c > 6.5 || $r->sbp > 140 || $r->dbp > 90;})->count() }}
                    </p>
                </div>
            </div>

            <!-- DataTable -->
            <div class="overflow-x-auto">
                <table id="patientTable" class="display responsive nowrap" style="width:100%">
                    <thead class="bg-[#f4f9ff] text-[#124263]">
                        <tr>
                            <th>ID</th>
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
                        @foreach ($records as $record)
                            @php
                                // Medical parameter evaluation based on reference table
                                $bmi = floatval($record->bmi);
                                $hba1c = floatval($record->hba1c);
                                $sbp = floatval($record->sbp);
                                $dbp = floatval($record->dbp);
                                $temp = floatval($record->temperature ?? 98.6);

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

                                // Count abnormal parameters
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
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->patient->record_date ? \Carbon\Carbon::parse($record->record_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    <span class="font-medium">{{ $record->patient->patient_name ?? 'N/A' }}</span>
                                    @if ($record->patient)
                                        <small class="text-gray-400 block text-xs">ID:
                                            {{ $record->patient->id ?? '' }}</small>
                                    @endif
                                </td>
                                <td>{{ $record->patient->age ?? '-' }} / {{ $record->patient->gender ?? '-' }}</td>
                                <td>{{ $record->patient->mobile_no ?? '-' }}</td>
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
                                        {{ $record->bmi ?? '-' }}
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
                                        {{ $record->hba1c ? $record->hba1c . '%' : '-' }}
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
                                        {{ $record->sbp && $record->dbp ? $record->sbp . '/' . $record->dbp : '-' }}
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
                                    @if ($record->newly_detected)
                                        <span class="badge-status bg-blue-100 text-blue-700"><i
                                                class="fas fa-bolt mr-1"></i>New</span>
                                    @else
                                        <span class="badge-status bg-gray-100 text-gray-600">Chronic</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($record->start_insulin_date && !$record->stop_insulin_date)
                                        <span class="badge-status bg-purple-100 text-purple-700"><i
                                                class="fas fa-syringe mr-1"></i>Active</span>
                                    @elseif($record->start_insulin_date && $record->stop_insulin_date)
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
                                            <span
                                                class="ml-1 px-1.5 py-0.5 bg-white/30 rounded-full text-xs">{{ $abnormalCount }}</span>
                                        @endif
                                    </span>
                                    @if ($temp > 99.4)
                                        <span class="badge-status badge-critical ml-1"><i
                                                class="fas fa-thermometer-half mr-1"></i>Fever</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        <button onclick="viewRecord({{ $record->id }})"
                                            class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('addnewReport',$record->id) }}"
                                            class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100" title="Add New">
                                            <i class="fas fa-add"></i>
                                        </a>
                                        <a href="{{ route('patient.edit',$record->id) }}"
                                            class="action-btn bg-yellow-50 text-yellow-600 hover:bg-yellow-100"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('patient.delete', $record->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure delete data')"
                                                class="action-btn bg-red-50 text-red-600 hover:bg-red-100" title="Delete">
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
    </div>

    <!-- Record Modal -->
    <div id="recordModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle" class="text-xl font-bold text-[#0b2a3f] mb-4"><i
                    class="fas fa-plus-circle text-[#1f6e96] mr-2"></i>Add New Record</h3>
            <form id="recordForm">
                <input type="hidden" id="recordId" name="recordId">

                <div class="form-row">
                    <div class="form-group">
                        <label>Record Date</label>
                        <input type="date" id="formDate" name="record_date">
                    </div>
                    <div class="form-group">
                        <label>Patient Name</label>
                        <input type="text" id="formName" name="patient_name" placeholder="Full name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" id="formAge" name="age" placeholder="Years">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select id="formGender" name="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="text" id="formMobile" name="mobile_no" placeholder="+91 XXXXX XXXXX">
                    </div>
                    <div class="form-group">
                        <label>New Registration No</label>
                        <input type="text" id="formRegNo" name="new_registration_no" placeholder="Reg number">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Newly Detected</label>
                        <select id="formNewlyDetected" name="newly_detected">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Duration of Diabetes (years)</label>
                        <input type="number" id="formDuration" name="duration_of_diabetes" placeholder="Years"
                            step="0.5">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Start Insulin Date</label>
                        <input type="date" id="formStartInsulin" name="start_insulin_date">
                    </div>
                    <div class="form-group">
                        <label>Stop Insulin Date</label>
                        <input type="date" id="formStopInsulin" name="stop_insulin_date">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="number" id="formHeight" name="height_cm" placeholder="cm" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" id="formWeight" name="weight_kg" placeholder="kg" step="0.1">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>BMI</label>
                        <input type="number" id="formBmi" name="bmi" step="0.1" readonly
                            style="background:#f1f5f9;">
                    </div>
                    <div class="form-group">
                        <label>BMI Group</label>
                        <input type="text" id="formBmiGroup" name="bmi_group" readonly style="background:#f1f5f9;">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>SBP (mmHg)</label>
                        <input type="number" id="formSbp" name="sbp" placeholder="Systolic">
                    </div>
                    <div class="form-group">
                        <label>DBP (mmHg)</label>
                        <input type="number" id="formDbp" name="dbp" placeholder="Diastolic">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>HbA1c (%)</label>
                        <input type="number" id="formHba1c" name="hba1c" step="0.1" placeholder="e.g. 7.2">
                    </div>
                    <div class="form-group">
                        <label>Creatinine (mg/dL)</label>
                        <input type="number" id="formCreatinine" name="creatinine" step="0.01"
                            placeholder="e.g. 1.2">
                    </div>
                </div>

                <div class="form-group">
                    <label>Temperature (°F)</label>
                    <input type="number" id="formTemperature" name="temperature" step="0.1" placeholder="98.6">
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit"><i class="fas fa-save mr-2"></i>Save Record</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 400px;">
            <h3 class="text-xl font-bold text-red-600 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
            </h3>
            <p class="text-gray-600 mb-4">Are you sure you want to delete this record? This action cannot be undone.</p>
            <input type="hidden" id="deleteId">
            <div class="flex gap-3 justify-end">
                <button class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-danger" onclick="confirmDelete()"><i class="fas fa-trash mr-2"></i>Delete</button>
            </div>
        </div>
    </div>

    <!-- View Record Modal -->
    <div id="viewModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px;">
            <span class="close-btn" onclick="closeViewModal()">&times;</span>
            <h3 class="text-xl font-bold text-[#0b2a3f] mb-4"><i class="fas fa-user-md text-[#1f6e96] mr-2"></i>Patient
                Details</h3>
            <div id="viewContent">
                <div class="text-center py-4 text-gray-500">Loading...</div>
            </div>
        </div>
    </div>

    <script>
        let dataTable;

        $(document).ready(function() {
            document.getElementById('lastUpdated').textContent = new Date().toLocaleString();

            dataTable = $('#patientTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fas fa-copy mr-1"></i>Copy',
                        className: 'dt-button'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv mr-1"></i>CSV',
                        className: 'dt-button'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i>Excel',
                        className: 'dt-button'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-1"></i>Print',
                        className: 'dt-button'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                        targets: [0],
                        width: '60px'
                    },
                    {
                        targets: [11],
                        width: '120px',
                        orderable: false
                    }
                ],
                language: {
                    emptyTable: "No patient records found",
                    zeroRecords: "No matching records found"
                }
            });

            // Auto-calculate BMI
            $('#formHeight, #formWeight').on('input', function() {
                calculateBmi();
            });

            // Form submit handler
            $('#recordForm').on('submit', function(e) {
                e.preventDefault();
                saveRecord();
            });
        });

        function calculateBmi() {
            const height = parseFloat($('#formHeight').val());
            const weight = parseFloat($('#formWeight').val());
            if (height && weight && height > 0) {
                const heightM = height / 100;
                const bmi = weight / (heightM * heightM);
                $('#formBmi').val(bmi.toFixed(1));

                let group = '';
                if (bmi < 18.5) group = 'Underweight';
                else if (bmi < 23) group = 'Normal';
                else if (bmi < 25) group = 'Overweight';
                else if (bmi < 30) group = 'Obese Class I';
                else if (bmi < 35) group = 'Obese Class II';
                else group = 'Obese Class III';
                $('#formBmiGroup').val(group);
            }
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerHTML =
                '<i class="fas fa-plus-circle text-[#1f6e96] mr-2"></i>Add New Record';
            document.getElementById('recordForm').reset();
            document.getElementById('recordId').value = '';
            $('#formBmi').val('');
            $('#formBmiGroup').val('');
            document.getElementById('recordModal').style.display = 'flex';
        }

        function editRecord(id) {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit text-[#1f6e96] mr-2"></i>Edit Record';

            $.ajax({
                url: `/api/patient-records/${id}`,
                method: 'GET',
                success: function(response) {
                    const data = response.data || response;
                    document.getElementById('recordId').value = data.id;
                    document.getElementById('formDate').value = data.record_date || '';
                    document.getElementById('formName').value = data.patient_name || '';
                    document.getElementById('formAge').value = data.age || '';
                    document.getElementById('formGender').value = data.gender || '';
                    document.getElementById('formNewlyDetected').value = data.newly_detected ? '1' : '0';
                    document.getElementById('formDuration').value = data.duration_of_diabetes || '';
                    document.getElementById('formStartInsulin').value = data.start_insulin_date || '';
                    document.getElementById('formStopInsulin').value = data.stop_insulin_date || '';
                    document.getElementById('formHeight').value = data.height_cm || '';
                    document.getElementById('formWeight').value = data.weight_kg || '';
                    document.getElementById('formBmi').value = data.bmi || '';
                    document.getElementById('formBmiGroup').value = data.bmi_group || '';
                    document.getElementById('formSbp').value = data.sbp || '';
                    document.getElementById('formDbp').value = data.dbp || '';
                    document.getElementById('formHba1c').value = data.hba1c || '';
                    document.getElementById('formCreatinine').value = data.creatinine || '';
                    document.getElementById('formMobile').value = data.mobile_no || '';
                    document.getElementById('formRegNo').value = data.new_registration_no || '';
                    document.getElementById('formTemperature').value = data.temperature || '';
                    document.getElementById('recordModal').style.display = 'flex';
                },
                error: function() {
                    showToast('Failed to load record data', 'error');
                }
            });
        }

        function viewRecord(id) {
            document.getElementById('viewModal').style.display = 'flex';
            document.getElementById('viewContent').innerHTML =
                '<div class="text-center py-4 text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</div>';

            $.ajax({
                url: `/api/patient-records/${id}`,
                method: 'GET',
                success: function(response) {
                    const data = response.data || response;

                    // Evaluate medical parameters
                    const bmi = parseFloat(data.bmi) || 0;
                    const hba1c = parseFloat(data.hba1c) || 0;
                    const sbp = parseFloat(data.sbp) || 0;
                    const dbp = parseFloat(data.dbp) || 0;
                    const temp = parseFloat(data.temperature) || 98.6;

                    let alerts = [];
                    if (bmi > 25) alerts.push({
                        status: 'critical',
                        text: 'Obesity: BMI > 25'
                    });
                    else if (bmi >= 23) alerts.push({
                        status: 'warning',
                        text: 'Overweight: BMI > 23'
                    });

                    if (hba1c >= 6.5) alerts.push({
                        status: 'critical',
                        text: 'Diabetes: HbA1c > 6.5%'
                    });
                    else if (hba1c >= 5.7) alerts.push({
                        status: 'warning',
                        text: 'Pre-Diabetes: HbA1c 5.7-6.4%'
                    });

                    if (sbp > 140 || dbp > 90) alerts.push({
                        status: 'critical',
                        text: 'Hypertension: BP > 140/90'
                    });
                    else if (sbp > 130 || dbp > 90) alerts.push({
                        status: 'warning',
                        text: 'Pre-Hypertension: BP > 130/90'
                    });

                    if (temp > 99.4) alerts.push({
                        status: 'critical',
                        text: 'Fever: Temperature > 99.4°F'
                    });

                    let alertHtml = '';
                    if (alerts.length > 0) {
                        alertHtml =
                            '<div class="mt-3"><strong class="text-sm text-gray-700">Medical Alerts:</strong>';
                        alerts.forEach(a => {
                            alertHtml +=
                                `<div class="alert-box alert-${a.status}"><i class="fas fa-${a.status === 'critical' ? 'exclamation-triangle' : 'exclamation-circle'} mr-2"></i>${a.text}</div>`;
                        });
                        alertHtml += '</div>';
                    } else {
                        alertHtml =
                            '<div class="alert-box alert-normal bg-green-50 border-l-4 border-green-500 text-green-700"><i class="fas fa-check-circle mr-2"></i>All parameters within normal range</div>';
                    }

                    document.getElementById('viewContent').innerHTML = `
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-2">
                            <div><strong class="text-gray-500">Name:</strong> ${data.patient_name || 'N/A'}</div>
                            <div><strong class="text-gray-500">Age:</strong> ${data.age || 'N/A'}</div>
                            <div><strong class="text-gray-500">Gender:</strong> ${data.gender || 'N/A'}</div>
                            <div><strong class="text-gray-500">Mobile:</strong> ${data.mobile_no || 'N/A'}</div>
                            <div><strong class="text-gray-500">BMI:</strong> ${data.bmi || 'N/A'}</div>
                            <div><strong class="text-gray-500">HbA1c:</strong> ${data.hba1c ? data.hba1c+'%' : 'N/A'}</div>
                            <div><strong class="text-gray-500">BP:</strong> ${data.sbp && data.dbp ? data.sbp+'/'+data.dbp : 'N/A'}</div>
                            <div><strong class="text-gray-500">Temp:</strong> ${data.temperature ? data.temperature+'°F' : '98.6°F'}</div>
                            <div><strong class="text-gray-500">Creatinine:</strong> ${data.creatinine || 'N/A'}</div>
                            <div><strong class="text-gray-500">Insulin:</strong> ${data.start_insulin_date ? (data.stop_insulin_date ? 'Stopped' : 'Active') : 'Not on'}</div>
                        </div>
                        ${alertHtml}
                    </div>
                `;
                },
                error: function() {
                    document.getElementById('viewContent').innerHTML =
                        '<div class="text-center py-4 text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>Failed to load record</div>';
                }
            });
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function saveRecord() {
            const id = document.getElementById('recordId').value;
            const url = id ? `/api/patient-records/${id}` : '/api/patient-records';
            const method = id ? 'PUT' : 'POST';

            const data = {
                record_date: document.getElementById('formDate').value,
                patient_name: document.getElementById('formName').value,
                age: document.getElementById('formAge').value,
                gender: document.getElementById('formGender').value,
                newly_detected: document.getElementById('formNewlyDetected').value === '1',
                duration_of_diabetes: document.getElementById('formDuration').value,
                start_insulin_date: document.getElementById('formStartInsulin').value || null,
                stop_insulin_date: document.getElementById('formStopInsulin').value || null,
                height_cm: document.getElementById('formHeight').value,
                weight_kg: document.getElementById('formWeight').value,
                bmi: document.getElementById('formBmi').value,
                bmi_group: document.getElementById('formBmiGroup').value,
                sbp: document.getElementById('formSbp').value,
                dbp: document.getElementById('formDbp').value,
                hba1c: document.getElementById('formHba1c').value,
                creatinine: document.getElementById('formCreatinine').value,
                mobile_no: document.getElementById('formMobile').value,
                new_registration_no: document.getElementById('formRegNo').value,
                temperature: document.getElementById('formTemperature').value,
            };

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function() {
                    closeModal();
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMsg = Object.values(errors).flat().join('\n');
                        showToast(errorMsg, 'error');
                    } else {
                        showToast('Failed to save record. Please try again.', 'error');
                    }
                }
            });
        }

        function openDeleteModal(id) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        function confirmDelete() {
            const id = document.getElementById('deleteId').value;

            $.ajax({
                url: "{{ url('admin/delete/patient') }}/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    closeDeleteModal();
                    toastr.success(res.message || "Record deleted successfully.");
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);

                    toastr.error("Failed to delete record.");
                }
            });
        }

        function closeModal() {
            document.getElementById('recordModal').style.display = 'none';
        }

        function refreshTable() {
            location.reload();
        }

        function showToast(message, type = 'success') {
            if (typeof toastr !== 'undefined') {
                if (type === 'success') toastr.success(message);
                else if (type === 'error') toastr.error(message);
                else if (type === 'info') toastr.info(message);
                else if (type === 'warning') toastr.warning(message);
                return;
            }

            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };

            const toast = document.createElement('div');
            toast.className =
                `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-xl shadow-lg fade-in max-w-md z-50`;
            toast.innerHTML =
                `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>${message}`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('recordModal');
            const deleteModal = document.getElementById('deleteModal');
            const viewModal = document.getElementById('viewModal');
            if (event.target === modal) closeModal();
            if (event.target === deleteModal) closeDeleteModal();
            if (event.target === viewModal) closeViewModal();
        }
    </script>
@endsection
