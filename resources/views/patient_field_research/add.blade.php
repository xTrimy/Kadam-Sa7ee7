<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="p-6 text-xl bg-white border-b border-gray-200">
                    {{ __('Add Patient Field Research') }} <br>
                </h1>

                @php
                    $field_research = $patient->field_research->last();
                @endphp
                <form action="" method="POST" class="px-8 py-16" enctype="multipart/form-data">
                    @if(Session::has('success'))
                    <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Info</span>
                        <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                            {{ Session::get('success') }}
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">{{ __('Close') }}</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    @endif
                    @csrf
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
                    @endif
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" readonly value="{{ $patient->name }}" id="name" name="name" class="block bg-gray-200 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="name" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Patient\'s Name') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" readonly value="{{ $patient->national_id }}" id="national_id" name="national_id" class="block bg-gray-200 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="national_id" class="absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('National ID') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" id="phone" readonly value="{{ $patient->phone }}" name="phone" class="block bg-gray-200 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="phone" class="absolute  text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Phone Number') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Gender') }}</h1>
                            <label > 
                                <input type="radio" value="1" 
                                @if (($field_research->gender??null) === 1)
                                    checked                                
                                @endif
                                name="gender" required>
                                {{ __('Male') }}
                            </label><br>
                             <label > 
                                <input type="radio" value="0"
                                @if (($field_research->gender??null) === 0)
                                    checked                                
                                @endif
                                name="gender">
                                {{ __('Female') }}
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">

                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="flex justify-center">
                                <div class="mb-3 w-full">
                                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700">{{ __('Photo of patient\'s house/place') }}</label>
                                    <input required name="home_photo" class="form-control
                                    block
                                    w-full
                                    px-3
                                    py-1.5
                                    text-base
                                    font-normal
                                    text-gray-700
                                    bg-white bg-clip-padding
                                    border border-solid border-gray-300
                                    rounded-md
                                    transition
                                    ease-in-out
                                    m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                                </div>
                            </div>
                        </div>
                     
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <select type="text" required id="governorate" name="governorate_id" class="  px-8 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >
                                <option value="" disabled selected>برجاء اختيار محافظة</option>
                                @foreach($governorates as $governorate)
                                    {{-- check language --}}
                                    @php
                                        $selected = ($field_research->governorate_id??null) == $governorate->id ? 'selected' : '';
                                    @endphp
                                    @if(App::getLocale() == 'ar')
                                        <option {{ $selected  }} value="{{ $governorate->id }}">{{ $governorate->ar_name }}</option>
                                    @else
                                        <option {{ $selected  }} value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="governorate" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Governorate') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{$field_research->center??"" }}" required id="center" name="center" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="center" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Center') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{$field_research->village??"" }}" required id="village" name="village" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="village" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Village') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{$field_research->address??"" }}" required id="address" name="address" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="address" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Detailed Address') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="number" value="{{$field_research->age??"" }}" required min="0"  id="age" name="age" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="age" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Age') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <select type="text"  required id="marital_status"name="marital_status_id" class="  px-8 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >
                                <option value="" disabled selected>برجاء اختيار </option>
                               
                                @foreach($marital_statuses as $marital_status)
                                    @php
                                        $selected = ($field_research->marital_status_id??null) == $marital_status->id ? "selected" : "";
                                    @endphp
                                    <option {{ $selected }} value="{{ $marital_status->id }}">{{ $marital_status->name }}</option>
                                @endforeach
                            </select>
                            <label for="marital_status" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Marital Status') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="number" value="{{$field_research->individuals??"" }}" required min="0"  id="individuals" name="individuals" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="individuals" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('The number of dependent people') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <select type="text" required id="educational_level"name="educational_level_id" class="  px-8 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >
                                <option value="" disabled selected>برجاء اختيار </option>
                                @foreach($educational_levels as $educational_level)
                                @php
                                    $selected = ($field_research->educational_level_id??null) == $educational_level->id ? "selected" : "";
                                @endphp
                                    <option {{ $selected }} value="{{ $educational_level->id }}">{{ $educational_level->name }}</option>
                                @endforeach
                            </select>
                            <label for="educational_level" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Educational Level') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{$field_research->job??"" }}" required  id="job" name="job" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="job" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Job or profession') }}</label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('What is the sector type?') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->sector_type??null)=="حكومي"?"checked":"" }} value="حكومي" name="sector" required>
                                حكومي
                            </label><br>
                             <label > 
                                <input type="radio" {{ ($field_research->sector_type??null)=="خاص"?"checked":"" }} value="خاص" name="sector" required>
                                خاص
                            </label><br>
                            <label > 
                                <input type="radio" {{ ($field_research->sector_type??null)=="أهلي"?"checked":"" }} value="أهلي" name="sector" required>
                                أهلي
                            </label><br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('What is the work type?') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->work_type??null)=="دائم"?"checked":"" }} value="دائم" name="work_type" required>
                                دائم
                            </label><br>
                             <label > 
                                <input type="radio" {{ ($field_research->work_type??null)=="متقطع"?"checked":"" }} value="متقطع" name="work_type" required>
                                متقطع
                            </label><br>
                            <label > 
                                <input type="radio" {{ ($field_research->work_type??null)=="موسمي"?"checked":"" }} value="موسمي" name="work_type" required>
                                موسمي
                            </label><br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Do you have a personal project?') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->personal_project??null)===1?"checked":"" }} value="1" name="personal_project" required>
                                نعم
                            </label><br>
                             <label > 
                                <input type="radio" {{ ($field_research->personal_project??null)===0?"checked":"" }} value="0" name="personal_project" required>
                                لا
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('If the answer is yes, please describe your project') }}</h1>
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" value="{{$field_research->project_type??"" }}"  id="project_type" name="project_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="project_type" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Project type') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Do you have any other income source?') }}</h1>
                            @php
                                $income_sources = [
                                    "معاش حكومي / تامينات",
                                    "مساعدات من اهل الخير",
                                    "المساجد / الكنائس / الجمعيات الاهلية",
                                    "ضمان اجتماعي / تكافل و كرامة",
                                    "عائد من ارض زراعية"
                                ];
                                $checked_income_source = explode(",",$field_research->income_source??null);

                            @endphp
                            @foreach ($income_sources as $income_source)
                                <label> 
                                    <input type="checkbox" {{ in_array($income_source,$checked_income_source)?"checked":"" }} value="{{$income_source}}" name="income_source[]" >
                                    {{$income_source}}
                                </label><br>
                            @endforeach
                            <label > 
                               
                                <input type="checkbox" class="peer" 
                                 {{-- If there's additional item than the items in $income_source then it's an extra item, so we check "Other" option --}}
                                {{ count(array_diff(explode(',',$field_research->income_source)??[],$income_sources))>0?"checked":"" }} 
                                value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                
                                <input type="text" 
                                 {{-- Get the extra items --}}
                                value="{{ implode(',',array_diff(explode(',',$field_research->income_source)??[],$income_sources)) }}" 
                                id="income_source" name="income_source[]" placeholder="اذكر مصدر الدخل" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Does anyone in the family suffer from diabetes?') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->is_family_member_has_diabetes??null)===1?"checked":"" }} value="1" name="is_family_member_has_diabetes" required>
                                نعم
                            </label><br>
                             <label > 
                                <input type="radio" {{ ($field_research->is_family_member_has_diabetes??null)===0?"checked":"" }} value="0" name="is_family_member_has_diabetes" required>
                                لا
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('If the answer is yes, indicate the degree of kinship') }}</h1>
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" value="{{$field_research->family_member_with_diabetes??"" }}" id="family_member_with_diabetes" name="family_member_with_diabetes" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="family_member_with_diabetes" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Degree of kinship') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" value="{{$field_research->period_of_diabetes??"" }}"   id="period_with_diabetes" name="period_with_diabetes" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="period_with_diabetes" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('How long have you been diabetic?') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text"  value="{{$field_research->period_of_diabetic_foot??"" }}"  id="period_with_diabetic_foot" name="period_with_diabetic_foot" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="period_with_diabetic_foot" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('How long have you been suffering from diabetic foot?') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Symptoms') }}</h1>
                             @php
                                $symptoms = 
                                [
                                    'جفاف القدم',
                                    'تقرحات بالقدم',
                                    'الاحساس بالبرودة',
                                    'تقشير القدم / تشقق القدم',
                                    'الاحساس بالحرارة',
                                    'فقدان الاحساس',
                                ];
                                $selected_symptoms = explode(',', $field_research->symptoms??null);
                            @endphp
                            @foreach ($symptoms as $symptom)
                                <label > 
                                <input type="checkbox" {{ in_array($symptom,$selected_symptoms)?"checked":"" }} value="{{ $symptom }}" name="symptoms[]">
                                {{ $symptom }}
                            </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->symptoms)??[],$symptoms))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->symptoms)??[],$symptoms)) }}" 
                                
                                id="" name="symptoms[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                           
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('What medication are you currently using for diabetes?') }}</h1>
                            @php
                                $medications = 
                                [
                                    'ادوية منخفضة للسكر',
                                    'انسولين',
                                    'لا أعرف',
                                ];
                                $selected_medications = explode(',', $field_research->medications??null);
                            @endphp
                            @foreach ($medications as $medication)
                                <label > 
                                <input type="checkbox" {{ in_array($medication,$selected_medications)?"checked":"" }} value="{{ $medication }}" name="medication[]">
                                {{ $medication }}
                            </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->medications)??[],$medications))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->medications)??[],$medications)) }}" 
                                
                                id="" name="medication[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Do you suffer from any other chronic diseases or complications of diabetes?') }}</h1>
                            @php
                                $chronic_diseases = 
                                [
                                    'التهاب الاعصاب الطرفية',
                                    'مضاعفات في العين',
                                    'امراض بالقلب و الاوعية الدموية',
                                    'جلطات',
                                    'ارتفاع ضغط الدم',
                                    'مشاكل في وظائف الكلي',
                                    'لا أعرف',
                                ];
                                $selected_chronic_diseases = explode(',', $field_research->other_chronic_diseases??null);
                            @endphp
                            @foreach ($chronic_diseases as $chronic_disease)
                                <label > 
                                <input type="checkbox" {{ in_array($chronic_disease,$selected_chronic_diseases)?"checked":"" }} value="{{ $chronic_disease }}" name="chronic_diseases[]">
                                {{ $chronic_disease }}
                            </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->other_chronic_diseases)??[],$chronic_diseases))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->other_chronic_diseases)??[],$chronic_diseases)) }}" 
                                
                                id="" name="chronic_diseases[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Where do you do the medical examination?') }}</h1>
                          
                            @php
                                $hospitals = 
                                [
                                    'مستشفي عام',
                                    'مستشفي جامعي',
                                    'وحدة صحية',
                                    'مستوصف',
                                    'عيادة خاصة',
                                ];
                                $selected_hospital =  $field_research->visiting_hospital;
                            @endphp
                            @foreach ($hospitals as $hospital)
                                <label > 
                                <input type="radio" {{ $hospital == $selected_hospital ? "checked":""}} value="{{ $hospital }}" name="hospital" required>
                                {{ $hospital }}
                            </label> <br>
                            @endforeach
                            <label> 
                                <input type="radio" 
                                {{ !in_array($selected_hospital, $hospitals)?"checked":"" }}  name="hospital"
                                class="peer"  value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ $field_research->visiting_hospital??null }}" 
                                
                                id="" name="hospital_other" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Where do you cover the costs of treatment?') }}</h1>
                           
                            @php
                                $costs_of_treatment = 
                                [
                                    'الاسرة بتغطي التكاليف',
                                    'مساعدات اهل الخير',
                                    'علاج علي نفقة الدولة',
                                    'تامين صحي',
                                    'مساعدات من اقارب',
                                ];
                                $selected_costs_of_treatment =  explode(',',$field_research->costs_of_treatment??null);
                            @endphp
                            @foreach ($costs_of_treatment as $cost)
                                <label > 
                                <input type="checkbox" {{ in_array($cost,$selected_costs_of_treatment)?"checked":"" }} value="{{ $cost }}" name="costs_of_treatment[]">
                                {{ $cost }}
                            </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->costs_of_treatment)??[],$costs_of_treatment))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->costs_of_treatment)??[],$costs_of_treatment)) }}" 
                                id="" name="costs_of_treatment[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>

                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" datepicker datepicker-format="yyyy-mm-dd" value="{{ $field_research->last_visit_date?date('Y-m-d',strtotime($field_research->last_visit_date)):null }}" id="last_visit_date" name="last_visit_date" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="last_visit_date" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('When was the last time you visited your doctor?') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Where did you hear about the Diabetic Foot Initiative?') }}</h1>
                          
                            @php
                                $heared_about_initiative = [
                                    'التلفزيون',
                                    'الفيسبوك',
                                    'مكان تلقي العلاج (المستشفي / العيادة)',
                                    'الاقارب / الاصدقاء',
                                ];
                                $selected_heared_about_initiative =  explode(',',$field_research->heared_about_initiative??null);

                            @endphp
                            
                            @foreach ($heared_about_initiative as $heared)
                                <label > 
                                <input type="checkbox" {{ in_array($heared,$selected_heared_about_initiative)?"checked":"" }} value="{{ $heared }}" name="heared_about_initiative[]">
                                {{ $heared }}
                                </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->heared_about_initiative)??[],$heared_about_initiative))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->heared_about_initiative)??[],$heared_about_initiative)) }}" 
                                id="" name="heared_about_initiative[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Where did you hear about the Organization?') }}</h1>
                            @php
                                $heared_about_organization = [
                                    'التلفزيون',
                                    'الفيسبوك',
                                    'مكان تلقي العلاج (المستشفي / العيادة)',
                                    'الاقارب / الاصدقاء',
                                ];
                                $selected_heared_about_organization =  explode(',',$field_research->heared_about_organization??null);
                            @endphp
                            
                            @foreach ($heared_about_organization as $heared)
                                <label > 
                                <input type="checkbox" {{ in_array($heared,$selected_heared_about_organization)?"checked":"" }} value="{{ $heared }}" name="heared_about_organization[]">
                                {{ $heared }}
                                </label> <br>
                            @endforeach
                            <label > 
                                <input type="checkbox" 
                                {{ count(array_diff(explode(',',$field_research->heared_about_organization)??[],$heared_about_organization))>0?"checked":"" }} 
                                class="peer" value="اخري تذكر">
                                 اخري تذكر
                                 <br>
                                <input type="text"  
                                value="{{ implode(',',array_diff(explode(',',$field_research->heared_about_organization)??[],$heared_about_organization)) }}" 
                                id="" name="heared_about_organization[]" placeholder="" class="hidden mt-2 peer-checked:block px-2.5 pb-2.5 pt-4 w-full text-sm
                                text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            </label> <br>

                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Have already benefited from the Organization before this?') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->benefited_from_organization??null)===1?"checked":"" }}  value="1" name="benefited_from_organization" required>
                                نعم
                            </label><br>
                             <label > 
                                <input type="radio" {{ ($field_research->benefited_from_organization??null)===0?"checked":"" }} value="0" name="benefited_from_organization" required>
                                لا
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" value="{{ $field_research->benefits_from_organization??null }}"  id="benefits_from_organization" name="benefits_from_organization" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="benefits_from_organization" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Mention the service you benefited from the Organization') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('What is your evaluation of the service provided by Diabetic Foot Clinic?') }}</h1>
                            @php
                                $rating = [
                                    '5',
                                    '4',
                                    '3',
                                    '2',
                                    '1',
                                ];
                                $selected_rating =  $field_research->rating??null;
                            @endphp
                            @foreach ($rating as $rate)
                                <label > 
                                <input type="radio" {{ $rate==$selected_rating?"checked":"" }} value="{{ $rate }}" name="rating" required>
                                {{ $rate }}
                                </label> <br>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <h1 class="text-lg mt-4 mb-2">{{ __('Researcher\'s opinion') }}</h1>
                            <label > 
                                <input type="radio" {{ ($field_research->evaluation??null)===1?"checked":"" }}   value="1" name="evaluation" required>
                                يستحق المساعدة
                            </label><br>
                            <label > 
                                <input type="radio" {{ ($field_research->evaluation??null)===0?"checked":"" }}  value="0" name="evaluation" required>
                                لا يستحق المساعدة
                            </label>
                           
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap">
                            <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                                <input type="text" value="{{ $field_research->evaluation_comment??null }}"  id="evaluation_comment" name="evaluation_comment" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="evaluation_comment" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform  bg-white -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Notes') }}</label>
                            </div>
                    </div>
                    <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                        <button type="submit" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:outline-none focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
