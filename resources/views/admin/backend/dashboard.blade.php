@extends('admin.loyout.master')
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card glass-card rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Doctor</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $doctors ?? 0 }}</p>
                    <span
                        class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i
                            class="fas fa-arrow-up mr-1"></i> +12.5%</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card glass-card rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Patients</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $patients ?? 0 }}</p>
                    <span
                        class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i
                            class="fas fa-arrow-up mr-1"></i> +8.2%</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card glass-card rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Diabetes Patient</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $diabetes ?? 0 }}</p>
                    <span
                        class="inline-flex items-center text-xs text-rose-600 bg-rose-100/70 px-2 py-0.5 rounded-full mt-2"><i
                            class="fas fa-arrow-down mr-1"></i> -3.1%</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card glass-card rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Hypertension Patient</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $hypertension ?? 0 }}</p>
                    <span
                        class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i
                            class="fas fa-arrow-up mr-1"></i> +2.3%</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>
    </div>

<div class="glass-card rounded-2xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-slate-800">Recent Patients</h2>
        <a href="{{ url('admin/patient/list') }}"
            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
            View all <i class="fas fa-arrow-right ml-1 text-xs"></i>
        </a>
    </div>

    <div class="table-wrap overflow-x-auto">
        <table class="min-w-full text-sm text-slate-700">
            <thead class="text-slate-500 border-b border-slate-200/70">
                <tr>
                    <th class="text-left py-3 px-4 font-medium">#</th>
                    <th class="text-left py-3 px-4 font-medium">Patient Name</th>
                    <th class="text-left py-3 px-4 font-medium">Mobile No</th>
                    <th class="text-left py-3 px-4 font-medium">Registration No</th>
                    <th class="text-left py-3 px-4 font-medium">Record Date</th>
                    <th class="text-left py-3 px-4 font-medium">Age</th>
                    <th class="text-left py-3 px-4 font-medium">Gender</th>
                    <th class="text-left py-3 px-4 font-medium">Address</th>
                    <th class="text-left py-3 px-4 font-medium">RCDHO Grade</th>

                </tr>
            </thead>

            <tbody>
                @forelse($allPatient as $data)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-4 font-medium">
                            {{ $loop->iteration }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $data->patient_name }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $data->mobile_no }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $data->registration_no }}
                        </td>

                        <td class="py-3 px-4">
                            {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $data->age }}
                        </td>

                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                                {{ $data->gender == 'Male'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($data->gender == 'Female'
                                        ? 'bg-pink-100 text-pink-700'
                                        : 'bg-gray-100 text-gray-700') }}">
                                {{ $data->gender }}
                            </span>
                        </td>

                        <td class="py-3 px-4">
                            {{ Str::limit($data->address, 30) }}
                        </td>

                        <td class="py-3 px-4">
                            @if($data->rcdho_grade)
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                                    {{ $data->rcdho_grade }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-slate-500">
                            No patient records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
