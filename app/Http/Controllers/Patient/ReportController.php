<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\DoctorData;
use App\Models\PatientClinicalRecord;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function diabetesReport()
    {
        $records = PatientClinicalRecord::with(['patient'])->where('diabetes', 'Diabetes')->get();
        return view('admin.reports.diabetes', compact('records'));
    }

    public function obesityReport()
    {
        $records = PatientClinicalRecord::with(['patient'])->where('obesity', 'Obesity')->get();
        return view('admin.reports.obesity', compact('records'));
    }

    public function hypertensioReport()
    {
        $records = PatientClinicalRecord::with(['patient'])->where('hypertension', 'Hypertension')->get();
        return view('admin.reports.hypertension', compact('records'));
    }

    public function InfectionReport()
    {
        $records = PatientClinicalRecord::with(['patient'])->where('infection', 'Infection')->get();
        return view('admin.reports.infection', compact('records'));
    }

    //doctores access

    public function doctorReportform()
    {
        return view('admin.backend.doctors.upload_doc_rep');
    }
    public function doctorReporlist()
    {
        $datas = DoctorData::all();
        return view('admin.backend.doctors.listdocdata', compact('datas'));
    }

    public function editDocRep($id)
    {
        $data =  DoctorData::findOrFail($id);
        return view('admin.backend.doctors.docrepoedit', compact('data'));
    }

    public function docRepstore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fullname' => 'required|string|max:255',
            'report_type' => 'required|string|max:255',
            'date' => 'required|date',

            'file' => 'nullable|array',
            'file.*' => 'nullable|file',
        ]);

        $files = [];

        if ($request->hasFile('file')) {

            foreach ($request->file('file') as $upload) {

                $filename = time() . '_' . uniqid() . '.' . $upload->getClientOriginalExtension();

                $upload->move(public_path('uploads/reports'), $filename);

                $files[] = $filename;
            }
        }

        DoctorData::create([
            'user_id' => $request->user_id,
            'fullname' => $request->fullname,
            'report_type' => $request->report_type,
            'date' => $request->date,
            'file' => json_encode($files),
        ]);

        return redirect()->route('doctorReporlist')
            ->with('success', 'Report Created Successfully.');
    }


    public function DocRepupdate(Request $request, $id)
    {
        $report = DoctorData::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fullname' => 'required|string|max:255',
            'report_type' => 'required|string|max:255',
            'date' => 'required|date',

            'file' => 'nullable|array',
            'file.*' => 'nullable|file',
        ]);

        $files = [];

        if (!empty($report->file)) {
            $files = json_decode($report->file, true);

            if (!is_array($files)) {
                $files = [];
            }
        }


        if ($request->hasFile('file')) {


            foreach ($files as $oldFile) {
                $path = public_path('uploads/reports/' . $oldFile);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $files = [];

            foreach ($request->file('file') as $upload) {

                $filename = time() . '_' . uniqid() . '.' . $upload->getClientOriginalExtension();

                $upload->move(public_path('uploads/reports'), $filename);

                $files[] = $filename;
            }
        }

        $report->update([
            'user_id' => $request->user_id,
            'fullname' => $request->fullname,
            'report_type' => $request->report_type,
            'date' => $request->date,
            'file' => json_encode($files),
        ]);

        return redirect()->route('doctorReporlist')
            ->with('success', 'Report Updated Successfully.');
    }

    public function DocRepodestroy($id)
    {
        $report = DoctorData::findOrFail($id);

        $files = [];

        if (!empty($report->file)) {

            $files = json_decode($report->file, true);

            if (!is_array($files)) {
                $files = [$report->file];
            }
        }

        foreach ($files as $file) {

            $path = public_path('uploads/reports/' . $file);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $report->delete();

        return back()->with('success', 'Report Deleted Successfully.');
    }
}
