<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    public function all(){
        $hospitals = \App\Models\Hospital::all();
        return $hospitals;
    }

    public function get($id){
        $hospital = \App\Models\Hospital::find($id);
        if(!$hospital){
            $response['response'] = 'Hospital not found';
            $response['success'] = false;
            return $response;
        }
        return $hospital;
    }

    public function add(Request $request){
        $rules = [
            'name' => 'required|string',
            'governorate_id' => 'required|integer|exists:governorates,id',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $hospital = new \App\Models\Hospital();
        $hospital->name = $request->name;
        $hospital->governorate_id = $request->governorate_id;
        $hospital->save();
        $response['response'] = 'Hospital added successfully';
        $response['data'] = $hospital;
        $response['success'] = true;
        return $response;
    }

    public function edit(Request $request, $id){
        $rules = [
            'name' => 'required|string',
            'governorate_id' => 'required|integer|exists:governorates,id',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $hospital = \App\Models\Hospital::find($id);
        if(!$hospital){
            $response['response'] = 'Hospital not found';
            $response['success'] = false;
            return $response;
        }
        $hospital->name = $request->name;
        $hospital->governorate_id = $request->governorate_id;
        $hospital->save();
        $response['response'] = 'Hospital updated successfully';
        $response['success'] = true;
        return $response;
    }

    public function delete($id){
        $hospital = \App\Models\Hospital::find($id);
        if(!$hospital){
            $response['response'] = 'Hospital not found';
            $response['success'] = false;
            return $response;
        }
        $hospital->delete();
        $response['response'] = 'Hospital deleted successfully';
        $response['success'] = true;
        return $response;
    }

    public function getHospitalsByGovernorate($id){
        $hospitals = \App\Models\Hospital::where('governorate_id', $id)->get();
        return $hospitals;
    }


}
