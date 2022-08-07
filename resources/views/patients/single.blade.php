<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-2xl mb-4">
                    {{ __('Patient File') }}
                </h1>
                    <a href="{{ route('dashboard.patients.record.create',$patient->id) }}">
                        <button type="button" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-plus"></i>
                            {{ __('Add New Record') }}
                        </button>
                    </a>
                    <a href="#">
                        <button type="button" class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-pen"></i>
                            {{ __('Edit') }}
                        </button>
                    </a>
                    <a href="{{ route('dashboard.patientsdownload_data_pdf',$patient->id) }}">
                        <button type="button" class="text-white bg-secondary-light hover:bg-secondary-dark focus:ring-4 focus:ring-secondary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">
                            <i class="las la-download"></i>
                            {{ __('Download PDF') }}
                        </button>
                    </a>
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
                    {{-- Get national id photos --}}
                    <div id="images">
                        <p class="font-bold mt-2">{{ __("National ID Photo (Front)") }}</p>
                        <div class="w-48 h-48 relative">
                            <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                <div class="las la-eye text-4xl text-white"></div>
                            </div>
                            <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('storage/'.$patient->national_id_photo_face) }}" alt="">
                        </div>
                        <p class="font-bold mt-2">{{ __("National ID Photo (Back)") }}</p>
                        <div class="w-48 h-48 relative">
                            <div class="w-full h-full absolute top-0 left-0 bg-black flex justify-center items-center">
                                <div class="las la-eye text-4xl text-white"></div>
                            </div>
                            <img class="w-full h-full object-contain hover:opacity-70 cursor-pointer relative" src="{{ asset('storage/'.$patient->national_id_photo_back) }}" alt="">
                        </div>
                    </div>
                    <p class="mt-8 text-sm text-gray-600">
                        <b>{{ __('Registration Date') }}</b> : {{ $patient->created_at->format('d/m/Y') }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600">
                        <b>{{ __('Registered by') }}</b> : {{ $patient->user->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const gallery = new Viewer(document.getElementById('images'));
    </script>
</x-app-layout>
