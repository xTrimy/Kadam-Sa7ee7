
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .page-break {
            page-break-after: always;
        }
        .pagenum:before {
            content: counter(page);
        }
        @page{
            margin-top:100px;
            header: page-header;
	        footer: page-footer;
        }
        body{
            font-family: 'XB Riyaz', sans-serif;
        }
    </style>
</head>
<body class="mx-8">
    <htmlpageheader name="page-header">
        <div>
            <div style="float: left; text-align:left; width: 25%;">مؤسسة صناع الخير</div>
            <div style="float:right; margin-left: 35%; width: 65%; ">مبادرة قدم صحيح</div>
        </div>
    </htmlpageheader>
        
    <div class="flex justify-between mb-8">
        التاريخ: {{ date('d/m/Y') }}
    </div>
    <p>
        ملف المريض:
    </p>
    {!! str_replace('<?xml version="1.0" encoding="UTF-8"?>','',QrCode::size(100)->generate(route('dashboard.patientsview_single',$patient->id)));  !!}
    <h1 class="text-center text-3xl mt-8 mb-8">بيانات المريض</h1>
    <p>الأسم: {{ $patient->name }}</p>
    <p>العمر: {{ $patient->getAge() }}</p>
    <p>تاريخ الميلاد: {{ $patient->birth_date }}</p>
    <p>المستشفى: {{ $patient->hospital->name }}</p>
    <p>رقم الهوية: {{ $patient->national_id }}</p>
    <p>الأمراض المزمنة: {{strlen($patient->displayChronicDiseases()) > 0 ? $patient->displayChronicDiseases(): __('None') }}</p>
    <p>رقم الهاتف: {{ $patient->phone }}</p>
    <p>العنوان: {{ $patient->address }}</p>
    <p>تاريخ تسجيل المريض: {{ $patient->created_at->format('d/m/Y') }}</p>
    <div class="page-break"></div>
        
    
    @if($patient->field_research->first())
        <div class="page-break"></div>
        
        <h1 class="text-center text-3xl mt-8 mb-8">بيانات البحث الميداني</h1>

    @php
        $field_research = $patient->field_research->last();
        $data = 
        [
            'governorate'=>App::isLocale('en')?($field_research->governorate? $field_research->governorate->name:$field_research->governorate->ar_name):"",
            'gender'=>$field_research->gender == 0 ? 'ذكر' : 'أنثى',
            'center'=>$field_research->center,
            'village'=>$field_research->village,
            'address'=>$field_research->address,
            'phone'=>$field_research->phone,
            'national_id'=>$field_research->national_id,
            'age'=>$field_research->age,
            'marital_status'=>$field_research->marital_status->name,
            'individuals'=>$field_research->individuals,
            'educational_level'=>$field_research->educational_level->name,
            'job'=>$field_research->job,
            'sector_type'=>$field_research->sector_type,
            'work_type'=>$field_research->work_type,
            'personal_project'=>$field_research->personal_project==1?'نعم':'لا',
            'project_type'=>$field_research->project_type,
            'income_source'=>$field_research->income_source,
            'is_family_member_has_diabetes'=>$field_research->is_family_member_has_diabetes,
            'family_member_with_diabetes'=>$field_research->family_member_with_diabetes,
            'period_of_diabetes'=>$field_research->period_of_diabetes,
            'period_of_diabetic_foot'=>$field_research->period_of_diabetic_foot,
            'symptoms'=>$field_research->symptoms,
            'medications'=>$field_research->medications,
            'other_chronic_diseases'=>$field_research->other_chronic_diseases,
            'visiting_hospital'=>$field_research->visiting_hospital,
            'costs_of_treatment'=>$field_research->costs_of_treatment,
            'last_visit_date'=>date('d/m/Y',strtotime($field_research->last_visit_date)),
            'heared_about_initiative'=>$field_research->heared_about_initiative,
            'heared_about_organization'=>$field_research->heared_about_organization,
            'benefited_from_organization'=>$field_research->benefited_from_organization,
            'benefits_from_organization'=>$field_research->benefits_from_organization,
            'rating'=>$field_research->rating,
            'evaluation'=>$field_research->evaluation==1?"يستحق المساعدة":"لا يستحق المساعدة",
            'evaluation_comment'=>$field_research->evaluation_comment,
    ];
        
        $locale = 
        [
            'governorate'=>__('Governorate'),
            'gender'=>__('Gender'),
            'center'=>__('Center'),
            'village'=>__('Village'),
            'address'=>__('Address'),
            'phone'=>__('Phone'),
            'national_id'=>__('National ID'),
            'age'=>__('Age'),
            'marital_status'=>__('Marital Status'),
            'individuals'=>__('The number of dependent people'),
            'educational_level'=>__('Educational Level'),
            'job'=>__('Job or profession'),
            'sector_type'=>__('What is the sector type?'),
            'work_type'=>__('What is the work type?'),
            'personal_project'=>__('Do you have a personal project?'),
            'project_type'=>__('If the answer is yes, please describe your project'),
            'income_source'=>__('Do you have any other income source?'),
            'is_family_member_has_diabetes'=>__('Does anyone in the family suffer from diabetes?'),
            'family_member_with_diabetes'=>__('If the answer is yes, indicate the degree of kinship'),
            'period_of_diabetes'=>__('How long have you been diabetic?'),
            'period_of_diabetic_foot'=>__('How long have you been suffering from diabetic foot?'),
            'symptoms'=>__('Symptoms'),
            'medications'=>__('What medication are you currently using for diabetes?'),
            'other_chronic_diseases'=>__('Do you suffer from any other chronic diseases or complications of diabetes?'),
            'visiting_hospital'=>__('Where do you do the medical examination?'),
            'costs_of_treatment'=>__('Where do you cover the costs of treatment?'),
            'last_visit_date'=>__('When was the last time you visited your doctor?'),
            'heared_about_initiative'=>__('Where did you hear about the Diabetic Foot Initiative?'),
            'heared_about_organization'=>__('Where did you hear about the Organization?'),
            'benefited_from_organization'=>__('Have already benefited from the Organization before this?'),
            'benefits_from_organization'=>__('Mention the service you benefited from the Organization'),
            'rating'=>__('What is your evaluation of the service provided by Diabetic Foot Clinic?'),
            'evaluation'=>__('Researcher\'s opinion'),
            'evaluation_comment'=>__('Notes'),
            'home_photo'=>__('Home Photo')
        ];

        $arrays = 
        [
            'income_source',
            'symptoms',
            'medications',
            'costs_of_treatment',
            'other_chronic_diseases',
            'heared_about_initiative',
            'heared_about_organization',
            'benefits_from_organization',
        ]
    @endphp

    @foreach ($data as $key=>$value)
        @php
            if($value == null){
                continue;
            }
        @endphp
        @if(in_array($key,$arrays))
            @php
                $values = explode(',',$value);

            @endphp
            <p class=" mt-4"><b>{{ $locale[$key] }}</b> :</p>
            <ol class="px-8">
                @foreach ($values as $v)
                    <li class="list-decimal">{{ $v }}</li>
                @endforeach
            </ol>
            @else

        <p class=" mt-2"><b>{{ $locale[$key] }}</b> : {!! $value !!}</p>
        @endif
                    
    @endforeach
    @php
        $meta = json_decode($field_research->meta);
    @endphp
    @foreach ($inputs as $input)
        @php
            $value = $meta->{$input['name']};
        @endphp
        @if($input->type == 'file')
            @if($value)
                <p class=" mt-2"><b>{{ $input->name }}</b> :</p>
                <img class="w-full" src="{{ public_path("/storage/".$value) }}">
            @endif
        @else
            @if($value)
                <p class=" mt-2"><b>{{ $input->name }}</b> : {!! $value !!}</p>
            @endif
        @endif
    @endforeach
    @else
        <p class="text-center text-red-500">لا يوجد بيانات</p>
    @endif

    <div>
        <div class="mt-16" >
            <div>التوقيع:</div>
        </div>
    </div>
</body>
</html>