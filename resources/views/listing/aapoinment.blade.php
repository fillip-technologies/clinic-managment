@extends('admin.loyout.master')
@section('content')

    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .table-row-transition {
            transition: background-color 0.15s ease;
        }
        .badge-pulse {
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
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
    </style>

    <div class="w-full max-w-6xl bg-white/90 backdrop-blur-sm shadow-xl shadow-slate-200/60 m-auto rounded-2xl border border-slate-200/60 p-5 md:p-7 transition-all">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="bg-indigo-50 p-1.5 rounded-lg text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    Patient records
                </h2>
                <p class="text-sm text-slate-500 mt-0.5 flex items-center gap-1.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>{{ $appointments->count() }} active patients</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" id="searchInput" placeholder="Search patients..." class="h-9 w-48 pl-9 pr-3 text-sm rounded-lg border border-slate-200 bg-white/70 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200/50 outline-none transition placeholder:text-slate-400" />
                </div>

            </div>
        </div>

        <div class="custom-scroll overflow-x-auto rounded-xl border border-slate-200/80 bg-white/60 shadow-sm">
            <table class="w-full text-sm text-left text-slate-700 min-w-[580px]">
                <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Patient name</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Phone</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Type</th>
                        <th scope="col" class="px-5 py-3.5 font-semibold">Message</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-slate-100">
                    @forelse($appointments as $appointment)
                    <tr class="table-row-transition hover:bg-indigo-50/40 group" data-name="{{ $appointment->patient_name ?? '' }}" data-phone="{{ $appointment->phone ?? '' }}" data-type="{{ $appointment->patient_type ?? '' }}" data-message="{{ $appointment->message ?? '' }}">
                        <td class="px-5 py-3.5 font-medium text-slate-800 flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold uppercase">
                                {{ $appointment->patient_name ? substr($appointment->patient_name, 0, 2) : 'NA' }}
                            </span>
                            {{ $appointment->patient_name ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $appointment->phone ?? 'N/A' }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $type = strtolower($appointment->patient_type ?? '');
                                $badgeClass = 'badge-default';
                                if (str_contains($type, 'outpatient')) $badgeClass = 'badge-outpatient';
                                elseif (str_contains($type, 'inpatient')) $badgeClass = 'badge-inpatient';
                                elseif (str_contains($type, 'emergency')) $badgeClass = 'badge-emergency';
                                elseif (str_contains($type, 'consult')) $badgeClass = 'badge-consultation';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_contains($type, 'outpatient') ? 'bg-emerald-500' : (str_contains($type, 'inpatient') ? 'bg-amber-500' : (str_contains($type, 'emergency') ? 'bg-violet-500' : 'bg-slate-400')) }}"></span>
                                {{ $appointment->patient_type ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 max-w-[160px] truncate">{{ $appointment->message ?? 'N/A' }}</td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <span>No patient records found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-5 text-xs text-slate-500">
            <div class="flex items-center gap-1.5">
                <span class="bg-slate-100 px-2.5 py-1 rounded-md text-slate-600 font-medium" id="recordCount">1–{{ $appointments->count() }}</span>
                <span>of {{ $appointments->count() }} patients</span>
            </div>
            <div class="flex items-center gap-1.5">
                <button disabled class="px-3 py-1.5 rounded-md bg-slate-100/60 text-slate-300 cursor-not-allowed border border-slate-200/50">Previous</button>
                <span class="px-3 py-1.5 rounded-md bg-indigo-100 text-indigo-700 font-semibold border border-indigo-200">1</span>
                <button disabled class="px-3 py-1.5 rounded-md bg-slate-100/60 text-slate-300 cursor-not-allowed border border-slate-200/50">Next</button>
            </div>
        </div>

        <div class="mt-3 text-[11px] text-slate-400 border-t border-slate-100 pt-3 flex flex-wrap items-center justify-between">
            <span class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-indigo-200"></span>
                <span>Fields: patient_name · phone · patient_type · message</span>
            </span>
            <span class="bg-slate-100 px-2 py-0.5 rounded-full text-slate-500">{{ $appointments->count() }} records</span>
        </div>
    </div>

    <script>
        (function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#tableBody tr');
            const recordCountSpan = document.getElementById('recordCount');
            const totalRecords = {{ $appointments->count() }};

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    let visibleCount = 0;

                    tableRows.forEach(row => {
                        // Skip the "no records" row
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

                    // Update record count
                    const visibleRows = document.querySelectorAll('#tableBody tr:not([style*="display: none"])');
                    const visibleCountFinal = visibleRows.length;

                    if (recordCountSpan) {
                        if (visibleCountFinal === 0) {
                            recordCountSpan.textContent = '0';
                        } else {
                            recordCountSpan.textContent = `1–${visibleCountFinal}`;
                        }
                    }

                    // Show/hide "no results" message
                    let noResultsRow = document.querySelector('#tableBody tr.no-results-row');
                    if (visibleCountFinal === 0 && query !== '') {
                        if (!noResultsRow) {
                            noResultsRow = document.createElement('tr');
                            noResultsRow.className = 'no-results-row';
                            noResultsRow.innerHTML = `
                                <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        <span>No results found for "<strong>${query}</strong>"</span>
                                    </div>
                                </td>
                            `;
                            document.querySelector('#tableBody').appendChild(noResultsRow);
                        }
                    } else if (noResultsRow) {
                        noResultsRow.remove();
                    }
                });
            }

            // Delete confirmation with toast feedback
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this patient record?')) {
                        e.preventDefault();
                    }
                });
            });

            // Edit action toast feedback (for demonstration)
            const editButtons = document.querySelectorAll('a[href*="edit"]');
            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Let the link work normally, just show feedback
                    const row = this.closest('tr');
                    const name = row?.dataset?.name || 'patient';
                    showToast(`Editing ${name}...`);
                });
            });

            // Toast notification helper
            function showToast(message) {
                const existingToast = document.querySelector('.custom-toast');
                if (existingToast) existingToast.remove();

                const toast = document.createElement('div');
                toast.className = 'custom-toast fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-800/90 text-white text-sm px-5 py-2.5 rounded-xl shadow-lg backdrop-blur-sm border border-white/10 transition-all duration-300 flex items-center gap-2 z-50';
                toast.innerHTML = `
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                    ${message}
                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    setTimeout(() => toast.remove(), 300);
                }, 2000);
            }
        })();
    </script>

@endsection
