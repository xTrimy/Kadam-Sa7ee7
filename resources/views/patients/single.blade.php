<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-2xl mb-4">
                    {{ __('Patient File') }}
                </h1>
                @if(Session::has('error'))
                
                <div id="alert-3" class="flex p-4 mb-4 bg-red-100 rounded-lg dark:bg-red-200" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                        {{ Session::get('error') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">{{ __('Close') }}</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                @endif
                @php
                    $access_to_patient = true;
                    if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager')){
                        $hospital = auth()->user()->hospitals()->first();
                        if($hospital){
                            $access_to_patient = $hospital->patients()->where('id', $patient->id)->exists();
                        }
                    }
                @endphp
                @if($access_to_patient)
                    <a href="{{ route('dashboard.patients.record.create',$patient->id) }}">
                        <button type="button" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-plus"></i>
                            {{ __('Add New Record') }}
                        </button>
                    </a>
                    @if(Auth::user()->hasPermissionTo('Edit patient'))
                    <a href="{{ route('dashboard.patients.edit',$patient->id) }}">
                        <button type="button" class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-pen"></i>
                            {{ __('Edit') }}
                        </button>
                    </a>
                    @endif
                    <a href="{{ route('dashboard.patientsdownload_data_pdf',$patient->id) }}">
                        <button type="button" class="text-white bg-secondary-light hover:bg-secondary-dark focus:ring-4 focus:ring-secondary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-download"></i>
                            {{ __('Download PDF') }}
                        </button>
                    </a>
                    <a href="{{ route('dashboard.patients.download_patient_field_research',$patient->id) }}">
                        <button type="button" class="text-white bg-secondary-light hover:bg-secondary-dark focus:ring-4 focus:ring-secondary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-download"></i>
                            {{ __('Extract Field Research Data') }}
                        </button>
                    </a>
                @else
                    
                    <button type="button" data-modal-toggle="defaultModal" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                        <i class="las la-sync-alt"></i>
                        {{ __('Request Transfer') }}
                    </button>
                    <!-- Main modal -->
                    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex justify-between w-full items-start p-4 rounded-t border-b dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ __('Are you sure you want to run this action?') }}
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ltr:ml-auto rtl:mr-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">{{ __('Close') }}</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        {{ __('A request will be sent to the admins and managers, and they will continue processing your request') }}
                                    </p>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        {{ __('A notification will be sent to you once the process is completed') }}
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                                    <a href="{{ route('dashboard.patients.transfer_request',$patient->id) }}">
                                        <button data-modal-toggle="defaultModal" type="button" class="text-white bg-primary-light mx-2 hover:bg-primary-dark focus:ring-4 focus:outline-none focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-light dark:hover:bg-primary-dark dark:focus:ring-primary-light">{{ __('Confirm') }}</button>
                                    </a>
                                    <button data-modal-toggle="defaultModal" type="button" class="text-gray-500 bg-white mx-2 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="">
                    <p class="mt-2">
                        <b>{{ __('Name') }}</b> : {{ $patient->name }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Age') }}</b> : {{ $patient->getAge() }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Birth Date') }}</b> : {{ $patient->birth_date }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Hospital') }}</b> : {{ $patient->hospital->name }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('National ID') }}</b> : {{ $patient->national_id }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Chronic Diseases') }}</b> : {{strlen($patient->displayChronicDiseases()) > 0 ? $patient->displayChronicDiseases(): __('None') }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Phone') }}</b> : {{ $patient->phone }}
                    </p>
                    <p class="mt-2">
                        <b>{{ __('Address') }}</b> : {{ $patient->address }}
                    </p>
                    @if($patient->is_cured)
                        <p class="mt-2">
                            <b>{{ __('Status') }}</b> : <span class="text-green-500">{{ __('Cured') }}</span>
                        </p>
                    @elseif($patient->is_discontinued)
                        <p class="mt-2">
                            <b>{{ __('Status') }}</b> : <span class="text-red-500">{{ __('Discontinued') }}</span>
                        </p>
                    @endif                        
                    {{-- Get national id photos --}}
                    <div id="images">
                        @if($patient->national_id_photo_face)
                            <p class="font-bold mt-2">{{ __("National ID Photo (Front)") }}</p>
                            <div class="w-48 h-48 relative">
                                <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                    <div class="las la-eye text-4xl text-white"></div>
                                </div>
                                <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('storage/'.$patient->national_id_photo_face) }}" alt="">
                            </div>
                        @endif
                        @if($patient->national_id_photo_back)
                        <p class="font-bold mt-2">{{ __("National ID Photo (Back)") }}</p>
                        <div class="w-48 h-48 relative">
                            <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                <div class="las la-eye text-4xl text-white"></div>
                            </div>
                            <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('storage/'.$patient->national_id_photo_back) }}" alt="">
                        </div>
                        @endif
                        @if($patient->social_research)
                        <p class="font-bold mt-2">{{ __("Social Research Form") }}</p>
                        <div class="w-48 h-48 relative">
                            <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                <div class="las la-eye text-4xl text-white"></div>
                            </div>
                            <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('storage/'.$patient->social_research) }}" alt="">
                        </div>
                        @endif
                    </div>
                    <p class="mt-8 text-sm text-gray-600">
                        <b>{{ __('Registration Date') }}</b> : {{ $patient->created_at->format('d/m/Y') }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600">
                        <b>{{ __('Registered by') }}</b> : {{ $patient->user->name }}
                    </p>
                </div>
                @if($access_to_patient)

                <div class="mt-8">
                    @if($patient->records->first())
                    <h1 class="text-3xl">{{ __("Patient Records") }}</h1>

        @foreach ($patient->records->reverse() as $record)
            @php
                $data = 
                [
                    "تاريخ التقرير" => date('d/m/Y',strtotime($record->record_date)),
                    "نوع التقرير" => $record->record_type,
                    "وصف التقرير" => $record->record_description,
                    "الملاحظات" => $record->record_notes,
                    "المرفقات" => $record->record_photo,
                    "صورة الجرح" => $record->wound_image,
                    "الطبيب" => $record->doctor?$record->doctor->name:null,
                    "الممرضة" => $record->nurse?$record->nurse->name:null,
                    "تاريخ العملية المحدد" => $record->operation_date?date('d/m/Y',strtotime($record->operation_date)):null,
                    "هل أستلم المريض المستلزمات الطبية؟" => $record->supplied?"نعم":"لا",
                    "استمارة صرف المسلتزمات الطبية" => $record->medication_form,
                    "هل تم فحص المريض؟" => $record->is_checked?"نعم":"لا",
                    "تم فحص المريض بواسطة الطبيب" => $record->checked_by,
                    "تم تسجيل هذا التقرير بواسطة" => $record->user->name??null,
                ];
                if($record->created_at)
                    $diff = $record->created_at->diffInDays($record->record_date);
                else
                    $diff = 0;
            @endphp
            {{-- display created at --}}
            <div class="mt-8">
                @if($record->created_at )
                <p class="text-sm {{ $diff>0?"text-red-500":"text-gray-600" }} ">
                    <b>تاريخ التسجيل</b> : {{ $record->created_at->format('d/m/Y') }}
                </p>
                @endif
            </div>
            <div id="imagex-{{ $record->id }}">
            @foreach ($data as $key=>$value)
                @php
                    if($value == null){
                        continue;
                    }
                @endphp
                @if ($key == "المرفقات" || $key == "صورة الجرح" || $key == "استمارة صرف المسلتزمات الطبية")
                    <div class="mt-2">
                        <p class="font-bold">{{ $key }}</p>
                        <div class="w-48 h-48 relative">
                            <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                <div class="las la-eye text-4xl text-white"></div>
                            </div>
                            <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('uploads/patient_records/'.$value) }}" alt="">
                        </div>
                    </div>
                @else
                    <p class=" mt-2"><b>{{ $key }}</b> : {{ $value }}</p>
                @endif
            @endforeach
            </div>
            <script>
                let images_{{ $record->id }} = new Viewer(document.getElementById('imagex-{{ $record->id }}'));
            </script>
            @if(count($record->supply_transactions) > 0)
            <p class="mt-4 text-xl"><b >المستلزمات المستخدمة:</b></p>
            <ol>
            @foreach ($record->supply_transactions as $transaction)
            <li class="list-decimal">
                <p class=" mt-2"><b>{{ __("Supply Name") }}</b> : {{ $transaction->supply->name }} 
                    |
                <span>
                <b>{{ __("Quantity") }}</b> : {{ $transaction->quantity }}
                </span></p>
                
            </li>
            @endforeach
            </ol>
            @endif
            @if(Auth::user()->hasPermissionTo('Edit patient report'))
            <a href="{{ route('dashboard.patients.record.edit',["id"=>$patient->id,"record_id"=>$record->id]) }}">
                <button type="button" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                    <i class="las la-pen"></i>
                    {{ __('Edit') }}
                </button>
            </a>
            @endif

            <hr class="my-8">
        @endforeach
    @endif
    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const gallery = new Viewer(document.getElementById('images'));
    </script>
</x-app-layout>
