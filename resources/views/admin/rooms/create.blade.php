@extends('admin.loyout.master')
@section('content')
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    <style>
        /* subtle table row animation */
        .member-row {
            transition: background 0.15s;
        }

        .member-row:hover {
            background-color: #f8fafc;
        }

        /* scrollbar for table container */
        .table-wrap::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .table-wrap::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .table-wrap::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .table-wrap::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* animation for new input fields */
        .input-row {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* file input styling */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-name {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.25rem;
            word-break: break-all;
        }

        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            border-top-color: #6366f1;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="w-full m-auto bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200/70 transition-all">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-indigo-100 p-2.5 rounded-xl text-indigo-600">
                <i class="fas fa-door-open text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Create new room</h2>
            <span class="ml-auto text-xs bg-slate-200 text-slate-600 px-3 py-1 rounded-full font-medium">data table</span>
        </div>

        <!-- Main form + table side by side (flex) -->
        <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col lg:flex-row gap-6">
            @csrf

            <!-- LEFT: main form fields (room name, type, actions) -->
            <div class="lg:w-2/5 space-y-5">
                <!-- Room Name -->
                <div>
                    <label for="roomName" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-tag text-indigo-400 mr-1.5"></i> Room name
                    </label>
                    <input type="text" id="roomName" placeholder="e.g. Design Sprint, Gaming Lobby..." name="room_name"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800 placeholder:text-slate-400">
                    @error('room_name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Room Type -->
                <div>
                    <label for="roomType" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-layer-group text-indigo-400 mr-1.5"></i> Room type
                    </label>
                    <select id="roomType" name="room_type"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800">
                        <option value="public">🌐 Public</option>
                        <option value="private" selected>🔒 Private</option>
                        <option value="team">👥 Team</option>
                        <option value="channel">📢 Channel</option>
                    </select>
                    @error('room_type')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- File Input -->
                <div>
                    <label for="roomImage" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-image text-indigo-400 mr-1.5"></i> Room Image
                    </label>
                    <div class="file-input-wrapper">
                        <input type="file" id="roomImage" accept="image/*" name="file"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800 cursor-pointer">
                        @error('file')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                        <div
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl bg-slate-50/50 text-slate-600 flex items-center gap-2 pointer-events-none">
                            <i class="fas fa-upload text-indigo-400"></i>
                            <span id="fileLabel">Choose an image...</span>
                        </div>
                    </div>
                    <div id="fileName" class="file-name"></div>
                </div>

                <!-- Add member section with dynamic inputs -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-user-plus text-indigo-400 mr-1.5"></i> Add Members
                    </label>

                    <!-- Container for dynamic member inputs -->
                    <div id="memberInputsContainer" class="space-y-2">
                        <!-- Default input row -->
                        <div class="input-row flex items-center gap-2">
                            <input type="text" placeholder="Member name..." name="members[]"
                                class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white member-input">
                            <button type="button" class="remove-input-btn text-red-400 hover:text-red-600 transition p-1"
                                title="Remove this input">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Add more input button -->
                    <button type="button" id="addMoreInputBtn"
                        class="mt-2 w-full bg-white hover:bg-slate-100 text-indigo-600 font-medium py-2 px-4 rounded-lg border border-dashed border-indigo-300 transition text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i> Add more member fields
                    </button>

                    <!-- Add all members to table button -->
                    <button type="button" id="addMembersToListBtn"
                        class="mt-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-users"></i> Add all members to list
                    </button>
                </div>

                <!-- Submit & reset -->
                <div class="flex flex-col sm:flex-row gap-3 pt-1">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i> Create room
                    </button>
                    <button type="reset" id="resetFormBtn"
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-undo-alt"></i> Reset
                    </button>
                </div>

                <!-- feedback message -->
                <div id="formFeedback" class="text-sm font-medium text-center transition-all duration-200 h-6"></div>
            </div>

            <!-- RIGHT: Member data table -->
            <div class="lg:w-3/5 bg-slate-50/80 rounded-xl border border-slate-200 p-4 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <h3 class="font-semibold text-slate-700 text-sm flex items-center gap-1.5">
                            <i class="fas fa-table text-indigo-500"></i> Members
                        </h3>
                        <span id="memberCounter"
                            class="bg-indigo-100 text-indigo-700 text-xs px-2.5 py-0.5 rounded-full font-bold">0</span>
                    </div>
                    <button type="button" id="clearMembersBtn" class="text-xs text-slate-400 hover:text-red-500 transition"
                        title="Clear all members">
                        <i class="fas fa-trash-alt"></i> Clear
                    </button>
                </div>

                <!-- Hidden input to store members as JSON -->
                <input type="hidden" name="members_list" id="membersList" value="[]">

                <!-- Table container (scrollable) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                    <div class="overflow-x-auto max-h-[450px]">
                        <table class="min-w-full text-sm">
                            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        #
                                    </th>

                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Room Type
                                    </th>

                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Room Name
                                    </th>

                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Team Members
                                    </th>

                                    <th
                                        class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @forelse($rooms as $key => $item)
                                    @php
                                        $members = json_decode($item->members, true) ?? [];
                                    @endphp

                                    <tr class="hover:bg-slate-50 transition duration-200">

                                        <td class="px-5 py-4 font-medium text-slate-700">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                @if ($item->room_type == 'public') bg-green-100 text-green-700
                                @elseif($item->room_type == 'private')
                                    bg-red-100 text-red-700
                                @elseif($item->room_type == 'team')
                                    bg-blue-100 text-blue-700
                                @else
                                    bg-purple-100 text-purple-700 @endif">
                                                {{ ucfirst($item->room_type) }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-slate-800">
                                            {{ $item->room_name }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <select
                                                class="w-52 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">

                                                <option selected disabled>
                                                    {{ count($members) }} Members
                                                </option>

                                                @foreach ($members as $member)
                                                    <option>{{ $member }}</option>
                                                @endforeach

                                            </select>
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">

                                                <a href="{{ url('admin/room/edit/' . $item->id) }}"
                                                    class="h-9 w-9 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white transition">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button onclick="deleteRoom({{ $item->id }})"
                                                    class="h-9 w-9 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </div>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="py-16 text-center">

                                            <div class="flex flex-col items-center">

                                                <i class="fas fa-users text-5xl text-slate-300 mb-3"></i>

                                                <h3 class="text-lg font-semibold text-slate-700">
                                                    No Rooms Found
                                                </h3>

                                                <p class="text-slate-500 text-sm mt-1">
                                                    Create your first room to get started.
                                                </p>

                                            </div>

                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- small hint -->
                <div class="mt-2 text-[10px] text-slate-400 flex items-center gap-1">
                    <i class="fas fa-info-circle"></i> click <span class="text-red-400 font-medium">✕</span> to remove
                </div>
            </div>
        </form>
    </div>

    <script>
        (function() {
            "use strict";

            // ----- DOM refs -----
            const memberInputsContainer = document.getElementById('memberInputsContainer');
            const addMoreInputBtn = document.getElementById('addMoreInputBtn');
            const addMembersToListBtn = document.getElementById('addMembersToListBtn');
            const memberTableBody = document.getElementById('memberTableBody');
            const emptyTableRow = document.getElementById('emptyTableRow');
            const memberCounter = document.getElementById('memberCounter');
            const clearMembersBtn = document.getElementById('clearMembersBtn');
            const roomImageInput = document.getElementById('roomImage');
            const fileLabel = document.getElementById('fileLabel');
            const fileName = document.getElementById('fileName');
            const roomForm = document.getElementById('roomForm');
            const feedback = document.getElementById('formFeedback');
            const membersListInput = document.getElementById('membersList');

            // ----- State -----
            let members = [];

            // ----- File input handler -----
            roomImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    fileLabel.textContent = file.name;
                    fileName.textContent = `📎 ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
                } else {
                    fileLabel.textContent = 'Choose an image...';
                    fileName.textContent = '';
                }
            });

            // ----- Function to get all member input values -----
            function getMemberInputs() {
                const inputs = document.querySelectorAll('.member-input');
                const values = [];
                inputs.forEach(input => {
                    const val = input.value.trim();
                    if (val !== '') {
                        values.push(val);
                    }
                });
                return values;
            }

            // ----- Function to clear all member inputs -----
            function clearMemberInputs() {
                const inputs = document.querySelectorAll('.member-input');
                inputs.forEach(input => {
                    input.value = '';
                });
            }

            // ----- Function to add a new input row -----
            function addInputRow(value = '') {
                const row = document.createElement('div');
                row.className = 'input-row flex items-center gap-2';
                row.innerHTML = `
          <input type="text" placeholder="Member name..." name="members[]"
                 class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white member-input"
                 value="${value}">
          <button type="button" class="remove-input-btn text-red-400 hover:text-red-600 transition p-1" title="Remove this input">
            <i class="fas fa-times"></i>
          </button>
        `;

                // Add remove functionality
                const removeBtn = row.querySelector('.remove-input-btn');
                removeBtn.addEventListener('click', function() {
                    const container = this.closest('.input-row');
                    if (document.querySelectorAll('.input-row').length > 1) {
                        container.remove();
                    } else {
                        // Clear the input instead of removing the last one
                        const input = container.querySelector('.member-input');
                        input.value = '';
                        input.focus();
                    }
                });

                // Add enter key functionality
                const input = row.querySelector('.member-input');
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addInputRow();
                        // Focus the new input
                        setTimeout(() => {
                            const lastInput = document.querySelector(
                                '.input-row:last-child .member-input');
                            if (lastInput) lastInput.focus();
                        }, 50);
                    }
                });

                memberInputsContainer.appendChild(row);

                // Focus the new input
                setTimeout(() => {
                    const newInput = row.querySelector('.member-input');
                    if (newInput) newInput.focus();
                }, 50);
            }

            // ----- Add more input button -----
            addMoreInputBtn.addEventListener('click', function() {
                addInputRow();
            });

            // ----- Add all members to table -----
            addMembersToListBtn.addEventListener('click', function() {
                const memberNames = getMemberInputs();

                if (memberNames.length === 0) {
                    feedback.textContent = '⚠️ Please enter at least one member name.';
                    feedback.className =
                        'mt-3 text-sm font-medium text-center text-amber-600 transition-all duration-200 h-6';
                    return;
                }

                // Add all members to the list
                memberNames.forEach(name => {
                    members.push(name);
                });

                renderTable();
                clearMemberInputs();

                // Keep at least one input row
                const existingRows = document.querySelectorAll('.input-row');
                if (existingRows.length === 0) {
                    addInputRow();
                }

                feedback.textContent = `✅ Added ${memberNames.length} member(s) to the list.`;
                feedback.className =
                    'mt-3 text-sm font-medium text-center text-emerald-600 transition-all duration-200 h-6';
            });

            // ----- Render table (data table format) -----
            function renderTable() {
                // remove all .member-row (keep empty row)
                const rows = memberTableBody.querySelectorAll('.member-row');
                rows.forEach(row => row.remove());

                // update counter
                memberCounter.textContent = members.length;

                // Update hidden input
                membersListInput.value = JSON.stringify(members);

                // toggle empty row
                if (members.length === 0) {
                    emptyTableRow.style.display = 'table-row';
                } else {
                    emptyTableRow.style.display = 'none';
                }

                // render each member as a table row
                members.forEach((memberName, index) => {
                    const tr = document.createElement('tr');
                    tr.className = 'member-row border-b border-slate-100 hover:bg-slate-50 transition';

                    // index column
                    const tdIndex = document.createElement('td');
                    tdIndex.className = 'px-4 py-2 text-slate-500 text-xs font-mono';
                    tdIndex.textContent = index + 1;

                    // name column
                    const tdName = document.createElement('td');
                    tdName.className = 'px-4 py-2 text-slate-700 font-medium';
                    // avatar + name
                    const nameWrapper = document.createElement('div');
                    nameWrapper.className = 'flex items-center gap-2';
                    const avatar = document.createElement('span');
                    avatar.className =
                        'inline-flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-semibold';
                    const initial = memberName.trim().charAt(0).toUpperCase() || '?';
                    avatar.textContent = initial;
                    const nameSpan = document.createElement('span');
                    nameSpan.textContent = memberName || 'Unnamed';
                    nameWrapper.appendChild(avatar);
                    nameWrapper.appendChild(nameSpan);
                    tdName.appendChild(nameWrapper);

                    // action column (remove button)
                    const tdAction = document.createElement('td');
                    tdAction.className = 'px-4 py-2 text-right';
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className =
                        'text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-full p-1 transition';
                    removeBtn.innerHTML = '<i class="fas fa-times-circle text-base"></i>';
                    removeBtn.setAttribute('aria-label', 'Remove member');

                    removeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        members.splice(index, 1);
                        renderTable();
                        // clear feedback
                        feedback.textContent = '';
                        feedback.className =
                            'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
                    });

                    tdAction.appendChild(removeBtn);

                    tr.appendChild(tdIndex);
                    tr.appendChild(tdName);
                    tr.appendChild(tdAction);

                    // insert before the empty row (which stays in tbody)
                    memberTableBody.insertBefore(tr, emptyTableRow);
                });
            }

            // ----- Clear all members -----
            function clearAllMembers() {
                if (members.length === 0) return;
                members = [];
                renderTable();
                feedback.textContent = '';
                feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
            }

            // ----- Event listeners -----
            clearMembersBtn.addEventListener('click', clearAllMembers);

            // ----- Form submission with AJAX -----
            roomForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Add members as JSON
                formData.append('members_json', JSON.stringify(members));

                // Show loading state
                const submitBtn = document.getElementById('createRoomBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner"></span> Creating...';
                submitBtn.disabled = true;

                // Send AJAX request
                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            feedback.innerHTML = `✅ ${data.message}`;
                            feedback.className =
                                'mt-3 text-sm font-medium text-center text-emerald-600 transition-all duration-200 h-6';

                            // Reset form after successful creation
                            setTimeout(() => {
                                resetForm();
                            }, 2000);
                        } else {
                            let errorMsg = '❌ Failed to create room.';
                            if (data.errors) {
                                errorMsg = '❌ ' + Object.values(data.errors).flat().join(', ');
                            }
                            feedback.textContent = errorMsg;
                            feedback.className =
                                'mt-3 text-sm font-medium text-center text-red-500 transition-all duration-200 h-6';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        feedback.textContent = '❌ An error occurred. Please try again.';
                        feedback.className =
                            'mt-3 text-sm font-medium text-center text-red-500 transition-all duration-200 h-6';
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            });

            // ----- Reset function -----
            function resetForm() {
                roomForm.reset();
                fileLabel.textContent = 'Choose an image...';
                fileName.textContent = '';
                members = [];
                renderTable();

                // Clear all input rows and keep one empty
                const rows = document.querySelectorAll('.input-row');
                rows.forEach((row, index) => {
                    if (index === 0) {
                        const input = row.querySelector('.member-input');
                        input.value = '';
                    } else {
                        row.remove();
                    }
                });

                feedback.textContent = '';
                feedback.className = 'mt-3 text-sm font-medium text-center transition-all duration-200 h-6';
                document.getElementById('roomName').focus();
            }

            // ----- Reset button -----
            document.getElementById('resetFormBtn').addEventListener('click', function(e) {
                e.preventDefault();
                resetForm();
            });

            // ----- Remove input row functionality (delegated) -----
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-input-btn')) {
                    const row = e.target.closest('.input-row');
                    if (document.querySelectorAll('.input-row').length > 1) {
                        row.remove();
                    } else {
                        const input = row.querySelector('.member-input');
                        input.value = '';
                        input.focus();
                    }
                }
            });

            // Initial render
            renderTable();

            // Focus input on load
            setTimeout(() => {
                const firstInput = document.querySelector('.member-input');
                if (firstInput) firstInput.focus();
            }, 100);

        })();
    </script>
@endsection
