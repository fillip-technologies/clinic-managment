@extends('admin.loyout.master')
@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Doctor Management</h1>
            <p class="text-sm text-slate-500">Register and view all doctors</p>
        </div>
        <a href="{{ route('doctor.form') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-md hover:shadow-lg transition">
            <i class="fas fa-plus"></i> Add Doctor
        </a>
    </div>

    <!-- Form Section (hidden by default) -->
    <div id="formSection" class="hidden mb-6">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-8">

            <!-- Message Container -->
            <div id="messageContainer" class="mb-4"></div>

            <!-- Form -->
            <form id="doctorForm" class="space-y-4">

                <!-- Row: Name + Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-user mr-2 text-indigo-400"></i>Full Name
                        </label>
                        <input type="text" id="name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Dr. John Doe" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-phone mr-2 text-indigo-400"></i>Phone
                        </label>
                        <input type="tel" id="phone" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="+91 98765 43210" required />
                    </div>
                </div>

                <!-- Row: City + State -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-city mr-2 text-indigo-400"></i>City
                        </label>
                        <input type="text" id="city" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Mumbai" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-map-pin mr-2 text-indigo-400"></i>State
                        </label>
                        <input type="text" id="state" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Maharashtra" required />
                    </div>
                </div>

                <!-- Row: Country + PIN Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-globe mr-2 text-indigo-400"></i>Country
                        </label>
                        <input type="text" id="country" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="India" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-mailbox mr-2 text-indigo-400"></i>PIN Code
                        </label>
                        <input type="text" id="pin_code" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="400001" required />
                    </div>
                </div>

                <!-- Row: Role + Doctor Strime -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-briefcase mr-2 text-indigo-400"></i>Doctor Strime
                        </label>
                        <select id="role" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            <option value="">Select Strime</option>
                            <option value="Cardiologist">Cardiologist</option>
                            <option value="Dermatologist">Dermatologist</option>
                            <option value="Neurologist">Neurologist</option>
                            <option value="Pediatrician">Pediatrician</option>
                            <option value="General Physician">General Physician</option>
                            <option value="Surgeon">Surgeon</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-stethoscope mr-2 text-indigo-400"></i>Speciality / Strime
                        </label>
                        <input type="text" id="doctor_strime" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="e.g. Interventional Cardiology" />
                    </div>
                </div>

                <!-- Row: Email + Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-envelope mr-2 text-indigo-400"></i>Email
                        </label>
                        <input type="email" id="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="doctor@hospital.com" required />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-lock mr-2 text-indigo-400"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent pr-12" placeholder="Min 8 characters" required minlength="8" />
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl transition duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="fas fa-save"></i> Save Doctor
                    </button>
                    <button type="button" id="cancelFormBtn" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-2.5 px-6 rounded-xl transition duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-semibold text-slate-700"><i class="fas fa-list mr-2 text-indigo-400"></i>All Doctors</h3>
            <span id="doctorCount" class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full">0 records</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">#</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Name</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Phone</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">City</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">State</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Country</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Role</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Speciality</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">PIN</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="doctorTableBody">
                    <!-- Rows will be inserted here -->
                </tbody>
            </table>
        </div>
        <!-- Empty state -->
        <div id="emptyState" class="text-center py-12 text-slate-400">
            <i class="fas fa-user-md text-4xl mb-3 block opacity-30"></i>
            <p class="text-sm">No doctors registered yet.</p>
            <p class="text-xs">Click "Add Doctor" to get started.</p>
        </div>
    </div>
</div>

<script>
    (function() {
        // ===== STATE =====
        let doctors = [];
        let editIndex = null;

        // ===== DOM REFS =====
        const formSection = document.getElementById('formSection');
        const showFormBtn = document.getElementById('showFormBtn');
        const cancelFormBtn = document.getElementById('cancelFormBtn');
        const form = document.getElementById('doctorForm');
        const msgContainer = document.getElementById('messageContainer');
        const tableBody = document.getElementById('doctorTableBody');
        const emptyState = document.getElementById('emptyState');
        const doctorCount = document.getElementById('doctorCount');

        // Form fields
        const fields = {
            name: document.getElementById('name'),
            phone: document.getElementById('phone'),
            city: document.getElementById('city'),
            state: document.getElementById('state'),
            country: document.getElementById('country'),
            role: document.getElementById('role'),
            pin_code: document.getElementById('pin_code'),
            doctor_strime: document.getElementById('doctor_strime'),
            email: document.getElementById('email'),
            password: document.getElementById('password')
        };

        // Toggle password
        const toggleBtn = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        toggleBtn.addEventListener('click', function() {
            const type = fields.password.type === 'password' ? 'text' : 'password';
            fields.password.type = type;
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // ===== UTILITY FUNCTIONS =====
        function showToast(text, type = 'error') {
            msgContainer.innerHTML = '';
            const toast = document.createElement('div');
            const colors = {
                success: 'bg-green-50 border-green-200 text-green-700',
                error: 'bg-red-50 border-red-200 text-red-700',
                info: 'bg-blue-50 border-blue-200 text-blue-700'
            };
            const icons = {
                success: 'fa-circle-check',
                error: 'fa-circle-exclamation',
                info: 'fa-circle-info'
            };
            toast.className = `px-4 py-3 rounded-xl border ${colors[type] || colors.error} flex items-center gap-3 text-sm`;
            const icon = document.createElement('i');
            icon.className = `fas ${icons[type] || icons.error}`;
            toast.appendChild(icon);
            const span = document.createElement('span');
            span.textContent = text;
            toast.appendChild(span);
            msgContainer.appendChild(toast);

            if (type === 'success' || type === 'info') {
                setTimeout(() => {
                    if (msgContainer.contains(toast)) toast.remove();
                }, 5000);
            }
        }

        function resetForm() {
            form.reset();
            editIndex = null;
            document.querySelector('#doctorForm button[type="submit"]').innerHTML = '<i class="fas fa-save"></i> Save Doctor';
            // Clear any password value
            fields.password.value = '';
        }

        function renderTable() {
            tableBody.innerHTML = '';
            if (doctors.length === 0) {
                emptyState.style.display = 'block';
                doctorCount.textContent = '0 records';
                return;
            }
            emptyState.style.display = 'none';
            doctorCount.textContent = `${doctors.length} record${doctors.length > 1 ? 's' : ''}`;

            doctors.forEach((doc, index) => {
                const tr = document.createElement('tr');
                tr.className = 'border-b border-slate-100 hover:bg-slate-50 transition';

                tr.innerHTML = `
                    <td class="px-4 py-3 text-slate-500 text-xs">${index + 1}</td>
                    <td class="px-4 py-3 font-medium text-slate-700">${doc.name || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.email || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.phone || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.city || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.state || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.country || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.role || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.doctor_strime || '-'}</td>
                    <td class="px-4 py-3 text-slate-600">${doc.pin_code || '-'}</td>
                    <td class="px-4 py-3 text-center">
                        <button class="edit-btn text-indigo-600 hover:text-indigo-800 mr-2 transition" data-index="${index}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn text-red-500 hover:text-red-700 transition" data-index="${index}" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

            // Attach event listeners to edit/delete buttons
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idx = parseInt(this.dataset.index);
                    editDoctor(idx);
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idx = parseInt(this.dataset.index);
                    deleteDoctor(idx);
                });
            });
        }

        // ===== CRUD OPERATIONS =====
        function addDoctor(data) {
            doctors.push(data);
            renderTable();
            resetForm();
            formSection.classList.add('hidden');
            showToast('Doctor added successfully!', 'success');
        }

        function updateDoctor(index, data) {
            doctors[index] = data;
            renderTable();
            resetForm();
            formSection.classList.add('hidden');
            showToast('Doctor updated successfully!', 'success');
        }

        function deleteDoctor(index) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                doctors.splice(index, 1);
                renderTable();
                showToast('Doctor deleted successfully!', 'info');
            }
        }

        function editDoctor(index) {
            const doc = doctors[index];
            if (!doc) return;

            // Fill form with data
            fields.name.value = doc.name || '';
            fields.phone.value = doc.phone || '';
            fields.city.value = doc.city || '';
            fields.state.value = doc.state || '';
            fields.country.value = doc.country || '';
            fields.role.value = doc.role || '';
            fields.pin_code.value = doc.pin_code || '';
            fields.doctor_strime.value = doc.doctor_strime || '';
            fields.email.value = doc.email || '';
            fields.password.value = ''; // Don't show password

            editIndex = index;
            document.querySelector('#doctorForm button[type="submit"]').innerHTML = '<i class="fas fa-pen"></i> Update Doctor';
            formSection.classList.remove('hidden');
            formSection.scrollIntoView({ behavior: 'smooth' });
        }

        // ===== FORM HANDLING =====
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                name: fields.name.value.trim(),
                phone: fields.phone.value.trim(),
                city: fields.city.value.trim(),
                state: fields.state.value.trim(),
                country: fields.country.value.trim(),
                role: fields.role.value,
                pin_code: fields.pin_code.value.trim(),
                doctor_strime: fields.doctor_strime.value.trim(),
                email: fields.email.value.trim(),
                password: fields.password.value.trim()
            };

            // Validation
            for (let key in formData) {
                if (key === 'doctor_strime') continue;
                if (!formData[key]) {
                    showToast(`Please fill in the ${key.replace('_', ' ')} field.`, 'error');
                    return;
                }
            }

            if (!formData.email.includes('@') || !formData.email.includes('.')) {
                showToast('Please enter a valid email address.', 'error');
                return;
            }

            if (formData.password.length < 8 && editIndex === null) {
                showToast('Password must be at least 8 characters.', 'error');
                return;
            }

            // If editing and password is empty, keep old password
            if (editIndex !== null && formData.password === '') {
                formData.password = doctors[editIndex].password;
            }

            if (editIndex !== null) {
                updateDoctor(editIndex, formData);
            } else {
                addDoctor(formData);
            }
        });

        // ===== UI CONTROLS =====
        showFormBtn.addEventListener('click', function() {
            resetForm();
            formSection.classList.remove('hidden');
            formSection.scrollIntoView({ behavior: 'smooth' });
        });

        cancelFormBtn.addEventListener('click', function() {
            resetForm();
            formSection.classList.add('hidden');
        });

        // ===== INIT: Load sample data =====
        function loadSampleData() {
            const sampleDoctors = [
                {
                    name: 'Dr. Amit Sharma',
                    phone: '+91 98765 43210',
                    city: 'Mumbai',
                    state: 'Maharashtra',
                    country: 'India',
                    role: 'Cardiologist',
                    pin_code: '400001',
                    doctor_strime: 'Interventional Cardiology',
                    email: 'amit.sharma@hospital.com',
                    password: 'password123'
                },
                {
                    name: 'Dr. Priya Patel',
                    phone: '+91 87654 32109',
                    city: 'Delhi',
                    state: 'Delhi',
                    country: 'India',
                    role: 'Neurologist',
                    pin_code: '110001',
                    doctor_strime: 'Stroke Medicine',
                    email: 'priya.patel@hospital.com',
                    password: 'password123'
                },
                {
                    name: 'Dr. Rajesh Kumar',
                    phone: '+91 76543 21098',
                    city: 'Bangalore',
                    state: 'Karnataka',
                    country: 'India',
                    role: 'Pediatrician',
                    pin_code: '560001',
                    doctor_strime: 'Child Health',
                    email: 'rajesh.kumar@hospital.com',
                    password: 'password123'
                }
            ];
            doctors = sampleDoctors;
            renderTable();
        }

        loadSampleData();
        console.log('Doctor Management System ready');
    })();
</script>

@endsection
