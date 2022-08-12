<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\Supply;
use Illuminate\Http\Request;

class PatientRecordController extends Controller
{
    public function create($id){
        $supplies = Supply::all();
        $patient = Patient::with('hospital')->find($id);
        return view('patient_records.add', compact('patient', 'supplies'));
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
        $patient_record->checked_by = $request->checked_by??null;
        $patient_record->record_photo = $request->record_photo??null;
        $patient_record->record_notes = $request->record_notes??null;
        $patient_record->operation_date = $request->operation_date? date('Y-m-d',strtotime($request->operation_date)):null;
        $patient_record->patient_id = $id;
        $patient_record->created_by = auth()->user()->id;
        $patient_record->save();

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
        
        
        return redirect()->back()->with(['success'=>__('Record added successfully'), 'supply_errors'=>$errors]);
    }
}
