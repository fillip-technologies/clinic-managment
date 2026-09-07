<!-- Mobile Backdrop Overlay -->
<div x-show="sidebarOpen"
    x-cloak
    @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden">
</div>

<!-- Responsive Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-800 text-slate-200 flex-shrink-0 flex flex-col shadow-2xl overflow-hidden transform transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
    @php
        $dashboardRoute = null;
        $name = null;
        if (Auth::guard('super_admin')->check()) {
            $dashboardRoute = route('admin.dashboard');
            $name = 'Admin';
        }
        if (Auth::guard('doctor')->check()) {
            $dashboardRoute = route('doctor.dashboard');
            $name = 'Doctor';
        }
    @endphp
    <!-- Logo & Mobile Close -->
    <div class="p-5 sm:p-6 flex items-center justify-between border-b border-slate-700/60">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <i class="fas fa-user-doctor text-white text-xl"></i>
            </div>

            <span class="text-2xl font-bold text-white">
                {{ $name }}<span class="text-indigo-400">Panel</span>
            </span>

            <span class="text-[10px] px-2 py-1 rounded-full bg-indigo-500/30 text-indigo-200 font-bold">
                v2.0
            </span>
        </div>

        <!-- Mobile Close Button -->
        <button type="button" @click="sidebarOpen = false" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700/60 transition">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
        @php
            $isDashboard = request()->routeIs('admin.dashboard') || request()->routeIs('doctor.dashboard') || request()->is('admin/dashboard') || request()->is('doctor/dashboard');
            $isDoctors = request()->routeIs('doctor.list*') || request()->routeIs('doctor.form*') || request()->routeIs('doctor.edit*') || request()->is('admin/doctor/*') || request()->is('admin/edit/doctor/*');
            $isRooms = request()->routeIs('room.*') || request()->routeIs('indexmember*') || request()->is('admin/listing/room/*') || request()->is('admin/edit/room/*') || request()->is('admin/member/*');
            $isPatients = request()->routeIs('list.patient*') || request()->routeIs('patient.*') || request()->routeIs('store.patient*') || request()->routeIs('addnewReport*') || request()->is('admin/patient/*') || request()->is('admin/single/patient/*') || request()->is('admin/addnewReport/*');
            $isAppointments = (request()->routeIs('listappoinment*') || request()->is('admin/listappoinment*')) && !request()->routeIs('on_site_appointment*') && !request()->routeIs('appointment.onsite*') && !request()->is('admin/on_site_appointment*') && !request()->is('admin/on-site-appointment*');
            $isOnSiteAppointments = request()->routeIs('on_site_appointment*') || request()->routeIs('appointment.onsite*') || request()->is('admin/on_site_appointment*') || request()->is('admin/on-site-appointment*');
            $isAnalytics = request()->routeIs('analytics.disease*') || request()->is('admin/analytics/*');
            $isReports = request()->routeIs('report.*') || request()->is('admin/*/report');
            $isSettings = request()->routeIs('admin.settings*') || request()->routeIs('doctor.settings*') || request()->is('admin/settings*') || request()->is('doctor/settings*');
        @endphp

        <!-- Dashboard -->
        <a href="{{ $dashboardRoute }}"
            class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
            {{ $isDashboard ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">

            <i class="fas fa-th-large w-5 text-center {{ $isDashboard ? 'text-white' : 'text-slate-400' }}"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        @if (Auth::guard('super_admin')->check())
            <!-- Doctors -->
            <a href="{{ route('doctor.list') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isDoctors ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">

                <i class="fas fa-user-doctor w-5 text-center {{ $isDoctors ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Doctors</span>
            </a>

            <!-- Rooms -->
            <a href="{{ route('room.list') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isRooms ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-users w-5 text-center {{ $isRooms ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Rooms</span>
            </a>

            <!-- Patients -->
            <a href="{{ route('list.patient') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isPatients ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-hospital-user w-5 text-center {{ $isPatients ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Patients</span>
            </a>

            <!-- Appointments -->
            <a href="{{ route('listappoinment') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isAppointments ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-calendar-check w-5 text-center {{ $isAppointments ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Appointments</span>
            </a>

            <!-- On-Site Appointments -->
            <a href="{{ route('on_site_appointment') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isOnSiteAppointments ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-globe w-5 text-center {{ $isOnSiteAppointments ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">On-Site Appointments</span>
            </a>

            <!-- Analytics -->
            <a href="{{ route('analytics.disease') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isAnalytics ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-chart-line w-5 text-center {{ $isAnalytics ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Analytics</span>
            </a>


            <!-- Reports -->
            <div x-data="{ open: {{ $isReports ? 'true' : 'false' }} }">
                <!-- Parent Menu -->
                <button @click="open = !open"
                    class="w-full sidebar-item flex items-center justify-between gap-4 px-4 py-3 rounded-xl transition-all duration-200
                    {{ $isReports ? 'bg-slate-700/70 text-white font-semibold' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">

                    <div class="flex items-center gap-4">
                        <i class="fas fa-file-medical-alt w-5 text-center {{ $isReports ? 'text-indigo-400' : 'text-slate-400' }}"></i>
                        <span class="font-medium">Reports</span>
                    </div>

                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="open" x-cloak x-transition style="{{ $isReports ? '' : 'display: none;' }}" class="ml-6 mt-1.5 space-y-1 pl-3 border-l-2 border-slate-700">

                    <a href="{{ route('report.diabetesReport') }}"
                        class="block px-3.5 py-2 rounded-lg text-xs font-medium transition-all duration-200
                        {{ request()->routeIs('report.diabetesReport') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                        <i class="fas fa-droplet text-[11px] mr-1.5 opacity-75"></i> Diabetes
                    </a>

                    <a href="{{ route('report.hypertensioReport') }}"
                        class="block px-3.5 py-2 rounded-lg text-xs font-medium transition-all duration-200
                        {{ request()->routeIs('report.hypertensioReport') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                        <i class="fas fa-heart-pulse text-[11px] mr-1.5 opacity-75"></i> Hypertension
                    </a>

                    <a href="{{ route('report.obesityReport') }}"
                        class="block px-3.5 py-2 rounded-lg text-xs font-medium transition-all duration-200
                        {{ request()->routeIs('report.obesityReport') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                        <i class="fas fa-weight-scale text-[11px] mr-1.5 opacity-75"></i> Obesity
                    </a>

                    <a href="{{ route('report.InfectionReport') }}"
                        class="block px-3.5 py-2 rounded-lg text-xs font-medium transition-all duration-200
                        {{ request()->routeIs('report.InfectionReport') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                        <i class="fas fa-virus text-[11px] mr-1.5 opacity-75"></i> Infection
                    </a>

                </div>
            </div>

            <!-- Settings -->
            <a href="{{ route('admin.settings') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isSettings ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-cog w-5 text-center {{ $isSettings ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium">Settings</span>
            </a>
        @elseif(Auth::guard('doctor')->check())
            @php
                $isDocReports = request()->routeIs('doctorReporlist*') || request()->routeIs('doctor.report.form*') || request()->routeIs('editDocRep.*');
            @endphp
            <a href="{{ route('doctorReporlist') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isDocReports ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-file-medical-alt w-5 text-center {{ $isDocReports ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="font-medium"> + Report Upload</span>
            </a>
            <a href="{{ route('doctor.settings') }}"
                class="sidebar-item flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200
                {{ $isSettings ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-600/30 active' : 'text-slate-300 hover:bg-slate-700/60 hover:text-white' }}">
                <i class="fas fa-cog w-5 text-center {{ $isSettings ? 'text-white' : 'text-slate-400' }}"></i>
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
