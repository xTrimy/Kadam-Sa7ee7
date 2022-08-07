<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientRecord;
use Illuminate\Http\Request;

class PatientRecordController extends Controller
{
    public function create($id){
        $patient = Patient::find($id);
        return view('patient_records.add', compact('patient'));
    }
    
    public function store(Request $request, $id){
        $patient = Patient::find($id);
        // data is 'record_type', 'record_date', 'record_description','is_checked','supplied','checked_by','record_photo', 'record_notes','operation_date'

        $patient_record = new PatientRecord();
        $patient_record->record_type = $request->record_type??null;
        $patient_record->record_date = date('Y-m-d',strtotime($request->record_date))??null;
        $patient_record->record_description = $request->record_description??null;
        $patient_record->is_checked = $request->is_checked?1:0;
        $patient_record->supplied = $request->supplied?1:0;
        $patient_record->checked_by = $request->checked_by??null;
        $patient_record->record_photo = $request->record_photo??null;
        $patient_record->record_notes = $request->record_notes??null;
        $patient_record->operation_date = $request->operation_date? date('Y-m-d',strtotime($request->operation_date)):null;
        $patient_record->patient_id = $id;
        $patient_record->checked_by = auth()->user()->id;
        $patient_record->save();
        
        
        return redirect()->back()->with('success', __('Record added successfully'));
    }
}
