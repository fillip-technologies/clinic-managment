@extends('admin.loyout.master')
@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="stat-card glass-card rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-slate-500 text-sm font-medium">Total Doctor</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $doctors ?? 0 }}</p>
            <span class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i class="fas fa-arrow-up mr-1"></i> +12.5%</span>
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
            <span class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i class="fas fa-arrow-up mr-1"></i> +8.2%</span>
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
            <span class="inline-flex items-center text-xs text-rose-600 bg-rose-100/70 px-2 py-0.5 rounded-full mt-2"><i class="fas fa-arrow-down mr-1"></i> -3.1%</span>
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
            <span class="inline-flex items-center text-xs text-emerald-600 bg-emerald-100/70 px-2 py-0.5 rounded-full mt-2"><i class="fas fa-arrow-up mr-1"></i> +2.3%</span>
          </div>
          <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
            <i class="fas fa-chart-line text-xl"></i>
          </div>
        </div>
      </div>
    </div>

  
    <div class="glass-card rounded-2xl p-6 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-slate-800">Recent orders</h2>
        <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View all <i class="fas fa-arrow-right ml-1 text-xs"></i></button>
      </div>
      <div class="table-wrap overflow-x-auto">
        <table class="min-w-full text-sm text-slate-700">
          <thead class="text-slate-500 border-b border-slate-200/70">
            <tr>
              <th class="text-left py-3 px-4 font-medium">Order ID</th>
              <th class="text-left py-3 px-4 font-medium">Customer</th>
              <th class="text-left py-3 px-4 font-medium">Status</th>
              <th class="text-left py-3 px-4 font-medium">Total</th>
              <th class="text-left py-3 px-4 font-medium">Date</th>
              <th class="text-right py-3 px-4 font-medium">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-slate-100/60 hover:bg-slate-50/50 transition">
              <td class="py-3 px-4 font-mono text-indigo-600">#1023</td>
              <td class="py-3 px-4">Olivia Chen</td>
              <td class="py-3 px-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700"><i class="fas fa-circle text-[6px] mr-1.5 text-emerald-500"></i> Completed</span></td>
              <td class="py-3 px-4 font-medium">$129.00</td>
              <td class="py-3 px-4 text-slate-500">Apr 12, 2026</td>
              <td class="py-3 px-4 text-right"><i class="fas fa-chevron-right text-slate-300 hover:text-indigo-500 cursor-pointer"></i></td>
            </tr>
            <tr class="border-b border-slate-100/60 hover:bg-slate-50/50 transition">
              <td class="py-3 px-4 font-mono text-indigo-600">#1022</td>
              <td class="py-3 px-4">Marcus Rivera</td>
              <td class="py-3 px-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700"><i class="fas fa-circle text-[6px] mr-1.5 text-amber-500"></i> Pending</span></td>
              <td class="py-3 px-4 font-medium">$79.50</td>
              <td class="py-3 px-4 text-slate-500">Apr 11, 2026</td>
              <td class="py-3 px-4 text-right"><i class="fas fa-chevron-right text-slate-300 hover:text-indigo-500 cursor-pointer"></i></td>
            </tr>
            <tr class="border-b border-slate-100/60 hover:bg-slate-50/50 transition">
              <td class="py-3 px-4 font-mono text-indigo-600">#1021</td>
              <td class="py-3 px-4">Sophia Park</td>
              <td class="py-3 px-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700"><i class="fas fa-circle text-[6px] mr-1.5 text-rose-400"></i> Cancelled</span></td>
              <td class="py-3 px-4 font-medium">$43.20</td>
              <td class="py-3 px-4 text-slate-500">Apr 10, 2026</td>
              <td class="py-3 px-4 text-right"><i class="fas fa-chevron-right text-slate-300 hover:text-indigo-500 cursor-pointer"></i></td>
            </tr>
            <tr class="hover:bg-slate-50/50 transition">
              <td class="py-3 px-4 font-mono text-indigo-600">#1020</td>
              <td class="py-3 px-4">James Kim</td>
              <td class="py-3 px-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700"><i class="fas fa-circle text-[6px] mr-1.5 text-indigo-400"></i> Processing</span></td>
              <td class="py-3 px-4 font-medium">$215.00</td>
              <td class="py-3 px-4 text-slate-500">Apr 09, 2026</td>
              <td class="py-3 px-4 text-right"><i class="fas fa-chevron-right text-slate-300 hover:text-indigo-500 cursor-pointer"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
@endsection
