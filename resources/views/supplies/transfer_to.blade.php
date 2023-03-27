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
                    {{ __('Transfer Supplies') }} {{ __('To') }} {{ $hospital?__('Hospital'): __('Patient') }} <br>
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
                    @if(Session::has('supply_errors'))
                        @foreach (Session::get('supply_errors') as $error)
                            {!! "<div class='text-red-500'>$error</div>" !!}
                        @endforeach
                    @endif
                    <div class="flex flex-wrap md:flex-nowrap">
                        @php
                            $name = $hospital?$hospital->name:$patient->name;
                        @endphp
                        <input type="hidden" name="type" value="{{ $hospital?"hospital":"patient" }}">
                        <input type="hidden" name="id" value="{{ $hospital?$hospital->id:$patient->id }}">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="text" value="{{ $name }}" readonly id="name" name="name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm bg-gray-200 text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Name') }}</label>
                        </div>
                    </div>
                    <div class="mt-8 mx-8">
                        <div class="text-xl font-bold">
                            {{ __('Supplies') }}
                        </div>
                    </div>
                    <div class="flex mt-4 space-x-4 space-y-4 flex-wrap">
                        @foreach ($supplies as $supply)
                                <div class="py-4 px-2 rounded-lg mx-4 border border-primary-light">
                                    <div class=" font-bold">
                                        {{ $supply->name }}
                                    </div>
                                    <p>
                                        الكمية الحالية: 
                                        @php
                                            $quantity = $hospital?$hospital->supplies()->where('supply_id', $supply->id)->first()->quantity??0:$patient->supplies()->where('supply_id', $supply->id)->first()->quantity??0;
                                        @endphp
                                        {{ $quantity }}
                                    </p>
                                     <p>
                                        الكمية الحالية في المخزون الرئيسي: 
                                        @php
                                            $quantity = $supply->quantity;
                                        @endphp
                                        {{ $quantity }}
                                    </p>
                                    <div class="mt-4">
                                        <p>تزويد بكمية:</p>
                                        <input type="hidden" value="{{ $supply->id }}" name="supply_id[]" >
                                        <input type="number" oninput="
                                            if(this.value > {{ $quantity }})
                                                this.value = {{ $quantity }};
                                            if(this.value < -{{ $hospital?$hospital->supplies()->where('supply_id', $supply->id)->first()->quantity??0:$patient->supplies()->where('supply_id', $supply->id)->first()->quantity??0; }})
                                                this.value = -{{ $hospital?$hospital->supplies()->where('supply_id', $supply->id)->first()->quantity??0:$patient->supplies()->where('supply_id', $supply->id)->first()->quantity??0; }};
                                        " max="{{ $supply->quantity }}" class="rounded border-gray-300 outline-none" value="0" name="quantity[]">
                                    </div>
                                </div>
                                
                        @endforeach
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
