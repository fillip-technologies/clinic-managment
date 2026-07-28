<?php

use Illuminate\Support\Facades\Auth;


if(!function_exists('AdminLogin')){
    function AdminLogin(){
        if(Auth::guard('super_admin')->check()){
            $data = Auth::guard('super_admin')->user();
            return $data;
        }else{
            return redirect()->route('login');
        }
    }
}


if(!function_exists('DoctorLogin')){
    function DoctorLogin(){
        if(Auth::guard('doctor')->check()){
            $data = Auth::guard('doctor')->user();
            return $data;
        }else{
            return redirect()->route('login');
        }
    }
}
