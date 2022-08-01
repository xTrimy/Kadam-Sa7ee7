<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GovernorateController extends Controller
{
    public function all(){
        $governorates = \App\Models\Governorate::all();
        return $governorates;
    }

    public function get($id){
        $governorate = \App\Models\Governorate::find($id);
        if(!$governorate){
            $response['response'] = 'Governorate not found';
            $response['success'] = false;
            return $response;
        }
        return $governorate;
    }

    public function add(Request $request){
        $rules = [
            'name' => 'required|string',
            'ar_name' => 'required|string',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $governorate = new \App\Models\Governorate();
        $governorate->name = $request->name;
        $governorate->ar_name = $request->ar_name;
        $governorate->save();
        $response['response'] = 'Governorate added successfully';
        $response['data'] = $governorate;
        $response['success'] = true;
        return $response;
    }

    public function edit(Request $request, $id){
        $rules = [
            'name' => 'required|string',
            'ar_name' => 'required|string',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $governorate = \App\Models\Governorate::find($id);
        if(!$governorate){
            $response['response'] = 'Governorate not found';
            $response['success'] = false;
            return $response;
        }
        $governorate->name = $request->name;
        $governorate->ar_name = $request->ar_name;
        $governorate->save();
        $response['response'] = 'Governorate updated successfully';
        $response['success'] = true;
        return $response;
    }

    public function delete($id){
        $governorate = \App\Models\Governorate::find($id);
        if(!$governorate){
            $response['response'] = 'Governorate not found';
            $response['success'] = false;
            return $response;
        }
        $governorate->delete();
        $response['response'] = 'Governorate deleted successfully';
        $response['success'] = true;
        return $response;
    }


}
