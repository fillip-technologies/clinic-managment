@extends('admin.loyout.master')
@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200/60">
            <div class="mb-8 border-b border-slate-200 pb-4">
                <h2 class="text-2xl md:text-3xl font-semibold text-slate-800 flex items-center gap-3">
                    <i class="fas fa-file-medical text-indigo-500 text-2xl"></i>
                    Doctor Report Upload
                </h2>
                <p class="text-slate-500 text-sm mt-1 flex items-center gap-1">
                    <i class="fas fa-notes-medical text-indigo-300"></i>
                    Fill in the details below to upload a new report
                </p>
            </div>
            <form  action="{{ route('DocRepupdate.update',$data->id) }}" class="space-y-7" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="user_id" value="{{ Auth::guard('doctor')->id() ?? 0 }}">

                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-slate-700 mb-1.5">
                            <i class="fas fa-user-md text-indigo-400 mr-1.5"></i> Full Name
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input type="text" id="fullName" name="fullname"
                                value="{{ old('fullname', $data->fullname ?? '') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl shadow-sm
                          focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
                          transition duration-200 outline-none bg-white text-slate-700"
                                placeholder="Dr. John Doe">
                            @error('fullname')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Enter the doctor's full name</p>
                    </div>

                    <!-- 2. REPORT TYPE -->
                    <div>
                        <label for="reportType" class="block text-sm font-medium text-slate-700 mb-1.5">
                            <i class="fas fa-tag text-indigo-400 mr-1.5"></i> Report Type
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fas fa-file-alt text-sm"></i>
                            </span>
                            <select id="reportType" name="report_type"
                                class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl shadow-sm
                           focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
                           transition duration-200 outline-none bg-white text-slate-700 appearance-none">
                                <option value="" disabled selected>– Select report type –</option>
                                <option value="radiology" @selected($data->report_type == 'radiology')>Radiology (X-ray, MRI, CT)</option>
                                <option value="pathology" @selected($data->report_type == 'pathology')>Pathology / Lab</option>
                                <option value="cardiology" @selected($data->report_type == 'cardiology')>Cardiology</option>
                                <option value="neurology" @selected($data->report_type == 'neurology')>Neurology</option>
                                <option value="dermatology" @selected($data->report_type == 'dermatology')>Dermatology</option>
                                <option value="ophthalmology" @selected($data->report_type == 'ophthalmology')>Ophthalmology</option>
                                <option value="other" @selected($data->report_type == 'other')>Other</option>
                            </select>
                            @error('report_type')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                            <span
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 pointer-events-none">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Choose the category of the report</p>
                    </div>
                </div>


                <!-- 3. MULTIPLE FILE UPLOAD -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-cloud-upload-alt text-indigo-400 mr-1.5"></i> Upload Files (multiple)
                    </label>
                    <div
                        class="relative border-2 border-dashed border-slate-300 rounded-xl bg-slate-50/50
                      hover:bg-slate-100/70 transition px-4 py-6 focus-within:ring-2
                      focus-within:ring-indigo-400 focus-within:border-indigo-400">
                        <input type="file" id="fileUpload" name="file[]" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        @error('file')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                        <div class="flex flex-col items-center justify-center text-center pointer-events-none">
                            <i class="fas fa-folder-open text-3xl text-indigo-300 mb-2"></i>
                            <p class="text-sm text-slate-600 font-medium">Drag & drop files or <span
                                    class="text-indigo-500 underline decoration-indigo-300">browse</span></p>
                            <p class="text-xs text-slate-400 mt-1">PDF, JPG, PNG, DICOM (max 20MB each)</p>
                            <div id="fileList"
                                class="mt-3 w-full text-left space-y-1 pointer-events-none text-sm text-slate-600">
                                <!-- dynamic file list will be shown via JS -->
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <i class="fas fa-file-alt text-indigo-300 text-[10px]"></i>
                            @php

                                $files = [];
                                if (isset($data->file)) {
                                    if (is_array($data->file)) {
                                        $files = $data->file;
                                    } elseif (is_string($data->file)) {
                                        $decoded = json_decode($data->file, true);
                                        $files = is_array($decoded) ? $decoded : [$data->file];
                                    } elseif ($data->file instanceof \Illuminate\Support\Collection) {
                                        $files = $data->file->toArray();
                                    }
                                }
                                $displayFiles = array_slice($files, 0, 3);
                                $remaining = count($files) - 3;
                            @endphp
                            @if (!empty($displayFiles))
                                @foreach ($displayFiles as $file)
                                    <span class="bg-slate-100 px-2 py-0.5 rounded text-xs">
                                        {{ strlen($file) > 15 ? substr($file, 0, 12) . '…' : $file }}
                                    </span>
                                @endforeach
                                @if ($remaining > 0)
                                    <span class="text-indigo-400 text-xs font-medium">+{{ $remaining }}
                                        more</span>
                                @endif
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                        <i class="fas fa-info-circle text-indigo-300"></i>
                        You can select multiple files at once (Ctrl+Click or Shift+Click)
                    </p>
                    <!-- hidden file counter for validation (optional) -->
                </div>

                <!-- 4. DATE -->
                <div>
                    <label for="reportDate" class="block text-sm font-medium text-slate-700 mb-1.5">
                        <i class="fas fa-calendar-day text-indigo-400 mr-1.5"></i> Report Date
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fas fa-calendar-alt text-sm"></i>
                        </span>
                        <input type="date" id="reportDate" name="date" value="{{ old('date',$data->date ?? "") }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl shadow-sm
                          focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
                          transition duration-200 outline-none bg-white text-slate-700">
                        @error('date')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Select the date of the report</p>
                </div>

                <!-- submit & reset row -->
                <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-slate-200/70 mt-8">
                    <button type="reset"
                        class="px-6 py-2.5 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition shadow-sm">
                        <i class="fas fa-undo-alt mr-1.5"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-8 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-upload"></i> Upload Report
                    </button>
                </div>

                <!-- extra: success/error message placeholder (no custom css) -->
                <div id="formFeedback" class="mt-4 text-sm font-medium"></div>

            </form>
        </div>

        <!-- tiny footer note -->
        <p class="text-center text-xs text-slate-400 mt-6">
            <i class="fas fa-lock text-indigo-200 mr-1"></i> Secured · Admin panel
        </p>
    </div>

    <!-- JavaScript – only for dynamic file list & submit preview (no custom CSS) -->
    <script>
        (function() {
            const fileInput = document.getElementById('fileUpload');
            const fileListDiv = document.getElementById('fileList');

            // Update file list on selection
            fileInput.addEventListener('change', function(e) {
                const files = this.files;
                if (files.length === 0) {
                    fileListDiv.innerHTML = '';
                    return;
                }

                let fileNamesHtml = '';
                for (let i = 0; i < files.length; i++) {
                    const f = files[i];
                    // truncate long names
                    let name = f.name;
                    if (name.length > 28) name = name.slice(0, 25) + '…';
                    const size = (f.size / 1024).toFixed(1) + ' KB';
                    fileNamesHtml += `<div class="flex items-center gap-1.5 text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md text-xs">
                              <i class="fas fa-file text-indigo-300 text-[10px]"></i>
                              <span>${name}</span>
                              <span class="text-slate-400 text-[10px]">(${size})</span>
                            </div>`;
                }
                fileListDiv.innerHTML = fileNamesHtml;
            });

            document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
                fileListDiv.innerHTML = '';

                setTimeout(() => {
                    if (fileInput.files.length === 0) {
                        fileListDiv.innerHTML = '';
                    }
                }, 0);
            });


            document.getElementById('reportForm').addEventListener('reset', function() {

                fileListDiv.innerHTML = '';

                document.getElementById('formFeedback').innerHTML = '';
            });

        })();


        function handleSubmit(event) {
            event.preventDefault();

            const form = document.getElementById('reportForm');
            const fd = new FormData(form);


            const fullName = fd.get('fullName') || '';
            const reportType = fd.get('reportType') || '';
            const reportDate = fd.get('reportDate') || '';
            const files = document.getElementById('fileUpload').files;

            // validation: check that at least one file is selected (already required, but double-check)
            if (files.length === 0) {
                document.getElementById('formFeedback').innerHTML = `
          <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-2.5 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-rose-400"></i>
            <span>Please select at least one file to upload.</span>
          </div>
        `;
                return false;
            }

            // Build success preview message
            let fileNames = [];
            for (let i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }
            const fileListStr = fileNames.length > 3 ?
                fileNames.slice(0, 3).join(', ') + ` and ${fileNames.length-3} more` :
                fileNames.join(', ');

            const feedbackDiv = document.getElementById('formFeedback');
            feedbackDiv.innerHTML = `
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex flex-col sm:flex-row sm:items-center gap-2 shadow-sm">
          <div class="flex items-center gap-2">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <span class="font-medium">Report ready to upload</span>
          </div>
          <span class="text-sm text-emerald-600/80 break-words">
            <i class="fas fa-user mr-1 text-emerald-400"></i> ${fullName} ·
            <i class="fas fa-tag mr-1 text-emerald-400"></i> ${reportType} ·
            <i class="fas fa-calendar mr-1 text-emerald-400"></i> ${reportDate} ·
            <i class="fas fa-file mr-1 text-emerald-400"></i> ${files.length} file(s)
          </span>
        </div>
        <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
          <i class="fas fa-paperclip text-indigo-300"></i>
          Files: ${fileListStr}
        </p>
        <p class="text-xs text-slate-400 mt-1 italic">(Demo: form data would be sent to server)</p>
      `;
            feedbackDiv.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            return false; // prevent default submit
        }
    </script>
@endsection
