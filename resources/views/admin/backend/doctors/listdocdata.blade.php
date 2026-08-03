{{-- admin.backend.doctors.listdocdata --}}
@extends('admin.loyout.master')
@section('content')
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Page Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 flex items-center gap-3">
                    <i class="fas fa-list-ul text-indigo-500 text-2xl"></i>
                    Doctor Reports
                </h1>
                <p class="text-slate-500 text-sm mt-0.5 flex items-center gap-1">
                    <i class="fas fa-notes-medical text-indigo-300"></i>
                    All uploaded doctor reports
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="bg-indigo-100 text-indigo-700 text-xs font-medium px-3 py-1.5 rounded-full flex items-center gap-1.5">
                    <i class="fas fa-database"></i>
                    <span>{{ count($datas) }}</span> records
                </span>
                <a href="{{ route('doctor.report.form') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-xl shadow-sm transition flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> New Report
                </a>
            </div>
        </div>

        {{-- Card Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/60 overflow-hidden">

            {{-- Table Toolbar --}}
            <div
                class="px-6 py-3 border-b border-slate-200/70 bg-slate-50/50 flex flex-wrap items-center justify-between gap-2 text-sm">
                <div class="flex items-center gap-2 text-slate-500">
                    <i class="fas fa-filter text-indigo-300"></i>
                    <span>Showing all reports</span>
                </div>
                <div class="flex items-center gap-1 text-slate-400">
                    <i class="fas fa-arrow-up-wide-short"></i>
                    <span>Sort by newest</span>
                </div>
            </div>

            {{-- Responsive Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-700">
                    <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 font-semibold">#</th>
                            <th scope="col" class="px-6 py-3.5 font-semibold">
                                <i class="fas fa-user mr-1.5 text-indigo-300"></i>Full Name
                            </th>
                            <th scope="col" class="px-6 py-3.5 font-semibold">
                                <i class="fas fa-tag mr-1.5 text-indigo-300"></i>Report Type
                            </th>
                            <th scope="col" class="px-6 py-3.5 font-semibold">
                                <i class="fas fa-calendar mr-1.5 text-indigo-300"></i>Date
                            </th>
                            <th scope="col" class="px-6 py-3.5 font-semibold">
                                <i class="fas fa-paperclip mr-1.5 text-indigo-300"></i>Files
                            </th>
                            <th scope="col" class="px-6 py-3.5 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($datas as $index => $data)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3.5 font-mono text-xs text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-3.5 font-medium text-slate-700">
                                    <i class="fas fa-user-circle text-indigo-300 mr-2"></i>
                                    {{ $data->fullname ?? ($data->fullname ?? '—') }}
                                </td>
                                <td class="px-6 py-3.5">
                                    <span
                                        class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ $data->report_type ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5">
                                    {{ $data->date ? \Carbon\Carbon::parse($data->date)->format('Y-m-d') : '—' }}
                                </td>
                                <td class="px-6 py-3.5 text-slate-600 text-xs">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <i class="fas fa-file-alt text-indigo-300 text-[10px]"></i>
                                        @php

                                            $files = [];
                                            if (isset($data->file)) {
                                                if (is_array($data->file)) {
                                                    $files = $data->file;
                                                } elseif (is_string($data->file)) {
                                                    $decoded = json_decode($data->file, true);
                                                    $files = is_array($decoded) ? $decoded : [$data->file];
                                                } elseif ($data->file instanceof \Illuminate\Support\Collection) {
                                                    $files = $data->file->toArray();
                                                }
                                            }
                                            $displayFiles = array_slice($files, 0, 3);
                                            $remaining = count($files) - 3;
                                        @endphp
                                        @if (!empty($displayFiles))
                                            @foreach ($displayFiles as $file)
                                                <span class="bg-slate-100 px-2 py-0.5 rounded text-xs">
                                                    {{ strlen($file) > 15 ? substr($file, 0, 12) . '…' : $file }}
                                                </span>
                                            @endforeach
                                            @if ($remaining > 0)
                                                <span class="text-indigo-400 text-xs font-medium">+{{ $remaining }}
                                                    more</span>
                                            @endif
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        <!-- View/Edit -->
                                        <a href="{{ route('editDocRep.edit', $data->id) }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-500 hover:bg-indigo-100 hover:text-indigo-700 transition border border-indigo-100"
                                            title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>

                                        <form action="{{ route('DocRepodestroy.delete', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-rose-50 text-rose-500 hover:bg-rose-100 hover:text-rose-700 transition border border-rose-100"
                                                title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>


                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                                    <i class="fas fa-inbox text-3xl block mb-3 text-indigo-200"></i>
                                    No reports found. Upload some reports to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Table Footer --}}
            <div
                class="px-6 py-3 border-t border-slate-200/60 bg-slate-50/30 text-xs text-slate-400 flex flex-wrap justify-between items-center gap-2">
                <span><i class="fas fa-info-circle mr-1 text-indigo-300"></i> Total: <strong>{{ count($datas) }}</strong>
                    reports</span>
                <span>Manage your doctor reports</span>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
