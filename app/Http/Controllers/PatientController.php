<?php

namespace App\Http\Controllers;

use App\Models\ChronicDisease;
use App\Models\FieldResearchInput;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\PatientTransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\ImageOptimizer\OptimizerChainFactory;


class PatientController extends Controller
{
    public function index(){
        $count = Patient::count();

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')){
            $patients = Patient::with(['chronic_diseases', 'hospital'])->paginate(15);
            return view('patients.view', compact('patients', 'count'));

        }else{
            $hospital = auth()->user()->hospitals()->first();
            $patients = $hospital->patients()->paginate(15);
            return view('patients.view', compact('patients', 'count', 'hospital'));
        }
    }
    public function view_single($id){
        $patient = Patient::with(['chronic_diseases','hospital','user'])->findOrFail($id);
        return view('patients.single',compact('patient'));
    }
    public function add_national_id(){
        return view('patients.add_ID_number');
    }

    // check_national_id to check if national id exists in the database
    // if exists redirect to view_single page with patient's data
    // if not exists redirect to create new patient page
    public function check_national_id(Request $request){
        $patient = Patient::where('national_id', $request->national_id)->first();
        if($patient){
            Session::flash('error', __('Patient already exists'));
            return redirect()->route('dashboard.patientsview_single', $patient->id);
        }else{
            Session::flash('national_id', $request->national_id);
            $national_data = extract_data_from_national_id($request->national_id);
            if($national_data){
                Session::flash('national_data', $national_data);
            }else{
                return redirect()->back()->with('error', __('Invalid national id'));
            }
            return redirect()->route('dashboard.patients.create_new');
        }
    }

    public function create()
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')){
            $hospitals = Hospital::all();
        }else{
            $hospitals = auth()->user()->hospitals()->get();
        }
        $chronic_diseases = ChronicDisease::all();
        return view('patients.add', compact('hospitals', 'chronic_diseases'));
    }

    public function view_api(){
        $patients = Patient::with(['chronic_diseases','hospital'])->paginate('15');
        return $patients;
    }

    public function transfer_request($id){
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')){
            return route('dashboard.patients');
        }
        $patient = Patient::findOrFail($id);
        $hospital = auth()->user()->hospitals()->first();
        if($patient->hospital->id == $hospital->id){
            return redirect()->back()->with('error', __('You can not transfer to the same hospital'));
        }
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "manager")->orWhere("name", "admin");
        })->get();
        Notification::sendNow($users, new PatientTransferRequest($patient, $hospital,auth()->user()));
        return redirect()->back()->with('success', __('Transfer request sent successfully'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'phone' => 'nullable|string|unique:patients',
            'address' => 'required|string',
            'national_id' => 'required|string|unique:patients,national_id',
            'birth_date' => 'required|date',
            'national_id_photo_face' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'national_id_photo_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'chronic_disease' => 'nullable|array',
            'gender' => 'required|boolean',
        ];
        $request->validate($rules);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->gender = $request->gender;
        $patient->national_id = $request->national_id;
        $patient->birth_date = date('Y-m-d', strtotime($request->birth_date));
        $patient->national_id_photo_face = $request->national_id_photo_face ?? null;
        $patient->national_id_photo_back = $request->national_id_photo_back ?? null;
        $patient->created_by = $request->user()->id;
        $patient->hospital_id = $request->hospital_id;
        if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')){
            $patient->hospital_id = auth()->user()->hospitals()->first()->id;
        }
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

    public function edit($id)
    {
        $hospitals = Hospital::all();
        $chronic_diseases = ChronicDisease::all();
        $patient = Patient::with(['chronic_diseases','hospital'])->find($id);
        return view('patients.add', compact('patient', 'hospitals', 'chronic_diseases'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'phone' => 'nullable|string|unique:patients,phone,' . $id,
            'address' => 'required|string',
            'national_id' => 'required|string|unique:patients,national_id,' . $id,
            'birth_date' => 'required|date',
            'national_id_photo_face' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'national_id_photo_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'chronic_disease' => 'nullable|array',
            'gender' => 'required|boolean'
        ];
        $request->validate($rules);
        $patient = Patient::find($id);
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->gender = $request->gender;
        $patient->national_id = $request->national_id;
        $patient->birth_date = date('Y-m-d', strtotime($request->birth_date));
        $patient->national_id_photo_face = $request->national_id_photo_face ?? null;
        $patient->national_id_photo_back = $request->national_id_photo_back ?? null;
        $patient->hospital_id = $request->hospital_id;
        $patient->save();
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
        $chronic_diseases = $request->chronic_disease ?? [];
        $patient->chronic_diseases()->detach();
        foreach ($chronic_diseases  as $disease) {
            if($disease == null) continue;
            $chronic_disease = \App\Models\ChronicDisease::where('name', $disease)->first();
            if (!$chronic_disease) {
                $chronic_disease = new \App\Models\ChronicDisease();
                $chronic_disease->name = $disease;
                $chronic_disease->created_by = $request->user()->id;
                $chronic_disease->save();
            }
            $patient->chronic_diseases()->attach($chronic_disease->id);
        }
        return redirect()->route('dashboard.patients')->with('success', __('Patient updated successfully'));
    }

    public function search(Request $request){
        
        $keyword = $request->q;
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')){
            $patients = Patient::with(['chronic_diseases', 'hospital'])->where('name', 'like', '%' . $keyword . '%')->orWhere('phone', 'like', '%' . $keyword . '%')->orWhere('national_id', 'like', '%' . $keyword . '%')->paginate(15);
        }else{
            $patients = Patient::with(['chronic_diseases', 'hospital'])->where('name', 'like', '%' . $keyword . '%')->orWhere('phone', 'like', '%' . $keyword . '%')->orWhere('national_id', 'like', '%' . $keyword . '%')->where('hospital_id', auth()->user()->hospitals()->first()->id)->paginate(15);
        }
        $count = $patients->count();
        return view('patients.view', compact('patients','count','keyword'));
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
        ini_set('memory_limit', '-1');
        $patient =  Patient::with([
            'field_research.governorate',
            'field_research.marital_status',
            'field_research.educational_level',
            'chronic_diseases',
            'hospital',
            'records.user',
            'patient_records.supply_transactions.supply'
           ])->find($id);
        if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')){
            if($patient->hospital_id != auth()->user()->hospitals()->first()->id){
                return redirect()->back()->with('error', __('You are not authorized to download this patient data'));
            }
        }
        $inputs = FieldResearchInput::all();
        $pdf = \PDF::loadView('pdf.patient-report', ['patient' => $patient, 'inputs' => $inputs]);
        return $pdf->download("patient-report-$id.pdf");
    }

    public function download_patient_data_t($id)
    {
        $inputs = FieldResearchInput::all();
        $patient =  Patient::with(['field_research.governorate', 'field_research.marital_status', 'field_research.educational_level','chronic_diseases','hospital','records.user'])->find($id);
        return view('pdf.patient-report', compact('patient','inputs'));
    }
}
