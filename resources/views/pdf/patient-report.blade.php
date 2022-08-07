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
    </style>
</head>
<body>
    <div class="flex justify-between mb-8">
       تاريخ تحميل الملف: {{ date('d/m/Y') }}
    </div>
    <div>
        <div style="float: left; width: 25%;">مؤسسة صناع الخير</div>
        <div style="float:right; margin-left: 35%; width: 65%; ">مبادرة قدم صحيح</div>
    </div>
    <h1 class="text-center text-3xl mt-8 mb-8">بيانات المريض</h1>
    <p>الأسم: {{ $patient->name }}</p>
    <p>العمر: {{ $patient->getAge() }}</p>
    <p>تاريخ الميلاد: {{ $patient->birth_date }}</p>
    <p>المستشفى: {{ $patient->hospital->name }}</p>
    <p>رقم الهوية: {{ $patient->national_id }}</p>
    <p>الأمراض المزمنة: {{strlen($patient->displayChronicDiseases()) > 0 ? $patient->displayChronicDiseases(): __('None') }}</p>
    <p>رقم الهاتف: {{ $patient->phone }}</p>
    <p>العنوان: {{ $patient->address }}</p>
    <div id="images">
        <p class="font-bold mt-2">{{ __("National ID Photo (Front)") }}</p>
        <img class="w-48" src="{{ public_path().'/storage/'.$patient->national_id_photo_face }}" alt="">
    </div>
    <div id="images">
        <p class="font-bold mt-2">{{ __("National ID Photo (Back)") }}</p>
        <img class="w-48" src="{{ public_path().'/storage/'.$patient->national_id_photo_back }}" alt="">
    </div>
    <p>تاريخ تسجيل المريض: {{ $patient->created_at->format('d/m/Y') }}</p>
     @if($patient->records->first())
        <div class="page-break"></div>
        <div>
            <div style="float: left; width: 25%;">مؤسسة صناع الخير</div>
            <div style="float:right; margin-left: 35%; width: 65%; ">مبادرة قدم صحيح</div>
        </div>
        <h1 class="text-center text-3xl mt-8 mb-8">تقارير المريض</h1>

        @foreach ($patient->records->reverse() as $record)
            @php
                $data = 
                [
                    "تاريخ التقرير" => date('d/m/Y',strtotime($record->record_date)),
                    "نوع التقرير" => $record->record_type,
                    "وصف التقرير" => $record->record_description,
                    "الملاحظات" => $record->record_notes,
                    "المرفقات" => $record->record_photo,
                    "تاريخ العملية المحدد" => $record->operation_date?date('d/m/Y',strtotime($record->operation_date)):null,
                    "هل أستلم المريض المستلزمات الطبية؟" => $record->supplied?"نعم":"لا",
                    "هل تم فحص المريض؟" => $record->is_checked?"نعم":"لا",
                    "تم فحص المريض بواسطة الطبيب" => $record->checked_by,
                    "تم تسجيل هذا التقرير بواسطة" => $record->user->name??null,
                ]
                
            @endphp
            @foreach ($data as $key=>$value)
                @php
                    if($value == null){
                        continue;
                    }
                @endphp
                <p class=" mt-2"><b>{{ $key }}</b> : {{ $value }}</p>
                
                    
            @endforeach
            <hr class="my-8">
        @endforeach
    @endif
    
    @if($patient->field_research->first())
        <div class="page-break"></div>
        <div>
            <div style="float: left; width: 25%;">مؤسسة صناع الخير</div>
            <div style="float:right; margin-left: 35%; width: 65%; ">مبادرة قدم صحيح</div>
        </div>
        <h1 class="text-center text-3xl mt-8 mb-8">البحث الميداني</h1>
    @endif
</body>
</html>