<div class="flex items-center justify-between mb-6 sm:mb-8">
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle Button -->
        <button type="button" @click="sidebarOpen = true"
            class="lg:hidden p-2.5 rounded-xl bg-white text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition flex items-center justify-center">
            <i class="fas fa-bars text-lg text-indigo-600"></i>
        </button>

        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 tracking-tight">
                @yield('page_title', 'Dashboard')
            </h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5 hidden sm:block">
                @yield('page_subtitle', "Welcome back. Here's what's happening.")
            </p>
        </div>
    </div>

    <!-- Quick Date Badge -->
    <div class="flex items-center gap-2 sm:gap-3">
        <div class="hidden sm:flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200/80 shadow-sm text-xs font-semibold text-slate-600">
            <i class="far fa-calendar-alt text-indigo-500"></i>
            <span>{{ date('d M Y') }}</span>
        </div>
    </div>
</div>
