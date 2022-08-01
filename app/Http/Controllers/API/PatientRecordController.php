<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientRecordController extends Controller
{


    public function all(){
        $patientRecords = \App\Models\PatientRecord::all();
        return $patientRecords;
    }

    public function get($id){
        $patientRecord = \App\Models\PatientRecord::find($id);
        if(!$patientRecord){
            $response['response'] = 'Patient record not found';
            $response['success'] = false;
            return $response;
        }
        return $patientRecord;
    }

    public function add(Request $request){
        $rules = [
            'patient_id' => 'required|integer|exists:patients,id',
            'notes' => 'nullable|string',
            'record_type' => 'required|string',
            'record_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'record_description' => 'nullable|string',
            'operation_date' => 'nullable|date',
            'date' => 'nullable|datetime',
            'is_checked' => 'nullable|boolean',
            'is_supplied' => 'nullable|boolean',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $patientRecord = new \App\Models\PatientRecord();
        $patientRecord->patient_id = $request->patient_id;
        $patientRecord->record_notes = $request->notes;
        $patientRecord->record_type = $request->record_type;
        if($request->hasFile('record_photo')){
            $image = $request->file('record_photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $patientRecord->record_photo = $name;
        }
        $patientRecord->record_description = $request->record_description??null;
        $patientRecord->operation_date = $request->operation_date??null;
        $patientRecord->record_date = $request->date??date('Y-m-d H:i:s');
        $patientRecord->is_checked = $request->is_checked??null;
        $patientRecord->supplied = $request->is_supplied??null;
        $patientRecord->created_by = $request->user()->id;
        if($patientRecord->is_checked){
            $patientRecord->checked_by = $request->user()->id;
        }
        $patientRecord->save();
        return $patientRecord;
    }


    public function delete($id){
        $patientRecord = \App\Models\PatientRecord::find($id);
        if(!$patientRecord){
            $response['response'] = 'Patient record not found';
            $response['success'] = false;
            return $response;
        }
        $patientRecord->delete();
        $response['response'] = 'Patient record deleted';
        $response['success'] = true;
        return $response;
    }




}
