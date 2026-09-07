<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientClinicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.admin_login');
    }

    public function systemLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $email = trim($request->email);
        $data = User::where('email', $email)->first();

        if (!$data) {
            return back()->with('error', 'User not found.');
        }

        if ($data->role == "super_admin") {
            if (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            } else {
                return back()->with('error', 'Invalid Credantials');
            }
        } else if($data->role == "doctor"){

                if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    $request->session()->regenerate();
                    return redirect()->route('doctor.dashboard');
                } else {
                    return back()->with('error', 'Invalid Credantials');
                }
            } else {
                return back()->with('error', 'Authentication Fails');
            }

    }


    public function dashboard()
    {
        $doctors = User::where('role', 'doctor')->count();
        $patients = Patient::count();
        $allPatient = Patient::paginate(10);
        $diabetes = PatientClinicalRecord::where('diabetes', 'Diabetes')->count();
        $hypertension = PatientClinicalRecord::where('hypertension', 'Hypertension')->count();
        $obesity = PatientClinicalRecord::where('obesity', 'Obesity')->count();
        $infection = PatientClinicalRecord::where('infection', 'Infection')->count();

        return view('admin.backend.dashboard', compact('doctors', 'patients', 'diabetes', 'hypertension', 'obesity', 'infection', 'allPatient'));
    }

    public function AdminLogout(Request $request)
    {
        if (Auth::guard('super_admin')->check()) {
            Auth::guard('super_admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }

    public function doctorLogout(Request $request)
    {
        if (Auth::guard('doctor')->check()) {
            Auth::guard('doctor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }

    public function settings()
    {
        $user = Auth::guard('super_admin')->user() ?? Auth::guard('doctor')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('admin.settings.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('super_admin')->user() ?? Auth::guard('doctor')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|max:32|confirmed',
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match our records.');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'New password cannot be the same as your current password.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your password has been changed successfully!');
    }
}
