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

        $appointment = Appoinment::create([
            'patient_name'     => $request->patient_name,
            'father_name'      => $request->father_name,
            'age'              => $request->age,
            'patient_type'     => $patientType,
            'appointment_type' => $appointmentType,
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

        // Only sort ascending by date when performing Export by Date; general export retains latest (desc)
        if ($isExportByDate) {
            if ($dateField === 'appointment_scheduled_date') {
                $query->orderBy('appointment_scheduled_date', 'asc')->orderBy('created_at', 'asc');
            } else {
                $query->orderBy('created_at', 'asc');
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
            $headers[] = 'Scheduled Date';

            fputcsv($handle, $headers);

            foreach ($appointments as $index => $app) {
                $row = [
                    $index + 1,
                    $app->created_at ? $app->created_at->format('d M Y, h:i A') : '-',
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
                $row[] = $app->appointment_scheduled_date ? \Carbon\Carbon::parse($app->appointment_scheduled_date)->format('d M Y') : 'Not Scheduled';

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function scheduleAppointment(Request $request, $id)
    {
        $request->validate([
            'appointment_scheduled_date' => 'required|date',
        ]);

        $appointment = Appoinment::findOrFail($id);
        $appointment->appointment_scheduled_date = $request->appointment_scheduled_date;
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
        $msg = "Appointment for {$appointment->patient_name} scheduled on {$formattedDate}.";
        if ($mailSent) {
            $msg .= " Confirmation email sent to {$appointment->mail}.";
        } elseif (!empty($appointment->mail)) {
            $msg .= " (Email could not be delivered, please verify mail configuration).";
        }

        return redirect()->back()->with('success', $msg);
    }

    public function deleteAppointment($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment deleted successfully.');
    }
}
