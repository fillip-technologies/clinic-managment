@extends('admin.loyout.master')
@section('content')

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

@if ($errors->any())
<script>
@foreach ($errors->all() as $error )
toastr.error("{{ $error }}")
@endforeach
</script>
@endif
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-8 m-auto">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                <i class="fas fa-user-md text-2xl text-indigo-600"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Edit Member Profile</h2>
                <p class="text-sm text-slate-500">Update doctor or staff profile and role</p>
            </div>
        </div>

        <!-- Message Container -->
        <div id="messageContainer" class="mb-4"></div>

        <!-- Form -->
        <form action="{{ route('doctor.update',$doctor->id) }}" class="space-y-4" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-user mr-2 text-indigo-400"></i>Full Name
                    </label>
                    <input type="text" id="name" value="{{ old('name',$doctor->name ?? "") }}" name="name"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name')
           border-red-600
                        @enderror"
                        placeholder="Dr. John Doe" />

                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-phone mr-2 text-indigo-400"></i>Phone
                    </label>
                    <input type="tel" id="phone" value="{{ old('phone',$doctor->phone ?? "") }}" name="phone"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('phone')
border-red-600
                        @enderror "
                        placeholder="+91 98765 43210" />
                        @error('phone')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row: City + State -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-city mr-2 text-indigo-400"></i>City
                    </label>
                    <input type="text" id="city" value="{{ old('city',$doctor->phone ?? "") }}" name="city"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('city')
border-red-600
                        @enderror"
                        placeholder="Mumbai"  />
                          @error('city')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-map-pin mr-2 text-indigo-400"></i>State
                    </label>
                    <input type="text" id="state" value="{{ old('state',$doctor->state ?? "") }}" name="state"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Maharashtra"  />
                        @error('state')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row: Country + PIN Code -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-globe mr-2 text-indigo-400"></i>Country
                    </label>
                    <input type="text" id="country" value="{{ old('country',$doctor->country ?? "") }}" name="country"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('country')
border-red-600
                        @enderror"
                        placeholder="India"  />
                        @error('country')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-mailbox mr-2 text-indigo-400"></i>PIN Code
                    </label>
                    <input type="text" id="pin_code" value="{{ old('pin_code',$doctor->pin_code ?? "") }}" name="pin_code"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('pin_code')
border-red-600
                        @enderror"
                        placeholder="400001"  />
                         @error('pin_code')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row: Role + Doctor Strime (Speciality) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-briefcase mr-2 text-indigo-400"></i>Role
                    </label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('role')
border-red-600
                        @enderror"
                        >
                        <option value="">Select role</option>
                        <option value="super_admin" @selected($doctor->role == "super_admin")>Super Admin</option>
                        <option value="doctor" @selected($doctor->role == 'doctor')>Doctor</option>
                        <option value="staff" @selected($doctor->role == 'staff')>Staff</option>
                    </select>

                     @error('role')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-stethoscope mr-2 text-indigo-400"></i>Speciality / Strime
                    </label>
                    <input type="text" id="doctor_strime" value="{{ old('doctor_strime',$doctor->doctor_strime ?? "") }}" name="doctor_strime"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('doctor_strime')
border-red-600
                        @enderror"
                        placeholder="e.g. Interventional Cardiology" />
                           @error('doctor_strime')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row: Email + Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-envelope mr-2 text-indigo-400"></i>Email
                    </label>
                    <input type="email" id="email" value="{{ old('email',$doctor->email ?? "") }}" name="email"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="doctor@hospital.com"  />
                         @error('email')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        <i class="fas fa-key mr-2 text-indigo-400"></i>Reset Password <span class="text-[11px] font-normal text-slate-400 lowercase">(leave blank to keep current)</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('password') border-red-600 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-12"
                            placeholder="Enter new password (min 8 chars)" />
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                    <p class="text-[11px] text-slate-400 mt-1">Leave empty if you don't want to change the password.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                <i class="fas fa-save"></i> Update Member
            </button>

            <!-- Footer Note -->
            <div class="text-center text-xs text-slate-400 flex items-center justify-center gap-2 pt-2">
                <i class="fas fa-shield-alt text-indigo-300"></i>
                <span>All fields are required unless marked optional</span>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const passwordField = document.getElementById('password');

            if (toggleBtn && eyeIcon && passwordField) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordField.type === 'password' ? 'text' : 'password';
                    passwordField.type = type;
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
@endsection
