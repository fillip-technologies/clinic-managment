<?php

namespace App\Http\Controllers\Backend;

use App\Events\DoctorRegEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorManageController extends Controller
{
    public function doctorList(){
        return view('admin.backend.doctors.index');
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
            return back()->with('success','Doctor Account Created SuccessFully');
          }else{
            return back()->with('error','Something went wrong');
          }
    }
}
