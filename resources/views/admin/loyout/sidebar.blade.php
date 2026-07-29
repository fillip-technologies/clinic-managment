<aside class="w-72 bg-slate-800 text-slate-200 flex-shrink-0 flex flex-col shadow-2xl">
    @php
        $dashboardRoute = null;
        $name = null;
        if (Auth::guard("super_admin")->check()) {
            $dashboardRoute = route('admin.dashboard');
            $name = 'Admin';
        }
        if (Auth::guard('doctor')->check()) {
            $dashboardRoute = route('doctor.dashboard');
            $name = 'Doctor';
        }
    @endphp
    <!-- Logo -->
    <div class="p-6 flex items-center space-x-3 border-b border-slate-700/60">
        <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
            <i class="fas fa-user-doctor text-white text-xl"></i>
        </div>

        <span class="text-2xl font-bold text-white">
            {{ $name }}<span class="text-indigo-400">Panel</span>
        </span>

        <span class="ml-auto text-[10px] px-2 py-1 rounded-full bg-indigo-500/30 text-indigo-200">
            v2.0
        </span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ $dashboardRoute }}"
            class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-300
            {{ request()->routeIs('doctor.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">

            <i class="fas fa-th-large w-5 text-center"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        @if (Auth::guard('super_admin')->check())
            <!-- Doctors -->
            <a href="{{ route('doctor.list') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-300
            {{ request()->routeIs('doctor.list*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">

                <i class="fas fa-user-doctor w-5 text-center"></i>
                <span class="font-medium">Doctors</span>
            </a>

            <!-- Patients -->
            <a href="#"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <i class="fas fa-hospital-user w-5"></i>
                <span class="font-medium">Patients</span>
            </a>

            <!-- Appointment -->
            <a href="{{ route('listappoinment') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <i class="fas fa-calendar-check w-5"></i>
                <span class="font-medium">Appointments</span>
            </a>

            <!-- Reports -->
            <a href="#"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <i class="fas fa-chart-line w-5"></i>
                <span class="font-medium">Reports</span>
            </a>

            <!-- Settings -->
            <a href="#"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <i class="fas fa-cog w-5"></i>
                <span class="font-medium">Settings</span>
            </a>
        @elseif(Auth::guard('doctor')->check())
            <a href="#"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <i class="fas fa-cog w-5"></i>
                <span class="font-medium">Settings</span>
            </a>
        @endif


    </nav>

    @php
        $name = 'Guest';
        $email = '';
        $logoutRoute = null;

        if (Auth::guard('super_admin')->check()) {
            $user = Auth::guard('super_admin')->user();
            $name = $user->name ?? 'N/A';
            $email = $user->email ?? '';
            $logoutRoute = route('admin.logout');
        } elseif (Auth::guard('doctor')->check()) {
            $user = Auth::guard('doctor')->user();
            $name = $user->name ?? 'N/A';
            $email = $user->email ?? '';
            $logoutRoute = route('doctor.logout');
        }
    @endphp

    <!-- User Profile -->
    <div class="p-4 border-t border-slate-700 flex items-center gap-3">

        <div
            class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
            {{ strtoupper(substr($name, 0, 1)) }}
        </div>

        <div class="flex-1 overflow-hidden">
            <h4 class="font-semibold text-white truncate">{{ $name }}</h4>
            <p class="text-xs text-slate-400 truncate">{{ $email }}</p>
        </div>

        @if ($logoutRoute)
            <form action="{{ $logoutRoute }}" method="POST">
                @csrf
                <button
                    class="w-10 h-10 rounded-lg bg-red-500/10 hover:bg-red-600 hover:text-white text-red-400 transition duration-300">
                    <i class="fas fa-right-from-bracket"></i>
                </button>
            </form>
        @endif

    </div>

</aside>
