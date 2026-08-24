@extends('admin.loyout.master')
@section('content')
    <div class="space-y-6 max-w-5xl mx-auto pb-12">

        <!-- Page Header -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 flex items-center gap-1.5">
                            <i class="fas fa-shield-halved text-indigo-300"></i> Account Security
                        </span>
                        <span class="text-xs text-slate-400">
                            {{ ucfirst(str_replace('_', ' ', $user->role ?? 'User')) }} Profile
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Account Settings & Password
                    </h1>
                    <p class="text-xs text-slate-300 mt-1 max-w-xl">
                        Manage your account credentials, view security details, and update your login password.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-indigo-500/30">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-base">{{ $user->name ?? 'Administrator' }}</h3>
                        <p class="text-xs text-slate-400">{{ $user->email ?? '' }}</p>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            Active Account
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Change Password Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <i class="fas fa-key text-indigo-600"></i>
                                Change Login Password
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Ensure your account is using a strong password to stay secure
                            </p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-50 text-indigo-700">
                            Authentication
                        </span>
                    </div>

                    @php
                        $updateRoute = Auth::guard('super_admin')->check()
                            ? route('admin.password.update')
                            : route('doctor.password.update');
                    @endphp

                    <form action="{{ $updateRoute }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fas fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="current_password" id="current_password" required
                                    placeholder="Enter your current password"
                                    class="w-full pl-10 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('current_password') ? 'border-red-400 bg-red-50/20' : 'border-slate-200' }} focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 outline-none transition bg-slate-50/50">
                                <button type="button" onclick="togglePasswordVisibility('current_password', 'current_toggle_icon')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                    <i class="far fa-eye text-xs" id="current_toggle_icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-[11px] font-semibold mt-1 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fas fa-key text-xs"></i>
                                </div>
                                <input type="password" name="password" id="password" required minlength="8"
                                    placeholder="Enter minimum 8 characters"
                                    class="w-full pl-10 pr-10 py-2.5 text-xs rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50/20' : 'border-slate-200' }} focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 outline-none transition bg-slate-50/50">
                                <button type="button" onclick="togglePasswordVisibility('password', 'new_toggle_icon')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                    <i class="far fa-eye text-xs" id="new_toggle_icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-[11px] font-semibold mt-1 flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @else
                                <p class="text-slate-400 text-[11px] mt-1">
                                    Must be at least 8 characters with a combination of letters and numbers.
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fas fa-check-double text-xs"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                    placeholder="Re-enter your new password"
                                    class="w-full pl-10 pr-10 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 outline-none transition bg-slate-50/50">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'confirm_toggle_icon')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                    <i class="far fa-eye text-xs" id="confirm_toggle_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-3">
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2">
                                <i class="fas fa-shield-check text-sm"></i>
                                <span>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right 1 Col: Account Details & Security Advice -->
            <div class="space-y-6">

                <!-- Account Information Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2 pb-3 mb-4 border-b border-slate-100">
                        <i class="fas fa-id-card text-indigo-600"></i>
                        Profile Information
                    </h4>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">User Name</span>
                            <span class="text-slate-800 font-bold">{{ $user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Email Address</span>
                            <span class="text-slate-800 font-semibold">{{ $user->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Account Role</span>
                            <span class="px-2 py-0.5 rounded-full font-bold text-[10px] bg-indigo-100 text-indigo-800">
                                {{ strtoupper($user->role ?? 'ADMIN') }}
                            </span>
                        </div>
                        @if(!empty($user->phone))
                            <div class="flex justify-between py-1.5 border-b border-slate-50">
                                <span class="text-slate-500 font-medium">Contact Phone</span>
                                <span class="text-slate-800 font-semibold">{{ $user->phone }}</span>
                            </div>
                        @endif
                        @if(!empty($user->doctor_strime))
                            <div class="flex justify-between py-1.5 border-b border-slate-50">
                                <span class="text-slate-500 font-medium">Specialization</span>
                                <span class="text-slate-800 font-semibold">{{ $user->doctor_strime }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500 font-medium">Registered Date</span>
                            <span class="text-slate-600 font-medium">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Security Tips Card -->
                <div class="bg-gradient-to-br from-indigo-50/60 to-purple-50/60 rounded-3xl p-6 border border-indigo-100 shadow-sm">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-900 flex items-center gap-2 mb-3">
                        <i class="fas fa-lock text-indigo-600"></i> Password Security Tips
                    </h4>
                    <ul class="text-[11px] text-slate-600 space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle-check text-emerald-500 mt-0.5"></i>
                            <span>Use at least <strong>8 characters</strong> with mixed letters & numbers.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle-check text-emerald-500 mt-0.5"></i>
                            <span>Never share your administrator login credentials with anyone.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle-check text-emerald-500 mt-0.5"></i>
                            <span>Change your password periodically to protect clinical patient data.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
