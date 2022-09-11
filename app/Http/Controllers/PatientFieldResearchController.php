<?php

namespace App\Http\Controllers;

use App\Models\EducationalLevel;
use App\Models\FieldResearchInput;
use App\Models\Governorate;
use App\Models\MaritalStatus;
use App\Models\Patient;
use App\Models\PatientFieldResearch as ModelsPatientFieldResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PatientFieldResearchController extends Controller
{
    function create($id)
    {
        $patient = Patient::with('field_research')->find($id);
        $marital_statuses = MaritalStatus::all();
        $educational_levels = EducationalLevel::all();
        $governorates = Governorate::all();
        $inputs = FieldResearchInput::all();
        return view('patient_field_research.add', compact('patient', 'marital_statuses', 'educational_levels', 'governorates', 'inputs'));
    }

    function store(Request $request, $id)
    {
        $patient = Patient::find($id);
        // dd($request->all());
        $request->validate(
            [
                'gender'=>'required|boolean',
                'home_photo'=>'required|mimes:png,jpg',
                'governorate_id'=>'required|exists:governorates,id',
                'center'=>'required|string',
                'village'=>"required|string",
                'address'=>"required|string",
                'age'=>'required|integer',
                'marital_status_id'=>'required|exists:marital_statuses,id',
                'individuals'=>'required|integer',
                'educational_level_id'=>'required|exists:educational_levels,id',
                'job'=>'required|string',
                'sector'=>'required|string',
                'work_type'=>'required|string',
                'personal_project'=>'required|boolean',
                'project_type'=>'string',
                'income_source'=>'array',
                'income_source.*'=>'required|string',
                'is_family_member_has_diabetes'=>'required|boolean',
                'family_member_with_diabetes'=>'nullable|string',
                'period_with_diabetes'=>'required|string',
                'period_with_diabetic_foot'=>'required|string',
                'symptoms'=>'array',
                'medication'=>'array',
                'chronic_diseases'=>'array',
                'hospital'=>'required|string',
                'costs_of_treatment'=>'array',
                'last_visit_date'=>'required|date',
                'heared_about_initiative'=>'array',
                'heared_about_organization'=>'array',
                'benefited_from_organization'=>'required|boolean',
                'benefits_from_organization'=>'string',
                'rating'=>'required|integer',
                'evaluation'=>'required|boolean',
                'evaluation_comment'=>'string',
            ]
        );
        $arrays = [
            'income_source',
            'symptoms',
            'medication',
            'chronic_diseases',
            'costs_of_treatment',
            'heared_about_initiative',
            'heared_about_organization',
        ];
        foreach ($arrays as $array) {

            if (isset($request[$array])) {
                $arrays[$array] = implode(',', $request[$array]);
            }
        }
        $arrays = array_filter($arrays,function($value){
            return !is_int($value);
        }, ARRAY_FILTER_USE_KEY);
        $field_research = new ModelsPatientFieldResearch();
        foreach($arrays as $key => $value){
            if($key == "medication"){
                $key = "medications";
            }
            if ($key == "chronic_diseases") {
                $key = "other_chronic_diseases";
            }
            $field_research->$key = $value;
        }
        $rest_of_data = [
            'patient_id'=>$id,
            'governorate_id'=>$request->governorate_id,
            'gender'=>$request->gender,
            'visiting_hospital'=>($request->hospital == "اخري تذكر"?$request->hospital_other:$request->hospital),
            'phone' => $request->phone,
            'national_id' => $request->national_id,
            'center'=>$request->center,
            'village'=>$request->village,
            'address'=>$request->address,
            'age'=>$request->age,
            'marital_status_id'=>$request->marital_status_id,
            'individuals'=>$request->individuals,
            'educational_level_id'=>$request->educational_level_id,
            'job'=>$request->job,
            'sector_type'=>$request->sector,
            'work_type'=>$request->work_type,
            'personal_project'=>$request->personal_project,
            'project_type'=>$request->project_type,
            'is_family_member_has_diabetes'=>$request->is_family_member_has_diabetes,
            'family_member_with_diabetes'=>$request->family_member_with_diabetes,
            'period_of_diabetes'=>$request->period_with_diabetes,
            'period_of_diabetic_foot'=>$request->period_with_diabetic_foot,
            'last_visit_date'=>date('Y-m-d',strtotime($request->last_visit_date)),
            'benefited_from_organization'=>$request->benefited_from_organization,
            'benefits_from_organization'=>$request->benefits_from_organization,
            'rating'=>$request->rating,
            'evaluation'=>$request->evaluation,
            'evaluation_comment'=>$request->evaluation_comment,
        ];

        foreach ($rest_of_data as $key => $value) {
            $field_research->$key = $value;
        }

        if ($request->hasFile('home_photo')) {
            $file = $request->file('home_photo');
            $name = time() . '_' . $file->getClientOriginalName();
            //move to storage/
            Storage::disk('public')->put($name, file_get_contents($file));
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path('app/public/') . $name);

            //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
            // check if image is jpg or png
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if($ext == "jpg" || $ext == "jpeg"){
                $image = imagecreatefromjpeg(storage_path('app/public/') . $name);
            }else{
                $image = imagecreatefrompng(storage_path('app/public/') . $name);
            }
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

            $field_research->home_photo = $name;
        }
        // meta extra inputs
        $meta = [];
        $inputs = FieldResearchInput::all();
        foreach ($inputs as $input) {
            if ($input->type == 'file') {
                if ($request->hasFile($input->name)) {
                    $file = $request->file($input->name);
                    $size = $file->getSize();
                    // max file size is 3MB
                    if($size > 3000000){
                        return redirect()->back()->with('error', 'حجم الملف كبير جداً');
                    }
                    $name = time() . '_' . $file->getClientOriginalName();
                    //move to storage/
                    Storage::disk('public')->put($name, file_get_contents($file));
                    $optimizerChain = OptimizerChainFactory::create();
                    $optimizerChain->optimize(storage_path('app/public/') . $name);
                    // get image size 
                    //if image is larger than 500×500, resize it to 500×500 andkeep the aspect ratio
                    // check if image is jpg or png
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    if($ext == "jpg" || $ext == "jpeg"){
                        $image = imagecreatefromjpeg(storage_path('app/public/') . $name);
                    }else{
                        $image = imagecreatefrompng(storage_path('app/public/') . $name);
                    }
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

                    $meta[$input->name] = $name;
                }
            } else {
                $meta[$input->name] = $request[$input->name];
            }
        }
        $field_research->meta = json_encode($meta);
        $field_research->save();
        return redirect()->back()->with('success', __('Data has been recorded successfully'));
    }

    public function field_settings(){
        $field_research_inputs = FieldResearchInput::all();
        return view('settings.field_research.fields',compact('field_research_inputs'));
    }

    public function field_settings_store(Request $request){
        $request->validate([
            'name'=>'array',
            'type'=>'array',
            'options'=>'array',
            'required'=>'array',
        ]);
        foreach($request->name as $key => $name){
            if($request->id[$key] == null){
                $field_research_input = new FieldResearchInput();
            }else{
                $field_research_input = FieldResearchInput::find($request->id[$key]);
            }
            if($name == null){
                $field_research_input->delete();
                continue;
            }
            $field_research_input->name = $name;
            $field_research_input->type = $request->type[$key];
            $field_research_input->options = $request->options[$key];
            $field_research_input->save();
        }
        return redirect()->back()->with('success', __('Data has been recorded successfully'));
    }
    

}
