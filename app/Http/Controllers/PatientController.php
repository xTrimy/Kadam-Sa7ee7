<?php

namespace App\Http\Controllers;

use App\Models\ChronicDisease;
use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\ImageOptimizer\OptimizerChainFactory;


class PatientController extends Controller
{
    public function index(){
        $patients = Patient::with(['chronic_diseases','hospital'])->paginate(15);
        return view('patients.view',compact('patients'));
    }
    public function view_single($id){
        $patient = Patient::with(['chronic_diseases','hospital','user'])->findOrFail($id);
        return view('patients.single',compact('patient'));
    }

    public function create()
    {
        $hospitals = Hospital::all();
        $chronic_diseases = ChronicDisease::all();
        return view('patients.add', compact('hospitals', 'chronic_diseases'));
    }

    public function view_api(){
        $patients = Patient::with(['chronic_diseases','hospital'])->paginate('15');
        return $patients;
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'phone' => 'required|string|unique:patients',
            'address' => 'required|string',
            'national_id' => 'required|string',
            'birth_date' => 'required|date',
            'national_id_photo_face' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'national_id_photo_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'chronic_disease' => 'nullable|array',
            'chronic_disease.*' => 'required|string',
        ];
        $request->validate($rules);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->national_id = $request->national_id;
        $patient->birth_date = date('Y-m-d', strtotime($request->birth_date));
        $patient->national_id_photo_face = $request->national_id_photo_face ?? null;
        $patient->national_id_photo_back = $request->national_id_photo_back ?? null;
        $patient->created_by = $request->user()->id;
        $patient->hospital_id = $request->hospital_id;

        //national_id_photo_face
        if ($request->hasFile('national_id_photo_face')) {
            $file = $request->file('national_id_photo_face');
            $name = time() . '_' . $file->getClientOriginalName();
            //move to storage/
            Storage::disk('public')->put($name, file_get_contents($file));
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/') . $name);

            //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
            $image = imagecreatefromjpeg(storage_path('app/public/') . $name);
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width > 500 || $height > 500) {
                $new_width = 500;
                $new_height = 500;
                //keep aspect ratio
                if ($width > $height) {
                    $new_height = $height * ($new_width / $width);
                } else {
                    $new_width = $width * ($new_height / $height);
                }
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($new_image, storage_path('app/public/') . $name);
            }

            $patient->national_id_photo_face = $name;
        }
        //national_id_photo_back
        if ($request->hasFile('national_id_photo_back')) {
            $file = $request->file('national_id_photo_back');
            $name = time() . '_' . $file->getClientOriginalName();
            //move to storage/
            Storage::disk('public')->put($name, file_get_contents($file));
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/') . $name);

            //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
            $image = imagecreatefromjpeg(storage_path('app/public/') . $name);
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width > 500 || $height > 500) {
                $new_width = 500;
                $new_height = 500;
                //keep aspect ratio
                if ($width > $height) {
                    $new_height = $height * ($new_width / $width);
                } else {
                    $new_width = $width * ($new_height / $height);
                }
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($new_image, storage_path('app/public/') . $name);
            }

            $patient->national_id_photo_back = $name;
        }
        $patient->save();

        //chronic_disease
        $chronic_diseases = implode(',', $request->chronic_disease);
        $chronic_diseases = explode(',', $chronic_diseases);
        foreach ($chronic_diseases  as $disease) {
            $chronic_disease = \App\Models\ChronicDisease::where('name', $disease)->first();
            if (!$chronic_disease) {
                $chronic_disease = new \App\Models\ChronicDisease();
                $chronic_disease->name = $disease;
                $chronic_disease->created_by = $request->user()->id;
                $chronic_disease->save();
            }
            $patient->chronic_diseases()->attach($chronic_disease->id);
        }
        return redirect()->route('dashboard.patients')->with('success', __('Patient added successfully'));
    }

    public function search(Request $request){
        $keyword = $request->q;
        $patients = Patient::with(['chronic_diseases','hospital'])->where('name', 'like', '%' . $keyword . '%')->orWhere('phone', 'like', '%' . $keyword . '%')->orWhere('national_id', 'like', '%' . $keyword . '%')->paginate(15);
        return view('patients.view', compact('patients'));
    }

    public function add_api(Request $request){
        $rules = [
            'name' => 'required|string',
            'phone' => 'required|string|unique:patients',
            'address' => 'required|string',
            'national_id' => 'required|string',
            'birth_date' => 'required|date',
            'national_id_photo_face' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'national_id_photo_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'chronic_disease' => 'nullable|array',
            'chronic_disease.*' => 'required|string',
        ];


        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->national_id = $request->national_id;
        $patient->birth_date = date('Y-m-d',strtotime($request->birth_date));
        $patient->national_id_photo_face = $request->national_id_photo_face??null;
        $patient->national_id_photo_back = $request->national_id_photo_back??null;
        $patient->created_by = $request->user()->id;
        $patient->hospital_id = $request->hospital_id;

        //national_id_photo_face
        if($request->hasFile('national_id_photo_face')){
            $file = $request->file('national_id_photo_face');
            $name = time().'_'.$file->getClientOriginalName();
            //move to storage/
            Storage::disk('public')->put($name, file_get_contents($file));
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/').$name);

            //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
            $image = imagecreatefromjpeg(storage_path('app/public/') . $name);
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width > 500 || $height > 500) {
                $new_width = 500;
                $new_height = 500;
                //keep aspect ratio
                if ($width > $height) {
                    $new_height = $height * ($new_width / $width);
                } else {
                    $new_width = $width * ($new_height / $height);
                }
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($new_image, storage_path('app/public/') . $name);
            }

            $patient->national_id_photo_face = $name;

        }
        //national_id_photo_back
        if($request->hasFile('national_id_photo_back')){
            $file = $request->file('national_id_photo_back');
            $name = time().'_'.$file->getClientOriginalName();
            //move to storage/
            Storage::disk('public')->put($name, file_get_contents($file));
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/') . $name);

            //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
            $image = imagecreatefromjpeg(storage_path('app/public/').$name);
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width > 500 || $height > 500) {
                $new_width = 500;
                $new_height = 500;
                //keep aspect ratio
                if ($width > $height) {
                    $new_height = $height * ($new_width / $width);
                } else {
                    $new_width = $width * ($new_height / $height);
                }
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($new_image, storage_path('app/public/') . $name);
            }

            $patient->national_id_photo_back = $name;
        }
        //chronic_disease

        $patient->save();
        foreach ($request->chronic_disease as $disease) {
            $chronic_disease = \App\Models\ChronicDisease::where('name', $disease)->first();
            if (!$chronic_disease) {
                $chronic_disease = new \App\Models\ChronicDisease();
                $chronic_disease->name = $disease;
                $chronic_disease->created_by = $request->user()->id;
                $chronic_disease->save();
            }
            $patient->chronic_diseases()->attach($chronic_disease->id);
        }
        $response['response'] = 'Patient added successfully';
        $response['success'] = true;
        return $response;


    }
    public function edit_api(Request $request, $id){
        $data = ['name','phone','address','national_id','birth_date','national_id_photo_face','national_id_photo_back','hospital_id'];

        $patient = Patient::find($id);
        if(!$patient){
            $response['response'] = 'Patient not found';
            $response['success'] = false;
            return $response;
        }
        $rules = [
            'name' => 'nullable|string',
            'phone' => 'nullable|string|unique:patients,phone,'.$patient->id,
            'address' => 'nullable|string',
            'national_id' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'national_id_photo_face' => 'nullable|string',
            'national_id_photo_back' => 'nullable|string',
        ];
        $response = array('response' => '', 'success' => false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            return $response;
        }
        $data = $request->only($data);
        foreach($data as $key){
            if($request->$key){
                $patient->$key = $request->$key;
            }
        }
        $response['response'] = 'Patient updated successfully';
        $response['success'] = true;
        return $response;
    }

    public function delete_api($id){
        $patient = Patient::find($id);
        $patient->delete();
        $response['response'] = 'Patient deleted successfully';
        $response['success'] = true;
        return $response;
    }

    public function view_single_api($id){
        $patient = Patient::with('chronic_diseases')->find($id);
        if(!$patient){
            $response['response'] = 'Patient not found';
            $response['success'] = false;
            return $response;
        }
        return $patient;
    }

    public function get_records_api($id){
        $patient = Patient::find($id);
        if(!$patient){
            $response['response'] = 'Patient not found';
            $response['success'] = false;
            return $response;
        }
        $records = $patient->records()->get();
        return $records;
    }


    public function download_patient_data($id){
        $patient =  Patient::with([
            'field_research.governorate',
            'field_research.marital_status',
            'field_research.educational_level',
            'chronic_diseases',
            'hospital',
            'records.user',
            'patient_records.supply_transactions.supply'
           ])->find($id);
        $pdf = \PDF::loadView('pdf.patient-report', ['patient' => $patient]);
        return $pdf->download("patient-report-$id.pdf");
    }

    public function download_patient_data_t($id)
    {
        $patient =  Patient::with(['field_research.governorate', 'field_research.marital_status', 'field_research.educational_level','chronic_diseases','hospital','records.user'])->find($id);
        return view('pdf.patient-report', compact('patient'));
    }
}
