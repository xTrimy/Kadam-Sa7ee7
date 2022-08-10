<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="p-6 text-xl bg-white border-b border-gray-200">
                    {{ __('Add Patient Record') }} <br>
                </h1>

                <form action="" method="POST" enctype="multipart/form-data" class="px-8 py-16">
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
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" readonly id="name" name="name" class="block bg-gray-200 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ $patient->name }}" />
                            <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Patient\'s Name') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" readonly id="national_id" name="national_id" class="block bg-gray-200 px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ $patient->national_id }}" />
                            <label for="national_id" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('National ID') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" id="record_type" name="record_type" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="تقرير طبي" placeholder=" " />
                            <label for="record_type" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Record Type') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{ date('Y/m/d') }}" datepicker datepicker-format="yyyy/mm/dd" id="record_date" name="record_date" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="record_date" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Record Date/Visit Date') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" id="record_description" name="record_description" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  placeholder=" " />
                            <label for="record_description" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Record Description') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                         <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="checkbox" checked id="is_checked" name="is_checked"  />
                            <label for="is_checked">{{ __('Patient Checked?') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" id="checked_by" name="checked_by" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  placeholder=" "/>
                            <label for="checked_by" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Checked By (Doctor Name)') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" id="record_notes" name="record_notes" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  placeholder=" " />
                            <label for="record_notes" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Notes') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" datepicker datepicker-format="yyyy/mm/dd"  id="operation_date" name="operation_date" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="operation_date" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Operation Date') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <div class="flex justify-center">
                                <div class="mb-3 w-full">
                                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700">{{ __('Record Photo/Patient Status Picture') }}</label>
                                    <input class="form-control
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
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile" name="record_photo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                        <input type="checkbox"  id="supplied" name="supplied"  />
                        <label for="supplied">{{ __('Patient received medical supplies?') }}</label>
                    </div>

                    <div class="mt-8">
                        <input type="checkbox"  id="reviewed" class="peer" />
                        <label for="reviewed">{{ __('I acknowledge that I checked the data carefully before saving') }}</label>

                        <div class="hidden peer-checked:block relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                        <button type="submit" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:outline-none focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            {{ __('Save') }}
                        </button>
                    </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
