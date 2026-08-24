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

    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .table-row-transition {
            transition: background-color 0.15s ease;
        }
        .custom-scroll::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 12px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 12px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        /* Status badge colors */
        .badge-outpatient { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .badge-inpatient { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        .badge-emergency { background: #f5f3ff; color: #5b21b6; border-color: #c4b5fd; }
        .badge-consultation { background: #f0f9ff; color: #075985; border-color: #bae6fd; }
        .badge-default { background: #f1f5f9; color: #334155; border-color: #cbd5e1; }

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

    <div class="w-full max-w-6xl bg-white/90 backdrop-blur-sm shadow-xl shadow-slate-200/60 m-auto rounded-2xl border border-slate-200/60 p-5 md:p-7 transition-all">
        <!-- Header & Action Row -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="bg-indigo-50 p-2 rounded-xl text-indigo-600">
                        <i class="fas fa-calendar-check text-lg"></i>
                    </span>
                    Appointment Records
                </h2>
                <p class="text-sm text-slate-500 mt-0.5 flex items-center gap-1.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>{{ $appointments->total() ?? $appointments->count() }} total appointment bookings</span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Search input -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Search appointments..." class="h-10 w-48 sm:w-56 pl-9 pr-3 text-sm rounded-xl border border-slate-200 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition placeholder:text-slate-400" />
                </div>

                <!-- Add Appointment Button -->
                <button type="button" onclick="openAppointmentModal()" class="h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 rounded-xl transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm">
                    <i class="fas fa-plus"></i>
                    <span>New Appointment</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="custom-scroll overflow-x-auto rounded-xl border border-slate-200/80 bg-white/60 shadow-sm">
            <table class="w-full text-sm text-left text-slate-700 min-w-[580px]">
                <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 font-semibold">#</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Patient Name</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Phone</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Visit Type</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Note / Message</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Date</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-slate-100">
                    @forelse($appointments as $index => $appointment)
                    <tr class="table-row-transition hover:bg-indigo-50/40 group" data-name="{{ $appointment->patient_name ?? '' }}" data-phone="{{ $appointment->phone ?? '' }}" data-type="{{ $appointment->patient_type ?? '' }}" data-message="{{ $appointment->message ?? '' }}">
                        <td class="px-5 py-3.5 text-slate-400 font-mono text-xs">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5 font-medium text-slate-800 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold uppercase flex-shrink-0">
                                {{ $appointment->patient_name ? substr($appointment->patient_name, 0, 2) : 'NA' }}
                            </span>
                            <span class="font-semibold text-slate-800">{{ $appointment->patient_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 font-mono text-xs">
                            <i class="fas fa-phone-alt text-slate-400 mr-1 text-[11px]"></i>
                            {{ $appointment->phone ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $type = strtolower($appointment->patient_type ?? '');
                                $badgeClass = 'badge-default';
                                if (str_contains($type, 'new')) $badgeClass = 'badge-outpatient';
                                elseif (str_contains($type, 'old') || str_contains($type, 'follow')) $badgeClass = 'badge-consultation';
                                elseif (str_contains($type, 'drug')) $badgeClass = 'badge-inpatient';
                                elseif (str_contains($type, 'investigation') || str_contains($type, 'ultrasound')) $badgeClass = 'badge-emergency';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_contains($type, 'new') ? 'bg-emerald-500' : (str_contains($type, 'old') || str_contains($type, 'follow') ? 'bg-sky-500' : (str_contains($type, 'drug') ? 'bg-amber-500' : 'bg-purple-500')) }}"></span>
                                {{ $appointment->patient_type ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 max-w-[200px] truncate" title="{{ $appointment->message }}">
                            {{ $appointment->message ?: '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-400 text-xs font-mono">
                            {{ $appointment->created_at ? $appointment->created_at->format('d M Y, h:i A') : '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-center whitespace-nowrap">
                            <a href="{{ route('patient.form') }}?name={{ urlencode($appointment->patient_name ?? '') }}&number={{ urlencode($appointment->phone ?? '') }}"
                               title="Register Patient (Pass {{ $appointment->patient_name }} and {{ $appointment->phone }})"
                               class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition shadow-sm hover:shadow-md group/btn">
                                <i class="fas fa-plus text-xs group-hover/btn:scale-125 transition-transform"></i>
                                <span>Add Patient</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-1">
                                    <i class="fas fa-calendar-times text-2xl"></i>
                                </div>
                                <span class="font-semibold text-slate-700">No appointment records found</span>
                                <p class="text-xs text-slate-400">Click "+ New Appointment" above to create one.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-5 text-xs text-slate-500">
            <div class="flex items-center gap-1.5">
                <span class="bg-slate-100 px-2.5 py-1 rounded-md text-slate-600 font-medium" id="recordCount">
                    {{ $appointments->count() }} loaded
                </span>
                <span>of {{ $appointments->total() ?? $appointments->count() }} records</span>
            </div>

            @if(method_exists($appointments, 'hasPages') && $appointments->hasPages())
                <div>
                    {{ $appointments->links() }}
                </div>
            @endif
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

                <!-- Patient Name -->
                <div>
                    <label for="patient_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-user text-indigo-500 mr-1"></i> Patient Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="patient_name" name="patient_name" placeholder="Enter full patient name" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                    @error('patient_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

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

                <!-- Patient Type / Visit Purpose -->
                <div>
                    <label for="patient_type" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-tag text-indigo-500 mr-1"></i> Visit Type <span class="text-red-500">*</span>
                    </label>
                    <select id="patient_type" name="patient_type" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50">
                        <option value="New patient">👤 New patient</option>
                        <option value="Old patient / follow-up">🔄 Old patient / follow-up</option>
                        <option value="Drug evaluation">💊 Drug evaluation</option>
                        <option value="Investigation / ultrasound">🔬 Investigation / ultrasound</option>
                    </select>
                    @error('patient_type')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message / Note -->
                <div>
                    <label for="message" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-notes-medical text-indigo-500 mr-1"></i> Appointment Note / Concern
                    </label>
                    <textarea id="message" name="message" rows="3" placeholder="Brief notes about symptoms, complaints, or consultation reasons..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50"></textarea>
                    @error('message')
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

        // Close when clicking outside modal box
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('appointmentModal');
            if (e.target === modal) {
                closeAppointmentModal();
            }
        });

        // Close on Escape key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAppointmentModal();
            }
        });

        // Client-side search filtering
        (function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#tableBody tr');
            const recordCountSpan = document.getElementById('recordCount');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    let visibleCount = 0;

                    tableRows.forEach(row => {
                        if (row.querySelector('td[colspan]')) {
                            row.style.display = query ? 'none' : '';
                            return;
                        }

                        const name = row.dataset.name?.toLowerCase() || '';
                        const phone = row.dataset.phone?.toLowerCase() || '';
                        const type = row.dataset.type?.toLowerCase() || '';
                        const message = row.dataset.message?.toLowerCase() || '';

                        const matches = name.includes(query) ||
                                       phone.includes(query) ||
                                       type.includes(query) ||
                                       message.includes(query);

                        if (matches || query === '') {
                            row.style.display = '';
                            if (query !== '') visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    const visibleRows = document.querySelectorAll('#tableBody tr:not([style*="display: none"])');
                    if (recordCountSpan) {
                        recordCountSpan.textContent = `${visibleRows.length} loaded`;
                    }
                });
            }
        })();
    </script>
@endsection
