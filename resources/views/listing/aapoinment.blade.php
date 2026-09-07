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

    <!-- DataTables CSS & Buttons Assets -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .table-row-transition {
            transition: background-color 0.15s ease;
        }
        .custom-scroll::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Custom DataTables Styling */
        .dataTables_wrapper {
            font-size: 0.8125rem;
            color: #475569;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 0.5rem;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.4rem 1.75rem 0.4rem 0.75rem;
            font-size: 0.8125rem;
            background-color: #ffffff;
            outline: none;
            cursor: pointer;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0.5rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.45rem 0.85rem;
            font-size: 0.8125rem;
            background-color: #ffffff;
            outline: none;
            width: 220px;
            transition: all 0.2s;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .dt-buttons {
            display: inline-flex;
            gap: 0.35rem;
            flex-wrap: wrap;
        }
        .dt-btn-action {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            padding: 0.4rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            transition: all 0.15s ease-in-out !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            display: inline-flex !important;
            align-items: center !important;
            cursor: pointer !important;
        }
        .dt-btn-action:hover {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #1e293b !important;
            transform: translateY(-1px);
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.75rem;
            color: #64748b;
            padding-top: 0.75rem;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 0.75rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.6rem !important;
            padding: 0.35rem 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            border: 1px solid #e2e8f0 !important;
            margin: 0 2px !important;
            background: #ffffff !important;
            color: #475569 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important;
            color: #ffffff !important;
            border-color: #4f46e5 !important;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;
        }
        table.dataTable thead th {
            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* Modal styling & animation */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes modalPop {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>

    <div class="w-full max-w-7xl bg-white/90 backdrop-blur-sm shadow-xl shadow-slate-200/60 m-auto rounded-2xl border border-slate-200/60 p-5 md:p-7 transition-all">
        <!-- Header & Action Row -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="bg-indigo-50 p-2 rounded-xl text-indigo-600">
                        <i class="fas {{ !empty($isOnlyOnSite) ? 'fa-globe' : 'fa-calendar-check' }} text-lg"></i>
                    </span>
                    {{ $pageTitle ?? 'Appointment Records' }}
                </h2>
                <p class="text-sm text-slate-500 mt-0.5 flex items-center gap-1.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>{{ $appointments->count() }} total {{ !empty($isOnlyOnSite) ? 'on-site appointments' : (!empty($isOnlyAdmin) ? 'admin appointments' : 'appointment bookings') }}</span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Unified Export Dropdown Button -->
                <div class="relative" x-data="{ exportOpen: false }" @click.outside="exportOpen = false">
                    <button type="button" @click="exportOpen = !exportOpen"
                        class="h-10 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 rounded-xl transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <i class="fas fa-file-export"></i>
                        <span>Export</span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': exportOpen }"></i>
                    </button>

                    <div x-show="exportOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50 overflow-hidden divide-y divide-slate-100">
                        
                        <div class="py-1">
                            <a href="{{ route('appointment.export', !empty($isOnlyOnSite) ? ['type' => 'on_site'] : (!empty($isOnlyAdmin) ? ['type' => 'admin'] : [])) }}" @click="exportOpen = false"
                                class="w-full flex items-center gap-3 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition group">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition flex-shrink-0">
                                    <i class="fas fa-file-csv text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800 group-hover:text-emerald-700">Export as CSV</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Direct CSV file download</div>
                                </div>
                            </a>

                            <button type="button" @click="exportOpen = false; triggerDtExport('excel');"
                                class="w-full flex items-center gap-3 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition group text-left">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition flex-shrink-0">
                                    <i class="fas fa-file-excel text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800 group-hover:text-emerald-700">Export as Excel</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Formatted .xlsx file</div>
                                </div>
                            </button>

                            <button type="button" @click="exportOpen = false; triggerDtExport('pdf');"
                                class="w-full flex items-center gap-3 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition group text-left">
                                <span class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition flex-shrink-0">
                                    <i class="fas fa-file-pdf text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800 group-hover:text-rose-700">Export as PDF</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Printable PDF document</div>
                                </div>
                            </button>

                            <button type="button" @click="exportOpen = false; triggerDtExport('print');"
                                class="w-full flex items-center gap-3 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition group text-left">
                                <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition flex-shrink-0">
                                    <i class="fas fa-print text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800 group-hover:text-indigo-700">Print Table</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Clean print view</div>
                                </div>
                            </button>

                            <button type="button" @click="exportOpen = false; triggerDtExport('copy');"
                                class="w-full flex items-center gap-3 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition group text-left">
                                <span class="w-7 h-7 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition flex-shrink-0">
                                    <i class="fas fa-copy text-xs"></i>
                                </span>
                                <div>
                                    <div class="font-bold text-slate-800 group-hover:text-sky-700">Copy to Clipboard</div>
                                    <div class="text-[10px] text-slate-400 font-normal">Copy table data</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                @if(empty($isOnlyOnSite))
                <!-- Add Appointment Button -->
                <button type="button" onclick="openAppointmentModal()" class="h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 rounded-xl transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm">
                    <i class="fas fa-plus"></i>
                    <span>New Appointment</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Hidden container for DataTables buttons -->
        <div id="dt-buttons-hidden" class="hidden"></div>

        <!-- Table -->
        <div class="rounded-xl border border-slate-200/80 bg-white/60 shadow-sm p-4">
            <table id="appointmentTable" class="w-full text-sm text-left text-slate-700 {{ !empty($isOnlyAdmin) ? 'min-w-[1450px]' : 'min-w-[1650px]' }} stripe hover">
                <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                    <tr>
                        <th scope="col" class="no-sort px-5 py-3.5 font-semibold min-w-[70px] whitespace-nowrap">Sr no.</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[180px] whitespace-nowrap">Patient Name</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[90px] whitespace-nowrap">Age</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[150px] whitespace-nowrap">Father's Name</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[140px] whitespace-nowrap">Phone</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[180px] whitespace-nowrap">Email</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[180px]">Address</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[130px] whitespace-nowrap">Visit Type</th>
                        @if(empty($isOnlyAdmin))
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[220px]">Note / Message</th>
                        @endif
                        <th scope="col" class="px-5 py-3.5 font-semibold min-w-[150px] whitespace-nowrap">Scheduled Date</th>
                        <th scope="col" class="col-date px-5 py-3.5 font-semibold min-w-[160px] whitespace-nowrap">Booked On</th>
                        <th scope="col" class="no-sort px-5 py-3.5 font-semibold min-w-[240px] text-center whitespace-nowrap no-export">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-slate-100">
                    @foreach($appointments as $index => $appointment)
                    <tr class="table-row-transition hover:bg-indigo-50/40 group" 
                        data-name="{{ $appointment->patient_name ?? '' }}" 
                        data-age="{{ $appointment->age ?? '' }}"
                        data-father="{{ $appointment->father_name ?? '' }}"
                        data-phone="{{ $appointment->phone ?? '' }}" 
                        data-mail="{{ $appointment->mail ?? '' }}" 
                        data-address="{{ $appointment->address ?? '' }}"
                        data-type="{{ $appointment->patient_type ?? '' }}" 
                        data-source="{{ $appointment->appointment_type ?? '' }}"
                        data-message="{{ $appointment->message ?? '' }}">
                        <td class="px-5 py-3.5 text-slate-400 font-mono text-xs whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5 font-medium text-slate-800 flex items-center gap-3 min-w-[180px] whitespace-nowrap">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold uppercase flex-shrink-0">
                                {{ $appointment->patient_name ? substr($appointment->patient_name, 0, 2) : 'NA' }}
                            </span>
                            <span class="font-semibold text-slate-800">{{ $appointment->patient_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-700 font-medium text-xs whitespace-nowrap min-w-[90px]">
                            @if($appointment->age)
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold">{{ $appointment->age }} yrs</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-slate-700 text-xs min-w-[150px] whitespace-nowrap">
                            {{ $appointment->father_name ?: '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 font-mono text-xs whitespace-nowrap min-w-[140px]">
                            <i class="fas fa-phone-alt text-slate-400 mr-1 text-[11px]"></i>
                            {{ $appointment->phone ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 text-xs min-w-[180px] whitespace-nowrap">
                            @if($appointment->mail)
                                <a href="mailto:{{ $appointment->mail }}" class="text-indigo-600 hover:text-indigo-800 hover:underline inline-flex items-center gap-1.5" title="{{ $appointment->mail }}">
                                    <i class="fas fa-envelope text-slate-400 text-[11px]"></i>
                                    <span>{{ $appointment->mail }}</span>
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 text-xs min-w-[180px] max-w-xs break-words">
                            {{ $appointment->address ?: '-' }}
                        </td>
                        <td class="px-5 py-3.5 min-w-[130px] whitespace-nowrap">
                            @php
                                $rawType = trim($appointment->patient_type ?? '');
                                $typeMap = [
                                    'N' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'dot' => 'bg-sky-500'],
                                    'ON' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'dot' => 'bg-indigo-500'],
                                    'DMF' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                    'NDM' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'dot' => 'bg-rose-500'],
                                    'NM' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'border' => 'border-teal-200', 'dot' => 'bg-teal-500'],
                                    'NMDM' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'dot' => 'bg-purple-500'],
                                    'complimentry' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                ];
                                $style = $typeMap[$rawType] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                                {{ $appointment->patient_type ?? 'N/A' }}
                            </span>
                        </td>
                        @if(empty($isOnlyAdmin))
                        <td class="px-5 py-3.5 text-slate-600 text-xs min-w-[220px] max-w-sm">
                            @if(empty($appointment->message))
                                <span class="text-slate-400 italic">-</span>
                            @elseif(mb_strlen($appointment->message) <= 50)
                                <span class="text-slate-700 whitespace-normal break-words">{{ $appointment->message }}</span>
                            @else
                                <div x-data="{ expanded: false }" class="relative">
                                    <div x-show="!expanded" class="text-slate-700 flex items-start gap-1">
                                        <span class="whitespace-normal break-words">{{ \Illuminate\Support\Str::limit($appointment->message, 50, '...') }}</span>
                                        <button type="button" @click="expanded = true" class="inline-flex items-center gap-0.5 text-indigo-600 hover:text-indigo-800 font-semibold text-[11px] underline flex-shrink-0 cursor-pointer focus:outline-none transition mt-0.5">
                                            <span>More</span>
                                            <i class="fas fa-chevron-down text-[9px]"></i>
                                        </button>
                                    </div>
                                    <div x-show="expanded" x-cloak class="mt-1 p-2.5 bg-slate-50 border border-slate-200/90 rounded-xl text-slate-700 whitespace-pre-line break-words shadow-sm">
                                        <div class="text-xs leading-relaxed text-slate-800">{{ $appointment->message }}</div>
                                        <div class="mt-1.5 pt-1.5 border-t border-slate-200/60 flex justify-end">
                                            <button type="button" @click="expanded = false" class="inline-flex items-center gap-0.5 text-indigo-600 hover:text-indigo-800 font-semibold text-[11px] underline cursor-pointer focus:outline-none transition">
                                                <span>Less</span>
                                                <i class="fas fa-chevron-up text-[9px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        @endif
                        <td class="px-5 py-3.5 min-w-[150px] whitespace-nowrap" data-order="{{ $appointment->appointment_scheduled_date ? \Carbon\Carbon::parse($appointment->appointment_scheduled_date)->timestamp : 0 }}">
                            @if($appointment->appointment_scheduled_date)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                    <i class="fas fa-calendar-check text-emerald-500 text-[11px]"></i>
                                    <span>{{ \Carbon\Carbon::parse($appointment->appointment_scheduled_date)->format('d M Y') }}</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="fas fa-clock text-amber-500 text-[11px]"></i>
                                    <span>Not Scheduled</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 text-xs font-mono whitespace-nowrap min-w-[160px]" data-order="{{ $appointment->created_at ? $appointment->created_at->timestamp : 0 }}">
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-clock text-slate-400 text-[11px]"></i>
                                <span>{{ $appointment->created_at ? $appointment->created_at->format('d M Y, h:i A') : '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-center whitespace-nowrap min-w-[240px]">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button"
                                    onclick="openScheduleModal({{ $appointment->id }}, '{{ addslashes($appointment->patient_name ?? '') }}', '{{ $appointment->appointment_scheduled_date ? \Carbon\Carbon::parse($appointment->appointment_scheduled_date)->format('Y-m-d') : '' }}', '{{ addslashes($appointment->mail ?? '') }}', '{{ addslashes($appointment->created_at ? $appointment->created_at->format('d M Y, h:i A') : '') }}')"
                                    title="{{ $appointment->appointment_scheduled_date ? 'Reschedule Appointment Date' : 'Schedule Appointment Date' }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-2.5 py-1.5 rounded-xl {{ $appointment->appointment_scheduled_date ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' }} font-semibold text-xs transition shadow-sm hover:shadow">
                                    <i class="fas {{ $appointment->appointment_scheduled_date ? 'fa-calendar-check text-emerald-600' : 'fa-calendar-alt text-amber-600' }} text-xs"></i>
                                    <span>{{ $appointment->appointment_scheduled_date ? 'Reschedule' : 'Schedule' }}</span>
                                </button>

                                <a href="{{ route('patient.form') }}?name={{ urlencode($appointment->patient_name ?? '') }}&father_name={{ urlencode($appointment->father_name ?? '') }}&guardian_name={{ urlencode($appointment->father_name ?? '') }}&number={{ urlencode($appointment->phone ?? '') }}&age={{ urlencode($appointment->age ?? '') }}&mail={{ urlencode($appointment->mail ?? '') }}&address={{ urlencode($appointment->address ?? '') }}"
                                   title="Register Patient (Pass details to form)"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition shadow-sm hover:shadow-md group/btn">
                                    <i class="fas fa-plus text-xs group-hover/btn:scale-125 transition-transform"></i>
                                    <span>Add Patient</span>
                                </a>

                                <form action="{{ route('appointment.delete', $appointment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this appointment for {{ addslashes($appointment->patient_name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        title="Delete Appointment"
                                        class="w-8 h-8 rounded-xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 transition flex items-center justify-center shadow-sm hover:shadow">
                                        <i class="fas fa-trash-alt text-xs"></i>
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

    <!-- Appointment Modal Popup (Matching Site Theme) -->
    <div id="appointmentModal" class="modal-overlay">
        <div class="modal-box w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-indigo-50 to-white border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-100">
                        <i class="fas fa-calendar-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Book New Appointment</h3>
                        <p class="text-xs text-slate-500">Add a patient visit or consultation request</p>
                    </div>
                </div>
                <button type="button" onclick="closeAppointmentModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('appoinmentstore') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="appointment_type" value="admin">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Patient Name -->
                    <div class="sm:col-span-2">
                        <label for="patient_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-user text-indigo-500 mr-1"></i> Patient Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="patient_name" name="patient_name" placeholder="Enter full patient name" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        @error('patient_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div class="sm:col-span-1">
                        <label for="age" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            <i class="far fa-calendar text-indigo-500 mr-1"></i> Age
                        </label>
                        <input type="number" id="age" name="age" min="0" max="150" placeholder="Years"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        @error('age')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Father's Name -->
                <div>
                    <label for="father_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-user-friends text-indigo-500 mr-1"></i> Father's Name
                    </label>
                    <input type="text" id="father_name" name="father_name" placeholder="Enter father's name (optional)"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                    @error('father_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-phone-alt text-indigo-500 mr-1"></i> Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="e.g. +91 98765 43210" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="mail" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-envelope text-indigo-500 mr-1"></i> Email Address
                        </label>
                        <input type="email" id="mail" name="mail" placeholder="e.g. patient@example.com (optional)"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        @error('mail')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> Address
                    </label>
                    <input type="text" id="address" name="address" placeholder="Enter address (street, city, state)"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                    @error('address')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Patient Type / Visit Purpose -->
                <div>
                    <label for="patient_type" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-tag text-indigo-500 mr-1"></i> Visit Type <span class="text-red-500">*</span>
                    </label>
                    <select id="patient_type" name="patient_type" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        <option value="" disabled selected>Select Visit Type</option>
                        <option value="N">N</option>
                        <option value="ON">ON</option>
                        <option value="DMF">DMF</option>
                        <option value="NDM">NDM</option>
                        <option value="NM">NM</option>
                        <option value="NMDM">NMDM</option>
                        <option value="complimentry">complimentry</option>
                    </select>
                    @error('patient_type')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeAppointmentModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-sm font-medium transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-100 hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Save Appointment</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Schedule Appointment Modal -->
    <div id="scheduleModal" class="modal-overlay">
        <div class="modal-box w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-emerald-50 via-teal-50 to-white border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-100">
                        <i class="fas fa-calendar-check text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Schedule Appointment</h3>
                        <p class="text-xs text-slate-500">Confirm date & send email notification</p>
                    </div>
                </div>
                <button type="button" onclick="closeScheduleModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="scheduleAppointmentForm" method="POST" action="" class="p-6 space-y-4">
                @csrf

                <!-- Patient Summary Card -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold uppercase tracking-wider text-slate-400">Patient:</span>
                        <span id="modalPatientName" class="font-bold text-slate-800 text-sm"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold uppercase tracking-wider text-slate-400">Booked On:</span>
                        <span id="modalBookedAt" class="font-mono text-slate-600"></span>
                    </div>
                    <div id="modalEmailNotice" class="pt-2 border-t border-slate-200">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>

                <!-- Scheduled Date Picker -->
                <div>
                    <label for="modalScheduledDateInput" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-calendar-day text-emerald-600 mr-1"></i> Scheduled Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="modalScheduledDateInput" name="appointment_scheduled_date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition bg-white">
                    <p class="text-[11px] text-slate-500 mt-1">Select the confirmed date on which patient should visit the clinic.</p>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeScheduleModal()"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-sm font-medium transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-md shadow-emerald-100 hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Confirm & Schedule</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            modal.classList.add('active');
            setTimeout(() => {
                document.getElementById('patient_name')?.focus();
            }, 100);
        }

        function closeAppointmentModal() {
            const modal = document.getElementById('appointmentModal');
            modal.classList.remove('active');
        }

        function openScheduleModal(id, name, scheduledDate, email, bookedAt) {
            const modal = document.getElementById('scheduleModal');
            const form = document.getElementById('scheduleAppointmentForm');
            
            form.action = "{{ url('/admin/appointment/schedule') }}/" + id;
            document.getElementById('modalPatientName').textContent = name || 'Patient';
            document.getElementById('modalBookedAt').textContent = bookedAt || '-';
            
            const emailNotice = document.getElementById('modalEmailNotice');
            if (email && email.trim() !== '') {
                emailNotice.innerHTML = `<span class="text-emerald-700 font-medium flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> Confirmation email will be sent to <strong>${email}</strong></span>`;
            } else {
                emailNotice.innerHTML = `<span class="text-amber-700 font-medium flex items-center gap-1.5"><i class="fas fa-exclamation-triangle text-amber-500"></i> No email provided. Appointment will be scheduled without email notification.</span>`;
            }
            
            const dateInput = document.getElementById('modalScheduledDateInput');
            dateInput.value = scheduledDate || '';
            
            modal.classList.add('active');
            setTimeout(() => {
                dateInput.focus();
            }, 100);
        }

        function closeScheduleModal() {
            const modal = document.getElementById('scheduleModal');
            modal.classList.remove('active');
        }

        // Close when clicking outside modal box
        window.addEventListener('click', function(e) {
            const appointmentModal = document.getElementById('appointmentModal');
            if (e.target === appointmentModal) {
                closeAppointmentModal();
            }
            const scheduleModal = document.getElementById('scheduleModal');
            if (e.target === scheduleModal) {
                closeScheduleModal();
            }
        });

        // Close on Escape key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAppointmentModal();
                closeScheduleModal();
            }
        });

        // Global trigger function for the unified export dropdown
        let appointmentDataTable;
        function triggerDtExport(type) {
            if (!appointmentDataTable) return;
            if (type === 'excel') {
                appointmentDataTable.button('.buttons-excel').trigger();
            } else if (type === 'csv') {
                appointmentDataTable.button('.buttons-csv').trigger();
            } else if (type === 'pdf') {
                appointmentDataTable.button('.buttons-pdf').trigger();
            } else if (type === 'print') {
                appointmentDataTable.button('.buttons-print').trigger();
            } else if (type === 'copy') {
                appointmentDataTable.button('.buttons-copy').trigger();
            }
        }

        // DataTable Initialization
        $(document).ready(function() {
            let dateColIndex = $('#appointmentTable thead th.col-date').index();
            if (dateColIndex === -1) {
                dateColIndex = {{ !empty($isOnlyAdmin) ? 9 : 10 }};
            }

            appointmentDataTable = $('#appointmentTable').DataTable({
                autoWidth: false,
                pageLength: 15,
                lengthMenu: [
                    [15, 25, 50, 100, -1],
                    [15, 25, 50, 100, "All"]
                ],
                order: [[dateColIndex, 'desc']], // Sort by Date descending by default
                columnDefs: [
                    {
                        targets: 'no-sort',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4"lf><"overflow-x-auto custom-scroll w-full pb-2"t><"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'buttons-excel',
                        title: '{{ !empty($isOnlyOnSite) ? 'OnSite_Appointments_' : (!empty($isOnlyAdmin) ? 'Admin_Appointments_' : 'Appointment_Records_') }}' + new Date().toISOString().slice(0, 10),
                        exportOptions: {
                            columns: ':not(.no-export)',
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text().trim().replace(/\s+/g, ' ');
                                }
                            }
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'buttons-csv',
                        title: '{{ !empty($isOnlyOnSite) ? 'OnSite_Appointments_' : (!empty($isOnlyAdmin) ? 'Admin_Appointments_' : 'Appointment_Records_') }}' + new Date().toISOString().slice(0, 10),
                        exportOptions: {
                            columns: ':not(.no-export)',
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text().trim().replace(/\s+/g, ' ');
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'buttons-pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: '{{ !empty($isOnlyOnSite) ? 'On-Site Appointment Records' : (!empty($isOnlyAdmin) ? 'Admin Appointment Records' : 'Appointment Records') }}',
                        exportOptions: {
                            columns: ':not(.no-export)',
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text().trim().replace(/\s+/g, ' ');
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        className: 'buttons-print',
                        title: '{{ !empty($isOnlyOnSite) ? 'On-Site Appointment Records' : (!empty($isOnlyAdmin) ? 'Admin Appointment Records' : 'Appointment Records') }}',
                        exportOptions: {
                            columns: ':not(.no-export)',
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text().trim().replace(/\s+/g, ' ');
                                }
                            }
                        }
                    },
                    {
                        extend: 'copyHtml5',
                        className: 'buttons-copy',
                        exportOptions: {
                            columns: ':not(.no-export)',
                            format: {
                                body: function(data, row, column, node) {
                                    return $(node).text().trim().replace(/\s+/g, ' ');
                                }
                            }
                        }
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ {{ !empty($isOnlyOnSite) ? 'on-site appointments' : (!empty($isOnlyAdmin) ? 'admin appointments' : 'appointments') }}",
                    infoEmpty: "No appointments found",
                    infoFiltered: "(filtered from _MAX_ total)",
                    emptyTable: "No appointment records found",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                }
            });

            // Mount buttons in hidden container so they can be triggered from the dropdown button
            appointmentDataTable.buttons().container().appendTo('#dt-buttons-hidden');

            // Dynamic sequential numbers on sort/search/page
            appointmentDataTable.on('order.dt search.dt draw.dt', function() {
                let info = appointmentDataTable.page.info();
                appointmentDataTable.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
        });
    </script>
@endsection
