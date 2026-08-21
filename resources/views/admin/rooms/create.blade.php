@extends('admin.loyout.master')
@section('content')
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
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
            z-index: 10;
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
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                    {{ isset($editroom) ? 'Edit Room: ' . $editroom->room_name : 'Create New Room' }}
                </h2>
                <p class="text-xs text-slate-500">Manage rooms, members, and uploaded documents</p>
            </div>
            @if(isset($editroom))
                <a href="{{ route('room.list') }}" class="ml-auto text-xs bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-1.5 rounded-lg font-medium transition flex items-center gap-1.5">
                    <i class="fas fa-plus"></i> New Room Mode
                </a>
            @else
                <span class="ml-auto text-xs bg-slate-200 text-slate-600 px-3 py-1 rounded-full font-medium">Room Management</span>
            @endif
        </div>

        <form action="{{ isset($editroom) ? route('room.update', $editroom->id) : route('room.store') }}" method="POST"
            enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-6">
            @csrf

            <!-- LEFT: main form fields (room name, type, file uploads, members) -->
            <div class="lg:w-2/5 space-y-5">
                <!-- Room Name -->
                <div>
                    <label for="roomName" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-tag text-indigo-400 mr-1.5"></i> Room Name
                    </label>
                    <input type="text" id="roomName" placeholder="e.g. Consultation Room 1, Diabetes Clinic..." name="room_name"
                        value="{{ old('room_name', isset($editroom) ? $editroom->room_name : '') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800 placeholder:text-slate-400" required>
                    @error('room_name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Room Type -->
                <div>
                    <label for="roomType" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-layer-group text-indigo-400 mr-1.5"></i> Room Type
                    </label>
                    <select id="roomType" name="room_type"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800">
                        <option value="public" @selected(isset($editroom) ? $editroom->room_type == 'public' : false)>🌐 Public</option>
                        <option value="private" @selected(isset($editroom) ? $editroom->room_type == 'private' : false)>🔒 Private</option>
                        <option value="team" @selected(isset($editroom) ? $editroom->room_type == 'team' : true)>👥 Team</option>
                        <option value="channel" @selected(isset($editroom) ? $editroom->room_type == 'channel' : false)>📢 Channel</option>
                    </select>
                    @error('room_type')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Multiple File Upload (All File Types Supported) -->
                <div>
                    <label for="roomFiles" class="block text-sm font-medium text-slate-700 mb-1.5 flex items-center justify-between">
                        <span><i class="fas fa-paperclip text-indigo-500 mr-1.5"></i> Room Files</span>
                        <span class="text-[11px] text-slate-400">Multiple files allowed</span>
                    </label>
                    <div class="file-input-wrapper">
                        <input type="file" id="roomFiles" name="files[]" multiple
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-slate-50/50 text-slate-800 cursor-pointer">
                        <div class="w-full px-4 py-2.5 border border-slate-300 rounded-xl bg-slate-50/50 text-slate-600 flex items-center gap-2">
                            <i class="fas fa-upload text-indigo-500"></i>
                            <span id="fileLabel">Choose file...</span>
                        </div>
                    </div>
                    <div id="fileListContainer" class="mt-2 space-y-1"></div>
                    <p class="text-[11px] text-slate-400 mt-1">Upload multiple files (PDF, Word, Excel, Images, etc.)</p>
                    @error('files')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror

                    <!-- In Edit Mode: Display current files using explode() -->
                    @if (isset($editroom) && !empty($editroom->file))
                        @php
                            // Explode stored string into array
                            $currentFiles = array_values(array_filter(explode(',', $editroom->file)));
                        @endphp
                        @if(count($currentFiles) > 0)
                            <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-slate-700 flex items-center gap-1">
                                        <i class="fas fa-folder-open text-indigo-500"></i> Attached Files ({{ count($currentFiles) }})
                                    </span>
                                    <span class="text-[10px] text-slate-400">Click ✕ to delete</span>
                                </div>
                                <div class="space-y-1.5" id="existingFilesContainer">
                                    @foreach ($currentFiles as $fileIdx => $filePath)
                                        @php
                                            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                            $fileName = basename($filePath);
                                        @endphp
                                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-200 text-xs hover:border-indigo-200 transition">
                                            <div class="flex items-center gap-2 truncate max-w-[80%]">
                                                @if($isImg)
                                                    <img src="{{ asset('storage/' . $filePath) }}" alt="" class="w-6 h-6 rounded object-cover border">
                                                @elseif($ext === 'pdf')
                                                    <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                                                @elseif(in_array($ext, ['doc', 'docx', 'txt']))
                                                    <i class="fas fa-file-word text-blue-500 text-sm"></i>
                                                @elseif(in_array($ext, ['xls', 'xlsx', 'csv']))
                                                    <i class="fas fa-file-excel text-green-500 text-sm"></i>
                                                @else
                                                    <i class="fas fa-file text-slate-500 text-sm"></i>
                                                @endif
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="truncate font-medium text-slate-700 hover:text-indigo-600" title="{{ $fileName }}">
                                                    {{ $fileName }}
                                                </a>
                                            </div>
                                            <button type="button" onclick="deleteRoomFile('{{ $editroom->id }}', '{{ $fileIdx }}')" class="text-slate-400 hover:text-red-600 p-1 transition" title="Delete file">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Add member section with dynamic inputs -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        <i class="fas fa-user-plus text-indigo-400 mr-1.5"></i> Add Members
                    </label>

                    <div id="memberInputsContainer" class="space-y-2">
                        @if (isset($editroom) && !empty($editroom->members))
                            @foreach (json_decode($editroom->members, true) ?? [] as $key => $member)
                                <div class="input-row flex items-center gap-2">
                                    <input type="text" name="members[]" value="{{ $member }}"
                                        placeholder="Member name..."
                                        class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white member-input">

                                    <button type="button"
                                        onclick="deleteMember('{{ $key }}','{{ $editroom->id }}')"
                                        class="remove-input-btn text-red-400 hover:text-red-600 transition p-1"
                                        title="Remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="input-row flex items-center gap-2">
                                <input type="text" name="members[]" placeholder="Member name..."
                                    class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white member-input">

                                <button type="button"
                                    class="remove-input-btn text-red-400 hover:text-red-600 transition p-1" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Add More -->
                    <button type="button" id="addMoreInputBtn"
                        class="mt-2 w-full bg-white hover:bg-slate-100 text-indigo-600 font-medium py-2 px-4 rounded-lg border border-dashed border-indigo-300 transition text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i> Add more member field
                    </button>
                </div>

                <!-- Submit & reset -->
                <div class="flex flex-col sm:flex-row gap-3 pt-1">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ isset($editroom) ? 'Update Room' : 'Create Room' }}
                    </button>
                    @if(isset($editroom))
                        <a href="{{ route('room.list') }}"
                            class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-center">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    @else
                        <button type="reset" id="resetFormBtn"
                            class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </button>
                    @endif
                </div>
            </div>

            <!-- RIGHT: Room data table with explode file viewing -->
            <div class="lg:w-3/5 bg-slate-50/80 rounded-xl border border-slate-200 p-4 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <h3 class="font-semibold text-slate-700 text-sm flex items-center gap-1.5">
                            <i class="fas fa-table text-indigo-500"></i> All Rooms & Attached Files
                        </h3>
                        <span class="bg-indigo-100 text-indigo-700 text-xs px-2.5 py-0.5 rounded-full font-bold">
                            {{ $rooms->total() ?? count($rooms) }}
                        </span>
                    </div>
                </div>

                <!-- Table container -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto max-h-[500px]">
                        <table class="min-w-full text-sm">
                            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Room Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Room Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Attached Files</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Members</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse($rooms as $key => $item)
                                    @php
                                        $members = json_decode($item->members, true) ?? [];
                                        // Use explode to split comma-separated file string into an array
                                        $roomFiles = !empty($item->file) ? array_values(array_filter(explode(',', $item->file))) : [];
                                    @endphp

                                    <tr class="hover:bg-slate-50 transition duration-200">
                                        <td class="px-4 py-4 font-medium text-slate-700">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="px-4 py-4">
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                @if ($item->room_type == 'public') bg-green-100 text-green-700
                                                @elseif($item->room_type == 'private') bg-red-100 text-red-700
                                                @elseif($item->room_type == 'team') bg-blue-100 text-blue-700
                                                @else bg-purple-100 text-purple-700 @endif">
                                                {{ ucfirst($item->room_type) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 font-semibold text-slate-800">
                                            {{ $item->room_name }}
                                        </td>

                                        <!-- Attached Files Column (Exploded from DB string) -->
                                        <td class="px-4 py-4">
                                            @if (count($roomFiles) > 0)
                                                <div class="space-y-1 max-w-[220px]">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 mb-1">
                                                        <i class="fas fa-paperclip"></i> {{ count($roomFiles) }} {{ count($roomFiles) === 1 ? 'file' : 'files' }}
                                                    </span>
                                                    <ul class="space-y-1">
                                                        @foreach ($roomFiles as $fPath)
                                                            @php
                                                                $ext = strtolower(pathinfo($fPath, PATHINFO_EXTENSION));
                                                                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                                                $fName = basename($fPath);
                                                            @endphp
                                                            <li>
                                                                <a href="{{ asset('storage/' . $fPath) }}" target="_blank"
                                                                    class="flex items-center gap-1.5 p-1 rounded bg-slate-50 hover:bg-indigo-50 border border-slate-200 text-xs text-slate-700 hover:text-indigo-600 transition"
                                                                    title="{{ $fName }}">
                                                                    @if ($isImg)
                                                                        <i class="fas fa-file-image text-indigo-500 text-xs flex-shrink-0"></i>
                                                                    @elseif ($ext === 'pdf')
                                                                        <i class="fas fa-file-pdf text-red-500 text-xs flex-shrink-0"></i>
                                                                    @elseif (in_array($ext, ['doc', 'docx', 'txt']))
                                                                        <i class="fas fa-file-word text-blue-500 text-xs flex-shrink-0"></i>
                                                                    @elseif (in_array($ext, ['xls', 'xlsx', 'csv']))
                                                                        <i class="fas fa-file-excel text-green-500 text-xs flex-shrink-0"></i>
                                                                    @else
                                                                        <i class="fas fa-file text-slate-500 text-xs flex-shrink-0"></i>
                                                                    @endif
                                                                    <span class="truncate flex-1 font-medium">{{ $fName }}</span>
                                                                    <i class="fas fa-external-link-alt text-[9px] text-slate-400"></i>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 italic">No files</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4">
                                            @if (count($members) > 0)
                                                <select class="w-44 rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                                    <option selected disabled>{{ count($members) }} Member(s)</option>
                                                    @foreach ($members as $member)
                                                        <option>{{ $member }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span class="text-xs text-slate-400 italic">0 members</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('room.edit', $item->id) }}"
                                                    class="h-8 w-8 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white transition"
                                                    title="Edit Room">
                                                    <i class="fas fa-edit text-xs"></i>
                                                </a>

                                                <button onclick="roomdelete({{ $item->id }})" type="button"
                                                    class="h-8 w-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition"
                                                    title="Delete Room">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-door-open text-5xl text-slate-300 mb-3"></i>
                                                <h3 class="text-lg font-semibold text-slate-700">No Rooms Found</h3>
                                                <p class="text-slate-500 text-sm mt-1">Create your first room using the form.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($rooms, 'hasPages') && $rooms->hasPages())
                        <div class="p-3 border-t border-slate-200">
                            {{ $rooms->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <script>
        function roomdelete(id) {
            if (!confirm('Are you sure you want to delete this room and its attached files?')) return;
            $.ajax({
                type: "GET",
                url: "{{ url('admin/delete/room/') }}/" + id,
                success: function(res) {
                    toastr.success(res.message || "Room deleted successfully.");
                    setTimeout(() => window.location.reload(), 500);
                },
                error: function(error) {
                    toastr.error("Failed to delete room.");
                }
            });
        }

        function deleteMember(index, id) {
            if (!confirm('Are you sure you want to remove this member?')) return;
            $.ajax({
                type: "GET",
                url: "{{ url('admin/member/index/') }}/" + id + "/" + index,
                success: function(res) {
                    toastr.success(res.message || "Member deleted successfully.");
                    setTimeout(() => window.location.reload(), 500);
                },
                error: function(error) {
                    toastr.error("Failed to delete member.");
                }
            });
        }

        function deleteRoomFile(roomId, fileIndex) {
            if (!confirm('Are you sure you want to delete this file?')) return;
            $.ajax({
                type: "GET",
                url: "{{ url('admin/delete/room-file/') }}/" + roomId + "/" + fileIndex,
                success: function(res) {
                    toastr.success(res.message || "File deleted successfully.");
                    setTimeout(() => window.location.reload(), 500);
                },
                error: function(error) {
                    toastr.error("Failed to delete file.");
                }
            });
        }

        // Multiple files selector display (List wise)
        const roomFilesInput = document.getElementById('roomFiles');
        const fileLabel = document.getElementById('fileLabel');
        const fileListContainer = document.getElementById('fileListContainer');

        if (roomFilesInput) {
            roomFilesInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileLabel.textContent = `${this.files.length} file(s) selected`;
                    let listHtml = '<ul class="space-y-1 mt-2">';
                    Array.from(this.files).forEach(f => {
                        let sizeKb = (f.size / 1024).toFixed(1);
                        listHtml += `
                            <li class="flex items-center justify-between p-1.5 bg-slate-100/90 rounded-lg text-xs text-slate-700 border border-slate-200">
                                <div class="flex items-center gap-1.5 truncate max-w-[78%]">
                                    <i class="fas fa-file text-indigo-500 text-xs flex-shrink-0"></i>
                                    <span class="truncate font-medium">${f.name}</span>
                                </div>
                                <span class="text-[10px] text-slate-500 flex-shrink-0">${sizeKb} KB</span>
                            </li>
                        `;
                    });
                    listHtml += '</ul>';
                    fileListContainer.innerHTML = listHtml;
                } else {
                    fileLabel.textContent = 'Choose file...';
                    fileListContainer.innerHTML = '';
                }
            });
        }

        // Dynamic member fields
        const memberInputsContainer = document.getElementById('memberInputsContainer');
        const addMoreInputBtn = document.getElementById('addMoreInputBtn');

        if (addMoreInputBtn) {
            addMoreInputBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'input-row flex items-center gap-2';
                row.innerHTML = `
                    <input type="text" name="members[]" placeholder="Member name..."
                        class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 outline-none text-sm bg-white member-input">
                    <button type="button" class="remove-input-btn text-red-400 hover:text-red-600 transition p-1" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                memberInputsContainer.appendChild(row);

                row.querySelector('.remove-input-btn').addEventListener('click', function() {
                    row.remove();
                });
            });
        }

        // Remove button delegation for existing rows
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-input-btn')) {
                const row = e.target.closest('.input-row');
                if (row && document.querySelectorAll('.input-row').length > 1) {
                    row.remove();
                }
            }
        });
    </script>
@endsection
