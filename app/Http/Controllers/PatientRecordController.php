<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PatientRecordController extends Controller
{
    public function create($id){
        $supplies = Supply::all();
        $patient = Patient::with('hospital')->find($id);
        
        // doctors and nurses
        $doctors = $patient->hospital->doctors()->get();
        $nurses = $patient->hospital->nurses()->get();

        return view('patient_records.add', compact('patient', 'supplies', 'doctors', 'nurses'));
    }
    
    public function store(Request $request, $id){
        $errors = [];
        $patient = Patient::find($id);
        // data is 'record_type', 'record_date', 'record_description','is_checked','supplied','checked_by','record_photo', 'record_notes','operation_date'
        $patient_record = new PatientRecord();
        $patient_record->record_type = $request->record_type??null;
        $patient_record->record_date = date('Y-m-d',strtotime($request->record_date))??null;
        $patient_record->record_description = $request->record_description??null;
        $patient_record->is_checked = $request->is_checked?1:0;
        $patient_record->supplied = $request->supplied?1:0;
        // $patient_record->checked_by = $request->checked_by??null;
       
        $patient_record->record_notes = $request->record_notes??null;
        $patient_record->operation_date = $request->operation_date? date('Y-m-d',strtotime($request->operation_date)):null;
        $patient_record->patient_id = $id;
        $patient_record->doctor_id = $request->doctor_id ?? null;
        if ($request->extra_doctor_name != null && $request->extra_doctor_name != '') {
            $doctor = new Doctor();
            $doctor->name = $request->extra_doctor_name;
            $doctor->hospital_id = $patient->hospital->id;
            $doctor->save();
            $patient_record->doctor_id = $doctor->id;
        }

        $patient_record->nurse_id = $request->nurse_id ?? null;
        if ($request->extra_nurse_name != null && $request->extra_nurse_name != '') {
            $nurse = new Nurse();
            $nurse->name = $request->extra_nurse_name;
            $nurse->hospital_id = $patient->hospital->id;
            $nurse->save();
            $patient_record->nurse_id = $nurse->id;
        }
        $patient_record->created_by = auth()->user()->id;
        // record_photo
        if($request->hasFile('record_photo')){
            $file = $request->file('record_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/patient_records'), $filename);
            $patient_record->record_photo = $filename;
        }
        // wound_image
        // if($request->hasFile('wound_image')){
        //     $file = $request->file('wound_image');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/patient_records'), $filename);
        //     $patient_record->wound_image = $filename;
        // }
        if($request->hasFile('medication_photo')){
            $file = $request->file('medication_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/patient_records'), $filename);
            $patient_record->medication_form = $filename;
        }
        $patient_record->save();

        // supplies used in clinic (no transaction)
        $supplies_in_clinic_ids = $request->supply_used_in_clinic_id;
        $supplies_in_clinic_quantities = $request->supply_used_in_clinic_quantity;
        $supplies_in_clinic_ids = array_combine($supplies_in_clinic_ids, $supplies_in_clinic_quantities);
        foreach ($supplies_in_clinic_ids as $supply_id => $quantity) {
            if ($quantity == 0) {
                continue;
            }
            $supply = \App\Models\HospitalSupply::where('supply_id', $supply_id)->where('hospital_id', $patient->hospital->id)->first();
            if ($supply == null) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->quantity -= $quantity;
            if ($supply->quantity < 0) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->save();
        }

        // Supply to patient outside clinic
        $supplies_ids = $request->supply_id;
        $quantities = $request->quantity;
        $supplies_ids = array_combine($supplies_ids, $quantities);
        foreach ($supplies_ids as $supply_id => $quantity) {
            if ($quantity == 0) {
                continue;
            }
            $supply = \App\Models\HospitalSupply::where('supply_id', $supply_id)->where('hospital_id', $patient->hospital->id)->first();
            if ($supply == null) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->quantity -= $quantity;
            if ($supply->quantity < 0) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->save();
            $patient_supply = \App\Models\PatientSupply::where('supply_id', $supply_id)->where('patient_id', $id)->first();
            if ($patient_supply == null) {
                $patient_supply = new \App\Models\PatientSupply();
                $patient_supply->patient_id = $id;
                $patient_supply->supply_id = $supply_id;
            }
            $patient_supply->quantity += intval($quantity);
            $patient_supply->save();
            // Add new transaction 
            $transaction = new \App\Models\SupplyTransaction();
            $transaction->patient_id = $id;
            $transaction->supply_id = $supply_id;
            $transaction->quantity = $quantity;
            $transaction->patient_record_id = $patient_record->id;
            $transaction->save();
        }
        // check difference between created_at and record_date
        $diff = $patient_record->created_at->diffInDays($patient_record->record_date);
        if ($diff > 0) {
            // notify admin that it is not the same day
            $admins = User::role('admin')->get();
            Notification::send($admins, new \App\Notifications\RecordDateNotSameAsCreatedDate($patient_record,auth()->user()));
        }
        
        return redirect()->back()->with(['success'=>__('Record added successfully'), 'supply_errors'=>$errors]);
    }

    public function edit($id,$record_id){
        $patient_record = PatientRecord::with(['doctor','nurse'])->find($record_id);
        $patient = Patient::find($id);
        $supplies = Supply::all();

        // doctors and nurses
        $doctors = $patient->hospital->doctors()->get();
        $nurses = $patient->hospital->nurses()->get();
        return view('patient_records.add', compact('patient_record', 'patient', 'supplies', 'doctors', 'nurses'));
    }

    public function update(Request $request, $id, $record_id){
        $errors = [];
        $patient = Patient::find($id);
        // data is 'record_type', 'record_date', 'record_description','is_checked','supplied','checked_by','record_photo', 'record_notes','operation_date'
        $patient_record = PatientRecord::find($record_id);
        $patient_record->record_type = $request->record_type??null;
        $patient_record->record_date = date('Y-m-d',strtotime($request->record_date))??null;
        $patient_record->record_description = $request->record_description??null;
        $patient_record->is_checked = $request->is_checked?1:0;
        $patient_record->supplied = $request->supplied?1:0;
        // $patient_record->checked_by = $request->checked_by??null;

        $patient_record->doctor_id = $request->doctor_id ?? null;
        if ($request->extra_doctor_name != null && $request->extra_doctor_name != ''){
            $doctor = new Doctor();
            $doctor->name = $request->extra_doctor_name;
            $doctor->hospital_id = $patient->hospital->id;
            $doctor->save();
            $patient_record->doctor_id = $doctor->id;
        }

        $patient_record->nurse_id = $request->nurse_id??null;
        if ($request->extra_nurse_name != null && $request->extra_nurse_name != ''){
            $nurse = new Nurse();
            $nurse->name = $request->extra_nurse_name;
            $nurse->hospital_id = $patient->hospital->id;
            $nurse->save();
            $patient_record->nurse_id = $nurse->id;
        }
        $patient_record->record_notes = $request->record_notes??null;
        $patient_record->operation_date = $request->operation_date? date('Y-m-d',strtotime($request->operation_date)):null;
        $patient_record->patient_id = $id;
        $patient_record->created_by = auth()->user()->id;
        // record_photo and wound_image
        if($request->hasFile('record_photo')){
            $file = $request->file('record_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/patient_records'), $filename);
            $patient_record->record_photo = $filename;
        }
        // if($request->hasFile('wound_image')){
        //     $file = $request->file('wound_image');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('uploads/patient_records'), $filename);
        //     $patient_record->wound_image = $filename;
        // }

        if ($request->hasFile('medication_photo')) {
            $file = $request->file('medication_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/patient_records'), $filename);
            $patient_record->medication_form = $filename;
        }
        
        $patient_record->save();

        // supplies used in clinic (no transaction)
        $supplies_in_clinic_ids = $request->supply_used_in_clinic_id;
        $supplies_in_clinic_quantities = $request->supply_used_in_clinic_quantity;
        $supplies_in_clinic_ids = array_combine($supplies_in_clinic_ids, $supplies_in_clinic_quantities);
        foreach ($supplies_in_clinic_ids as $supply_id => $quantity) {
            if ($quantity == 0) {
                continue;
            }
            $supply = \App\Models\HospitalSupply::where('supply_id', $supply_id)->where('hospital_id', $patient->hospital->id)->first();
            if ($supply == null) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->quantity -= $quantity;
            if ($supply->quantity < 0) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->save();
        }


        // Supply to patient outside clinic
        $supplies_ids = $request->supply_id;
        $quantities = $request->quantity;
        $supplies_ids = array_combine($supplies_ids, $quantities);
        foreach ($supplies_ids as $supply_id => $quantity) {
            if ($quantity == 0) {
                continue;
            }
            $supply = \App\Models\HospitalSupply::where('supply_id', $supply_id)->where('hospital_id', $patient->hospital->id)->first();
            if ($supply == null) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]); 
                continue;
            }
            $supply->quantity -= $quantity;
            if ($supply->quantity < 0) {
                $errors[] = __('Supply ":supply" could not be updated. Main stock is not enough', ['supply' => $supply->name]);
                continue;
            }
            $supply->save();
            $patient_supply = \App\Models\PatientSupply::where('supply_id', $supply_id)->where('patient_id', $id)->first();
            if ($patient_supply == null) {
                $patient_supply = new \App\Models\PatientSupply();
                $patient_supply->patient_id = $id;
                $patient_supply->supply_id = $supply_id;
            }
            $patient_supply->quantity += intval($quantity);
            $patient_supply->save();
            // Add new transaction
            $transaction = new \App\Models\SupplyTransaction();
            $transaction->patient_id = $id;
            $transaction->supply_id = $supply_id;
            $transaction->quantity = $quantity;
            $transaction->patient_record_id = $patient_record->id;
            $transaction->save();
        }
        return redirect()->back()->with(['success'=>__('Record updated successfully'), 'supply_errors'=>$errors]);
    }

}
