<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center border-b p-6 border-gray-200">
                    <h1 class=" text-xl bg-white ">
                        {{ __('Hospitals') }} <br>
                        <p class="text-sm mt-4">
                        {{ __('Total Count') }} : {{ $hospitals->count() }}
                        </p>
                    </h1>
                    <a href="{{ route('dashboard.hospitals.create') }}">
                        <button type="button" class="text-white bg-primary-light hover:bg-primary-dark focus:ring-4 focus:ring-primary-light font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">{{ __('Add') }}</button>
                    </a>
                </div>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <div class="p-4">
        <label for="table-search" class="sr-only">{{ __('Search') }}</label>
        <div class="relative mt-1">
            <div class="flex absolute inset-y-0 ltr:left-0 rtl:right-0 items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 ltr:pl-10 rtl:pr-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Search for') . ' ' . __('Hospitals') }}">
        </div>
    </div>
    <div class="">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400  table-auto ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="py-3 px-6">
                    {{ __('Hospital\'s Name') }}
                </th>
                <th scope="col" class="py-3 px-6">
                    {{ __('Address') }}
                </th>
                <th scope="col" class="py-3 px-6">
                    {{ __('Patients Count') }}
                </th>
                <th scope="col" class="py-3 px-6">
                    <span class="sr-only">{{ __('Edit') }}</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hospitals as $hospital)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="p-4 w-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $hospital->name }}
                </th>
                <td class="py-4 px-6">
                    {{ $hospital->address }}
                </td>
                <td class="py-4 px-6">
                    {{ $hospital->patients_count }}
                </td>
                <td class="py-4 px-6 text-right">
                    <div class="flex items-center justify-center">
                        <a href="{{ route('dashboard.hospitals.edit',$hospital->id) }}">
                        <div class="text-center font-medium px-4 py-2 border-primary-dark border rounded-full whitespace-nowrap text-primary-dark hover:text-white hover:bg-primary-light hover:border-primary-light mx-2 dark:text-blue-500 hover:underline">{{ __('Edit') }}</div>
                        </a>
                        @if(auth()->user()->hasPermissionTo('Add supplies'))
                            <a href="{{ route('dashboard.supplies.transfer',['type'=>'hospital','id'=>$hospital->id]) }}">
                            <div class="text-center font-medium px-4 py-2 border-primary-dark border rounded-full whitespace-nowrap text-primary-dark hover:text-white hover:bg-primary-light hover:border-primary-light mx-2 dark:text-blue-500 hover:underline">{{ __('Transfer Supplies') }}</div>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>
    </div>

    </table>
</div>

            </div>
        </div>
    </div>
</x-app-layout>
