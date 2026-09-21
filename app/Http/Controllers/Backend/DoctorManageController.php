<?php

namespace App\Http\Controllers\Backend;

use App\Events\DoctorRegEvent;
use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Models\User;
use App\Mail\AppointmentScheduledMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DoctorManageController extends Controller
{
    public function doctorList(Request $request){
        $query = User::where('role', "!=", 'super_admin');
        if ($request->filled('role') && in_array($request->role, ['doctor', 'staff'])) {
            $query->where('role', $request->role);
        }
        $doctors = $query->latest()->paginate(10)->withQueryString();
        $totalCount = User::where('role', '!=', 'super_admin')->count();
        $doctorCount = User::where('role', 'doctor')->count();
        $staffCount = User::where('role', 'staff')->count();
        return view('admin.backend.doctors.index', compact('doctors', 'totalCount', 'doctorCount', 'staffCount'));
    }

    public function createdocForm(){
        return view('admin.backend.doctors.create');
    }

    public function AddDoctor(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|min:8|max:12',
            'city'=>'required|string',
            'country'=>'required|string',
            'state'=>'required|string',
            'pin_code'=>'required|string',
            'doctor_strime'=>'required|string',
            'phone'=>'required',
            'role'=>'required|in:doctor,super_admin,staff',
        ]);

        $planTextPasssword = trim($request->password);

        $data = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'city'=>$request->city,
            'country'=>$request->country,
            'state'=>$request->state,
            'pin_code'=>$request->pin_code,
            'doctor_strime'=>$request->doctor_strime,
            'phone'=>$request->phone,
            'role'=>$request->role,
        ]);
          $createdata = DoctorRegEvent::dispatch($data,$planTextPasssword);

          if($createdata){
            return redirect()->back()->with('success','Doctor Account Created SuccessFully');
          }else{
            return redirect()->back()->with('error','Something went wrong');
          }
    }

    public function UpdateDoctor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'city' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'pin_code' => 'required|string',
            'doctor_strime' => 'required|string',
            'phone' => 'required',
            'role' => 'required|in:doctor,super_admin,staff',
            'password' => 'nullable|min:8|max:32',
        ]);

        $doctor = User::findOrFail($id);

        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->city = $request->city;
        $doctor->country = $request->country;
        $doctor->state = $request->state;
        $doctor->pin_code = $request->pin_code;
        $doctor->doctor_strime = $request->doctor_strime;
        $doctor->phone = $request->phone;
        $doctor->role = $request->role;
        if ($request->filled('password')) {
            $doctor->password = Hash::make(trim($request->password));
        }
        $doctor->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function DeleteDoctor($id)
    {
        $doctor = User::findOrFail($id);

        $doctor->delete();

        return redirect()->back()->with('success', 'Doctor deleted successfully.');
    }


    public function editDoctor($id)
    {
        $doctor = User::find($id);
        return view('admin.backend.doctors.edit',compact('doctor'));
    }


    public function appoinmentstore(Request $request)
    {
        $request->validate([
            'patient_name'     => 'required|string|max:255',
            'father_name'      => 'nullable|string|max:255',
            'age'              => 'nullable|numeric|min:0|max:150',
            'patient_type'     => 'required|string|in:N,ON,ON DM,ON-DM,DMF,NDM,NM,NMDM,complimentry,Complimentry,complementary,Complementary,complimentary,Complimentary',
            'phone'            => 'required|string|max:20',
            'mail'             => 'nullable|email|max:255',
            'address'          => 'nullable|string',
            'message'          => 'nullable|string',
            'appointment_type' => 'nullable|string|in:on_site,admin',
            'appointment_scheduled_date' => 'nullable|date',
            'slot_number'      => ['nullable', 'string', 'regex:/^[1-9]\d*\/([1-9]|1[0-5])$/'],
        ]);

        $appointmentType = $request->appointment_type;
        if (empty($appointmentType)) {
            $appointmentType = ($request->is('admin/*') || str_contains(url()->previous() ?? '', 'admin')) ? 'admin' : 'on_site';
        }

        $rawPatientType = trim($request->patient_type);
        if (in_array(strtolower($rawPatientType), ['complimentry', 'complementary', 'complimentary'])) {
            $patientType = 'Complementary';
        } elseif (in_array(strtolower($rawPatientType), ['on dm', 'on-dm', 'ondm'])) {
            $patientType = 'ON DM';
        } else {
            $patientType = $rawPatientType;
        }

        $scheduledDate = $request->filled('appointment_scheduled_date') ? $request->appointment_scheduled_date : null;
        $slotNumber = $request->filled('slot_number') ? trim($request->slot_number) : null;

        if ($scheduledDate && $slotNumber) {
            $exists = Appoinment::whereDate('appointment_scheduled_date', $scheduledDate)
                ->where('slot_number', $slotNumber)
                ->exists();
            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['slot_number' => "Slot {$slotNumber} is already booked on " . \Carbon\Carbon::parse($scheduledDate)->format('d M Y') . "."])
                    ->with('error', "Slot {$slotNumber} is already booked on this date.");
            }
        }

        $appointment = Appoinment::create([
            'patient_name'     => $request->patient_name,
            'father_name'      => $request->father_name,
            'age'              => $request->age,
            'patient_type'     => $patientType,
            'appointment_type' => $appointmentType,
            'appointment_scheduled_date' => $scheduledDate,
            'slot_number'      => $slotNumber,
            'phone'            => $request->phone,
            'mail'             => $request->mail,
            'address'          => $request->address,
            'message'          => $request->message,
        ]);
        if ($appointmentType === 'admin' || $request->is('admin/*') || str_contains(url()->previous() ?? '', 'admin')) {
            return redirect()->route('listappoinment')->with('success','Appointment created successfully');
        }
        return redirect()->back()->with('success','Appointment created successfully');
    }


    public function listappoinment()
    {
       $appointments = Appoinment::where('appointment_type', 'admin')->latest()->get();
       $isOnlyAdmin = true;
       $pageTitle = 'Appointments';
       return view('listing.aapoinment', compact('appointments', 'isOnlyAdmin', 'pageTitle'));
    }

    public function onSiteAppointments()
    {
        $appointments = Appoinment::where('appointment_type', 'on_site')
            ->orWhereNull('appointment_type')
            ->latest()
            ->get();
        $isOnlyOnSite = true;
        $pageTitle = 'On-Site Appointments';
        return view('listing.aapoinment', compact('appointments', 'isOnlyOnSite', 'pageTitle'));
    }

    public function exportAppointments(Request $request)
    {
        $query = Appoinment::query();
        if ($request->filled('type')) {
            if ($request->type === 'on_site') {
                $query->where(function ($q) {
                    $q->where('appointment_type', 'on_site')->orWhereNull('appointment_type');
                });
            } else {
                $query->where('appointment_type', $request->type);
            }
        }

        $dateField = ($request->get('date_field') === 'scheduled_date') ? 'appointment_scheduled_date' : 'created_at';
        $isExportByDate = $request->boolean('export_by_date') || $request->filled('start_date') || $request->filled('end_date');

        if ($request->filled('start_date')) {
            $query->whereDate($dateField, '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate($dateField, '<=', $request->end_date);
        }

        // Date-wise export: always order first by date, and on the same date by slot number naturally (1/1, 1/2... 1/15, 2/1)
        if ($isExportByDate) {
            if ($dateField === 'appointment_scheduled_date') {
                $query->orderBy('appointment_scheduled_date', 'asc')
                    ->orderByRaw("CASE WHEN slot_number IS NULL OR slot_number = '' THEN 1 ELSE 0 END ASC")
                    ->orderByRaw("CAST(SUBSTRING_INDEX(slot_number, '/', 1) AS UNSIGNED) ASC")
                    ->orderByRaw("CAST(SUBSTRING_INDEX(slot_number, '/', -1) AS UNSIGNED) ASC")
                    ->orderBy('created_at', 'asc');
            } else {
                $query->orderBy('created_at', 'asc')
                    ->orderByRaw("CASE WHEN slot_number IS NULL OR slot_number = '' THEN 1 ELSE 0 END ASC")
                    ->orderByRaw("CAST(SUBSTRING_INDEX(slot_number, '/', 1) AS UNSIGNED) ASC")
                    ->orderByRaw("CAST(SUBSTRING_INDEX(slot_number, '/', -1) AS UNSIGNED) ASC");
            }
        } else {
            $query->latest();
        }

        $appointments = $query->get();
        $prefix = $request->type === 'on_site' ? 'onsite_' : ($request->type === 'admin' ? 'admin_' : '');
        
        $dateSuffix = '';
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $dateSuffix = '_' . $request->start_date . '_to_' . $request->end_date;
        } elseif ($request->filled('start_date')) {
            $dateSuffix = '_from_' . $request->start_date;
        } elseif ($request->filled('end_date')) {
            $dateSuffix = '_until_' . $request->end_date;
        }

        $fieldLabel = ($dateField === 'appointment_scheduled_date') ? '_by_scheduled_date' : '';
        $filename = $prefix . 'appointments' . $fieldLabel . $dateSuffix . '_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $isAdmin = ($request->type === 'admin');

        return response()->stream(function () use ($appointments, $isAdmin) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel

            $headers = [
                'Sr No.',
                'Booked On',
                'Scheduled Date',
                'Slot No.',
                'Status',
                'Patient Name',
                'Age',
                'Father\'s Name',
                'Phone',
                'Email',
                'Address',
                'Visit Type',
            ];
            if (!$isAdmin) {
                $headers[] = 'Note / Message';
            }

            fputcsv($handle, $headers);

            foreach ($appointments as $index => $app) {
                $row = [
                    $index + 1,
                    $app->created_at ? $app->created_at->format('d M Y, h:i A') : '-',
                    $app->appointment_scheduled_date ? \Carbon\Carbon::parse($app->appointment_scheduled_date)->format('d M Y') : 'Not Scheduled',
                    $app->slot_number ? 'Slot ' . $app->slot_number : '-',
                    $app->appointment_done ? 'Done' : 'Pending',
                    $app->patient_name ?? 'N/A',
                    $app->age ? $app->age . ' yrs' : '-',
                    $app->father_name ?? '-',
                    $app->phone ?? '-',
                    $app->mail ?? '-',
                    $app->address ?? '-',
                    $app->patient_type ?? '-',
                ];
                if (!$isAdmin) {
                    $row[] = $app->message ?? '-';
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function scheduleAppointment(Request $request, $id)
    {
        $request->validate([
            'appointment_scheduled_date' => 'required|date',
            'slot_number' => ['nullable', 'string', 'regex:/^[1-9]\d*\/([1-9]|1[0-5])$/'],
        ]);

        $appointment = Appoinment::findOrFail($id);
        $date = $request->appointment_scheduled_date;
        $slotNumber = $request->filled('slot_number') ? trim($request->slot_number) : null;

        if ($slotNumber) {
            $exists = Appoinment::whereDate('appointment_scheduled_date', $date)
                ->where('slot_number', $slotNumber)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['slot_number' => "Slot {$slotNumber} is already booked for " . \Carbon\Carbon::parse($date)->format('d M Y') . ". Please select another slot."])
                    ->with('error', "Slot {$slotNumber} is already booked on this date.");
            }
        }

        $wasOnSite = ($appointment->appointment_type === 'on_site' || empty($appointment->appointment_type));
        $isFullyScheduled = !empty($date) && !empty($slotNumber);

        if ($wasOnSite && $isFullyScheduled) {
            $appointment->appointment_type = 'admin';
        }

        $appointment->appointment_scheduled_date = $date;
        $appointment->slot_number = $slotNumber;
        $appointment->save();

        $mailSent = false;
        if (!empty($appointment->mail) && filter_var($appointment->mail, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($appointment->mail)->send(new AppointmentScheduledMail($appointment));
                $mailSent = true;
            } catch (\Throwable $e) {
                Log::error("Failed to send appointment schedule email to {$appointment->mail}: " . $e->getMessage());
            }
        }

        $formattedDate = \Carbon\Carbon::parse($appointment->appointment_scheduled_date)->format('d M Y');
        $slotMsg = $slotNumber ? " (Slot: {$slotNumber})" : "";
        $msg = "Appointment for {$appointment->patient_name} scheduled on {$formattedDate}{$slotMsg}";
        if ($wasOnSite && $isFullyScheduled) {
            $msg .= " and moved to Appointments tab.";
        } else {
            $msg .= ".";
        }
        if ($mailSent) {
            $msg .= " Confirmation email sent to {$appointment->mail}.";
        } elseif (!empty($appointment->mail)) {
            $msg .= " (Email could not be delivered, please verify mail configuration).";
        }

        return redirect()->back()->with('success', $msg);
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'appointment_id' => 'nullable|integer',
        ]);

        $date = $request->date;
        $excludeId = $request->appointment_id;

        $nextSlot = Appoinment::calculateNextSlot($date, $excludeId);
        $takenSlots = Appoinment::getTakenSlots($date, $excludeId);

        $batch = 1;
        if (preg_match('/^(\d+)\//', $nextSlot, $m)) {
            $batch = intval($m[1]);
        }

        $batchSlots = [];
        for ($i = 1; $i <= 15; $i++) {
            $slotStr = "{$batch}/{$i}";
            $batchSlots[] = [
                'slot' => $slotStr,
                'is_taken' => in_array($slotStr, $takenSlots),
                'is_suggested' => ($slotStr === $nextSlot),
            ];
        }

        return response()->json([
            'success' => true,
            'date' => $date,
            'formatted_date' => \Carbon\Carbon::parse($date)->format('d M Y'),
            'next_slot' => $nextSlot,
            'taken_slots' => $takenSlots,
            'batch' => $batch,
            'batch_slots' => $batchSlots,
        ]);
    }

    public function toggleDone(Request $request, $id)
    {
        $appointment = Appoinment::findOrFail($id);

        if ($request->has('done')) {
            $appointment->appointment_done = $request->boolean('done');
        } else {
            $appointment->appointment_done = !$appointment->appointment_done;
        }

        $appointment->save();

        return response()->json([
            'success' => true,
            'id' => $appointment->id,
            'appointment_done' => (bool)$appointment->appointment_done,
            'status_label' => $appointment->appointment_done ? 'Done' : 'Pending',
            'message' => $appointment->appointment_done 
                ? "Appointment for {$appointment->patient_name} marked as Done." 
                : "Appointment for {$appointment->patient_name} marked as Pending."
        ]);
    }

    public function deleteAppointment($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment deleted successfully.');
    }
}
