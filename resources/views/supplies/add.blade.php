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
                    {{ __('Add Supply') }} <br>
                </h1>

                <form action="" method="POST" enctype="multipart/form-data" class="px-8 py-16">
                    @if (isset($supply))
                        @method('PUT')
                    @endif
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
                            <input type="text" value="{{ $supply->name??"" }}" id="name" name="name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Name') }}</label>
                        </div>
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="number" value="{{ $supply->quantity??"" }}" min="0" value="0" id="quantity" name="quantity" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="quantity" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Quantity') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <input type="number" value="{{ $supply->price??"" }}" min="0" id="price" name="price" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                            <label for="price" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Price') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <select type="text" id="category" name="category_id" class="block px-8 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" >
                            @if(!isset($supply))
                            <option value="" disabled selected> 
                                {{ __('Select Option') }}
                            </option>
                            @endif
                            @foreach ($categories as $category)
                                <option 
                                    @if(isset($supply))
                                        @if($supply->supply_category_id == $category->id)
                                            selected
                                        @endif
                                    @endif
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                            <label for="category" class="absolute text-sm text-gray-500 dark:text-gray-400 duration
                            -300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:right-1 ltr:left-1">{{ __('Category') }}</label>
                        </div>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap">
                        <div class="relative  w-full md:flex-auto md:w-auto mx-4 mt-4">
                            <a target="_blank" href="{{ route('dashboard.supplies.categories.create') }}">
                                <button type="button" class="text-white bg-green-400 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                    {{ __('Add Category') }}
                                </button>
                            </a>
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
