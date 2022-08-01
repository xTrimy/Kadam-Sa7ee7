<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChronicDiseaseController extends Controller
{
    public function all(){
        $chronicDiseases = \App\Models\ChronicDisease::all();
        return $chronicDiseases;
    }

    public function get($id){
        $chronicDisease = \App\Models\ChronicDisease::find($id);
        if(!$chronicDisease){
            $response['response'] = 'Chronic disease not found';
            $response['success'] = false;
            return $response;
        }
        return $chronicDisease;
    }

    public function add(Request $request){
        $rules = [
            'name' => 'required|string',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $chronicDisease = new \App\Models\ChronicDisease();
        $chronicDisease->name = $request->name;
        $chronicDisease->save();
        $response['response'] = 'Chronic disease added successfully';
        $response['data'] = $chronicDisease;
        $response['success'] = true;
        return $response;
    }

    public function edit(Request $request, $id){
        $rules = [
            'name' => 'required|string',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $chronicDisease = \App\Models\ChronicDisease::find($id);
        $chronicDisease->name = $request->name;
        $chronicDisease->save();
        $response['response'] = 'Chronic disease added successfully';
        $response['data'] = $chronicDisease;
        $response['success'] = true;
        return $response;
    }

    public function delete($id){
        $chronicDisease = \App\Models\ChronicDisease::find($id);
        if(!$chronicDisease){
            $response['response'] = 'Chronic disease not found';
            $response['success'] = false;
            return $response;
        }
        $chronicDisease->delete();
        $response['response'] = 'Chronic disease deleted successfully';
        $response['success'] = true;
        return $response;
    }


}
