<?php

namespace App\Http\Controllers\Backend;

use App\Events\DoctorRegEvent;
use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorManageController extends Controller
{
    public function doctorList(){
        $doctors = User::where('role',"!=",'super_admin')->paginate(10);
        return view('admin.backend.doctors.index',compact('doctors'));
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
            'role'=>'required|in:doctor,super_admin',
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
            'role' => 'required|in:doctor,super_admin',
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
        $doctor->save();

        return redirect()->back()->with('success', 'Doctor updated successfully.');
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
            'age'              => 'nullable|numeric|min:0|max:150',
            'patient_type'     => 'required|string|in:N,ON,DMF,NDM,NM,NMDM,complimentry,Complimentry',
            'phone'            => 'required|string|max:20',
            'mail'             => 'nullable|email|max:255',
            'message'          => 'nullable|string',
            'appointment_type' => 'nullable|string|in:on_site,admin',
        ]);

        $appointmentType = $request->appointment_type;
        if (empty($appointmentType)) {
            $appointmentType = ($request->is('admin/*') || str_contains(url()->previous() ?? '', 'admin')) ? 'admin' : 'on_site';
        }

        $patientType = strtolower($request->patient_type) === 'complimentry' ? 'complimentry' : $request->patient_type;

        $appointment = Appoinment::create([
            'patient_name'     => $request->patient_name,
            'age'              => $request->age,
            'patient_type'     => $patientType,
            'appointment_type' => $appointmentType,
            'phone'            => $request->phone,
            'mail'             => $request->mail,
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
        $query = Appoinment::latest();
        if ($request->filled('type')) {
            if ($request->type === 'on_site') {
                $query->where(function ($q) {
                    $q->where('appointment_type', 'on_site')->orWhereNull('appointment_type');
                });
            } else {
                $query->where('appointment_type', $request->type);
            }
        }
        $appointments = $query->get();
        $prefix = $request->type === 'on_site' ? 'onsite_' : ($request->type === 'admin' ? 'admin_' : '');
        $filename = $prefix . 'appointments_export_' . date('Y-m-d_His') . '.csv';

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
                'Patient Name',
                'Age',
                'Phone',
                'Email',
                'Visit Type',
            ];
            if (!$isAdmin) {
                $headers[] = 'Note / Message';
            }
            $headers[] = 'Booking Date';

            fputcsv($handle, $headers);

            foreach ($appointments as $index => $app) {
                $row = [
                    $index + 1,
                    $app->patient_name ?? 'N/A',
                    $app->age ? $app->age . ' yrs' : '-',
                    $app->phone ?? '-',
                    $app->mail ?? '-',
                    $app->patient_type ?? '-',
                ];
                if (!$isAdmin) {
                    $row[] = $app->message ?? '-';
                }
                $row[] = $app->created_at ? $app->created_at->format('d M Y, h:i A') : '-';

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function deleteAppointment($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment deleted successfully.');
    }
}
